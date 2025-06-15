<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemUpdateRequest;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $cartItems = $user->cartItems()->with('product')->get();

        $selectedIds = $request->input('selected_items', []);
        $selectedSum = 0;

        $itemsToCalculate = !empty($selectedIds)
            ? $cartItems->whereIn('id', $selectedIds)
            : $cartItems;

        $selectedSum = $itemsToCalculate->sum(fn($item) => $item->product->price * $item->quantity);

        return view('cart.index', [
            'cartItems' => $cartItems,
            'selectedSum' => $selectedSum,
            'selectedIds' => $selectedIds
        ]);
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
        $cartItem = auth()->user()->cartItems()->where('product_id', $product->id)->firstOrFail();

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

    public function update(CartItemUpdateRequest $request, CartItem $cartItem)
    {
        $this->authorize('update', $cartItem);

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return back()->with('success', 'Количество обновлено');
    }
}
