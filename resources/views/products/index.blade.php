@extends('layouts.app')

@push('styles')
    @vite('resources/css/products/index.css')
@endpush


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
                <p class="welcome-price font-bold text-[32px]">12.999 ₽</p>

                <button
                    type="submit"
                    title="Добавить в корзину"
                    class="text-[#fff] text-[24px] font-semibold welcome-btn-cart rounded-[20px] bg-[#365B6A] flex justify-center items-center py-[18px] px-[36px]"
                >
                    В корзину
                </button>


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
    <h1 class="font-montserrat text-2xl font-bold text-[#191919]">Каталог обуви</h1>

    @if(isset($category))
        <h2 class="text-center mb-5">Категория: {{ $category->name }}</h2>
    @endif

    <div class="flex flex-wrap gap-6 mx-32 my-5">
        @forelse ($products as $product)
            @php
                $isFavorite = auth()->check() && auth()->user()->favorites->contains('product_id', $product->id);
                $itemInCartCount = 0;
                if(auth()->check() && auth()->user()->role !== 'admin') {
                    $cartItem = auth()->user()->cartItems()->where('product_id', $product->id)->first();
                    $itemInCartCount = $cartItem ? $cartItem->quantity : 0;
                }
            @endphp

            <div class="flex flex-col border border-gray-300 rounded-xl p-3 w-[220px] bg-white shadow-sm hover:shadow-md transition-shadow relative group">
                <a href="{{ route('products.show', $product) }}" class="absolute inset-0 z-10" aria-label="Перейти к товару {{ $product->name }}"></a>

                <div class="relative mb-3">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-44 object-cover rounded-lg">
                    @endif

                    <!-- Кнопка избранного -->
                    <form action="{{ route('favorites.toggle', $product) }}" method="POST" class="absolute top-1.5 right-1.5 z-20">
                        @csrf
                        <div class="relative">
                            @if($isFavorite)
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75 -z-10"></span>
                            @endif
                            <button type="submit" title="{{ $isFavorite ? 'Удалить из избранного' : 'Добавить в избранное' }}"
                                    class="bg-white/80 backdrop-blur-sm border {{ $isFavorite ? 'border-teal-700 bg-teal-50/80' : 'border-gray-200 hover:border-teal-400' }} cursor-pointer rounded-full p-1 transition-all hover:scale-110 hover:shadow-md relative z-0">
                                <svg width="16" height="16" viewBox="0 0 18 17" xmlns="http://www.w3.org/2000/svg"
                                     class="{{ $isFavorite ? 'text-teal-700' : 'text-gray-400' }} transition-colors mx-auto">
                                    <path d="M5.85 13.825L9 11.925L12.15 13.85L11.325 10.25L14.1 7.85L10.45 7.525L9 4.125L7.55 7.5L3.9 7.825L6.675 10.25L5.85 13.825ZM9 14.275L4.85 16.775C4.66663 16.8917 4.47496 16.9417 4.27496 16.925C4.07496 16.9083 3.89996 16.8417 3.74996 16.725C3.59996 16.6083 3.4833 16.4627 3.39996 16.288C3.31663 16.1133 3.29996 15.9173 3.34996 15.7L4.45 10.975L0.775 7.8C0.608296 7.65 0.504296 7.479 0.462963 7.287C0.421629 7.095 0.433963 6.90768 0.499963 6.725C0.565963 6.54235 0.665963 6.39235 0.799963 6.275C0.933963 6.15768 1.1173 6.08268 1.35 6.05L6.2 5.625L8.075 1.175C8.1583 0.975 8.28763 0.825 8.46296 0.725C8.6383 0.625 8.8173 0.575 9 0.575C9.18263 0.575 9.36163 0.625 9.53696 0.725C9.7123 0.825 9.84163 0.975 9.925 1.175L11.8 5.625L16.65 6.05C16.8833 6.08335 17.0666 6.15835 17.2 6.275C17.3333 6.39168 17.4333 6.54168 17.5 6.725C17.5666 6.90835 17.5793 7.096 17.538 7.288C17.4966 7.48 17.3923 7.65068 17.225 7.8L13.55 10.975L14.65 15.7C14.7 15.9167 14.6833 16.1127 14.6 16.288C14.5166 16.4633 14.4 16.609 14.25 16.725C14.1 16.841 13.925 16.9077 13.725 16.925C13.525 16.9423 13.3333 16.8923 13.15 16.775L9 14.275Z"
                                          fill="currentColor"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="flex flex-col flex-grow">
                    <h3 class="text-center text-base font-semibold my-2 text-gray-800">{{ $product->name }}</h3>
                </div>

                <div class="flex justify-between items-center mt-auto">
                    <p class="text-gray-800 font-semibold">{{ number_format($product->price, 2) }} ₽</p>
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="ml-auto relative z-20">
                        @csrf
                        <button type="submit" title="Добавить в корзину" class="bg-white/80 backdrop-blur-sm border border-gray-200 cursor-pointer rounded-full p-1 transition-all hover:scale-110 hover:shadow-md hover:border-teal-400">
                            <svg width="16" height="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="text-teal-700 mx-auto">
                                <path d="M21.822 7.431C21.73 7.298 21.607 7.189 21.464 7.114C21.321 7.039 21.162 7 21 7H7.333L6.179 4.23C6.028 3.865 5.772 3.553 5.443 3.334C5.115 3.115 4.728 2.999 4.333 3H2V5H4.333L9.077 16.385C9.153 16.567 9.281 16.723 9.445 16.832C9.61 16.942 9.803 17 10 17H18C18.417 17 18.79 16.741 18.937 16.352L21.937 8.352C21.994 8.201 22.013 8.038 21.993 7.877C21.973 7.717 21.914 7.564 21.822 7.431ZM17.307 15H10.667L8.167 9H19.557L17.307 15Z" fill="currentColor"/>
                                <path d="M10.5 21C11.328 21 12 20.328 12 19.5C12 18.672 11.328 18 10.5 18C9.672 18 9 18.672 9 19.5C9 20.328 9.672 21 10.5 21Z" fill="currentColor"/>
                                <path d="M17.5 21C18.328 21 19 20.328 19 19.5C19 18.672 18.328 18 17.5 18C16.672 18 16 18.672 16 19.5C16 20.328 16.672 21 17.5 21Z" fill="currentColor"/>
                            </svg>
                        </button>

                        @if(auth()->check() && $itemInCartCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-teal-600 rounded-full -translate-y-1/2 translate-x-1/2">
                                {{ $itemInCartCount }}
                            </span>
                        @endif
                    </form>
                </div>
            </div>
        @empty
            <p class="w-full text-center">Товары не найдены.</p>
        @endforelse
    </div>

    <div class="flex justify-center my-8">
        {{ $products->links() }}
    </div>
@endsection
