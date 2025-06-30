<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles del Trayecto') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <!-- Card para mostrar los detalles del trayectos -->
                    <div class="card">
                        <div class="card-body">
                            <!-- Campo: Nombre -->
                            <h5 class="card-title">Nombre</h5>
                            <p class="card-text">{{ $trayectos->nombre }}</p>

                            <!-- Campo: descripcion -->
                            <h5 class="card-title">Descripcion</h5>
                            <p class="card-text">{{ $trayectos->descripcion }}</p>

                            <!-- Campo: Estatus -->
                            <h5 class="card-title">Estatus</h5>
                            <p class="card-text">
                                @if ($trayectos->estatus)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </p>

                            <!-- Botón para volver a la lista -->
                            <a href="{{ route('trayectos.index') }}" class="btn btn-secondary">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
