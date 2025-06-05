<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }
    public function toggle(Product $product)
    {
        $user = auth()->user();
        $cartItem = $user->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->delete();
            $message = 'Товар удалён из корзины';
        } else {
            $user->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => 1
            ]);
            $message = 'Товар добавлен в корзину';
        }

        return back()->with('success', $message);
    }
    public function add(Product $product)
    {
        $user = auth()->user();
        $cartItem = $user->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + 1
            ]);
        } else {
            $user->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        return back()->with('success', 'Товар добавлен в корзину');
    }
    public function remove(CartItem $cartItem)
    {
        if ($cartItem->user_id !== auth()->id()) {
            abort(403, 'Доступ запрещён');
        }

        $cartItem->delete();

        return back()->with('success', 'Товар удалён из корзины');
    }
    public function update(Request $request, CartItem $cartItem)
    {
        if ($cartItem->user_id !== auth()->id()) {
            abort(403, 'Доступ запрещён');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return back()->with('success', 'Количество обновлено');
    }
}
