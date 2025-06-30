<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Hora</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('horas.store') }}">
                    @csrf

                    <div>
                        <x-label for="hora_inicio" value="Hora de Inicio" />
                        <x-input id="hora_inicio" class="block mt-1 w-full" type="time" name="hora_inicio" required autofocus  />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="mt-4">
                        <x-label for="hora_fin" value="Hora de Fin" />
                        <x-input id="hora_fin" class="block mt-1 w-full" type="time" name="hora_fin" required  />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href={{ asset('horas') }} class="btn btn-secondary">Volver</a>
                        <button id="submitButton" class="btn btn-primary ms-4" disabled><i class="bi bi-check-lg"></i>Crear Hora</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#hora_inicio, #hora_fin').on('input', function() {
                let inicio = $('#hora_inicio').val();
                let fin = $('#hora_fin').val();

                if (inicio && fin) {
                    let diffInMinutes = calculateTimeDifference(inicio, fin);
                    if (diffInMinutes !== 45) {
                        mostrarError('hora_fin', 'La diferencia debe ser de 45 minutos.');
                    } else {
                        ocultarError('hora_fin');
                    }
                } else {
                    ocultarError('hora_fin');
                }
                validarFormulario();
            });

            $('#hora_inicio').on('input', function() {
                let valor = $(this).val();
                if (!valor) {
                    mostrarError('hora_inicio', 'La hora de inicio es requerida.');
                } else {
                    ocultarError('hora_inicio');
                }
                validarFormulario();
            });

            $('#hora_fin').on('input', function() {
                let valor = $(this).val();
                if (!valor) {
                    mostrarError('hora_fin', 'La hora de fin es requerida.');
                } else {
                    ocultarError('hora_fin');
                }
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

            function calculateTimeDifference(startTime, endTime) {
                let start = moment(startTime, 'HH:mm');
                let end = moment(endTime, 'HH:mm');
                return end.diff(start, 'minutes');
            }

            function validarFormulario() {
                let camposValidos = true;

                $('input').each(function() {
                    if ($(this).hasClass('border-red-500') || ($(this).prop('required') && $(this).val().trim() === '')) {
                        camposValidos = false;
                    }
                });
                let inicio = $('#hora_inicio').val();
                let fin = $('#hora_fin').val();
                 if (inicio && fin) {
                    let diffInMinutes = calculateTimeDifference(inicio, fin);
                     if (diffInMinutes !== 45) {
                        camposValidos = false;
                    }
                }

                $('#submitButton').prop('disabled', !camposValidos);
            }

            $('input').on('input', validarFormulario);
        });
    </script>
</x-app-layout>
