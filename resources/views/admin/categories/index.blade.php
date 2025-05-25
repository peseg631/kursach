@extends('layouts.app')

@section('content')
    <div class="admin-index-container">
        <h1>Список категорий</h1>

        <a href="{{ route('admin.categories.create') }}" class="btn-add-category">
            Добавить категорию
        </a>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Название категории</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn-edit">Редактировать</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Удалить эту категорию?');" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Удалить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="empty-message">Категории не найдены</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
