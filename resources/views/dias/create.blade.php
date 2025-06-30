<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Día</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('dias.store') }}">
                    @csrf

                    <div>
                        <x-label for="nombre" value="Nombre" />
                        <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" required autofocus />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="mt-4">
                        <x-label for="valor" value="Valor" />
                        <x-input id="valor" class="block mt-1 w-full" type="number" name="valor" required />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href={{ asset('dias') }} class="btn btn-secondary">Volver</a>
                        <button id="submitButton" class="btn btn-primary ms-4" disabled><i class="bi bi-check-lg"></i>Crear Día</button>
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

                $('input').each(function() {
                    if ($(this).hasClass('border-red-500') || $(this).val().trim() === '') {
                        camposValidos = false;
                    }
                });

                $('#submitButton').prop('disabled', !camposValidos);
            }

            $('input').on('input', validarFormulario);
        });
    </script>
</x-app-layout>
