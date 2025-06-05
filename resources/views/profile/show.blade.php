@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto my-8 px-10 py-8 bg-white shadow-md rounded-xl font-sans text-gray-800">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Профиль</h1>

        @if(session('success'))
            <div class="mb-5 px-5 py-3 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4 mb-8">
            <div class="flex items-center">
                <strong class="w-32 text-gray-700">Имя:</strong>
                <span class="text-gray-800">{{ $user->name }}</span>
            </div>
            <div class="flex items-center">
                <strong class="w-32 text-gray-700">Email:</strong>
                <span class="text-gray-800">{{ $user->email }}</span>
            </div>
            <div class="flex items-center">
                <strong class="w-32 text-gray-700">Телефон:</strong>
                <span class="text-gray-800">{{ $user->phone ?? 'не указан' }}</span>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <a href="{{ route('profile.edit') }}"
               class="px-5 py-2 bg-[rgb(54,91,106)] text-white rounded-lg font-bold no-underline transition-colors hover:bg-[rgb(45,75,88)]">
                Редактировать профиль
            </a>

        </div>
    </div>
@endsection
