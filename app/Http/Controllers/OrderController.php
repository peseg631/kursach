<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Показать форму оформления заказа
    public function create(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);

        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product');

        // Если выбраны товары — фильтруем, иначе берём все
        if (!empty($selectedItems)) {
            $cartItems = $cartItems->whereIn('id', $selectedItems);
        }

        $cartItems = $cartItems->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        return view('orders.create', compact('cartItems'));
    }

    // Сохранить заказ
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:500',
            'selected_items' => 'sometimes|array',
        ]);

        $user = Auth::user();

        // Если товары не выбраны — берём все
        $selectedItems = $request->input('selected_items', []);
        $cartItems = $user->cartItems()->with('product');

        if (!empty($selectedItems)) {
            $cartItems = $cartItems->whereIn('id', $selectedItems);
        }

        $cartItems = $cartItems->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        // Создание заказа и удаление товаров из корзины
        DB::transaction(function () use ($user, $cartItems, $request) {
            $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

            $order = Order::create([
                'user_id' => $user->id,
                'address' => $request->address,
                'total_price' => $total,
                'status' => 'new',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            // Удаляем товары из корзины (только выбранные или все)
            $cartItems->each->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Заказ оформлен!');
    }

    // Просмотр истории заказов
    public function index()
    {
        $orders = Auth::user()->orders()->with('items.product')->orderBy('created_at', 'desc')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    // Просмотр конкретного заказа
    public function show(Order $order)
    {
        $this->authorize('view', $order); // Если используете политику
        return view('orders.show', compact('order'));
    }
}
