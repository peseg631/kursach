@extends('layouts.app')

@push('styles')
    @vite('resources/css/products/show.css')
@endpush

@section('content')
    <div class="product-container">
        <h1 class="product-title">{{ $product->name }}</h1>

        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
        @endif

        <p class="product-price">{{ number_format($product->price, 2) }} ₽</p>

        @if($product->description)
            <section class="product-description">
                <h2>Описание</h2>
                <p>{{ $product->description }}</p>
            </section>
        @endif

        <div class="product-actions">
            @auth
                <form action="{{ route('favorites.toggle', $product) }}" method="POST" class="action-form">
                    @csrf
                    <button type="submit" class="btn btn-favorite">
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

                <form action="{{ route('cart.add', $product) }}" method="POST" class="action-form">
                    @csrf
                    <button type="submit" class="btn btn-cart">Добавить в корзину</button>
                </form>
            @else
                <p class="login-prompt">
                    <a href="{{ route('login') }}">Войдите</a>, чтобы добавить в избранное и корзину
                </p>
            @endauth
        </div>

        <a href="{{ route('products.index') }}" class="back-link">← Вернуться к каталогу</a>

        <section class="reviews-section">
            <h2>Отзывы</h2>

            @auth
                @if($errors->has('limit'))
                    <div class="error-message">
                        {{ $errors->first('limit') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('reviews.store', $product) }}" class="review-form">
                    @csrf
                    <div class="form-group">
                        <label for="rating">Оценка:</label>
                        <select name="rating" id="rating" required>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="text">Отзыв:</label>
                        <textarea name="text" id="text" rows="4" required>{{ old('text') }}</textarea>
                        @error('text')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-submit-review">Оставить отзыв</button>
                </form>
            @else
                <p>Чтобы оставить отзыв, пожалуйста, <a href="{{ route('login') }}">войдите в систему</a>.</p>
            @endauth

            <hr>

            @forelse ($product->reviews as $review)
                <article class="review-card">
                    <header>
                        <strong>{{ $review->user->name }}</strong> — Оценка: {{ $review->rating }}/5
                    </header>
                    <p>{{ $review->text }}</p>

                    <div class="review-actions">
                        @auth
                            <form action="{{ route('reviews.like.toggle', $review) }}" method="POST" class="inline-form">
                                @csrf
                                <button type="submit" class="btn-like" aria-label="Лайк">
                                    👍 <span class="like-count">{{ $review->likes()->count() }}</span>
                                </button>
                            </form>
                        @else
                            <p class="login-to-like">Войдите, чтобы поставить лайк</p>
                        @endauth

                        @auth
                            @if (auth()->id() === $review->user_id)
                                <a href="{{ route('reviews.edit', $review) }}" class="btn-edit-review">Редактировать</a>

                                <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Удалить отзыв?')" class="btn-delete-review">Удалить</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </article>
            @empty
                <p>Пока нет отзывов.</p>
            @endforelse
        </section>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
    </div>
@endsection
