@extends('layouts.app')

@section('content')
    <div class="admin-container">
        <h1>Список товаров</h1>

        @if(session('success'))
            <div class="admin-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.products.create') }}" class="admin-btn">
            Добавить новый товар
        </a>

        <form method="GET" action="{{ route('admin.products.index') }}" class="mb-6 flex flex-wrap items-center gap-4">
            <!-- Поиск -->
            <input type="text" name="search" placeholder="Поиск по названию" value="{{ request('search') }}"
                   class="border rounded px-3 py-2 w-64" />

            <!-- Фильтр по категории -->
            <select name="category_id" class="border rounded px-3 py-2">
                <option value="">Все категории</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>

            <!-- Сортировка -->
            <select name="sort_field" class="border rounded px-3 py-2">
                <option value="id" @selected(request('sort_field') == 'id')>Сортировать по ID</option>
                <option value="name" @selected(request('sort_field') == 'name')>Сортировать по названию</option>
                <option value="price" @selected(request('sort_field') == 'price')>Сортировать по цене</option>
            </select>

            <select name="sort_direction" class="border rounded px-3 py-2">
                <option value="asc" @selected(request('sort_direction') == 'asc')>По возрастанию</option>
                <option value="desc" @selected(request('sort_direction') == 'desc')>По убыванию</option>
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Применить
            </button>
        </form>

        <table class="admin-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Изображение</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->price, 2) }} ₽</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            Нет изображения
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product) }}" class="admin-action-link">Редактировать</a>

                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Удалить этот товар?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-action-delete-btn">Удалить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; font-style: italic;">Товары не найдены</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="admin-pagination">
            {{ $products->links() }}
        </div>
    </div>
@endsection
