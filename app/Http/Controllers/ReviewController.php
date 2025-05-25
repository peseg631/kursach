<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $user = auth()->user();

        // Проверяем, есть ли уже отзыв от этого пользователя к этому товару
        $existingReview = $product->reviews()
            ->where('user_id', $user->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->withErrors(['limit' => 'Вы уже оставили отзыв на этот товар.']);
        }

        $request->validate([
            'text' => 'required|string|max:1000',
            'rating' => 'required|integer|between:1,5'
        ]);

        $product->reviews()->create([
            'text' => $request->text,
            'rating' => $request->rating,
            'user_id' => $user->id
        ]);

        return redirect()->back()->with('success', 'Отзыв успешно добавлен!');
    }


    public function update(Request $request, Review $review)
    {
        if (auth()->id() !== $review->user_id) {
            abort(403, 'Доступ запрещён');
        }

        $request->validate([
            'text' => 'required|string|max:1000',
            'rating' => 'required|integer|between:1,5'
        ]);

        $review->update($request->only(['text', 'rating']));

        return redirect()->route('products.show', $review->product_id)
            ->with('success', 'Отзыв успешно обновлён!');
    }

    public function edit(Review $review)
    {
        if (auth()->id() !== $review->user_id) {
            abort(403, 'Доступ запрещён');
        }

        return view('reviews.edit', compact('review'));
    }

    public function destroy(Review $review)
    {
        if (auth()->id() !== $review->user_id) {
            abort(403, 'Доступ запрещён');
        }

        $review->delete();
        return redirect()->back()->with('success', 'Отзыв успешно удалён!');
    }
}
