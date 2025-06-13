<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\ProductController as PublicProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('products.index');
    }
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return Auth::user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('products.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    });
});

Route::middleware(['auth', 'verified', 'ensure.not.admin'])->group(function () {
    Route::resource('products', PublicProductController::class)
        ->only(['index', 'show']);
    Route::get('products/category/{category}', [PublicProductController::class, 'byCategory'])
        ->name('products.byCategory');
    Route::get('/products/search', [PublicProductController::class, 'search'])
        ->name('products.search');

    Route::view('/contacts', 'contacts')
        ->name('contacts.index');

    Route::resource('cart', CartController::class)
        ->only(['index', 'store', 'update', 'destroy']);
    Route::post('/cart/add/{product}', [CartController::class, 'add'])
        ->name('cart.add');
    Route::post('/cart/decrement/{product}', [CartController::class, 'decrement'])
        ->name('cart.decrement');

    Route::resource('favorites', FavoriteController::class)
        ->only(['index']);
    Route::post('/favorites/{product}/toggle', [FavoriteController::class, 'toggle'])
        ->name('favorites.toggle');

    Route::resource('products.reviews', ReviewController::class)
        ->only(['store', 'edit', 'update', 'destroy']);

    Route::post('/reviews/{review}/like', [LikeController::class, 'toggle'])
        ->name('reviews.like.toggle');

    Route::resource('orders', OrderController::class)
        ->except(['edit', 'update', 'destroy']);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class)
        ->only(['index']);
});
