<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Asignaciones PNF por Docente</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('docentesporpnf.update', $docente->id) }}" id="edit-form">
                    @csrf
                    @method('PUT')

                    <!-- Nombre del docente (no modificable) -->
                    <div>
                        <x-label for="name" value="Nombre del Docente" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $docente->name }}" readonly />
                    </div>

                    <!-- Lista de PNFs con checkboxes -->
                    <div class="mt-4">
                        <x-label for="pnfs" value="PNFs Asignados" />
                        @foreach ($pnfs as $pnf)
                            <div class="flex items-center gap-2 mt-2">
                                <input type="checkbox" name="pnf_id[]" id="pnf_{{ $pnf->id }}" value="{{ $pnf->id }}"
                                    {{ in_array($pnf->id, $asignados) ? 'checked' : '' }} />
                                <label for="pnf_{{ $pnf->id }}">{{ $pnf->nombre }}</label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Botón para guardar cambios -->
                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('docentesporpnf.index') }}" class="btn btn-secondary">Volver</a>
                        <button type="submit" class="btn btn-primary ms-4"><i class="bi bi-check-lg"></i> Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para manejar la alerta al destildar todos -->
    <script>
        document.getElementById('edit-form').addEventListener('submit', function(e) {
            const checkboxes = document.querySelectorAll('input[name="pnf_id[]"]');
            const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
    
            if (!anyChecked) {
                e.preventDefault(); // Evitar el envío del formulario
                if (confirm('No se ha seleccionado ningún PNF. ¿Desea inactivar al docente?')) {
                    const deleteRoute = "{{ route('docentesporpnf.destroy', $docente->id) }}";
                    fetch(deleteRoute, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la respuesta del servidor.');
                        }
                        return response.json(); // Procesar respuesta JSON del servidor
                    })
                    .then(data => {
                        alert(data.message); // Mensaje de éxito del servidor
                        window.location.href = "{{ route('docentesporpnf.index') }}"; // Redirigir al índice
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Ocurrió un error al intentar inactivar al docente. Por favor, inténtelo nuevamente.');
                    });
                }
            }
        });
    </script>
    
    
    
</x-app-layout>
