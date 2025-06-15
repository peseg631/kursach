@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto my-10 p-8 bg-white rounded-xl shadow-lg font-sans text-gray-800">
        <h1 class="text-3xl font-bold mb-8 text-gray-900">Редактирование отзыва</h1>

        <form method="POST" action="{{ route('reviews.update', $review) }}" class="mb-8">
            @csrf
            @method('PATCH')

            <div class="mb-5">
                <label for="rating" class="block font-semibold mb-2 text-gray-700">Оценка:</label>
                <select name="rating" id="rating" required class="w-full p-3 border border-gray-300 rounded-lg text-gray-900 focus:border-blue-500 focus:outline-none">
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('rating', $review->rating) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                @error('rating')
                <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-5">
                <label for="text" class="block font-semibold mb-2 text-gray-700">Отзыв (необязательно):</label>
                <textarea name="text" id="text" rows="5" class="w-full p-3 border border-gray-300 rounded-lg text-gray-900 focus:border-blue-500 focus:outline-none">{{ old('text', $review->text) }}</textarea>
                @error('text')
                <div class="text-red-700 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-[#365B6A] text-white px-7 py-3 rounded-lg font-bold text-base hover:bg-[#2d4b57] transition-colors">
                    Сохранить изменения
                </button>
                <a href="{{ url()->previous() }}" class="bg-gray-200 text-gray-800 px-7 py-3 rounded-lg font-bold text-base hover:bg-gray-300 transition-colors">
                    Отмена
                </a>
            </div>
        </form>

        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded-lg font-semibold">
                {{ session('success') }}
            </div>
        @endif
    </div>
@endsection
