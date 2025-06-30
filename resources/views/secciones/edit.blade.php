<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Sección</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('secciones.update', $seccion->id) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-label for="nombre" value="Nombre (3 dígitos)" />
                        <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" maxlength="3"
                            value="{{ $seccion->nombre }}" required />
                    </div>

                    <div class="mt-4">
                        <x-label for="cantidad_alumnos" value="Cantidad de Alumnos" />
                        <x-input id="cantidad_alumnos" class="block mt-1 w-full" type="number" name="cantidad_alumnos"
                            value="{{ $seccion->cantidad_alumnos }}" min="1" required />
                    </div>

                    <div class="mt-4">
                        <x-label for="fk_pnf" value="PNF" />
                        <select name="fk_pnf" id="fk_pnf" class="form-control" required>
                            <option value="">Seleccione un PNF</option>
                            @foreach ($pnfs as $pnf)
                                <option value="{{ $pnf->id }}" {{ $seccion->fk_pnf == $pnf->id ? 'selected' : '' }}>
                                    {{ $pnf->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-label for="fk_trayecto" value="Trayecto" />
                        <select name="fk_trayecto" id="fk_trayecto" class="form-control" required>
                            <option value="">Seleccione un Trayecto</option>
                            @foreach ($trayectos as $trayecto)
                                <option value="{{ $trayecto->id }}"
                                    {{ $seccion->fk_trayecto == $trayecto->id ? 'selected' : '' }}>
                                    {{ $trayecto->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-label for="fk_unidad_curricular" value="Unidad Curricular" />
                        <select name="fk_unidad_curricular" id="fk_unidad_curricular" class="form-control" required>
                            <option value="">Seleccione una Unidad Curricular</option>
                            @foreach ($unidadesCurriculares as $unidadCurricular)
                                <option value="{{ $unidadCurricular->id }}"
                                    {{ $seccion->fk_unidad_curricular == $unidadCurricular->id ? 'selected' : '' }}>
                                    {{ $unidadCurricular->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Campo de estatus -->
                    <div class="mt-4">
                        <x-label for="estatus" value="Estatus" />
                        <select name="estatus" id="estatus" class="form-control" required>
                            <option value="1" {{ $seccion->estatus == '1' ? 'selected' : '' }}>Activa</option>
                            <option value="0" {{ $seccion->estatus == '0' ? 'selected' : '' }}>Inactiva</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('secciones.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" id="submitButton" class="btn btn-primary ms-4">Actualizar</button>
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

                            // Limpia el selector de Unidades Curriculares al cambiar PNF
                            $('#fk_unidad_curricular').prop('disabled', true).empty().append('<option value="" selected disabled>Seleccione una unidad curricular</option>');
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
