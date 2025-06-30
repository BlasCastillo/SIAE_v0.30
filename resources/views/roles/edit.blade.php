<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Rol: {{ $role->name }}
        </h2>
    </x-slot>

    <div class="py-12 contenedor" style="overflow: visible; height: auto;" >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="overflow: visible; height: auto;">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="overflow: visible; height: auto;">
                <div class="p-6 bg-white border-b border-gray-200" style="overflow: visible; height: auto;">
                    <h2 class="text-lg font-medium text-gray-900">Editar Rol: {{ $role->name }}</h2>

                    <form method="POST" action="{{ route('roles.update', $role->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nombre del Rol -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Rol</label>
                            <input id="name" name="name" type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                value="{{ $role->name }}" required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Permisos -->
                        <div class="mb-4" style="overflow: visible; height: auto;">
                            <label class="form-label fw-semibold">Permisos</label>

                            <div class="row g-4" id="permissionsGrid">
                                @foreach ($groupedPermissions as $group => $permissions)
                                    <div class="col-12 col-md-6 permission-cell border rounded shadow-sm bg-white">
                                        <button type="button"
                                            class="btn btn w-100 text-center fw-semibold permission-toggle"
                                            aria-expanded="false" aria-controls="panel-{{ $loop->index }}"
                                            id="toggle-{{ $loop->index }}"
                                            @if (count($permissions) === 0) disabled @endif>
                                            {{ ucfirst($group) }}
                                        </button>

                                        @if (count($permissions) > 0)
                                            <div class="permission-panel" id="panel-{{ $loop->index }}" role="region"
                                                aria-labelledby="toggle-{{ $loop->index }}">
                                                @foreach ($permissions as $permission)
                                                    <div class="form-check py-1">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="permission-{{ $permission->id }}" name="permissions[]"
                                                            value="{{ $permission->id }}"
                                                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="permission-{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <style>
                            .permission-cell {
                                position: relative;
                            }

                            .permission-panel {
                                position: relative;
                                /* Por defecto relativo */
                                max-height: 0;
                                overflow: hidden;
                                transition: max-height 0.3s ease, padding 0.3s ease;
                                padding-left: 1rem;
                                padding-right: 1rem;
                                padding-top: 0;
                                padding-bottom: 0;
                                border-top: 1px solid #dee2e6;
                                border-radius: 0 0 0.375rem 0.375rem;
                                background-color: #fff;
                                z-index: auto;
                            }

                            .permission-panel.open {
                                max-height: 200px;
                                padding-top: 1rem;
                                padding-bottom: 1rem;
                                overflow-y: visible;
                            }

                            .permission-panel.absolute {
                                position: absolute !important;
                                top: 100%;
                                left: 0;
                                right: 0;
                                z-index: 20;
                                box-shadow: 0 4px 6px rgb(0 0 0 / 0.1);
                                border: 1px solid #dee2e6;
                                border-top: none;
                                border-radius: 0 0 0.375rem 0.375rem;
                                background: white;
                            }

                            .contenedor{
                                height: auto;
                                overflow: visible;
                            }
                        </style>

                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                const toggles = document.querySelectorAll('.permission-toggle');

                                toggles.forEach(toggle => {
                                    toggle.addEventListener('click', () => {
                                        if (toggle.disabled) return;

                                        const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
                                        const panelId = toggle.getAttribute('aria-controls');
                                        const panel = document.getElementById(panelId);

                                        toggles.forEach(t => {
                                            const p = document.getElementById(t.getAttribute('aria-controls'));
                                            if (p) {
                                                // Si el panel está abierto, iniciamos el cierre
                                                if (p.classList.contains('open')) {
                                                    p.classList.remove('open');
                                                    // Esperar a que termine la transición para quitar absolute
                                                    const onTransitionEnd = (e) => {
                                                        if (e.propertyName === 'max-height') {
                                                            p.classList.remove('absolute');
                                                            p.removeEventListener('transitionend',
                                                                onTransitionEnd);
                                                        }
                                                    };
                                                    p.addEventListener('transitionend', onTransitionEnd);
                                                }
                                            }
                                            t.setAttribute('aria-expanded', 'false');
                                        });

                                        if (!isExpanded && panel) {
                                            toggle.setAttribute('aria-expanded', 'true');
                                            panel.classList.add('absolute');
                                            // Forzar reflow para que la transición funcione bien al agregar 'open'
                                            void panel.offsetWidth;
                                            panel.classList.add('open');
                                        }
                                    });
                                });

                                // Cerrar paneles al hacer clic fuera
                                document.addEventListener('click', (e) => {
                                    if (![...toggles].some(btn => btn.contains(e.target)) &&
                                        ![...document.querySelectorAll('.permission-panel')].some(p => p.contains(e.target))) {
                                        toggles.forEach(t => {
                                            const p = document.getElementById(t.getAttribute('aria-controls'));
                                            if (p && p.classList.contains('open')) {
                                                p.classList.remove('open');
                                                const onTransitionEnd = (e) => {
                                                    if (e.propertyName === 'max-height') {
                                                        p.classList.remove('absolute');
                                                        p.removeEventListener('transitionend', onTransitionEnd);
                                                    }
                                                };
                                                p.addEventListener('transitionend', onTransitionEnd);
                                            }
                                            t.setAttribute('aria-expanded', 'false');
                                        });
                                    }
                                });
                            });
                        </script>

<br><br><br><br>
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary mr-2">
                                volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i>
                                Actualizar Rol
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
