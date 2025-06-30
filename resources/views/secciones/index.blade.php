<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Listado de Secciones</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <!-- Botón para crear nueva sección -->
                @can('secciones.create')
                <div class="flex justify-end mb-4">
                    <a href="{{ route('secciones.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Nueva Sección
                    </a>
                </div>
                @endcan

                <!-- Filtros -->
                <form method="GET" action="{{ route('secciones.index') }}" class="mb-4">
                    <div class="flex gap-4">
                        <div class="w-1/3">
                            <x-label for="filter_pnf" value="Filtrar por PNF" />
                            <select name="filter_pnf" id="filter_pnf" class="form-control">
                                <option value="">Todos</option>
                                @foreach ($pnfs as $pnf)
                                    <option value="{{ $pnf->id }}" {{ request('filter_pnf') == $pnf->id ? 'selected' : '' }}>
                                        {{ $pnf->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-1/3">
                            <x-label for="filter_trayecto" value="Filtrar por Trayecto" />
                            <select name="filter_trayecto" id="filter_trayecto" class="form-control">
                                <option value="">Todos</option>
                                @foreach ($trayectos as $trayecto)
                                    <option value="{{ $trayecto->id }}" {{ request('filter_trayecto') == $trayecto->id ? 'selected' : '' }}>
                                        {{ $trayecto->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-1/3">
                            <x-label for="ver_inactivas" value="Ver Secciones Inactivas" />
                            <input type="checkbox" name="ver_inactivas" id="ver_inactivas" {{ request('ver_inactivas') ? 'checked' : '' }}>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-4">Filtrar</button>
                </form>

                <!-- Listado de Secciones -->
                <table class="table-auto w-full mt-4 border border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">Nombre</th>
                            <th class="border px-4 py-2 text-left">Código</th>
                            <th class="border px-4 py-2 text-left">Cantidad de Alumnos</th>
                            <th class="border px-4 py-2 text-left">PNF</th>
                            <th class="border px-4 py-2 text-left">Trayecto</th>
                            <th class="border px-4 py-2 text-left">Unidad Curricular</th>
                            <th class="border px-4 py-2 text-left">Estatus</th>
                            @canany(['secciones.edit', 'secciones.destroy'])
                            <th class="border px-4 py-2 text-left">Acciones</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($secciones as $seccion)
                            <tr>
                                <td class="border px-4 py-2">{{ $seccion->nombre }}</td>
                                <td class="border px-4 py-2">{{ $seccion->codigo }}</td>
                                <td class="border px-4 py-2">{{ $seccion->cantidad_alumnos }}</td>
                                <td class="border px-4 py-2">{{ $seccion->pnf->nombre }}</td>
                                <td class="border px-4 py-2">{{ $seccion->trayecto->nombre }}</td>
                                <td class="border px-4 py-2">{{ $seccion->unidadCurricular->nombre }}</td>
                                <td class="border px-4 py-2">{{ $seccion->estatus == '1' ? 'Activa' : 'Inactiva' }}</td>
                                @canany(['secciones.edit', 'secciones.destroy'])
                                <td class="border px-4 py-2">
                                    @can('secciones.edit')
                                    <a href="{{ route('secciones.edit', $seccion->id) }}" class="btn btn-warning">Editar</a>
                                    @endcan
                                    @can('secciones.destroy')
                                    <form method="POST" action="{{ route('secciones.destroy', $seccion->id) }}" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                    @endcan
                                </td>
                                @endcanany
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No hay secciones registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
