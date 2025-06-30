<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Nueva Sección</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('secciones.store') }}">
                    @csrf

                    <div>
                        <x-label for="nombre" value="Nombre (3 dígitos)" />
                        <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" maxlength="3" required />
                    </div>

                    <div class="mt-4">
                        <x-label for="cantidad_alumnos" value="Cantidad de Alumnos" />
                        <x-input id="cantidad_alumnos" class="block mt-1 w-full" type="number" name="cantidad_alumnos" min="1" required />
                    </div>

                    <div class="mt-4">
                        <x-label for="fk_pnf" value="PNF" />
                        <select name="fk_pnf" id="fk_pnf" class="form-control" required>
                            <option value="">Seleccione un PNF</option>
                            @foreach ($pnfs as $pnf)
                                <option value="{{ $pnf->id }}">{{ $pnf->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-label for="fk_trayecto" value="Trayecto" />
                        <select name="fk_trayecto" id="fk_trayecto" class="form-control" required>
                            <option value="">Seleccione un Trayecto</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-label for="fk_unidad_curricular" value="Unidad Curricular" />
                        <select name="fk_unidad_curricular" id="fk_unidad_curricular" class="form-control" required>
                            <option value="">Seleccione una Unidad Curricular</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('secciones.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" id="submitButton" class="btn btn-primary ms-4">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para Selectores Dependientes -->
    <script>
        $(document).ready(function() {
            // Cargar trayectos al seleccionar un PNF
            $('#fk_pnf').on('change', function() {
                const pnfId = $(this).val();
                $('#fk_trayecto').prop('disabled', true).empty().append('<option value="" selected disabled>Cargando trayectos...</option>');

                if (pnfId) {
                    $.ajax({
                        url: `/unidad_curricular/trayectos/${pnfId}`,
                        method: 'GET',
                        success: function(data) {
                            $('#fk_trayecto').prop('disabled', false).empty().append('<option value="" selected disabled>Seleccione un trayecto</option>');
                            data.forEach(trayecto => {
                                $('#fk_trayecto').append(`<option value="${trayecto.id}">${trayecto.nombre}</option>`);
                            });
                        },
                        error: function() {
                            $('#fk_trayecto').prop('disabled', true).empty().append('<option value="" selected disabled>Error al cargar trayectos</option>');
                        }
                    });
                }
            });

            // Cargar Unidades Curriculares al seleccionar un Trayecto
            $('#fk_trayecto').on('change', function() {
    const trayectoId = $(this).val();
    const pnfId = $('#fk_pnf').val();
    $('#fk_unidad_curricular').prop('disabled', true).empty().append('<option value="" selected disabled>Cargando unidades curriculares...</option>');

    if (trayectoId && pnfId) {
        $.ajax({
            url: `/unidad_curricular/unidades/${pnfId}/${trayectoId}`,
            method: 'GET',
            success: function(data) {
                $('#fk_unidad_curricular').prop('disabled', false).empty().append('<option value="" selected disabled>Seleccione una unidad curricular</option>');
                data.forEach(unidad => {
                    $('#fk_unidad_curricular').append(`<option value="${unidad.id}">${unidad.nombre}</option>`);
                });
            },
            error: function() {
                $('#fk_unidad_curricular').prop('disabled', true).empty().append('<option value="" selected disabled>Error al cargar unidades curriculares</option>');
            }
        });
    }
});
        });
    </script>
</x-app-layout>
