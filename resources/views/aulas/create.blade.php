<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Aula</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('aulas.store') }}">
                    @csrf

                    <div>
                        <x-label for="nombre" value="Nombre" />
                        <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" required
                            autofocus />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="mt-4">
                        <x-label for="descripcion" value="Descripción" />
                        <x-input id="descripcion" class="block mt-1 w-full" type="text" name="descripcion" required
                        />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="mt-4">
                        <x-label for="cantidad" value="Cantidad" />
                        <x-input id="cantidad" class="block mt-1 w-full" type="number" name="cantidad" required
                        />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="mt-4">
                        <x-label for="fk_tipo_aulas" value="Tipo de Aula" />
                        <select name="fk_tipo_aulas" id="fk_tipo_aulas" class="block mt-1 w-full">
                            <option value="">Seleccione un tipo de aula</option>
                            @foreach ($tipoAulas as $tipoAula)
                                <option value="{{ $tipoAula->id }}">{{ $tipoAula->nombre }}</option>
                            @endforeach
                        </select>
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href={{ asset('aulas') }} class="btn btn-secondary">Volver</a>
                        <button id="submitButton" class="btn btn-primary ms-4" disabled><i class="bi bi-check-lg"></i>
                            Crear Aula</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
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

            $('#nombre').on('input', function() {
                let valor = $(this).val();
                let regex = /^[A-Za-zÁÉÍÓÚÑñ0-9\s]+$/; // 🔥 Permite letras, números y espacios
                if (!regex.test(valor)) {
                    mostrarError('nombre', 'El nombre solo puede contener letras, números y espacios.');
                } else {
                    ocultarError('nombre');
                }
            });


            $('#descripcion').on('input', function() {
                let valor = $(this).val();
                if (valor.trim() === '') {
                    mostrarError('descripcion', 'La descripción no puede estar vacía.');
                } else {
                    ocultarError('descripcion');
                }
            });

            // 🔥 Validar que la cantidad solo tenga números y esté dentro del rango permitido
            $('#cantidad').on('keypress', function(e) {
                if (e.which < 48 || e.which > 57) {
                    e.preventDefault();
                }
            }).on('input', function() {
                let cantidad = parseInt($(this).val(), 10);
                if (isNaN(cantidad) || cantidad < 20 || cantidad > 50) {
                    mostrarError('cantidad', 'La cantidad debe estar entre 20 y 50.');
                } else {
                    ocultarError('cantidad');
                }
            });

            $('#fk_tipo_aula').on('change', function() {
                if ($(this).val() === '') {
                    mostrarError('fk_tipo_aula', 'Debe seleccionar un tipo de aula.');
                } else {
                    ocultarError('fk_tipo_aula');
                }
                validarFormulario();
            });

            function validarFormulario() {
                let camposValidos = true;

                $('input, select').each(function() {
                    if ($(this).hasClass('border-red-500') || $(this).val().trim() === '') {
                        camposValidos = false;
                    }
                });

                $('#submitButton').prop('disabled', !camposValidos);
            }

            $('input, select').on('input change', validarFormulario);
        });
    </script>

</x-app-layout>
