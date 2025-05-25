@extends('layouts.app')

@section('content')
    <div class="admin-form-container">
        <h1>Добавить категорию</h1>

        @if ($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.categories.store') }}" method="POST" class="form-space-y">
            @csrf

            <label for="name">Название категории</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required />

            <div class="buttons">
                <a href="{{ route('admin.categories.index') }}">Отмена</a>
                <button type="submit">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
