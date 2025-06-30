<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Día</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('dias.update', $dia) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-label for="nombre" value="Nombre" />
                        <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" value="{{ $dia->nombre }}" required autofocus autocomplete="nombre" />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="mt-4">
                        <x-label for="valor" value="Valor" />
                        <x-input id="valor" class="block mt-1 w-full" type="number" name="valor" value="{{ $dia->valor }}" required autocomplete="valor" />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="mt-4">
                        <x-label for="estatus" value="Estatus" />
                        <select name="estatus" id="estatus" class="w-full pl-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="1" {{ $dia->estatus == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ $dia->estatus == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href={{ asset('dias') }} class="btn btn-secondary">Volver</a>
                        <button id="submitButton" class="btn btn-primary ms-4" disabled><i class="bi bi-check-lg"></i>Actualizar Día</button>
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

            $('#nombre').on('input', function() {
                let valor = $(this).val();
                let regex = /^[A-Za-zÁÉÍÓÚÑñ\s]+$/;
                if (!regex.test(valor)) {
                    mostrarError('nombre', 'El nombre solo puede contener letras y espacios.');
                } else {
                    ocultarError('nombre');
                }
            });

            $('#valor').on('input', function() {
                let valor = $(this).val();
                let regex = /^[0-9]+$/;
                if (!regex.test(valor)) {
                    mostrarError('valor', 'El valor debe ser un número.');
                } else {
                    ocultarError('valor');
                }
            });

            $('#estatus').on('change', function() {
                validarFormulario();
            });

            function mostrarError(id, mensaje) {
                $('#' + id).addClass('border-red-500');
                $('#' + id).next('.error-message').text(mensaje).removeClass('hidden');
            }

            function ocultarError(id) {
                $('#' + id).removeClass('border-red-500');
                $('#' + id).next('.error-message').text('').addClass('hidden');
            }

            function validarFormulario() {
                let camposValidos = true;

                $('input[type="text"], input[type="number"]').each(function() {
                    if ($(this).hasClass('border-red-500') || ($(this).prop('required') && $(this).val().trim() === '')) {
                        camposValidos = false;
                    }
                });

                if ($('#estatus').val() === '') {
                    camposValidos = false;
                    $('#estatus').addClass('border-red-500');
                } else {
                    $('#estatus').removeClass('border-red-500');
                }

                $('#submitButton').prop('disabled', !camposValidos);
            }

            $('input[type="text"], input[type="number"], #estatus').on('input change', validarFormulario);
            validarFormulario(); // Para validar al cargar la página
        });
    </script>
</x-app-layout>
