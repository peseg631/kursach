<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favorites()->with('product')->get();

        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Product $product)
    {
        $user = auth()->user();
        $favorite = $user->favorites()->where('product_id', $product->id)->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'Товар удалён из избранного';
        } else {
            $user->favorites()->create(['product_id' => $product->id]);
            $message = 'Товар добавлен в избранное';
        }
        return back()->with('success', $message);
    }
}
