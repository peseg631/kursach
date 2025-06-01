@extends('layouts.app')

@push('styles')
    @vite('resources/css/products/show.css')
@endpush

@section('content')
    <div class="max-w-3xl mx-auto my-10 p-8 bg-white rounded-xl shadow-lg font-sans text-gray-800">
        <div class="flex flex-col items-center">
            <h1 class="text-4xl font-bold mb-5 text-gray-900">{{ $product->name }}</h1>

            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                     class="w-full max-w-md h-auto rounded-lg shadow-md mb-5">
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
            @auth
                <form action="{{ route('favorites.toggle', $product) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-[#365B6A] text-white px-7 py-3 rounded-lg font-bold text-base hover:bg-[#2d4b57] transition-colors whitespace-nowrap">
                        @php
                            $isFavorite = auth()->user()->favorites()->where('product_id', $product->id)->exists();
                        @endphp

                        @if($isFavorite)
                            Убрать из избранного
                        @else
                            В избранное
                        @endif
                    </button>
                </form>

                <form action="{{ route('cart.add', $product) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-[#365B6A] text-white px-7 py-3 rounded-lg font-bold text-base hover:bg-[#2d4b57] transition-colors">Добавить в корзину</button>
                </form>
            @else
                <p class="text-gray-500">
                    <a href="{{ route('login') }}" class="text-[#365B6A] font-semibold hover:underline">Войдите</a>, чтобы добавить в избранное и корзину
                </p>
            @endauth
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
