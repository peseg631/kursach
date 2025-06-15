@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto my-8 px-10 py-8 bg-white shadow-md rounded-xl font-sans text-gray-800">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Заказ #{{ $order->id }}</h1>
            <a href="{{ route('orders.index') }}"
               class="px-4 py-2 bg-[rgb(54,91,106)] text-white rounded-lg font-semibold text-sm transition-colors hover:bg-[rgb(45,75,88)]">
                Вернуться к истории заказов
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold mb-4 text-[rgb(54,91,106)]">Информация о заказе</h3>
                <div class="space-y-3">
                    <p class="flex justify-between">
                        <span class="text-gray-600">Дата:</span>
                        <span class="font-medium">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                    </p>
                    <p class="flex justify-between">
                        <span class="text-gray-600">Адрес доставки:</span>
                        <span class="font-medium">{{ $order->address }}</span>
                    </p>
                    <p class="flex justify-between text-lg pt-3 border-t border-gray-200">
                        <span class="text-gray-800 font-semibold">Итого:</span>
                        <span class="font-bold text-[rgb(54,91,106)]">{{ number_format($order->total_price, 2) }} ₽</span>
                    </p>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold mb-4 text-[rgb(54,91,106)]">Товары в заказе</h3>
                <ul class="divide-y divide-gray-200">
                    @foreach($order->items as $item)
                        <li class="py-3 flex justify-between items-start">
                            <div class="flex items-center gap-4">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                         alt="{{ $item->product->name }}"
                                         class="h-12 object-contain">
                                @endif
                                <div>
                                    <p class="text-gray-800">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $item->quantity }} шт. × {{ number_format($item->price, 2) }} ₽</p>
                                </div>
                            </div>
                            <p class="font-medium">{{ number_format($item->price * $item->quantity, 2) }} ₽</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
@endsection
