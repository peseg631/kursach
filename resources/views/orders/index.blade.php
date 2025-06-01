@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto my-8 px-10 py-8 bg-white shadow-md rounded-xl font-sans text-gray-800">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">История заказов</h1>

        @if($orders->isEmpty())
            <div class="text-center py-10">
                <p class="text-gray-500 text-lg mb-4">Заказов пока нет.</p>
                <a href="{{ route('products.index') }}"
                   class="inline-block px-5 py-2 bg-[rgb(54,91,106)] text-white rounded-lg font-bold no-underline transition-colors hover:bg-[rgb(45,75,88)]">
                    Перейти к покупкам
                </a>
            </div>
        @else
            <div class="overflow-x-auto mb-8">
                <table class="w-full bg-white rounded-lg overflow-hidden shadow-sm">
                    <thead>
                    <tr>
                        <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">Номер заказа</th>
                        <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">Дата</th>
                        <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">Статус</th>
                        <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">Сумма</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-50 border-b border-gray-200">
                            <td class="px-4 py-3">
                                <a href="{{ route('orders.show', $order) }}" class="text-[rgb(54,91,106)] hover:underline font-medium">
                                    #{{ $order->id }}
                                </a>
                            </td>
                            <td class="px-4 py-3">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                            <td class="px-4 py-3">
                                    <span class="capitalize px-3 py-1 rounded-full text-sm
                                        @if($order->status === 'completed') bg-green-100 text-green-800
                                        @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-blue-100 text-blue-800
                                        @endif">
                                        {{ $order->status }}
                                    </span>
                            </td>
                            <td class="px-4 py-3 font-semibold">{{ number_format($order->total_price, 2) }} ₽</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection
