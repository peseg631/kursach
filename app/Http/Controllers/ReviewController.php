<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewStoreRequest;
use App\Http\Requests\ReviewUpdateRequest;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    public function store(ReviewStoreRequest $request, Product $product)
    {
        $user = Auth::user();

        if ($product->reviews()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->withErrors(['limit' => 'Вы уже оставили отзыв на этот товар.']);
        }

        $reviewData = [
            'rating' => $request->rating,
            'user_id' => $user->id
        ];

        if ($request->filled('text')) {
            $reviewData['text'] = $request->text;
        }

        $product->reviews()->create($reviewData);

        return redirect()->back()->with('success', 'Отзыв успешно добавлен!');
    }

    public function update(ReviewUpdateRequest $request, Review $review)
    {
        if (Auth::id() !== $review->user_id) {
            abort(403, 'Доступ запрещён');
        }

        $updateData = [
            'rating' => $request->rating,
            'text' => $request->text ?: null
        ];

        $review->update($updateData);

        return redirect()->route('products.show', $review->product_id)
            ->with('success', 'Отзыв успешно обновлён!');
    }

    public function edit(Review $review)
    {
        if (Auth::id() !== $review->user_id) {
            abort(403, 'Доступ запрещён');
        }

        return view('reviews.edit', compact('review'));
    }

    public function destroy(Review $review)
    {
        if (Auth::id() !== $review->user_id) {
            abort(403, 'Доступ запрещён');
        }

        $review->delete();
        return redirect()->back()->with('success', 'Отзыв успешно удалён!');
    }
}
