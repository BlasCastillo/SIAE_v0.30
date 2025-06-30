<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lista de PNF</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4 gap-4">
                    <div class="flex gap-4">
                        <a href="{{ route('pnfs.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Crear PNF</a>
                        <a href="{{ route('pnfs.index', ['ver_inactivas' => !$mostrarInactivas]) }}"
                            class="btn btn-secondary"   >
                            {{ $mostrarInactivas ? 'Ver Activos' : 'Ver Inactivos' }}
                        </a>
                        <x-pdf-download-button routeName="pnfs.reportePdf" />
                    </div>

                    <!-- Buscador (ocupando el espacio restante) -->
                    <div class="relative flex-grow max-w-md">
                        <input type="text" id="searchInput" placeholder="Buscar"
                            class="w-full pl-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                    </div>
                </div>

                @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="w-full table-auto border-collapse border border-gray-200" id="mainTable">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-left">Código</th> <!-- 🔥 Nueva columna -->
                            <th class="border border-gray-300 px-4 py-2 text-left">Nombre</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Descripción</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @if ($pnfs->isEmpty())
                            <tr>
                                <td colspan="10" class="border px-4 py-2 text-center">No hay aulas registradas.</td>
                            </tr>
                        @endif
                        @foreach ($pnfs as $pnf)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="border border-gray-300 px-4 py-2">{{ $pnf->codigo }}</td>
                                <!-- 🔥 Mostrar código -->
                                <td class="border border-gray-300 px-4 py-2">{{ $pnf->nombre }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $pnf->descripcion }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="{{ route('pnfs.edit', $pnf) }}"  class="btn btn-warning inline-flex items-center gap-1 px-3 py-1 rounded hover:bg-yellow-400 transition">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <form action="{{ route('pnfs.destroy', $pnf) }}" method="POST"
                                        class="inline-block ml-2 delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Controles de paginación y select debajo de la tabla -->
                <div class="flex justify-between items-center mt-6">
                    <select id="rowsPerPage"
                        class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition w-36">

                        <option value="5" selected>5 por página</option>
                        <option value="10">10 por página</option>
                        <option value="20">20 por página</option>
                    </select>

                    <div id="pagination" class="flex gap-2"></div>
                </div>

            </div>
        </div>
    </div>

    {{-- paginacion y busqueda --}}
    <style>
        .pagination-btn {
            padding: 8px 14px;
            border: 1px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            user-select: none;
            transition: all 0.3s ease;
            background-color: white;
            color: #374151; /* gray-700 */
        }
        .pagination-btn:hover {
            background-color: #3b82f6; /* blue-500 */
            color: white;
            transform: translateY(-1px);
            border-color: #3b82f6;
        }
        .pagination-btn:disabled,
        .pagination-btn[disabled] {
            cursor: default;
            opacity: 0.5;
            transform: none;
            background-color: #f9fafb; /* gray-50 */
            color: #9ca3af; /* gray-400 */
            border-color: #d1d5db; /* gray-300 */
        }
        .active-page {
            background-color: #3b82f6; /* blue-500 */
            color: white;
            border-color: #3b82f6;
            cursor: default;
            transform: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const table = document.getElementById('mainTable');
            const allRows = Array.from(table.querySelectorAll('tbody tr'));
            const searchInput = document.getElementById('searchInput');
            const rowsPerPageSelect = document.getElementById('rowsPerPage');
            const paginationDiv = document.getElementById('pagination');

            let currentPage = 1;
            let rowsPerPage = parseInt(rowsPerPageSelect.value);
            let filteredRows = allRows;

            // Filtrar filas según búsqueda
            function filterRows() {
                const searchTerm = searchInput.value.trim().toLowerCase();
                filteredRows = allRows.filter(row => {
                    return Array.from(row.cells).some(cell =>
                        cell.textContent.toLowerCase().includes(searchTerm)
                    );
                });

                // Mostrar mensaje si no hay resultados
                const noResultsRow = document.getElementById('noResultsRow');
                if (!filteredRows.length) {
                    if (!noResultsRow) {
                        const row = document.createElement('tr');
                        row.id = 'noResultsRow';
                        row.innerHTML = `<td colspan="10" class="border px-4 py-2 text-center">No se encontraron resultados.</td>`;
                        table.querySelector('tbody').appendChild(row);
                    }
                } else if (noResultsRow) {
                    noResultsRow.remove();
                }

                currentPage = 1;
                renderTable();
            }


            // Renderizar tabla y paginación
            function renderTable() {
                const totalPages = Math.ceil(filteredRows.length / rowsPerPage) || 1;
                if (currentPage > totalPages) currentPage = totalPages;

                // Mostrar filas correctas
                allRows.forEach(row => (row.style.display = 'none'));
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                filteredRows.slice(start, end).forEach(row => (row.style.display = ''));

                // Limpiar paginación
                paginationDiv.innerHTML = '';

                // Botón Anterior
                const prevBtn = document.createElement('button');
                prevBtn.className = 'pagination-btn';
                prevBtn.textContent = '<';
                prevBtn.disabled = currentPage === 1;
                prevBtn.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        renderTable();
                        scrollToTop();
                    }
                });
                paginationDiv.appendChild(prevBtn);

                // Botones de páginas
                // Mostrar máximo 5 botones para evitar saturar
                let startPage = Math.max(1, currentPage - 2);
                let endPage = Math.min(totalPages, startPage + 4);
                if (endPage - startPage < 4) {
                    startPage = Math.max(1, endPage - 4);
                }

                for (let i = startPage; i <= endPage; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.className = 'pagination-btn';
                    if (i === currentPage) pageBtn.classList.add('active-page');
                    pageBtn.textContent = i;
                    pageBtn.addEventListener('click', () => {
                        currentPage = i;
                        renderTable();
                        scrollToTop();
                    });
                    paginationDiv.appendChild(pageBtn);
                }

                // Botón Siguiente
                const nextBtn = document.createElement('button');
                nextBtn.className = 'pagination-btn';
                nextBtn.textContent = '>';
                nextBtn.disabled = currentPage === totalPages;
                nextBtn.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        renderTable();
                        scrollToTop();
                    }
                });
                paginationDiv.appendChild(nextBtn);
            }

            // Scroll suave hacia arriba (opcional)
            function scrollToTop() {
                window.scrollTo({
                    top: table.offsetTop - 80,
                    behavior: 'smooth'
                });
            }

            // Eventos
            searchInput.addEventListener('input', filterRows);
            rowsPerPageSelect.addEventListener('change', () => {
                rowsPerPage = parseInt(rowsPerPageSelect.value);
                currentPage = 1;
                renderTable();
            });

            // Inicializar
            renderTable();
        });
    </script>

    {{-- alert de boton --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Selecciona todos los formularios de eliminación
            document.querySelectorAll('.delete-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Evita el envío inmediato

                    Swal.fire({
                        title: "¿Estás seguro?",
                        text: "¡Vas a Desactivar este PNF!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, desactivar",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Envía el formulario si confirma
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
