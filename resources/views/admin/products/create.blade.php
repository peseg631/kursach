@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto my-8 px-10 py-8 bg-white shadow-md rounded-xl font-sans text-gray-800">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Добавить новый товар</h1>

        @if ($errors->any())
            <div class="mb-5 px-5 py-3 bg-red-100 text-red-800 rounded-lg">
                <strong class="font-bold">Пожалуйста, исправьте ошибки:</strong>
                <ul class="mt-1 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Название товара <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="w-full border border-gray-300 rounded-[0.7rem] px-4 py-2 focus:ring-[rgb(54,91,106)] focus:border-[rgb(54,91,106)]"
                       required />
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                    Описание
                </label>
                <textarea name="description" id="description" rows="4"
                          class="w-full border border-gray-300 rounded-[0.7rem] px-4 py-2 focus:ring-[rgb(54,91,106)] focus:border-[rgb(54,91,106)]">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                    Цена (₽) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="price" id="price" value="{{ old('price') }}" min="0" step="0.01"
                       class="w-full border border-gray-300 rounded-[0.7rem] px-4 py-2 focus:ring-[rgb(54,91,106)] focus:border-[rgb(54,91,106)]"
                       required />
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Категория <span class="text-red-500">*</span>
                </label>
                <select name="category_id" id="category_id"
                        class="w-full border border-gray-300 rounded-[0.7rem] px-4 py-2 focus:ring-[rgb(54,91,106)] focus:border-[rgb(54,91,106)]"
                        required>
                    <option value="">Выберите категорию</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                    Изображение
                </label>
                <input type="file" name="image" id="image" accept="image/*"
                       class="block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-[0.7rem] file:border-0
                              file:text-sm file:font-semibold
                              file:bg-[rgb(54,91,106)] file:text-white
                              hover:file:bg-[rgb(45,75,88)]" />
            </div>

            <div class="flex items-center justify-end gap-4 pt-4">
                <a href="{{ route('admin.products.index') }}"
                   class="px-5 py-2 border border-gray-300 rounded-lg font-bold text-gray-700 hover:bg-gray-50 transition-colors">
                    Отмена
                </a>
                <button type="submit"
                        class="px-5 py-2 bg-[rgb(54,91,106)] text-white rounded-lg font-bold no-underline transition-colors hover:bg-[rgb(45,75,88)]">
                    Сохранить товар
                </button>
            </div>
        </form>
    </div>
@endsection
