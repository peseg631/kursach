@extends('layouts.app')

@section('content')
    <h1>{{ $product->name }}</h1>

    @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 400px; height: auto; margin-bottom: 20px;">
    @endif

    <p><strong>Цена:</strong> {{ number_format($product->price, 2) }} ₽</p>

    @if($product->description)
        <p><strong>Описание:</strong></p>
        <p>{{ $product->description }}</p>
    @endif

    <div style="margin-top: 20px;">
        @auth
            <form action="{{ route('favorites.toggle', $product) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">
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

            <form action="{{ route('cart.add', $product) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Добавить в корзину</button>
            </form>
        @else
            <a href="{{ route('login') }}">Войдите</a>, чтобы добавить в избранное и корзину
        @endauth
    </div>

    <a href="{{ route('products.index') }}" style="display: inline-block; margin-top: 20px;">← Вернуться к каталогу</a>

    <h3>Отзывы</h3>

    @auth
        @if($errors->has('limit'))
            <div style="color: red; margin-bottom: 10px;">
                {{ $errors->first('limit') }}
            </div>
        @endif

        <form method="POST" action="{{ route('reviews.store', $product) }}">
            @csrf
            <div>
                <label for="rating">Оценка:</label>
                <select name="rating" id="rating" required>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div>
                <label for="text">Отзыв:</label>
                <textarea name="text" id="text" rows="4" required>{{ old('text') }}</textarea>
                @error('text')
                <div style="color: red;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Оставить отзыв</button>
        </form>
    @else
        <p>Чтобы оставить отзыв, пожалуйста, <a href="{{ route('login') }}">войдите в систему</a>.</p>
    @endauth

    <hr>

    @forelse ($product->reviews as $review)
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
            <strong>{{ $review->user->name }}</strong> — Оценка: {{ $review->rating }}/5<br>
            <p>{{ $review->text }}</p>

            @auth
                <form action="{{ route('reviews.like.toggle', $review) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none; border:none; cursor:pointer; color: {{ $review->likedByUser(auth()->id()) ? 'blue' : 'gray' }};">
                        👍 {{ $review->likes()->count() }}
                    </button>
                </form>
            @else
                <p style="font-size: 0.9em; color: #555;">Войдите, чтобы поставить лайк</p>
            @endauth

            @auth
                @if (auth()->id() === $review->user_id)
                    <a href="{{ route('reviews.edit', $review) }}">Редактировать</a>

                    <form method="POST" action="{{ route('reviews.destroy', $review) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Удалить отзыв?')">Удалить</button>
                    </form>
                @endif
            @endauth
        </div>
    @empty
        <p>Пока нет отзывов.</p>
    @endforelse

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

@endsection
