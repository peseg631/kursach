@extends('layouts.app')

@section('content')
    <div class="admin-dashboard-container">
        <h1>Панель администратора</h1>

        <div class="admin-dashboard-buttons">
            <a href="{{ route('admin.products.index') }}" class="admin-dashboard-button products-button">
                📦<br>
                Просмотр товаров
            </a>

            <a href="{{ route('admin.categories.index') }}" class="admin-dashboard-button categories-button">
                📂<br>
                Просмотр категорий
            </a>
        </div>
    </div>
@endsection
