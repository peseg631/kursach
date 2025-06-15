@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto my-8 px-10 py-8 bg-white shadow-md rounded-xl font-sans text-gray-800">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Ваша корзина</h1>

        @if(session('success'))
            <div class="mb-5 px-5 py-3 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($cartItems->count() > 0)
            <form id="cart-form" action="{{ route('cart.index') }}" method="GET">
                <div class="overflow-x-auto mb-8">
                    <table class="w-full bg-white rounded-lg overflow-hidden shadow-sm">
                        <thead>
                        <tr>
                            <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-center">Выбрать</th>
                            <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">Товар</th>
                            <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">Цена</th>
                            <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">Количество</th>
                            <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">Итого</th>
                            <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cartItems as $cartItem)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-center">
                                    <input
                                        type="checkbox"
                                        name="selected_items[]"
                                        value="{{ $cartItem->id }}"
                                        @if(request('selected_items') && in_array($cartItem->id, request('selected_items'))) checked @endif
                                        onchange="setTimeout(() => document.getElementById('cart-form').submit(), 100)"
                                    >

                                </td>
                                <td class="px-4 py-3 flex items-center gap-4">
                                    <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                        @if($cartItem->product->image)
                                            <img src="{{ asset('storage/' . $cartItem->product->image) }}"
                                                 alt="{{ $cartItem->product->name }}"
                                                 class="max-w-full max-h-full object-contain p-1">
                                        @else
                                            <img src="{{ asset('images/no_img.png') }}"
                                                 alt="Нет изображения"
                                                 class="max-w-full max-h-full object-contain p-1">
                                        @endif
                                    </div>
                                    <a href="{{ route('products.show', $cartItem->product) }}"
                                       class="text-[rgb(54,91,106)] hover:underline">
                                        {{ $cartItem->product->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">{{ number_format($cartItem->product->price, 2) }} ₽</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('cart.decrement', $cartItem->product) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="px-2 py-1 bg-gray-200 rounded text-xl font-bold" @if($cartItem->quantity <= 1) disabled @endif>-</button>
                                        </form>
                                        <span class="w-10 text-center">{{ $cartItem->quantity }}</span>
                                        <form action="{{ route('cart.add', $cartItem->product) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="px-2 py-1 bg-gray-200 rounded text-xl font-bold">+</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-4 py-3">{{ number_format($cartItem->product->price * $cartItem->quantity, 2) }} ₽</td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('cart.remove', $cartItem->product) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 bg-red-600 text-white rounded-lg font-semibold text-sm transition-colors hover:bg-red-700">
                                            Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </form>

            <div class="flex flex-col items-end gap-4 p-4 bg-gray-50 rounded-lg">
                <p class="text-lg">
                    <strong>Общая сумма:</strong>
                    <span class="font-bold text-[rgb(54,91,106)]">
            {{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}
        </span> ₽
                </p>

                @if(!empty($selectedIds) && $selectedSum > 0)
                    <p class="text-md">
                        <strong>Сумма выбранных:</strong>
                        <span class="font-bold text-[rgb(54,91,106)]">{{ number_format($selectedSum, 2) }}</span> ₽
                    </p>
                @endif

                <div class="flex gap-2">
                    <a href="{{ route('orders.create', ['selected_items' => $selectedIds ?? []]) }}"
                       class="px-5 py-2 bg-green-600 text-white rounded-lg font-bold no-underline transition-colors hover:bg-green-700">
                        Оформить заказ
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-10">
                <p class="text-gray-500 text-lg">Ваша корзина пуста.</p>
                <a href="{{ route('products.index') }}"
                   class="inline-block mt-4 px-5 py-2 bg-[rgb(54,91,106)] text-white rounded-lg font-bold no-underline transition-colors hover:bg-[rgb(45,75,88)]">
                    Перейти к покупкам
                </a>
            </div>
        @endif
    </div>
@endsection
