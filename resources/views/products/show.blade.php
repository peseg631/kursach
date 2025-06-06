@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto my-10 p-8 bg-white rounded-xl shadow-lg font-sans text-gray-800">
        <div class="flex flex-col items-center">
            <h1 class="text-4xl font-bold mb-5 text-gray-900">{{ $product->name }}</h1>

            @if($product->image)
                <div class="relative mb-5">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                         class="w-full max-w-md h-auto rounded-lg shadow-md">

                    @php
                        $isFavorite = auth()->check() && auth()->user()->favorites()->where('product_id', $product->id)->exists();
                    @endphp

                    <form action="{{ route('favorites.toggle', $product) }}" method="POST" class="absolute top-3 right-3 z-20">
                        @csrf
                        <div class="relative">
                            @if($isFavorite)
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[rgba(54,91,106,0.4)] opacity-75 -z-10"></span>
                            @endif
                            <button type="submit" title="{{ $isFavorite ? 'Удалить из избранного' : 'Добавить в избранное' }}"
                                    class="bg-white/80 backdrop-blur-sm border {{ $isFavorite ? 'border-[rgb(54,91,106)] bg-[rgba(54,91,106,0.1)]' : 'border-gray-200 hover:border-[rgb(54,91,106)]' }} cursor-pointer rounded-full p-2 transition-all hover:scale-110 hover:shadow-md relative z-0">
                                <svg width="20" height="20" viewBox="0 0 18 17" xmlns="http://www.w3.org/2000/svg"
                                     class="{{ $isFavorite ? 'text-[rgb(54,91,106)]' : 'text-gray-400' }} transition-colors mx-auto">
                                    <path d="M5.85 13.825L9 11.925L12.15 13.85L11.325 10.25L14.1 7.85L10.45 7.525L9 4.125L7.55 7.5L3.9 7.825L6.675 10.25L5.85 13.825ZM9 14.275L4.85 16.775C4.66663 16.8917 4.47496 16.9417 4.27496 16.925C4.07496 16.9083 3.89996 16.8417 3.74996 16.725C3.59996 16.6083 3.4833 16.4627 3.39996 16.288C3.31663 16.1133 3.29996 15.9173 3.34996 15.7L4.45 10.975L0.775 7.8C0.608296 7.65 0.504296 7.479 0.462963 7.287C0.421629 7.095 0.433963 6.90768 0.499963 6.725C0.565963 6.54235 0.665963 6.39235 0.799963 6.275C0.933963 6.15768 1.1173 6.08268 1.35 6.05L6.2 5.625L8.075 1.175C8.1583 0.975 8.28763 0.825 8.46296 0.725C8.6383 0.625 8.8173 0.575 9 0.575C9.18263 0.575 9.36163 0.625 9.53696 0.725C9.7123 0.825 9.84163 0.975 9.925 1.175L11.8 5.625L16.65 6.05C16.8833 6.08335 17.0666 6.15835 17.2 6.275C17.3333 6.39168 17.4333 6.54168 17.5 6.725C17.5666 6.90835 17.5793 7.096 17.538 7.288C17.4966 7.48 17.3923 7.65068 17.225 7.8L13.55 10.975L14.65 15.7C14.7 15.9167 14.6833 16.1127 14.6 16.288C14.5166 16.4633 14.4 16.609 14.25 16.725C14.1 16.841 13.925 16.9077 13.725 16.925C13.525 16.9423 13.3333 16.8923 13.15 16.775L9 14.275Z"
                                          fill="currentColor"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <p class="text-2xl font-bold mb-8 text-gray-900">{{ number_format($product->price, 2) }} ₽</p>
        </div>

        @if($product->description)
            <section class="mb-8">
                <h2 class="text-xl font-semibold mb-3 text-gray-700">Описание</h2>
                <p class="leading-relaxed text-gray-600">{{ $product->description }}</p>
            </section>
        @endif

        <div class="flex gap-4 mb-8 flex-wrap">

            @php
                $isInCart = auth()->check() && auth()->user()->cartItems()->where('product_id', $product->id)->exists();
            @endphp

            @if($isInCart)
                <div class="flex items-center gap-2">
                    <form action="{{ route('cart.decrement', $product) }}" method="POST">
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
            {{ auth()->user()->cartItems()->where('product_id', $product->id)->first()->quantity }}
        </span>
                    <form action="{{ route('cart.add', $product) }}" method="POST">
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
                <form action="{{ route('cart.add', $product) }}" method="POST">
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

        <a href="{{ route('products.index') }}" class="inline-block mb-10 text-[#365B6A] font-semibold hover:text-[#2d4b57] transition-colors">← Вернуться к каталогу</a>

        <section class="border-t border-gray-200 pt-8">
            <h2 class="text-2xl font-semibold mb-5 text-gray-900">Отзывы</h2>

            @auth
                @if($errors->has('limit'))
                    <div class="text-red-700 text-sm mb-4">
                        {{ $errors->first('limit') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('reviews.store', $product) }}" class="mb-10">
                    @csrf
                    <div class="mb-5">
                        <label for="rating" class="block font-semibold mb-2 text-gray-700">Оценка:</label>
                        <select name="rating" id="rating" required class="w-full p-3 border border-gray-300 rounded-lg text-gray-900 focus:border-blue-500 focus:outline-none">
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="text" class="block font-semibold mb-2 text-gray-700">Отзыв:</label>
                        <textarea name="text" id="text" rows="4" required class="w-full p-3 border border-gray-300 rounded-lg text-gray-900 focus:border-blue-500 focus:outline-none">{{ old('text') }}</textarea>
                        @error('text')
                        <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="bg-[#365B6A] text-white px-7 py-3 rounded-lg font-bold text-base hover:bg-[#2d4b57] transition-colors">Оставить отзыв</button>
                </form>
            @else
                <p class="mb-8">Чтобы оставить отзыв, пожалуйста, <a href="{{ route('login') }}" class="text-[#365B6A] font-semibold hover:underline">войдите в систему</a>.</p>
            @endauth

            <hr class="my-6 border-gray-200">

            @forelse ($product->reviews as $review)
                <article class="border border-gray-300 p-5 mb-5 rounded-xl bg-gray-50">
                    <header class="font-bold mb-2 text-gray-900">
                        <strong>{{ $review->user->name }}</strong> — Оценка: {{ $review->rating }}/5
                    </header>
                    <p class="text-gray-600 leading-relaxed mb-3">{{ $review->text }}</p>

                    <div class="flex items-center gap-4 flex-wrap">
                        @auth
                            <form action="{{ route('reviews.like.toggle', $review) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="flex items-center gap-1 font-semibold text-sm text-gray-500 hover:text-[#365B6A] transition-colors" aria-label="Лайк">
                                    <svg width="18" height="16" viewBox="0 0 18 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.75 6.75V15.75H0.75V6.75H3.75ZM6.75 15.75C6.35218 15.75 5.97064 15.592 5.68934 15.3107C5.40804 15.0294 5.25 14.6478 5.25 14.25V6.75C5.25 6.3375 5.415 5.9625 5.6925 5.6925L10.6275 0.75L11.4225 1.545C11.625 1.7475 11.7525 2.025 11.7525 2.3325L11.73 2.5725L11.0175 6H15.75C16.1478 6 16.5294 6.15804 16.8107 6.43934C17.092 6.72064 17.25 7.10218 17.25 7.5V9C17.25 9.195 17.2125 9.375 17.145 9.5475L14.88 14.835C14.655 15.375 14.1225 15.75 13.5 15.75H6.75ZM6.75 14.25H13.5225L15.75 9V7.5H9.1575L10.005 3.51L6.75 6.7725V14.25Z"/>
                                    </svg>
                                    <span>{{ $review->likes()->count() }}</span>
                                </button>
                            </form>
                        @else
                            <p class="text-sm text-gray-500">Войдите, чтобы поставить лайк</p>
                        @endauth

                        @auth
                            @if (auth()->id() === $review->user_id)
                                <a href="{{ route('reviews.edit', $review) }}" class="text-[#365B6A] font-semibold text-sm hover:underline">Редактировать</a>

                                <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Удалить отзыв?')" class="text-[#365B6A] font-semibold text-sm hover:underline">Удалить</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </article>
            @empty
                <p class="text-gray-500">Пока нет отзывов.</p>
            @endforelse
        </section>

        @if(session('success'))
            <div class="mt-5 p-4 bg-green-100 text-green-800 rounded-lg font-semibold">
                {{ session('success') }}
            </div>
        @endif
    </div>
@endsection
