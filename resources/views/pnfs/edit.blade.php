<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar PNF</h2>
    </x-slot>

    <div class="py-12"  style="margin: 0 auto; width: 60%;">>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('pnfs.update', $pnf) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-label for="nombre" value="Nombre" />
                        <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" value="{{ $pnf->nombre }}" required autofocus autocomplete="nombre" />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div>
                        <x-label for="codigo" value="Código" />
                        <x-input id="codigo" class="block mt-1 w-full" type="text" name="codigo" value="{{ $pnf->codigo }}" required autocomplete="codigo" />
                        <span id="codigo-error" class="error-message text-red-500 text-sm hidden"></span>
                    </div>


                    <div class="mt-4">
                        <x-label for="descripcion" value="Descripción" />
                        <x-input id="descripcion" class="block mt-1 w-full" type="text" name="descripcion" value="{{ $pnf->descripcion }}" required autocomplete="descripcion" />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="mt-4">
                        <x-label for="estatus" value="Estatus" />
                        <select name="estatus" id="estatus" class="w-full pl-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="1" {{ $pnf->estatus == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ $pnf->estatus == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href={{ asset('pnfs') }} class="btn btn-secondary">Volver</a>
                        <button id="submitButton" class="btn btn-primary ms-4" disabled><i class="bi bi-check-lg"></i>Actualizar PNF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('input[type="text"]').not('#codigo').on('input', function() {
                $(this).val($(this).val().toUpperCase());
            });

            $('#codigo').on('keypress', function(event) {
                const charCode = event.which ? event.which : event.keyCode;
                if (charCode < 48 || charCode > 57) { // Solo permitir números
                    event.preventDefault();
                    $('#codigo-error').text('Ingrese solo números.').removeClass('hidden');
                } else {
                    $('#codigo-error').addClass('hidden');
                    if ($(this).val().length >= 2) {
                        event.preventDefault(); // No permitir más de dos dígitos
                    }
                }
            });

            $('#codigo').on('input', function() {
                if ($(this).val().length > 2) {
                    $(this).val($(this).val().slice(0, 2)); // Truncar a dos dígitos si se pega más
                }
                validarFormulario();
            });

            $('#estatus').on('change', function() {
                validarFormulario();
            });

            function validarFormulario() {
                let camposValidos = true;

                $('input[type="text"]').each(function() {
                    if ($(this).prop('required') && $(this).val().trim() === '') {
                        camposValidos = false;
                        $(this).addClass('border-red-500');
                        $(this).next('.error-message').removeClass('hidden').text('Este campo es requerido.');
                    } else {
                        $(this).removeClass('border-red-500');
                        $(this).next('.error-message').addClass('hidden');
                    }
                });

                // Validación específica para el código
                const codigoInput = $('#codigo');
                if (codigoInput.prop('required') && codigoInput.val().trim() === '') {
                    camposValidos = false;
                    codigoInput.addClass('border-red-500');
                    $('#codigo-error').removeClass('hidden').text('Este campo es requerido.');
                } else if (!/^\d+$/.test(codigoInput.val())) {
                    camposValidos = false;
                    codigoInput.addClass('border-red-500');
                    $('#codigo-error').removeClass('hidden').text('Ingrese solo números.');
                } else if (codigoInput.val().length !== 2) {
                    camposValidos = false;
                    codigoInput.addClass('border-red-500');
                    $('#codigo-error').removeClass('hidden').text('El código debe tener dos dígitos.');
                } else {
                    codigoInput.removeClass('border-red-500');
                    $('#codigo-error').addClass('hidden');
                }

                if ($('#estatus').val() === '') {
                    camposValidos = false;
                    $('#estatus').addClass('border-red-500');
                } else {
                    $('#estatus').removeClass('border-red-500');
                }

                $('#submitButton').prop('disabled', !camposValidos);
            }

            $('input[type="text"], #estatus').on('input change', validarFormulario);
            validarFormulario(); // Para validar al cargar la página
        });
    </script>

</x-app-layout>
