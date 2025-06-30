<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles del Tipo de Aula') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nombre: {{ $tipoAula->nombre }}</h5>
                        <p class="card-text">Descripción: {{ $tipoAula->descripcion }}</p>
                        <p class="card-text">Valor: {{ $tipoAula->valor }}</p>
                        <p class="card-text">Estatus: {{ $tipoAula->estatus ? 'Activo' : 'Inactivo' }}</p>
                        <a href="{{ route('tipo-aulas.edit', $tipoAula->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('tipo-aulas.destroy', $tipoAula->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
