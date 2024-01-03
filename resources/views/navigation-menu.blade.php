<nav
    x-data="{ mobileMenu: false, userMenu: false }"
    class="bg-white shadow dark:bg-gray-700">
    <div class="mx-auto max-w-7xl px-2 sm:px-4 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex px-2 lg:px-0">
                <div class="flex flex-shrink-0 items-center">
                    @auth
                        <a href="{{ route('dashboard') }}">
                            <x-application-logo class="h-10"/>
                        </a>
                    @endauth
                    @guest
                        <a href="{{ route('welcome') }}">
                            <x-application-logo class="h-10"/>
                        </a>
                    @endguest
                </div>
                <div class="hidden lg:ml-6 lg:flex lg:space-x-8">
                    @auth
                        <x-nav-link wire:navigate href="{{ route('dashboard') }}"
                                    :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endauth

                    @guest
                        <x-nav-link wire:navigate href="{{ route('welcome') }}"
                                    :active="request()->routeIs('welcome')">
                            {{ __('Home') }}
                        </x-nav-link>
                    @endguest
                </div>
            </div>
            <div class="flex flex-1 items-center justify-center px-2 lg:ml-6 lg:justify-end">
                <div class="w-full max-w-lg lg:max-w-xs">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                 aria-hidden="true">
                                <path fill-rule="evenodd"
                                      d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <input id="search" name="search"
                               class="block w-full rounded-md border-0 bg-white py-1.5 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                               placeholder="Search" type="search">
                    </div>
                </div>
            </div>
            @guest
                <div class="flex items-center lg:ml-4 lg:flex-shrink-0 hidden lg:inline-flex">
                    @if (Route::has('login'))
                        <x-button type="button" wire:navigate href="{{ route('login') }}"
                                  class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                            {{ __('Login') }}
                        </x-button>
                    @endif
                </div>
            @endguest
            <div class="flex items-center lg:hidden">
                <!-- Mobile menu button -->
                <button type="button"
                        @click="mobileMenu = !mobileMenu"
                        class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                        aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>

                    <svg
                        :class="mobileMenu ? 'hidden' : 'block'"
                        class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>

                    <svg
                        :class="mobileMenu ? 'block' : 'hidden'"
                        class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            @auth
                <div class="hidden lg:ml-4 lg:flex lg:items-center">
                    <button type="button"
                            class="relative flex-shrink-0 rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="absolute -inset-1.5"></span>
                        <span class="sr-only">View notifications</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                             aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                        </svg>
                    </button>

                    <!-- Profile dropdown -->
                    <div class="relative ml-4 flex-shrink-0">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">

                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover"
                                             src="{{ Auth::user()->profile_photo_url }}"
                                             alt="{{ Auth::user()->getFullName() }}"/>
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                    <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        {{ Auth::user()->getFullName() }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                    </button>
                                </span>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>

                                <x-dropdown-link wire:navigate href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link wire:navigate href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-dropdown-link>
                                @endif

                                <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-dropdown-link href="{{ route('logout') }}"
                                                     @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div
        x-show="mobileMenu"
        @click.away="mobileMenu = false"
        class="lg:hidden" id="mobile-menu">
        <div class="space-y-1 pb-3 pt-2">
            @auth
                <x-responsive-nav-link wire:navigate href="{{ route('dashboard') }}"
                                       :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endauth

            @guest
                <x-responsive-nav-link wire:navigate href="{{ route('welcome') }}"
                                       :active="request()->routeIs('welcome')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
            @endguest
        </div>
        @auth
            <div class="border-t border-gray-200 pb-3 pt-4">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button
                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-10 w-10 rounded-full object-cover"
                                     src="{{ Auth::user()->profile_photo_url }}"
                                     alt="{{ Auth::user()->getFullName() }}"/>
                            </button>
                        @else
                            <span class="inline-flex rounded-md">
                                    <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        {{ Auth::user()->getFullName() }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                    </button>
                                </span>
                        @endif
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">{{ Auth::user()->getFullName() }} </div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                    <button type="button"
                            class="relative ml-auto flex-shrink-0 rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="absolute -inset-1.5"></span>
                        <span class="sr-only">View notifications</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                             aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                        </svg>
                    </button>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link wire:navigate href="{{ route('profile.show') }}"
                                           :active="request()->routeIs('profile.show')">
                        {{ __('Your Profile') }}
                    </x-responsive-nav-link>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <x-responsive-nav-link wire:navigate href="{{ route('api-tokens.index') }}"
                                               :active=" request()->routeIs('api-tokens.index')">
                            {{ __('API Tokens') }}
                        </x-responsive-nav-link>
                    @endif

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf

                        <x-responsive-nav-link
                            href="{{ route('logout') }}"
                            @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
        @guest
            <div class="border-t border-gray-200 pb-3 pt-4">
                @if(Route::has('login'))
                    <x-responsive-nav-link wire:navigate href="{{ route('login') }}"
                                           :active="request()->routeIs('login')">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                @endif

                @if (Route::has('register'))
                    <x-responsive-nav-link wire:navigate href="{{ route('register') }}"
                                           :active=" request()->routeIs('register')">
                        {{ __('Sign Up') }}
                    </x-responsive-nav-link>
                @endif
            </div>
        @endguest
    </div>
</nav>
