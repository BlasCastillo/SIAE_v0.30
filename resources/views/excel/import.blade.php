<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Carga Masiva</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                <!-- Select que ya tienes -->
                <select id="tableSelector" class="form-control" name="table">
                    <option value="">Seleccionar tabla</option>
                    @foreach ($tables as $alias => $realName)
                        <option value="{{ $alias }}">{{ ucfirst($alias) }}</option>
                    @endforeach

                </select>

                <!-- Sección de carga oculta inicialmente -->
                <div id="uploadSection" class="d-none mt-3">
                    <form id="importForm" method="POST" enctype="multipart/form-data"
                        action="{{ route('excel_import.handle') }}">
                        @csrf
                        <input type="hidden" name="table" id="selectedTable">
                        <input type="file" name="file" accept=".xlsx,.xls" required class="block mt-1 w-full mb-2 " />
                        <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i>Subir archivo</button>
                    </form>
                </div>

            </div>
            <div class="flex items-center justify-end mt-4">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-4">Cancelar</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('tableSelector').addEventListener('change', function(e) {
            const alias = e.target.value;
            if (alias) {
                Swal.fire({
                    title: '¿Ya tienes la plantilla?',
                    text: `Puedes descargar la plantilla Excel para la tabla ${alias} o subirla si ya la tienes.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya tengo la plantilla',
                    cancelButtonText: 'Descargar plantilla',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Usuario ya tiene la plantilla, mostrar formulario para subir archivo
                        document.getElementById('uploadSection').classList.remove('d-none');
                        document.getElementById('selectedTable').value = alias;
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        // Usuario quiere descargar la plantilla
                        Swal.fire({
                            title: 'Descargando plantilla',
                            text: `Se descargará el archivo Excel para la tabla ${alias}`,
                            icon: 'info',
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Redirigir para descargar plantilla después de un pequeño delay
                        setTimeout(() => {
                            window.location.href = `/download-template?table=${alias}`;
                            // Mostrar formulario para subir archivo
                            document.getElementById('uploadSection').classList.remove('d-none');
                            document.getElementById('selectedTable').value = alias;
                        }, 2100);
                    } else {
                        // Si cierra el modal o cancela, resetea el select y oculta formulario
                        e.target.value = '';
                        document.getElementById('uploadSection').classList.add('d-none');
                    }
                });
            } else {
                document.getElementById('uploadSection').classList.add('d-none');
            }
        });

        document.getElementById('importForm').addEventListener('submit', function(e) {
            e.preventDefault(); // evitar envío automático

            const form = e.target;
            const formData = new FormData(form);

            Swal.fire({
                title: 'Procesando archivo...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('{{ route('excel_import.preview') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error('Error en la respuesta del servidor');
                    return response.json();
                })
                .then(data => {
                    Swal.close();

                    // Construir HTML para columnas destino
                    let columnsHtml = '<p><strong>Columnas en la tabla destino:</strong></p><ul>';
                    data.columns.forEach(col => {
                        columnsHtml += `<li>${col}</li>`;
                    });
                    columnsHtml += '</ul>';

                    // Construir tabla HTML para vista previa
                    let tableHtml = '<p><strong>Vista previa de los datos a importar:</strong></p>';
                    tableHtml +=
                        '<table border="2" style="width:100%;text-align:left;border-collapse:collapse;"><thead><tr>';
                    data.header.forEach(h => {
                        tableHtml += `<th style="padding:4px;">${h}</th>`;
                    });
                    tableHtml += '</tr></thead><tbody>';
                    data.rows.forEach(row => {
                        tableHtml += '<tr>';
                        row.forEach(cell => {
                            tableHtml += `<td style="padding:4px;">${cell ?? ''}</td>`;
                        });
                        tableHtml += '</tr>';
                    });
                    tableHtml += '</tbody></table>';

                    Swal.fire({
                        title: 'Confirmar datos a importar',
                        html: columnsHtml + tableHtml,
                        width: '80%',
                        showCancelButton: true,
                        confirmButtonText: 'Confirmar',
                        cancelButtonText: 'Cancelar',
                        preConfirm: () => {
                            form.submit();
                        }
                    });
                })
                .catch(error => {
                    Swal.fire('Error', 'No se pudo obtener la vista previa: ' + error.message, 'error');
                });
        });
    </script>
</x-app-layout>
