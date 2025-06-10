<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();

        // Рассчитываем сумму выбранных товаров, если пришли выбранные id
        $selectedSum = 0;
        $selectedIds = $request->input('selected_items', []);
        if (!empty($selectedIds)) {
            $selectedSum = $cartItems
                ->whereIn('id', $selectedIds)
                ->sum(fn($item) => $item->product->price * $item->quantity);
        }

        return view('cart.index', compact('cartItems', 'selectedSum'));
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
            $cartItem->increment('quantity');
        } else {
            $user->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        return back()->with('success', 'Товар добавлен в корзину');
    }

    public function decrement(Product $product)
    {
        $cartItem = auth()->user()->cartItems()->where('product_id', $product->id)->first();

        if (!$cartItem) {
            return back()->with('error', 'Товар не найден в корзине');
        }

        if ($cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        } else {
            $cartItem->delete();
        }

        return back()->with('success', 'Количество товара обновлено');
    }

    public function remove(Product $product)
    {
        auth()->user()->cartItems()
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Товар удалён из корзины');
    }

    // Метод update можно оставить для универсальности, но в вашем шаблоне он не нужен
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
