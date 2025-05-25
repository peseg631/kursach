@extends('layouts.app')

@section('content')
    <h1>Редактирование отзыва</h1>

    <form method="POST" action="{{ route('reviews.update', $review) }}">
        @csrf
        @method('PATCH')

        <div>
            <label for="rating">Оценка:</label>
            <select name="rating" id="rating" required>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
            @error('rating')
            <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="text">Отзыв:</label>
            <textarea name="text" id="text" rows="5" required>{{ old('text', $review->text) }}</textarea>
            @error('text')
            <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Сохранить изменения</button>
        <a href="{{ url()->previous() }}">Отмена</a>
    </form>
    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

@endsection
