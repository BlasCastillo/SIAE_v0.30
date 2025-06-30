<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Tipo de Aula</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('tipo-aulas.update', $tipoAula) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-label for="nombre" value="Nombre" />
                        <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" value="{{ $tipoAula->nombre }}" required autofocus />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="mt-4">
                        <x-label for="descripcion" value="Descripción" />
                        <x-input id="descripcion" class="block mt-1 w-full" type="text" name="descripcion" value="{{ $tipoAula->descripcion }}" required />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="mt-4">
                        <x-label for="estatus" value="Estatus" />
                        <select name="estatus" id="estatus" class="block mt-1 w-full">
                            <option value="1" {{ $tipoAula->estatus == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ $tipoAula->estatus == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href={{ asset('tipo-aulas') }} class="btn btn-secondary">Volver</a>
                        <button id="submitButton" class="btn btn-primary ms-4" disabled><i class="bi bi-check-lg"></i> Actualizar Tipo de Aula</button>
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
                if (!/^[A-Za-zÁÉÍÓÚÑñ\s]+$/.test(valor)) {
                    mostrarError('nombre', 'El nombre solo puede contener letras y espacios.');
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

            // 🔥 Validar que el estatus siempre tenga un valor seleccionado
            $('#estatus').on('change', function() {
                validarFormulario();
            });

            function validarFormulario() {
                let camposValidos = true;

                // 🔥 Validar todos los inputs y el select
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
