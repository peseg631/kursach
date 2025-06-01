@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto my-8 px-10 py-8 bg-white shadow-md rounded-xl font-sans text-gray-800">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Избранное</h1>

        @if(session('success'))
            <div class="mb-5 px-5 py-3 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($favorites->isEmpty())
            <div class="text-center py-10">
                <p class="text-gray-500 text-lg">У вас нет избранных товаров.</p>
                <a href="{{ route('products.index') }}"
                   class="inline-block mt-4 px-5 py-2 bg-[rgb(54,91,106)] text-white rounded-lg font-bold no-underline transition-colors hover:bg-[rgb(45,75,88)]">
                    Перейти к покупкам
                </a>
            </div>
        @else
            <div class="overflow-x-auto mb-8">
                <table class="w-full bg-white rounded-lg overflow-hidden shadow-sm">
                    <thead>
                    <tr>
                        <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">Товар</th>
                        <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">Цена</th>
                        <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($favorites as $favorite)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 flex items-center gap-4">
                                <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                    @if($favorite->product->image)
                                        <img src="{{ asset('storage/' . $favorite->product->image) }}"
                                             alt="{{ $favorite->product->name }}"
                                             class="max-w-full max-h-full object-contain p-1">
                                    @else
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $favorite->product) }}"
                                   class="text-[rgb(54,91,106)] hover:underline">
                                    {{ $favorite->product->name }}
                                </a>
                            </td>
                            <td class="px-4 py-3">{{ number_format($favorite->product->price, 2) }} ₽</td>
                            <td class="px-4 py-3">
                                <form action="{{ route('favorites.toggle', $favorite->product) }}" method="POST"
                                      onsubmit="return confirm('Удалить товар из избранного?');">
                                    @csrf
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

        @endif
    </div>
@endsection
