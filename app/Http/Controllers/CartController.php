<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartItemRequest;
use App\Models\{CartItem, Product};
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(CartItemRequest $request): View
    {
        $cartService = new CartService();

        $cartItems = $cartService->getCartItems();
        $selectedSum = $cartService->calculateSelectedSum(
            $cartItems,
            $request->input('selected_items', [])
        );

        return view('cart.index', compact('cartItems', 'selectedSum'));
    }

    public function add(Product $product): RedirectResponse
    {
        try {
            (new CartService())->addProduct($product);
            return back()->with('success', 'Product added to cart');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function decrement(Product $product): RedirectResponse
    {
        try {
            $this->cartService->decrementProduct($product);
            return back()->with('success', 'Quantity updated');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function remove(Product $product): RedirectResponse
    {
        try {
            $this->cartService->removeProduct($product);
            return back()->with('success', 'Product removed');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(CartItemRequest $request, CartItem $cartItem): RedirectResponse
    {
        try {
            $this->cartService->updateQuantity($cartItem, $request->quantity);
            return back()->with('success', 'Quantity updated');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
