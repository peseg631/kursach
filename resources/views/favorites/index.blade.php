@extends('layouts.app')

@section('content')
    <h1>Избранное</h1>

    @if(session('success'))
        <div style="color: green; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if($favorites->isEmpty())
        <p>У вас нет избранных товаров.</p>
    @else
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
            <tr>
                <th>Товар</th>
                <th>Цена</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($favorites as $favorite)
                <tr>
                    <td>
                        @if($favorite->product->image)
                            <img src="{{ asset('storage/' . $favorite->product->image) }}" alt="{{ $favorite->product->name }}" style="width: 50px; height: 50px; object-fit: cover; vertical-align: middle;">
                        @endif
                        <a href="{{ route('products.show', $favorite->product) }}" style="margin-left: 10px;">
                            {{ $favorite->product->name }}
                        </a>
                    </td>
                    <td>{{ number_format($favorite->product->price, 2) }} ₽</td>
                    <td>
                        <form action="{{ route('favorites.toggle', $favorite->product) }}" method="POST" onsubmit="return confirm('Удалить товар из избранного?');">
                            @csrf
                            <button type="submit" style="background-color: #e3342f; color: white; border: none; padding: 5px 10px; cursor: pointer;">
                                Удалить
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
