@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto my-8 px-10 py-8 bg-white shadow-md rounded-xl font-sans text-gray-800">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Список категорий</h1>


        @if(session('success'))
            <div class="mb-5 px-5 py-3 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full bg-white rounded-lg overflow-hidden shadow-sm">
            <thead>
            <tr>
                <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">ID</th>
                <th class="px-4 py-3 bg-[rgb(70,115,133)] font-bold text-gray-100 text-left">Название категории</th>
            </tr>
            </thead>
            <tbody>
            @forelse($categories as $category)
                <tr class="hover:bg-gray-100 cursor-pointer">
                    <td class="px-4 py-3 border-b border-gray-200 text-gray-800">{{ $category->id }}</td>
                    <td class="px-4 py-3 border-b border-gray-200 text-gray-800">{{ $category->name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="px-4 py-3 text-center text-gray-500 italic">Категории не найдены</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
