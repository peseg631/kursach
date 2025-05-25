<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // Отображение списка избранных товаров пользователя
    public function index()
    {
        $favorites = auth()->user()->favorites()->with('product')->get();

        return view('favorites.index', compact('favorites'));
    }

    // Добавление или удаление товара из избранного (переключение)
    public function toggle(Product $product)
    {
        $user = auth()->user();

        $favorite = $user->favorites()->where('product_id', $product->id)->first();

        if ($favorite) {
            // Если уже в избранном - удаляем
            $favorite->delete();
            $message = 'Товар удалён из избранного';
        } else {
            // Если нет - добавляем
            $user->favorites()->create(['product_id' => $product->id]);
            $message = 'Товар добавлен в избранное';
        }

        return back()->with('success', $message);
    }
}
