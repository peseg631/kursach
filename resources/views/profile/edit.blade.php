@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto my-8 px-10 py-8 bg-white shadow-md rounded-xl font-sans text-gray-800">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Редактирование профиля</h1>

        @if(session('success'))
            <div class="mb-5 px-5 py-3 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Имя</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[rgb(54,91,106)] focus:border-[rgb(54,91,106)]">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[rgb(54,91,106)] focus:border-[rgb(54,91,106)]">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Телефон</label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone', $user->phone) }}"
                           placeholder="+7 (XXX) XXX-XX-XX"
                           oninput="this.value = this.value.replace(/[^0-9+()\s-]/g, '').replace(/(\+.?)\+/, '$1');"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[rgb(54,91,106)] focus:border-[rgb(54,91,106)]">
                    <p class="mt-1 text-sm text-gray-500">Формат: +7 (XXX) XXX-XX-XX</p>
                    @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Смена пароля</h3>

                    <div class="space-y-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Новый пароль</label>
                            <input id="password" name="password" type="password" autocomplete="new-password"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[rgb(54,91,106)] focus:border-[rgb(54,91,106)]">
                            @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Подтверждение пароля</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[rgb(54,91,106)] focus:border-[rgb(54,91,106)]">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4">
                <a href="{{ route('profile.show') }}"
                   class="px-5 py-2 bg-gray-200 text-gray-800 rounded-lg font-bold no-underline transition-colors hover:bg-gray-300">
                    Отмена
                </a>
                <button type="submit"
                        class="px-5 py-2 bg-[rgb(54,91,106)] text-white rounded-lg font-bold no-underline transition-colors hover:bg-[rgb(45,75,88)]">
                    Сохранить изменения
                </button>
            </div>
        </form>
    </div>
@endsection

