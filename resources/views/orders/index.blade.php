@extends('layouts.app')

@section('content')
    <h1>История заказов</h1>

    @if($orders->isEmpty())
        <p>Заказов пока нет.</p>
    @else
        <ul>
            @foreach($orders as $order)
                <li>
                    <a href="{{ route('orders.show', $order) }}">Заказ #{{ $order->id }}</a> — {{ $order->created_at->format('d.m.Y H:i') }} — Статус: {{ $order->status }} — Сумма: {{ $order->total_price }} ₽
                </li>
            @endforeach
        </ul>

        {{ $orders->links() }}
    @endif
@endsection
