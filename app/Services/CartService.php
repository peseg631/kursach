<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function __construct(
        private User $user
    ) {}

    public function getCartItems(): Collection
    {
        return $this->user->cartItems()->with('product')->get();
    }

    public function calculateSelectedSum(Collection $cartItems, array $selectedIds): float
    {
        return $cartItems
            ->whereIn('id', $selectedIds)
            ->sum(fn($item) => $item->product->price * $item->quantity);
    }

    public function addProduct(Product $product): void
    {
        DB::transaction(function () use ($product) {
            $cartItem = $this->user->cartItems()->firstOrNew([
                'product_id' => $product->id
            ]);

            $cartItem->exists
                ? $cartItem->increment('quantity')
                : $cartItem->save(['quantity' => 1]);
        });
    }

    public function decrementProduct(Product $product): void
    {
        $cartItem = $this->getUserCartItem($product);
        $cartItem->quantity > 1
            ? $cartItem->decrement('quantity')
            : $cartItem->delete();
    }

    public function removeProduct(Product $product): void
    {
        $this->user->cartItems()
            ->where('product_id', $product->id)
            ->delete();
    }

    public function updateQuantity(CartItem $cartItem, int $quantity): void
    {
        $this->validateCartItemOwnership($cartItem);
        $cartItem->update(['quantity' => $quantity]);
    }

    protected function getUserCartItem(Product $product): CartItem
    {
        return $this->user->cartItems()
            ->where('product_id', $product->id)
            ->firstOrFail();
    }

    protected function validateCartItemOwnership(CartItem $cartItem): void
    {
        if ($cartItem->user_id !== $this->user->id) {
            abort(403, 'Доступ запрещён');
        }
    }
}
