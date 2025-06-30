<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Usuario
        </h2>
    </x-slot>

    <div class="py-12  items-center" style="margin: 0 auto; width: 70%;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- ✅ Mostrar mensajes de error correctamente -->
                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <div>
                            <x-label for="name" value="Nombre" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
                            <span class="error-message text-red-500 text-sm hidden"></span>
                        </div>

                        <div class="mt-4">
                            <x-label for="cedula" value="Cédula" />
                            <x-input id="cedula" class="block mt-1 w-full" type="text" name="cedula" required autofocus />
                            <span class="error-message text-red-500 text-sm hidden"></span>
                        </div>

                        <div class="mt-4">
                            <x-label for="cod_telefono" value="Código de Teléfono" />
                            <x-input id="cod_telefono" class="block mt-1 w-full" type="text" name="cod_telefono" required autofocus />
                            <span class="error-message text-red-500 text-sm hidden"></span>
                        </div>

                        <div class="mt-4">
                            <x-label for="num_telefono" value="Número de Teléfono" />
                            <x-input id="num_telefono" class="block mt-1 w-full" type="text" name="num_telefono" required autofocus />
                            <span class="error-message text-red-500 text-sm hidden"></span>
                        </div>

                        <div class="mt-4">
                            <x-label for="email" value="Email" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
                            <span class="error-message text-red-500 text-sm hidden"></span>
                        </div>

                        <div class="mt-4">
                            <x-label for="password" value="Contraseña" />
                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                            <span class="error-message text-red-500 text-sm hidden"></span>
                        </div>

                        <div class="mt-4">
                            <x-label for="password_confirmation" value="Confirmar Contraseña" />
                            <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                            <span class="error-message text-red-500 text-sm hidden"></span>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href={{ asset('users') }} class="btn btn-secondary">Volver</a>
                            <button id="submitButton" class="btn btn-primary" disabled>
                                Crear Usuario
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // 🔥 Convertir todos los campos a MAYÚSCULAS automáticamente
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

            // 🔥 Validar que el NOMBRE solo tenga letras y espacios
            $('#name').on('keypress', function(e) {
                let regex = /^[A-Za-zÁÉÍÓÚÑñ\s]+$/;
                let key = String.fromCharCode(e.which);
                if (!regex.test(key)) {
                    e.preventDefault();
                }
            }).on('input', function() {
                let valor = $(this).val();
                if (!/^[A-Za-zÁÉÍÓÚÑñ\s]+$/.test(valor)) {
                    mostrarError('name', 'El nombre solo puede contener letras y espacios.');
                } else {
                    ocultarError('name');
                }
            });

            // 🔥 Validar que la CÉDULA solo tenga números y esté dentro del rango permitido
            $('#cedula').on('keypress', function(e) {
                if (e.which < 48 || e.which > 57) {
                    e.preventDefault();
                }
            }).on('input', function() {
                let cedula = parseInt($(this).val(), 10);
                if (isNaN(cedula) || cedula < 1000000 || cedula > 50000000) {
                    mostrarError('cedula', 'La cédula debe estar entre 1.000.000 y 50.000.000.');
                } else {
                    ocultarError('cedula');
                }
            });

            // 🔥 Validar que el EMAIL tenga formato correcto
            $('#email').on('input', function() {
                let email = $(this).val();
                let regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!regex.test(email)) {
                    mostrarError('email', 'El correo debe tener formato nombre@dominio.com.');
                } else {
                    ocultarError('email');
                }
            });

            // 🔥 Validar CÓDIGO DE TELÉFONO (solo ciertos valores permitidos)
            $('#cod_telefono').on('keypress', function(e) {
                if (e.which < 48 || e.which > 57) {
                    e.preventDefault();
                }
            }).on('input', function() {
                let validCodes = ['0416', '0426', '0412', '0414', '0424', '0254'];
                if (!validCodes.includes($(this).val())) {
                    mostrarError('cod_telefono', 'El código de teléfono debe ser 0416, 0426, 0412, 0414, 0424 o 0254.');
                } else {
                    ocultarError('cod_telefono');
                }
            });

            // 🔥 Validar que el NÚMERO DE TELÉFONO solo tenga números
            $('#num_telefono').on('keypress', function(e) {
                if (e.which < 48 || e.which > 57) {
                    e.preventDefault();
                }
            }).on('input', function() {
                let valor = $(this).val();
                if (!/^[0-9]+$/.test(valor)) {
                    mostrarError('num_telefono', 'El número de teléfono solo debe contener números.');
                } else {
                    ocultarError('num_telefono');
                }
            });

            // 🔥 Validar CONTRASEÑA: mínimo 9 caracteres, al menos 1 mayúscula, 1 minúscula, 1 número y 1 carácter especial
            $('#password').on('input', function() {
                let password = $(this).val();
                let regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#@$!%*?&])[A-Za-z\d#@$!%*?&]{9,}$/;
                if (!regex.test(password)) {
                    mostrarError('password', 'La contraseña debe tener mínimo 9 caracteres, incluir mayúsculas, minúsculas, números y un carácter especial.');
                } else {
                    ocultarError('password');
                }
            });

            // 🔥 Habilitar/deshabilitar el botón Submit
            function validarFormulario() {
                let camposValidos = true;

                $('input').each(function() {
                    if ($(this).hasClass('border-red-500') || $(this).val().trim() === '') {
                        camposValidos = false;
                    }
                });

                if ($('#password').val().trim() === '' && $('#password_confirmation').val().trim() === '' && $('#password').closest('form').attr('id') === 'editForm') {
                    camposValidos = true; // En formulario de edición, la contraseña es opcional
                }

                $('#submitButton').prop('disabled', !camposValidos);
            }

            // 🔥 Validar el formulario en cada cambio
            $('input').on('input', validarFormulario);
        });
        </script>


</x-app-layout>
