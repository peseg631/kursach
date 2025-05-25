@extends('layouts.app')

@section('content')
    <h1>Каталог обуви</h1>

    @if(isset($category))
        <h2>Категория: {{ $category->name }}</h2>
    @endif

    <div class="products-grid">
        @forelse ($products as $product)
            <div class="product-card">
                <a href="{{ route('products.show', $product) }}" class="product-link">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                    @endif
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <p class="product-price">{{ number_format($product->price, 2) }} ₽</p>
                </a>

                <div class="product-actions">
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="action-form">
                        @csrf
                        <button type="submit" title="Добавить в корзину" class="btn-icon btn-cart">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="icon-svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h11l-1.5-7M7 13h10M5 21h14"/>
                            </svg>
                        </button>
                    </form>

                    <form action="{{ route('favorites.toggle', $product) }}" method="POST" class="action-form">



                        @csrf
                        <button type="submit" title="Добавить в избранное" class="btn-icon btn-favorite">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                 stroke-linejoin="round" stroke-linecap="round" class="icon-svg">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p>Товары не найдены.</p>
        @endforelse
    </div>

    <div class="pagination-wrapper">
        {{ $products->links() }}
    </div>
@endsection
