<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                        <img src="{{ asset('images/my-logo.png') }}" alt="Логотип" style="height: 50px; width: auto;">
                    </a>
                </div>

                <!-- Кнопка переключения меню категорий -->
                <button id="categories-toggle" aria-label="Открыть меню категорий" style="font-size: 24px; background: none; border: none; cursor: pointer; margin-left: 10px;">
                    &#9776;
                </button>

                <!-- Меню категорий -->
                <div id="categories-menu" style="display: none; position: absolute; background: white; border: 1px solid #ccc; padding: 10px; z-index: 1000; margin-top: 50px; left: 10px;">
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @foreach($categories as $category)
                            <li style="margin-bottom: 5px;">
                                <a href="{{ route('products.byCategory', $category->id) }}" class="hover:underline">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    @if(auth()->user()->role !== 'admin')
                        @php
                            $cartCount = auth()->user()->cartItems()->sum('quantity');
                            $favoritesCount = auth()->user()->favorites()->count();
                        @endphp

                            <!-- Иконка корзины -->
                        <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-gray-900 ms-4" title="Корзина">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h11l-1.5-7M7 13h10M5 21h14"/>
                            </svg>

                            @if($cartCount > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full -translate-x-1/2 -translate-y-1/2">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <!-- Иконка избранного -->
                        <a href="{{ route('favorites.index') }}" class="relative text-gray-700 hover:text-gray-900 ms-4" title="Избранное">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linejoin="round" stroke-linecap="round">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>

                            @if($favoritesCount > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-yellow-500 rounded-full -translate-x-1/2 -translate-y-1/2">
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
