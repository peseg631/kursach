<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;

class FavoriteService
{
    public function getUserFavorites(User $user)
    {
        return $user->favorites()
            ->with('product')
            ->get();
    }

    public function toggle(User $user, Product $product): string
    {
        return $user->favorites()
            ->where('product_id', $product->id)
            ->exists()
            ? $this->remove($user, $product)
            : $this->add($user, $product);
    }

    protected function add(User $user, Product $product): string
    {
        $user->favorites()->create(['product_id' => $product->id]);
        return 'Товар добавлен в избранное';
    }

    protected function remove(User $user, Product $product): string
    {
        $user->favorites()->where('product_id', $product->id)->delete();
        return 'Товар удалён из избранного';
    }
}
