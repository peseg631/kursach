@extends('layouts.app')

@section('content')
    <h1>Оформление заказа</h1>

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf

        <!-- Передаём все выбранные товары -->
        @foreach($cartItems as $item)
            <input type="hidden" name="selected_items[]" value="{{ $item->id }}">
        @endforeach

        <h3>Товары в заказе:</h3>
        <ul>
            @foreach($cartItems as $item)
                <li>
                    {{ $item->product->name }} —
                    {{ $item->quantity }} шт. ×
                    {{ number_format($item->product->price, 2) }} ₽ =
                    {{ number_format($item->product->price * $item->quantity, 2) }} ₽
                </li>
            @endforeach
        </ul>

        <div>
            <label for="address">Адрес доставки:</label>
            <textarea id="address" name="address" required></textarea>
        </div>

        <button type="submit">Подтвердить заказ</button>
    </form>
@endsection
