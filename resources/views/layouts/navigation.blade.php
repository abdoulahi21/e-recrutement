@php
    // Configuration des liens de navigation
    $navLinks = [
        [
            'name' => 'Offres d\'emploi',
            'route' => 'jobs',
            'active' => request()->routeIs('jobs') || request()->routeIs('jobs-detail')
        ],
        [
            'name' => 'Tableau de bord',
            'route' => 'candidat.dashboard',
            'active' => request()->routeIs('candidat.dashboard')
        ],
    ];

    // Configuration des liens du dropdown utilisateur
    $userDropdownLinks = [
        [
            'name' => 'Profil',
            'route' => 'profile.edit',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>',
            'class' => ''
        ],
        [
            'name' => 'Paramètres',
            'route' => 'settings.index',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>',
            'class' => ''
        ]
    ];
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-10">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/" class="flex items-center">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                            <x-application-logo class="w-8 h-8 text-white" />
                        </div>
                        <span class="text-xl font-semibold text-gray-900">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                @auth
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        @foreach($navLinks as $link)
                            <x-nav-link
                                :href="Route::has($link['route']) ? route($link['route']) : '#'"
                                :active="$link['active']"
                                class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium
                                leading-5 transition duration-150 ease-in-out focus:outline-none
                                {{ $link['active'] ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-green-600 hover:border-green-300 focus:text-green-700 focus:border-green-300' }}">
                                {{ __($link['name']) }}
                            </x-nav-link>
                        @endforeach
                    </div>
                @endauth
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden md:flex sm:items-center sm:ml-6">
                @auth
                    <!-- Notifications Button -->
                    <button class="relative p-2 text-gray-400 hover:text-green-600 transition-colors duration-200 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5-5 5-5H9l4 4-4 4z"></path>
                        </svg>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-orange-500 rounded-full"></span>
                    </button>

                    <!-- User Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-green-600 focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-orange-500 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-sm font-medium">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </span>
                                    </div>
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @foreach($userDropdownLinks as $link)
                                <x-dropdown-link
                                    :href="Route::has($link['route']) ? route($link['route']) : '#'"
                                    class="flex items-center {{ $link['class'] }}">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        {!! $link['icon'] !!}
                                    </svg>
                                    {{ __($link['name']) }}
                                </x-dropdown-link>
                            @endforeach

                            <div class="border-t border-gray-100"></div>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link
                                    :href="route('logout')"
                                    class="flex items-center text-red-600 hover:text-red-700 hover:bg-red-50"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    {{ __('Se déconnecter') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>

                @else
                    <!-- Guest Links -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            Se connecter
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-orange-500 text-white px-6 py-2 rounded-lg text-sm font-medium hover:from-green-600 hover:to-orange-600 transition-all duration-200 shadow-md hover:shadow-lg">
                                S'inscrire
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="-mr-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-green-600 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-green-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
        @auth
            <!-- Mobile Navigation Links -->
            <div class="pt-2 pb-3 space-y-1 bg-gray-50">
                @foreach($navLinks as $link)
                    <x-responsive-nav-link
                        :href="Route::has($link['route']) ? route($link['route']) : '#'"
                        :active="$link['active']"
                        class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium focus:outline-none transition duration-150 ease-in-out {{ $link['active'] ? 'border-green-500 text-green-600 bg-green-50' : 'border-transparent text-gray-600 hover:text-green-600 hover:bg-gray-50 hover:border-green-300 focus:text-green-600 focus:bg-gray-50 focus:border-green-300' }}">
                        {{ __($link['name']) }}
                    </x-responsive-nav-link>
                @endforeach
            </div>

            <!-- Mobile User Menu -->
            <div class="pt-4 pb-1 border-t border-gray-200 bg-white">
                <!-- User Info -->
                <div class="px-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-orange-500 rounded-full flex items-center justify-center mr-3">
                        <span class="text-white font-medium">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </span>
                        </div>
                        <div>
                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                </div>

                <!-- Mobile User Links -->
                <div class="mt-3 space-y-1">
                    @foreach($userDropdownLinks as $link)
                        <x-responsive-nav-link
                            :href="Route::has($link['route']) ? route($link['route']) : '#'"
                            class="flex items-center {{ $link['class'] }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $link['icon'] !!}
                            </svg>
                            {{ __($link['name']) }}
                        </x-responsive-nav-link>
                    @endforeach

                    <!-- Mobile Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link
                            :href="route('logout')"
                            class="flex items-center text-red-600"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            {{ __('Se déconnecter') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>

        @else
            <!-- Mobile Guest Links -->
            <div class="pt-2 pb-3 space-y-1 bg-gray-50">
                <x-responsive-nav-link :href="route('login')" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-green-600 hover:bg-gray-50 hover:border-green-300 focus:outline-none focus:text-green-600 focus:bg-gray-50 focus:border-green-300 transition duration-150 ease-in-out">
                    Se connecter
                </x-responsive-nav-link>

                @if (Route::has('register'))
                    <x-responsive-nav-link :href="route('register')" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-green-600 hover:bg-gray-50 hover:border-green-300 focus:outline-none focus:text-green-600 focus:bg-gray-50 focus:border-green-300 transition duration-150 ease-in-out">
                        S'inscrire
                    </x-responsive-nav-link>
                @endif
            </div>
        @endauth
    </div>
</nav>
