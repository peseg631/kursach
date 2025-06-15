<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartService
{
    protected ?User $user;

    public function __construct()
    {
        $this->user = Auth::user();

        if (!$this->user) {
            throw new \RuntimeException('User must be authenticated to use cart');
        }
    }

    public function getCartItems(): Collection
    {
        return $this->getAuthenticatedUser()->cartItems()->with('product')->get();
    }

    public function calculateSelectedSum(Collection $cartItems, array $selectedIds): float
    {
        return empty($selectedIds)
            ? 0
            : $cartItems->whereIn('id', $selectedIds)
                ->sum(fn($item) => $item->product->price * $item->quantity);
    }

    public function addProduct(Product $product): void
    {
        DB::transaction(function () use ($product) {
            $this->getAuthenticatedUser()->cartItems()->updateOrCreate(
                ['product_id' => $product->id],
                ['quantity' => DB::raw('quantity + 1')]
            );
        });
    }

    protected function getAuthenticatedUser(): User
    {
        if (!$this->user) {
            throw new \RuntimeException('No authenticated user');
        }
        return $this->user;
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
        if ($cartItem->user_id !== $this->user->id) {
            abort(403, 'Unauthorized action');
        }

        $cartItem->update(['quantity' => $quantity]);
    }

    protected function getUserCartItem(Product $product): CartItem
    {
        return $this->user->cartItems()
            ->where('product_id', $product->id)
            ->firstOrFail();
    }
}
