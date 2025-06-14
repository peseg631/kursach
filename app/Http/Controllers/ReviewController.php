<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Product;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
class ReviewController extends Controller
{
    public function __construct(
        private ReviewService $reviewService
    ) {}

    public function store(ReviewRequest $request, Product $product): RedirectResponse
    {
        try {
            $this->reviewService->createReview($product, $request->validated());
            return redirect()->back()
                ->with('success', 'Отзыв успешно добавлен!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['limit' => $e->getMessage()]);
        }
    }

    public function edit(Product $product, Review $review): View
    {
        try {
            $this->reviewService->ensureUserOwnsReview($review);
            return view('reviews.edit', compact('product', 'review'));
        } catch (\Exception $e) {
            abort(403, $e->getMessage());
        }
    }

    public function update(ReviewRequest $request, Product $product, Review $review): RedirectResponse
    {
        try {
            $this->reviewService->updateReview($review, $request->validated());
            return redirect()->route('products.show', $product)
                ->with('success', 'Отзыв успешно обновлён!');
        } catch (\Exception $e) {
            abort(403, $e->getMessage());
        }
    }

    public function destroy(Product $product, Review $review): RedirectResponse
    {
        try {
            $this->reviewService->deleteReview($review);
            return redirect()->back()
                ->with('success', 'Отзыв успешно удалён!');
        } catch (\Exception $e) {
            abort(403, $e->getMessage());
        }
    }
}
