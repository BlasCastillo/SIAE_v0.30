<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Trayecto</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('trayectos.store') }}">
                    @csrf

                    <div>
                        <x-label for="codigo" value="Código" />
                        <x-input id="codigo" class="block mt-1 w-full" type="text" name="codigo" required autofocus  />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="mt-4">
                        <x-label for="nombre" value="Nombre" />
                        <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" required  />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="mt-4">
                        <x-label for="descripcion" value="Descripción" />
                        <x-input id="descripcion" class="block mt-1 w-full" type="text" name="descripcion" required />
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="mt-4">
                        <x-label for="fk_pnf" value="PNF Asociado" />
                        <select name="fk_pnf" id="fk_pnf" class="block mt-1 w-full">
                            <option value="">Seleccione un PNF</option>
                            @foreach ($pnfs as $pnf)
                                <option value="{{ $pnf->id }}">{{ $pnf->nombre }}</option>
                            @endforeach
                        </select>
                        <span class="error-message text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href={{ asset('trayectos') }} class="btn btn-secondary">Volver</a>
                        <button id="submitButton" class="btn btn-primary ms-4" disabled><i class="bi bi-check-lg"></i> Crear Trayecto</button>
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

        $('#codigo').on('input', function() {
            let valor = $(this).val();
            let regex = /^[0-9]{2}$/;
            if (!regex.test(valor)) {
                mostrarError('codigo', 'El código debe tener exactamente 2 dígitos numéricos.');
            } else {
                ocultarError('codigo');
            }
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

        $('#fk_pnf').on('change', function() {
            if ($(this).val() === '') {
                mostrarError('fk_pnf', 'Debe seleccionar un PNF.');
            } else {
                ocultarError('fk_pnf');
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
