@extends('layouts.app')

@section('content')
    <div class="profile-edit-container">
        <h1>Редактирование профиля</h1>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div>
                <label for="name">Имя:</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div>
                <label for="email">Email:</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div>
                <label for="phone">Телефон:</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}">
                @error('phone')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div>
                <label for="password">Новый пароль (оставьте пустым, если не меняете):</label>
                <input id="password" name="password" type="password" autocomplete="new-password">
                @error('password')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div>
                <label for="password_confirmation">Подтверждение пароля:</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
            </div>

            <div class="buttons">
                <a href="{{ route('profile.show') }}" class="cancel-link">Отмена</a>
                <button type="submit">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
