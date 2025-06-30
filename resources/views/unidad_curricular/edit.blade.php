<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Unidad Curricular</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('unidad_curricular.update', $unidadCurricular) }}">
                    @csrf
                    @method('PUT')

                    <!-- Código -->
                    <div>
                        <x-label for="codigo" value="Código" />
                        <x-input id="codigo" class="block mt-1 w-full" type="text" name="codigo" value="{{ $unidadCurricular->codigo }}" required autofocus />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <!-- Nombre -->
                    <div class="mt-4">
                        <x-label for="nombre" value="Nombre" />
                        <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" value="{{ $unidadCurricular->nombre }}" required />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <!-- Descripción -->
                    <div class="mt-4">
                        <x-label for="descripcion" value="Descripción" />
                        <x-input id="descripcion" class="block mt-1 w-full" type="text" name="descripcion" value="{{ $unidadCurricular->descripcion }}" required  />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <!-- Duración -->
                    <div class="mt-4">
                        <x-label for="duracion" value="Duración" />
                        <x-input id="duracion" class="block mt-1 w-full" type="text" name="duracion" value="{{ $unidadCurricular->duracion }}" required  />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <!-- PNF Asociado -->
                    <div class="mt-4">
                        <x-label for="fk_pnf" value="PNF Asociado" />
                        <select name="fk_pnf" id="fk_pnf" class="w-full pl-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            @foreach ($pnfs as $pnf)
                                <option value="{{ $pnf->id }}" {{ $unidadCurricular->fk_pnf == $pnf->id ? 'selected' : '' }}>
                                    {{ $pnf->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <!-- Trayecto Asociado -->
                    <div class="mt-4">
                        <x-label for="fk_trayecto" value="Trayecto Asociado" />
                        <select name="fk_trayecto" id="fk_trayecto" class="w-full pl-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            @foreach ($trayectos as $trayecto)
                                <option value="{{ $trayecto->id }}" {{ $unidadCurricular->fk_trayecto == $trayecto->id ? 'selected' : '' }}>
                                    {{ $trayecto->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <!-- Duración Asociada -->
                    <div class="mt-4">
                        <x-label for="fk_duracion" value="Duración Asociada" />
                        <select name="fk_duracion" id="fk_duracion" class="w-full pl-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            @foreach ($duraciones as $duracion)
                                <option value="{{ $duracion->id }}" {{ $unidadCurricular->fk_duracion == $duracion->id ? 'selected' : '' }}>
                                    {{ $duracion->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <!-- Estatus -->
                    <div class="mt-4">
                        <x-label for="estatus" value="Estatus" />
                        <select name="estatus" id="estatus" class="w-full pl-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="1" {{ $unidadCurricular->estatus == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ $unidadCurricular->estatus == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <!-- Botón Actualizar -->
                    <div class="flex items-center justify-end mt-4">
                        <a href={{ asset('unidad_curricular') }} class="btn btn-secondary">Volver</a>
                        <button id="submitButton" class="btn btn-primary ms-4" disabled><i class="bi bi-check-lg"></i> Actualizar Unidad Curricular</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
    // Selector dependiente: Cargar trayectos al cambiar PNF
    $('#fk_pnf').on('change', function() {
        const pnfId = $(this).val();
        $('#fk_trayecto').prop('disabled', true).empty().append('<option value="" selected disabled>Cargando trayectos...</option>');

        if (pnfId) {
            $.ajax({
                url: `/unidad_curricular/trayectos/${pnfId}`, // Ajusta este endpoint según tu configuración
                method: 'GET',
                success: function(data) {
                    $('#fk_trayecto').prop('disabled', false).empty().append('<option value="" disabled>Seleccione un trayecto</option>');
                    data.forEach(trayecto => {
                        $('#fk_trayecto').append(`<option value="${trayecto.id}" ${trayecto.id == "{{ $unidadCurricular->fk_trayecto }}" ? 'selected' : ''}>${trayecto.nombre}</option>`);
                    });
                },
                error: function() {
                    $('#fk_trayecto').prop('disabled', true).empty().append('<option value="" selected disabled>Error al cargar trayectos</option>');
                }
            });
        }
    });

    // Validaciones dinámicas con jQuery
    $('input[type="text"]').on('input', function() {
        $(this).val($(this).val().toUpperCase());
    });

    function mostrarError(id, mensaje) {
        $('#' + id).addClass('border-red-500');
        $('#' + id).next('.error-message').text(mensaje).removeClass('hidden');
    }

    function ocultarError(id) {
        $('#' + id).removeClass('border-red-500');
        $('#' + id).next('.error-message').text('').addClass('hidden');
    }

    $('#codigo').on('input', function() {
        const valor = $(this).val();
        const regex = /^[A-Za-z0-9]{3,5}$/; // Entre 3 y 5 caracteres alfanuméricos
        if (!regex.test(valor)) {
            mostrarError('codigo', 'Debe contener entre 3 y 5 caracteres alfanuméricos.');
        } else {
            ocultarError('codigo');
        }
    });

    $('#nombre').on('input', function() {
        const valor = $(this).val();
        const regex = /^[A-Za-zÁÉÍÓÚÑñ\s]+$/; // Solo letras y espacios
        if (!regex.test(valor)) {
            mostrarError('nombre', 'Solo se permiten letras y espacios.');
        } else {
            ocultarError('nombre');
        }
    });

    $('#descripcion').on('input', function() {
        const valor = $(this).val();
        if (valor.trim() === '') {
            mostrarError('descripcion', 'La descripción no puede estar vacía.');
        } else {
            ocultarError('descripcion');
        }
    });

    $('#duracion').on('input', function() {
        const valor = $(this).val();
        if (valor.trim() === '') {
            mostrarError('duracion', 'La duración no puede estar vacía.');
        } else {
            ocultarError('duracion');
        }
    });

    $('#fk_trayecto').on('change', function() {
        if ($(this).val() === null || $(this).val() === '') {
            mostrarError('fk_trayecto', 'Debe seleccionar un trayecto válido.');
        } else {
            ocultarError('fk_trayecto');
        }
    });

    // Validar el formulario
    function validarFormulario() {
        let camposValidos = true;
        $('input, select').each(function() {
            if ($(this).hasClass('border-red-500') || $(this).val().trim() === '') {
                camposValidos = false;
            }
        });

        $('#submitButton').prop('disabled', !camposValidos);
    }

    // Ejecutar validaciones cada vez que hay un cambio en los campos
    $('input, select').on('input change', validarFormulario);

    // Validar el formulario inicialmente al cargar la página
    validarFormulario();
});

    </script>
</x-app-layout>
