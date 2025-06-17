<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
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
    return Auth::check()
        ? (Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('products.index'))
        : redirect()->route('login');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route(Auth::user()->role === 'admin'
            ? 'admin.dashboard'
            : 'products.index');
    })->name('dashboard');

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    });
});

Route::middleware(['auth', 'verified', 'customer'])->group(function () {
    Route::prefix('products')->group(function () {
        Route::get('/', [PublicProductController::class, 'index'])->name('products.index');
        Route::get('/search', [PublicProductController::class, 'search'])->name('products.search');
        Route::get('/{product}', [PublicProductController::class, 'show'])->name('products.show');
        Route::get('/category/{category}', [PublicProductController::class, 'byCategory'])->name('products.byCategory');
    });

    Route::get('/contacts', function () {
        return view('contacts');
    })->name('contacts.index');

    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/toggle/{product}', [CartController::class, 'toggle'])->name('cart.toggle');
        Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
        Route::post('/update-quantity/{product}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
        Route::post('/decrement/{product}', [CartController::class, 'decrement'])->name('cart.decrement');
        Route::delete('/{product}', [CartController::class, 'remove'])->name('cart.remove');
        Route::patch('/{cartItem}/update', [CartController::class, 'update'])->name('cart.update');
    });

    Route::prefix('favorites')->group(function () {
        Route::get('/', [FavoriteController::class, 'index'])->name('favorites.index');
        Route::post('/{product}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    });

    Route::prefix('reviews')->group(function () {
        Route::post('/{product}', [ReviewController::class, 'store'])->name('reviews.store');
        Route::get('/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
        Route::patch('/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    });

    Route::post('/reviews/{review}/like', [LikeController::class, 'toggle'])->name('reviews.like.toggle');

    Route::prefix('orders')->group(function () {
        Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
});
