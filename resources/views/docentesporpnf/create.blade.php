<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Asignar PNF a Docente</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('docentesporpnf.store') }}">
                    @csrf

                    <!-- Selección de docente -->
                    <div>
                        <x-label for="user_id" value="Seleccione Docente" />
                        <select name="user_id" id="user_id" class="block mt-1 w-full">
                            <option value="" selected disabled>Seleccione un docente...</option>
                            @foreach ($docentes as $docente)
                                <option value="{{ $docente->id }}">{{ $docente->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Selección de PNF -->
                    <div class="mt-4">
                        <x-label for="pnf_id" value="Seleccione PNF" />
                        @foreach ($pnfs as $pnf)
                            <div>
                                <input type="checkbox" name="pnf_id[]" value="{{ $pnf->id }}" id="pnf_{{ $pnf->id }}">
                                <label for="pnf_{{ $pnf->id }}">{{ $pnf->nombre }}</label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Botón Asignar -->
                    <div class="flex items-center justify-end mt-4">
                        <button class="btn btn-primary">Asignar PNF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
