<nav x-data="{ open: false }" class="sticky top-0 z-50 flex items-center h-[80px] bg-[#365B6A] shadow-[0_3px_17px_0_rgba(0,0,0,0.25)]">
    <!-- Primary Navigation Menu -->
    <div class="w-full px-[150px]">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    @php
                        $logoLink = route('products.index');
                        if(auth()->check() && auth()->user()->role === 'admin') {
                            $logoLink = route('admin.dashboard');
                        }
                    @endphp

                    <a href="{{ $logoLink }}">
                        <img src="{{ asset('images/Logo.svg') }}" alt="Логотип" style="height: 50px; width: auto;">
                    </a>
                </div>

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-[30px]">
                @auth
                    @if(auth()->user()->role !== 'admin')
                        @php
                            $cartCount = auth()->user()->cartItems()->sum('quantity');
                            $favoritesCount = auth()->user()->favorites()->count();
                        @endphp

                            <!-- Иконка корзины -->
                        <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-gray-900" title="Корзина">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.822 7.43101C21.73 7.29808 21.6072 7.18943 21.464 7.11437C21.3209 7.03931 21.1616 7.00007 21 7.00001H7.333L6.179 4.23001C6.02813 3.86492 5.77202 3.55299 5.44328 3.33394C5.11453 3.1149 4.72803 2.99865 4.333 3.00001H2V5.00001H4.333L9.077 16.385C9.15299 16.5672 9.28118 16.7228 9.44542 16.8322C9.60967 16.9416 9.80263 17 10 17H18C18.417 17 18.79 16.741 18.937 16.352L21.937 8.35201C21.9937 8.20063 22.0129 8.03776 21.9928 7.87736C21.9728 7.71696 21.9142 7.5638 21.822 7.43101ZM17.307 15H10.667L8.167 9.00001H19.557L17.307 15Z" fill="white" stroke="white"/>
                                <path d="M10.5 21C11.3284 21 12 20.3284 12 19.5C12 18.6716 11.3284 18 10.5 18C9.67157 18 9 18.6716 9 19.5C9 20.3284 9.67157 21 10.5 21Z" fill="white"/>
                                <path d="M17.5 21C18.3284 21 19 20.3284 19 19.5C19 18.6716 18.3284 18 17.5 18C16.6716 18 16 18.6716 16 19.5C16 20.3284 16.6716 21 17.5 21Z" fill="white"/>
                            </svg>

                            @if($cartCount > 0)
                                <span class="absolute top-[4px] right-[10px] inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-[rgb(166,169,170)] rounded-full -translate-x-1/2 -translate-y-1/2">
                        {{ $cartCount }}
                    </span>
                            @endif
                        </a>

                        <!-- Иконка избранного -->
                        <a href="{{ route('favorites.index') }}" class="relative text-gray-700 hover:text-gray-900" title="Избранное">
                            <svg width="21" height="20" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.84996 13.825L8.99996 11.925L12.15 13.85L11.325 10.25L14.1 7.85001L10.45 7.52501L8.99996 4.12501L7.54996 7.50001L3.89996 7.82501L6.67496 10.25L5.84996 13.825ZM8.99996 14.275L4.84996 16.775C4.66663 16.8917 4.47496 16.9417 4.27496 16.925C4.07496 16.9083 3.89996 16.8417 3.74996 16.725C3.59996 16.6083 3.4833 16.4627 3.39996 16.288C3.31663 16.1133 3.29996 15.9173 3.34996 15.7L4.44996 10.975L0.774963 7.80001C0.608296 7.65001 0.504296 7.47901 0.462963 7.28701C0.421629 7.09501 0.433963 6.90768 0.499963 6.72501C0.565963 6.54235 0.665963 6.39235 0.799963 6.27501C0.933963 6.15768 1.1173 6.08268 1.34996 6.05001L6.19996 5.62501L8.07496 1.17501C8.1583 0.975012 8.28763 0.825012 8.46296 0.725012C8.6383 0.625012 8.8173 0.575012 8.99996 0.575012C9.18263 0.575012 9.36163 0.625012 9.53696 0.725012C9.7123 0.825012 9.84163 0.975012 9.92496 1.17501L11.8 5.62501L16.65 6.05001C16.8833 6.08335 17.0666 6.15835 17.2 6.27501C17.3333 6.39168 17.4333 6.54168 17.5 6.72501C17.5666 6.90835 17.5793 7.09601 17.538 7.28801C17.4966 7.48001 17.3923 7.65068 17.225 7.80001L13.55 10.975L14.65 15.7C14.7 15.9167 14.6833 16.1127 14.6 16.288C14.5166 16.4633 14.4 16.609 14.25 16.725C14.1 16.841 13.925 16.9077 13.725 16.925C13.525 16.9423 13.3333 16.8923 13.15 16.775L8.99996 14.275Z" fill="white"/>
                            </svg>


                            @if($favoritesCount > 0)
                                <span class="absolute top-0 right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-[rgb(166,169,170)] rounded-full -translate-x-1/2 -translate-y-1/2">
                        {{ $favoritesCount }}
                    </span>
                            @endif
                        </a>
                    @endif
                @endauth

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.show')">
                            {{ __('Профиль') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('orders.index')">
                            {{ __('История заказов') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Выйти') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            @if(auth()->check() && auth()->user()->role !== 'admin')
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Профиль') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('orders.index')">
                    {{ __('История заказов') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Выйти') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoriesToggle = document.getElementById('categories-toggle');
            const categoriesMenu = document.getElementById('categories-menu');

            if (!categoriesToggle || !categoriesMenu) return;

            // Переключение видимости меню категорий при клике на кнопку
            categoriesToggle.addEventListener('click', function () {
                if (categoriesMenu.style.display === 'block') {
                    categoriesMenu.style.display = 'none';
                } else {
                    categoriesMenu.style.display = 'block';
                }
            });

            // Закрывать меню при клике вне его
            document.addEventListener('click', function(event) {
                const isClickInside = categoriesToggle.contains(event.target) || categoriesMenu.contains(event.target);
                if (!isClickInside) {
                    categoriesMenu.style.display = 'none';
                }
            });
        });
    </script>
</nav>
