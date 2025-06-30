<div id="{{ $id }}" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
        <div class="flex justify-between mb-4">
            <h1 class="text-lg font-bold">{{'Menu de configuración'}}</h1>
            <button class="close-modal">
                <span>&times;</span>
            </button>
        </div>

        <div class="container text-center">
            <div class="cardBoxs">
                <div class="cardsM">
                    <div class="iconBxs">
                        <a :active="request()->routeIs('tipo-aulas.index')" href="{{ route('tipo-aulas.index') }}">
                            {{ __('Tipo de aulas') }}
                        </a>
                        <i class="bi bi-airplane-engines logo"></i>
                    </div>
                </div>
                <div class="cardsM">
                    <div class="iconBxs">
                        <a :active="request()->routeIs('roles.index')" href="{{ route('roles.index') }}">
                            {{ __('Roles') }}

                        <i class="bi bi-airplane-engines logo"></i>
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
