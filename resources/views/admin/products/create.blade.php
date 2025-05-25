@extends('layouts.app')

@section('content')
    <div class="admin-form-container">
        <h1>Добавить новый товар</h1>

        @if ($errors->any())
            <div class="error-messages">
                <strong>Пожалуйста, исправьте ошибки:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label for="name">Название товара<span class="required">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required />

            <label for="description">Описание</label>
            <textarea name="description" id="description" rows="4">{{ old('description') }}</textarea>

            <label for="price">Цена (₽)<span class="required">*</span></label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" min="0" step="0.01" required />

            <label for="category_id">Категория<span class="required">*</span></label>
            <select name="category_id" id="category_id" required>
                <option value="">Выберите категорию</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>

            <label for="image">Изображение</label>
            <input type="file" name="image" id="image" accept="image/*" />

            <div class="buttons">
                <a href="{{ route('admin.products.index') }}">Отмена</a>
                <button type="submit">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
