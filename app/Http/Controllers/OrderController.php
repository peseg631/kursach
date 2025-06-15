<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();
        $selectedIds = $request->input('selected_items', []);

        $cartItems = $user->cartItems()
            ->with('product')
            ->when(!empty($selectedIds), fn($q) => $q->whereIn('id', $selectedIds))
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        return view('orders.create', [
            'cartItems' => $cartItems,
            'selectedIds' => $selectedIds
        ]);
    }

    public function store(OrderStoreRequest $request)
    {
        $user = Auth::user();
        $selectedIds = $request->input('selected_items', []);

        $cartItems = $user->cartItems()
            ->with('product')
            ->when(!empty($selectedIds), fn($q) => $q->whereIn('id', $selectedIds))
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        DB::transaction(function () use ($user, $cartItems, $request) {
            $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

            $order = Order::create([
                'user_id' => $user->id,
                'address' => $request->address,
                'total_price' => $total,
            ]);

            $cartItems->each(function ($item) use ($order) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
                $item->delete();
            });
        });

        return redirect()->route('orders.index')->with('success', 'Заказ оформлен!');
    }

    public function index()
    {
        $orders = Auth::user()
            ->orders()
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if (Auth::id() !== $order->user_id) {
            abort(403, 'Доступ запрещён');
        }

        return view('orders.show', compact('order'));
    }
}
