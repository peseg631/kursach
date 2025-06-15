@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto my-8 px-10 py-8 bg-white shadow-md rounded-xl font-sans text-gray-800">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Оформление заказа</h1>

        @if($errors->any())
            <div class="mb-5 p-4 bg-red-100 text-red-800 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('orders.store') }}" class="space-y-6">
            @csrf

            @if(!empty($selectedIds))
                @foreach($selectedIds as $itemId)
                    <input type="hidden" name="selected_items[]" value="{{ $itemId }}">
                @endforeach
            @else
                @foreach($cartItems as $item)
                    <input type="hidden" name="selected_items[]" value="{{ $item->id }}">
                @endforeach
            @endif

            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-semibold mb-4 text-[rgb(54,91,106)]">Товары в заказе:</h3>
                <ul class="divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                        <li class="py-3 flex justify-between">
                            <div class="flex items-center gap-4">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                         alt="{{ $item->product->name }}"
                                         class="h-12 object-contain">
                                @endif
                                <span class="text-gray-700">{{ $item->product->name }}</span>
                            </div>
                            <div class="text-gray-800">
                                {{ $item->quantity }} шт. ×
                                {{ number_format($item->product->price, 2) }} ₽ =
                                <span class="font-semibold">{{ number_format($item->product->price * $item->quantity, 2) }} ₽</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between text-lg">
                    <span class="font-semibold">Итого:</span>
                    <span class="font-bold text-[rgb(54,91,106)]">
                        {{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity; }), 2) }} ₽
                    </span>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Адрес доставки</label>
                    <textarea id="address" name="address" required
                              class="w-full border border-gray-300 rounded-[0.7rem] px-4 py-2 focus:ring-[rgb(54,91,106)] focus:border-[rgb(54,91,106)]"
                              rows="3"></textarea>
                </div>

            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-5 py-2 bg-[rgb(54,91,106)] text-white rounded-lg font-bold no-underline transition-colors hover:bg-[rgb(45,75,88)]">
                    Подтвердить заказ
                </button>
            </div>
        </form>
    </div>
@endsection
