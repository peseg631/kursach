<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('product')->get();
        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Product $product)
    {
        $user = Auth::user();
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
