<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Trayecto</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('trayectos.update', $trayecto) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-label for="codigo" value="Código" />
                        <x-input id="codigo" class="block mt-1 w-full" type="text" name="codigo" value="{{ $trayecto->codigo }}" required  />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div>
                        <x-label for="nombre" value="Nombre" />
                        <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" value="{{ $trayecto->nombre }}" required  />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="mt-4">
                        <x-label for="descripcion" value="Descripción" />
                        <x-input id="descripcion" class="block mt-1 w-full" type="text" name="descripcion" value="{{ $trayecto->descripcion }}" required  />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="mt-4">
                        <x-label for="fk_pnf" value="PNF Asociado" />
                        <select name="fk_pnf" id="fk_pnf" class="block mt-1 w-full">
                            @foreach ($pnfs as $pnf)
                                <option value="{{ $pnf->id }}" {{ $trayecto->fk_pnf == $pnf->id ? 'selected' : '' }}>
                                    {{ $pnf->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-label for="estatus" value="Estatus" />
                        <select name="estatus" id="estatus" class="block mt-1 w-full">
                            <option value="1" {{ $trayecto->estatus == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ $trayecto->estatus == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href={{ asset('trayects') }} class="btn btn-secondary"> Voler</a>
                        <button id="submitButton" class="btn btn-primary ms-4" disabled><i class="bi bi-check-lg"></i> Actualizar Trayecto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
    // Convertir texto a mayúsculas
    $('input[type="text"]').on('input', function() {
        $(this).val($(this).val().toUpperCase());
    });

    // Validación del Código
    $('#codigo').on('input', function() {
        const valor = $(this).val().trim();
        const regex = /^[0-9]{2}$/;
        if (!regex.test(valor)) {
            mostrarError('codigo', 'Debe tener 2 dígitos numéricos.');
        } else {
            ocultarError('codigo');
        }
    });

    // Validación del Nombre
    $('#nombre').on('input', function() {
        const valor = $(this).val().trim();
        const regex = /^[A-Za-zÁÉÍÓÚÑñ\s]+$/;
        if (!regex.test(valor)) {
            mostrarError('nombre', 'Solo se permiten letras y espacios.');
        } else {
            ocultarError('nombre');
        }
    });

    // Validación de la Descripción
    $('#descripcion').on('input', function() {
        const valor = $(this).val().trim();
        if (valor === '') {
            mostrarError('descripcion', 'La descripción es obligatoria.');
        } else {
            ocultarError('descripcion');
        }
    });

    // Validación del PNF
    $('#fk_pnf').on('change', function() {
        const valor = $(this).val();
        if (!valor) {
            mostrarError('fk_pnf', 'Debe seleccionar un PNF asociado.');
        } else {
            ocultarError('fk_pnf');
        }
        validarFormulario();
    });

    // Validación del Estatus
    $('#estatus').on('change', function() {
        const valor = $(this).val();
        if (!valor) {
            mostrarError('estatus', 'Seleccione un estatus.');
        } else {
            ocultarError('estatus');
        }
        validarFormulario();
    });

    // Mostrar errores
    function mostrarError(id, mensaje) {
        $('#' + id).addClass('border-red-500');
        $('#' + id).next('.error-message').text(mensaje).removeClass('hidden');
    }

    // Ocultar errores
    function ocultarError(id) {
        $('#' + id).removeClass('border-red-500');
        $('#' + id).next('.error-message').text('').addClass('hidden');
    }

    // Validación General
    function validarFormulario() {
        let camposValidos = true;

        ['codigo', 'nombre', 'descripcion', 'fk_pnf', 'estatus'].forEach(function(id) {
            const elemento = $('#' + id);

            if (elemento.val().trim() === '' || elemento.hasClass('border-red-500')) {
                camposValidos = false;
            }
        });

        $('#submitButton').prop('disabled', !camposValidos);
    }

    // Validar al cargar la página
    $('#fk_pnf').trigger('change');
    $('#estatus').trigger('change');
    validarFormulario();

    // Validar en cada interacción
    $('input, select').on('input change', validarFormulario);
});
    </script>
</x-app-layout>
