<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Asignaciones PNF por Docentes</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <!-- Botón para asignar docentes -->
                <div class="flex justify-end mb-4">
                    <a href="{{ route('docentesporpnf.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Asignar Docente a PNF
                    </a>
                </div>

                <!-- Filtro por PNF -->
                <form method="GET" action="{{ route('docentesporpnf.index') }}" class="mb-6">
                    <x-label for="filter_pnf" value="Filtrar por PNF" />
                    <select name="filter_pnf" id="filter_pnf" class="block mt-1 w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos</option>
                        @foreach ($pnfs as $pnf)
                            <option value="{{ $pnf->id }}" {{ request('filter_pnf') == $pnf->id ? 'selected' : '' }}>
                                {{ $pnf->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-success mt-4">Filtrar</button>
                </form>

                <!-- Listado de asignaciones -->
                <table class="table-auto w-full mt-4 border border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-center">Docente</th>
                            <th class="border px-4 py-2 text-left">PNFs Asignados</th>
                            <th class="border px-4 py-2 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($docentesPorPNF->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center py-4">No hay asignaciones registradas.</td>
                            </tr>
                        @endif
                        @foreach ($docentesPorPNF as $docente => $asignaciones)
                            <tr class="border-b">
                                <td class="border px-4 py-2 align-middle text-center font-bold">
                                    {{ $docente }}
                                </td>
                                <td class="border px-4 py-2">
                                    <ul class="list-disc pl-5">
                                        @foreach ($asignaciones as $asignacion)
                                            <li>{{ $asignacion->pnf->nombre }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    <a href="{{ route('docentesporpnf.edit', $asignaciones->first()->user_id) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
