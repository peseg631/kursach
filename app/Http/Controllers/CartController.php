<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemRequest;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService
    ) {}

    public function index(): View
    {
        $cartItems = $this->cartService->getCartItems();
        $selectedSum = $this->cartService->calculateSelectedSum(
            $cartItems,
            request()->input('selected_items', [])
        );

        return view('cart.index', compact('cartItems', 'selectedSum'));
    }

    public function add(Product $product): RedirectResponse
    {
        $this->cartService->addProduct($product);
        return back()->with('success', 'Товар добавлен в корзину');
    }

    public function decrement(Product $product): RedirectResponse
    {
        try {
            $this->cartService->decrementProduct($product);
            return back()->with('success', 'Количество товара обновлено');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function remove(Product $product): RedirectResponse
    {
        $this->cartService->removeProduct($product);
        return back()->with('success', 'Товар удалён из корзины');
    }

    public function update(CartItemRequest $request, CartItemRequest $cartItem): RedirectResponse
    {
        $this->cartService->updateQuantity($cartItem, $request->quantity);
        return back()->with('success', 'Количество обновлено');
    }
}
