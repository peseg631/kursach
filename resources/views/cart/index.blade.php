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
            <div class="overflow-x-auto mb-8">
                <table class="w-full bg-white rounded-lg overflow-hidden shadow-sm">
                    <thead>
                    <tr>
                        <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-center">
                            <input type="checkbox" id="selectAll" class="rounded text-[rgb(54,91,106)]">
                        </th>
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
                                    data-price="{{ $cartItem->product->price * $cartItem->quantity }}"
                                    class="item-checkbox rounded text-[rgb(54,91,106)]"
                                    form="orderForm"
                                >
                            </td>
                            <td class="px-4 py-3 flex items-center gap-4">
                                <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                    @if($cartItem->product->image)
                                        <img src="{{ asset('storage/' . $cartItem->product->image) }}"
                                             alt="{{ $cartItem->product->name }}"
                                             class="max-w-full max-h-full object-contain p-1">
                                    @else
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $cartItem->product) }}"
                                   class="text-[rgb(54,91,106)] hover:underline">
                                    {{ $cartItem->product->name }}
                                </a>
                            </td>
                            <td class="px-4 py-3">{{ number_format($cartItem->product->price, 2) }} ₽</td>
                            <td class="px-4 py-3">
                                <form action="{{ route('cart.update', $cartItem) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number"
                                           name="quantity"
                                           value="{{ $cartItem->quantity }}"
                                           min="1"
                                           class="w-20 border border-gray-300 rounded-[0.7rem] px-3 py-1 focus:ring-[rgb(54,91,106)] focus:border-[rgb(54,91,106)]">
                                    <button type="submit"
                                            class="px-3 py-1 bg-[rgb(54,91,106)] text-white rounded-lg font-semibold text-sm transition-colors hover:bg-[rgb(45,75,88)]">
                                        Обновить
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-3 item-total">{{ number_format($cartItem->product->price * $cartItem->quantity, 2) }} ₽</td>
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

            <form id="orderForm" action="{{ route('orders.create') }}" method="GET" class="flex flex-col items-end gap-4 p-4 bg-gray-50 rounded-lg">
                @csrf
                <p class="text-lg">
                    <strong>Итоговая сумма:</strong>
                    <span id="totalAmount" class="font-bold text-[rgb(54,91,106)]">
                        {{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity; }), 2) }}
                    </span> ₽
                </p>
                <button type="submit"
                        class="px-5 py-2 bg-[rgb(54,91,106)] text-white rounded-lg font-bold no-underline transition-colors hover:bg-[rgb(45,75,88)]">
                    Оформить заказ
                </button>
            </form>
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

    <script>
        // Динамический подсчёт суммы выбранных товаров
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const totalElement = document.getElementById('totalAmount');
            const selectAllCheckbox = document.getElementById('selectAll');
            const initialTotal = parseFloat("{{ $cartItems->sum(fn($item) => $item->product->price * $item->quantity) }}");

            function updateTotal() {
                let selectedTotal = 0;
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedTotal += parseFloat(checkbox.dataset.price);
                    }
                });
                // Если не выбрано ни одного товара — показываем общую сумму
                totalElement.textContent = selectedTotal > 0 ? selectedTotal.toFixed(2) : initialTotal.toFixed(2);
            }

            // Обработчик изменения чекбоксов
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateTotal);
            });

            // Выбрать все товары
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', (e) => {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = e.target.checked;
                    });
                    updateTotal();
                });
            }
        });
    </script>
@endsection
