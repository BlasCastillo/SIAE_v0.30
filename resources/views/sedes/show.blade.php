<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles de la Sede') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <!-- Card para mostrar los detalles de la sede -->
                    <div class="card">
                        <div class="card-body">
                            <!-- Campo: Código -->
                            <h5 class="card-title">Código</h5>
                            <p class="card-text">{{ $sede->codigo }}</p>

                            <!-- Campo: Nombre -->
                            <h5 class="card-title">Nombre</h5>
                            <p class="card-text">{{ $sede->nombre }}</p>

                            <!-- Campo: Descripción -->
                            <h5 class="card-title">Descripción</h5>
                            <p class="card-text">{{ $sede->descripcion }}</p>

                            <!-- Campo: Estatus -->
                            <h5 class="card-title">Estatus</h5>
                            <p class="card-text">
                                @if ($sede->estatus)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </p>

                            <!-- Botón para volver a la lista -->
                            <a href="{{ route('sedes.index') }}" class="btn btn-secondary">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
