@extends('layouts.app')

@section('content')
    <div class="profile-show-container">
        <h1>Профиль пользователя</h1>

        <p><strong>Имя:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Телефон:</strong> {{ $user->phone ?? 'не указан' }}</p>

        <a href="{{ route('profile.edit') }}">Редактировать профиль</a>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif
    </div>
@endsection
