@extends('layouts.app')

@section('welcome')
    <div class="welcome-container pl-[150px] flex h-[100vh] mt-[50px] justify-between">
        <div class="welcome-left flex flex-col items-start text-[#191919]">
            <h1 class="welcome-title text-left text-[96px] font-medium leading-[0.9] whitespace-nowrap">
                NIKE AIR MAX<br><span class="text-[240px] font-bold">97</span>
            </h1>
            <p class="welcome-info text-left text-[18px] font-medium max-w-[500px] pt-[50px]">
                Волнообразные линии, футуристичный силуэт и революционная воздушная подушка — кроссовки Nike Air Max 97 уже более двух десятилетий остаются символом прогрессивного дизайна и непревзойдённого комфорта.
            </p>
            <div class="welcome-action flex gap-[14px] pt-[30px] items-center">
                <p class="welcome-price font-bold text-[32px]">{{ number_format($featuredProduct->price, 0, ',', ' ') }} ₽</p>

                @php
                    $inCart = auth()->check() && auth()->user()->cartItems()->where('product_id', $featuredProduct->id)->exists();
                @endphp

                @if($inCart)
                    <div class="flex items-center gap-2">
                        <form action="{{ route('cart.decrement', $featuredProduct) }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                title="Уменьшить количество"
                                class="text-[#fff] text-[24px] font-semibold welcome-btn-cart rounded-l-[20px] bg-[#365B6A] flex justify-center items-center py-[18px] px-[24px] hover:bg-[#2a4753] transition-colors"
                            >
                                -
                            </button>
                        </form>
                        <span class="text-[24px] font-semibold bg-[#365B6A] text-[#fff] py-[18px] px-[10px]">
                            {{ auth()->user()->cartItems()->where('product_id', $featuredProduct->id)->first()->quantity }}
                        </span>
                        <form action="{{ route('cart.add', $featuredProduct) }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                title="Увеличить количество"
                                class="text-[#fff] text-[24px] font-semibold welcome-btn-cart rounded-r-[20px] bg-[#365B6A] flex justify-center items-center py-[18px] px-[24px] hover:bg-[#2a4753] transition-colors"
                            >
                                +
                            </button>
                        </form>
                    </div>
                @else
                    <form action="{{ route('cart.add', $featuredProduct) }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            title="Добавить в корзину"
                            class="text-[#fff] text-[24px] font-semibold welcome-btn-cart rounded-[20px] bg-[#365B6A] flex justify-center items-center py-[18px] px-[36px] hover:bg-[#2a4753] transition-colors"
                        >
                            В корзину
                        </button>
                    </form>
                @endif
            </div>
        </div>
        <div class="welcome-right bg-[#365B6A] rounded-tl-[50px] rounded-bl-[50px] w-[35vw] mr-0 h-[85vh]">
            <img
                src="{{ asset('images/welcome-img.png') }}"
                alt="welcome image"
                class="object-contain absolute h-full top-[60px] right-[125px] welcome-image w-[800px] transform rotate-[0deg]"
            >
        </div>
    </div>
@endsection

@section('content')
    <h1 class="font-montserrat text-2xl font-bold text-[#191919] text-center mb-10">Каталог обуви</h1>

    <form method="GET" action="{{ route('products.index') }}" class="mb-6 flex flex-wrap items-center justify-center gap-4">
        <input type="text" name="search" placeholder="Поиск по названию" value="{{ request('search') }}"
               class="border rounded-[0.7rem] px-3 py-2 w-64" />

        <select name="category_id" class="border rounded-[0.7rem] px-3 py-2 w-[180px]">
            <option value="">Все категории</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>

        <div class="relative">
            <select name="price_sort" class="border rounded-[0.7rem] px-8 py-2 appearance-none bg-white">
                <option value="">Сортировка по цене</option>
                <option value="asc" @selected(request('price_sort') == 'asc')>По возрастанию</option>
                <option value="desc" @selected(request('price_sort') == 'desc')>По убыванию</option>
            </select>
            <div class="absolute inset-y-0 left-2 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        <button type="submit" class="bg-[rgb(54,91,106)] text-white px-4 py-2 rounded-[0.7rem] hover:bg-[rgb(40,70,82)] transition">
            Применить
        </button>

        @if(request()->hasAny(['search', 'category_id', 'price_sort']))
            <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-800 underline">
                Сбросить фильтры
            </a>
        @endif
    </form>

    <div class="flex flex-wrap gap-6 mx-32 my-5">
        @forelse ($products as $product)
            @php
                $isFavorite = auth()->check() && auth()->user()->favorites->contains('product_id', $product->id);
                $isInCart = auth()->check() && auth()->user()->cartItems()->where('product_id', $product->id)->exists();
                $itemInCartCount = 0;
                if(auth()->check() && auth()->user()->role !== 'admin') {
                    $cartItem = auth()->user()->cartItems()->where('product_id', $product->id)->first();
                    $itemInCartCount = $cartItem ? $cartItem->quantity : 0;
                }
            @endphp

            <div class="flex flex-col border border-gray-300 rounded-xl p-3 w-[220px] bg-white shadow-sm hover:shadow-md transition-shadow relative group">
                <!-- Обертка для кликабельных элементов (изображение и название) -->
                <a href="{{ route('products.show', $product) }}" class="block mb-3">
                    <div class="relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-44 object-cover rounded-lg">
                        @endif

                        <!-- Кнопка избранного - выносим за пределы ссылки -->
                        <form action="{{ route('favorites.toggle', $product) }}" method="POST" class="absolute top-1.5 right-1.5 z-10">
                            @csrf
                            <div class="relative">
                                @if($isFavorite)
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[rgba(54,91,106,0.4)] opacity-75 -z-10"></span>
                                @endif
                                <button type="submit" title="{{ $isFavorite ? 'Удалить из избранного' : 'Добавить в избранное' }}"
                                        class="bg-white/80 backdrop-blur-sm border {{ $isFavorite ? 'border-[rgb(54,91,106)] bg-[rgba(54,91,106,0.1)]' : 'border-gray-200 hover:border-[rgb(54,91,106)]' }} cursor-pointer rounded-full p-1 transition-all hover:scale-110 hover:shadow-md relative z-0">
                                    <svg width="16" height="16" viewBox="0 0 18 17" xmlns="http://www.w3.org/2000/svg"
                                         class="{{ $isFavorite ? 'text-[rgb(54,91,106)]' : 'text-gray-400' }} transition-colors mx-auto">
                                        <path d="M5.85 13.825L9 11.925L12.15 13.85L11.325 10.25L14.1 7.85L10.45 7.525L9 4.125L7.55 7.5L3.9 7.825L6.675 10.25L5.85 13.825ZM9 14.275L4.85 16.775C4.66663 16.8917 4.47496 16.9417 4.27496 16.925C4.07496 16.9083 3.89996 16.8417 3.74996 16.725C3.59996 16.6083 3.4833 16.4627 3.39996 16.288C3.31663 16.1133 3.29996 15.9173 3.34996 15.7L4.45 10.975L0.775 7.8C0.608296 7.65 0.504296 7.479 0.462963 7.287C0.421629 7.095 0.433963 6.90768 0.499963 6.725C0.565963 6.54235 0.665963 6.39235 0.799963 6.275C0.933963 6.15768 1.1173 6.08268 1.35 6.05L6.2 5.625L8.075 1.175C8.1583 0.975 8.28763 0.825 8.46296 0.725C8.6383 0.625 8.8173 0.575 9 0.575C9.18263 0.575 9.36163 0.625 9.53696 0.725C9.7123 0.825 9.84163 0.975 9.925 1.175L11.8 5.625L16.65 6.05C16.8833 6.08335 17.0666 6.15835 17.2 6.275C17.3333 6.39168 17.4333 6.54168 17.5 6.725C17.5666 6.90835 17.5793 7.096 17.538 7.288C17.4966 7.48 17.3923 7.65068 17.225 7.8L13.55 10.975L14.65 15.7C14.7 15.9167 14.6833 16.1127 14.6 16.288C14.5166 16.4633 14.4 16.609 14.25 16.725C14.1 16.841 13.925 16.9077 13.725 16.925C13.525 16.9423 13.3333 16.8923 13.15 16.775L9 14.275Z"
                                              fill="currentColor"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                    <h3 class="text-center text-base font-semibold my-2 text-gray-800">{{ $product->name }}</h3>
                </a>

                <!-- Блок с ценой и кнопками корзины -->
                <div class="flex justify-between items-center mt-auto">
                    <p class="text-gray-800 font-semibold">{{ number_format($product->price, 2) }} ₽</p>

                    @if($isInCart)
                        <div class="flex items-center gap-1">
                            <form action="{{ route('cart.decrement', $product) }}" method="POST">
                                @csrf
                                <button
                                    type="submit"
                                    title="Уменьшить количество"
                                    class="text-[#fff] text-[14px] font-semibold rounded-l-[12px] bg-[#365B6A] flex justify-center items-center py-[8px] px-[12px] hover:bg-[#2a4753] transition-colors"
                                >
                                    -
                                </button>
                            </form>
                            <span class="text-[14px] font-semibold bg-[#365B6A] text-[#fff] py-[8px] px-[6px]">
                    {{ $itemInCartCount }}
                </span>
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button
                                    type="submit"
                                    title="Увеличить количество"
                                    class="text-[#fff] text-[14px] font-semibold rounded-r-[12px] bg-[#365B6A] flex justify-center items-center py-[8px] px-[12px] hover:bg-[#2a4753] transition-colors"
                                >
                                    +
                                </button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                title="Добавить в корзину"
                                class="text-[#fff] text-[14px] font-semibold rounded-[12px] bg-[#365B6A] flex justify-center items-center py-[8px] px-[16px] hover:bg-[#2a4753] transition-colors"
                            >
                                В корзину
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="w-full text-center">Товары не найдены.</p>
        @endforelse
    </div>
@endsection
