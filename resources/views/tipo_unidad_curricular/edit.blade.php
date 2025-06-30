<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Tipo de Unidad Curricular</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('tipo_unidad_curricular.update', $tipoUnidadCurricular) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-label for="nombre" value="Nombre" />
                        <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" value="{{ $tipoUnidadCurricular->nombre }}" required autofocus  />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="mt-4">
                        <x-label for="descripcion" value="Descripción" />
                        <x-input id="descripcion" class="block mt-1 w-full" type="text" name="descripcion" value="{{ $tipoUnidadCurricular->descripcion }}" required  />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="mt-4">
                        <x-label for="estatus" value="Estatus" />
                        <select name="estatus" id="estatus" class="block mt-1 w-full">
                            <option value="1" {{ $tipoUnidadCurricular->estatus == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ $tipoUnidadCurricular->estatus == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href={{ asset('tipo_unidad_curricular') }} class="btn btn-secondary">Volver</a>
                        <button id="submitButton" class="btn btn-primary ms-4" disabled><i class="bi bi-check-lg"></i>Actualizar Tipo de Unidad Curricular</button>
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

        $('#estatus').on('change', function() {
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
