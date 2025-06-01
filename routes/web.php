<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;;
use App\Http\Controllers\ProductController as PublicProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('products.index');
    }
    // Если не авторизован - показываем страницу входа
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Админские маршруты
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
});

// Публичные маршруты для покупателей
Route::get('/products', [PublicProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [PublicProductController::class, 'search'])->name('products.search');

Route::get('/products/{product}', [PublicProductController::class, 'show'])->name('products.show');
Route::get('products/category/{category}', [PublicProductController::class, 'byCategory'])->name('products.byCategory');

Route::middleware('auth')->group(function () {
    // Профиль
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');  // просмотр профиля
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit'); // редактирование профиля
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Корзина
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{product}/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{cartItem}/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/{cartItem}/update', [CartController::class, 'update'])->name('cart.update');

    // Избранное
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{product}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Отзывы
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::patch('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Лайки
    Route::post('/reviews/{review}/like', [LikeController::class, 'toggle'])->name('reviews.like.toggle');

    Route::get('/order/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/order', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

require __DIR__.'/auth.php';
