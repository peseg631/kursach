@extends('layouts.app')

@section('content')
    <h1>Заказ #{{ $order->id }}</h1>

    <p><strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
    <p><strong>Статус:</strong> {{ $order->status }}</p>
    <p><strong>Адрес доставки:</strong> {{ $order->address }}</p>
    <p><strong>Сумма:</strong> {{ $order->total_price }} ₽</p>

    <h3>Товары в заказе:</h3>
    <ul>
        @foreach($order->items as $item)
            <li>{{ $item->product->name }} — {{ $item->quantity }} шт. — {{ $item->price }} ₽ за шт.</li>
        @endforeach
    </ul>

    <a href="{{ route('orders.index') }}">Вернуться к истории заказов</a>
@endsection
