@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto my-8 px-10 py-8 bg-white shadow-md rounded-xl font-sans text-gray-800">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Список товаров</h1>

        @if(session('success'))
            <div class="mb-5 px-5 py-3 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.products.create') }}" class="inline-block mb-6 px-5 py-2 bg-[rgb(54,91,106)] text-white rounded-lg font-bold no-underline transition-colors hover:bg-[rgb(45,75,88)]">
            Добавить новый товар
        </a>

        <form method="GET" action="{{ route('admin.products.index') }}" class="mb-8 flex flex-wrap items-center justify-center gap-4">
            <input type="text" name="search" placeholder="Поиск по названию" value="{{ request('search') }}"
                   class="border border-gray-300 rounded-[0.7rem] px-4 py-2 w-64 focus:ring-[rgb(54,91,106)] focus:border-[rgb(54,91,106)]" />

            <select name="category_id" class="border border-gray-300 rounded-[0.7rem] px-4 py-2 focus:ring-[rgb(54,91,106)] focus:border-[rgb(54,91,106)]">
                <option value="">Все категории</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>

            <div class="relative">
                <select name="sort" class="border border-gray-300 rounded-[0.7rem] px-8 py-2 appearance-none bg-white focus:ring-[rgb(54,91,106)] focus:border-[rgb(54,91,106)]">
                    <option value="">Сортировка по цене</option>
                    <option value="price_asc" @selected(request('sort') == 'price_asc')>По возрастанию цены</option>
                    <option value="price_desc" @selected(request('sort') == 'price_desc')>По убыванию цены</option>
                </select>
                <div class="absolute inset-y-0 left-2 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            <button type="submit" class="bg-[rgb(54,91,106)] text-white px-4 py-2 rounded-[0.7rem] hover:bg-[rgb(40,70,82)] transition">
                Применить
            </button>

            @if(request()->hasAny(['search', 'category_id', 'sort']))
                <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-800 underline">
                    Сбросить фильтры
                </a>
            @endif
        </form>

        <div class="overflow-x-auto">
            <table class="w-full bg-white rounded-lg overflow-hidden shadow-sm">
                <thead>
                <tr>
                    <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">ID</th>
                    <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">Название</th>
                    <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">Цена</th>
                    <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">Изображение</th>
                    <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $product->id }}</td>
                        <td class="px-4 py-3">{{ $product->name }}</td>
                        <td class="px-4 py-3">{{ number_format($product->price, 2) }} ₽</td>
                        <td class="px-4 py-3">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-16 object-contain">
                            @else
                                <img src="{{ asset('images/no_img.png') }}" alt="Нет изображения" class="h-16 object-contain opacity-50">
                            @endif
                        </td>
                        <td class="px-4 py-3 flex gap-3">
                            <a href="{{ route('admin.products.edit', $product) }}" class="px-3 py-1 bg-[rgb(54,91,106)] text-white rounded-lg font-semibold text-sm no-underline transition-colors hover:bg-[rgb(45,75,88)]">Редактировать</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Удалить этот товар?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-[rgb(54,91,106)] text-white rounded-lg font-semibold text-sm transition-colors hover:bg-[rgb(45,75,88)]">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-center text-gray-500 italic">Товары не найдены</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
@endsection
