@extends('layouts.app')

@section('content')
    <h1>Ваша корзина</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($cartItems->count() > 0)
        <form id="orderForm" action="{{ route('orders.create') }}" method="GET">
            @csrf

            <table class="cart-table">
                <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>Товар</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Итого</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cartItems as $cartItem)
                    <tr>
                        <td>
                            <input
                                type="checkbox"
                                name="selected_items[]"
                                value="{{ $cartItem->id }}"
                                data-price="{{ $cartItem->product->price * $cartItem->quantity }}"
                                class="item-checkbox"
                            >
                        </td>
                        <td>
                            @if($cartItem->product->image)
                                <img src="{{ asset('storage/' . $cartItem->product->image) }}" alt="{{ $cartItem->product->name }}">
                            @endif
                            <a href="{{ route('products.show', $cartItem->product) }}">{{ $cartItem->product->name }}</a>
                        </td>
                        <td>{{ number_format($cartItem->product->price, 2) }} ₽</td>
                        <td>
                            <form action="{{ route('cart.update', $cartItem) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $cartItem->quantity }}" min="1">
                                <button type="submit">Обновить</button>
                            </form>
                        </td>
                        <td class="item-total">{{ number_format($cartItem->product->price * $cartItem->quantity, 2) }} ₽</td>
                        <td>
                            <form action="{{ route('cart.remove', $cartItem) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="total-section">
                <p><strong>Итоговая сумма:</strong> <span id="totalAmount">{{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity; }), 2) }}</span> ₽</p>
                <button type="submit" class="btn-order">Оформить заказ</button>
            </div>
        </form>
    @else
        <p>Ваша корзина пуста.</p>
    @endif

    <script>
        // Динамический подсчёт суммы выбранных товаров
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const totalElement = document.getElementById('totalAmount');
        const selectAllCheckbox = document.getElementById('selectAll');
        let total = parseFloat(totalElement.textContent.replace(/\s/g, ''));

        function updateTotal() {
            let selectedTotal = 0;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedTotal += parseFloat(checkbox.dataset.price);
                }
            });
            // Если не выбрано ни одного товара — показываем общую сумму
            totalElement.textContent = selectedTotal > 0 ? selectedTotal.toFixed(2) : {{ $cartItems->sum(fn($item) => $item->product->price * $item->quantity) }};
        }

        // Обработчик изменения чекбоксов
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateTotal);
        });

        // Выбрать все товары
        selectAllCheckbox.addEventListener('change', (e) => {
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
            updateTotal();
        });
    </script>

    <style>
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .cart-table th, .cart-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .total-section {
            margin-top: 20px;
            text-align: right;
        }
        .btn-order {
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
@endsection
