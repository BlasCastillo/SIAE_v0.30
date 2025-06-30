<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src={{ asset('Imagenes/siae-dashboard.png') }} alt="" srcset=""
                            class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :active="request()->routeIs('dashboard')" href="{{ route('dashboard') }}">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-dropdown align="left" width="1">{{-- Archivo --}}
                        <x-slot name="trigger">
                            <button type="button"
                                class="inline-flex items-center px-1 pt-4 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500
                                hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out"
                                style="padding: 20px">
                                {{ __('Archivos') }}
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @can('users.index')
                                <x-dropdown-link href="{{ route('users.index') }}">
                                    {{ __('Usuarios') }}
                                </x-dropdown-link>
                            @endcan
                            @can('aulas.index')
                                <x-dropdown-link href="{{ route('aulas.index') }}">
                                    {{ __('Aulas') }}
                                </x-dropdown-link>
                            @endcan
                            @can('sedes.index')
                                <x-dropdown-link href="{{ route('sedes.index') }}">
                                    {{ __('Sedes') }}
                                </x-dropdown-link>
                            @endcan
                            @can('pnfs.index')
                                <x-dropdown-link href="{{ route('pnfs.index') }}">
                                    {{ __('PNFs') }}
                                </x-dropdown-link>
                            @endcan
                        </x-slot>
                    </x-dropdown>

                    <x-dropdown align="left" width="1">{{-- Proceso --}}
                        <x-slot name="trigger">
                            <button type="button"
                                class="inline-flex items-center px-1 pt-4 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500
                                hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out"
                                style="padding: 20px">
                                {{ __('Procesos') }}
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @can('trayectos.index')
                                <x-dropdown-link href="{{ route('trayectos.index') }}">
                                    {{ __('Trayectos') }}
                                </x-dropdown-link>
                            @endcan
                            @can('unidad_curricular.index')
                                <x-dropdown-link href="{{ route('unidad_curricular.index') }}">
                                    {{ __('Unidad Curricular') }}
                                </x-dropdown-link>
                            @endcan
                            @can('docentesporpnf.index')
                                <x-dropdown-link href="{{ route('docentesporpnf.index') }}">
                                    {{ __('Docentes por PNF') }}
                                </x-dropdown-link>
                            @endcan
                        </x-slot>
                    </x-dropdown>

                    <x-dropdown align="left" width="1">{{-- Horarios --}}
                        <x-slot name="trigger">
                            <button type="button"
                                class="inline-flex items-center px-1 pt-4 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500
                                hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out"
                                style="padding: 20px">
                                {{ __('Horarios') }}
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Asignar Espacios') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('dashboard') }}">
                                {{ __('Lista de Espacios') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <x-dropdown align="left" width="1">{{-- Configuracion --}}
                        <x-slot name="trigger">
                            <button type="button"
                                class="inline-flex items-center px-1 pt-4 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500
                                hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out"
                                style="padding: 20px">
                                {{ __('Configuracion') }}
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @can('tipo-aulas.index')
                                <x-dropdown-link href="{{ route('tipo-aulas.index') }}">
                                    {{ __('Tipo de Aulas') }}
                                </x-dropdown-link>
                            @endcan
                            @can('tipo_unidad_curricular.index')
                                <x-dropdown-link href="{{ route('tipo_unidad_curricular.index') }}">
                                    {{ __('Tipo de unidedes Curriculares') }}
                                </x-dropdown-link>
                            @endcan
                            @can('roles.index')
                                <x-dropdown-link href="{{ route('roles.index') }}">
                                    {{ __('Roles') }}
                                </x-dropdown-link>
                            @endcan
                            @can('duraciones.index')
                                <x-dropdown-link href="{{ route('duraciones.index') }}">
                                    {{ __('Duracion') }}
                                </x-dropdown-link>
                            @endcan
                            @can('dias.index')
                            <x-dropdown-link href="{{ route('dias.index') }}">
                                {{ __('Dias Academicos') }}
                            </x-dropdown-link>
                            @endcan
                            @can('horas.index')
                            <x-dropdown-link href="{{ route('horas.index') }}">
                                {{ __('Horas Academicos') }}
                            </x-dropdown-link>
                            @endcan
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <!-- Team Switcher -->
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-200"></div>

                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="size-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Administrar cuenta') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Perfil') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Cerrar sesión') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('roles.index') }}" :active="request()->routeIs('roles.index')">
                {{ __('Roles') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('tipo-aulas.index') }}" :active="request()->routeIs('tipo-aulas.index')">
                {{ __('Tipo de Aulas') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('aulas.index') }}" :active="request()->routeIs('aulas.index')">
                {{ __('Aulas') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('pnfs.index') }}" :active="request()->routeIs('pnfs.index')">
                {{ __('Pnf´s') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('trayectos.index') }}" :active="request()->routeIs('trayectos.index')">
                {{ __('trayectos') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                        :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link" />
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>
