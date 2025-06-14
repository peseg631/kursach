<?php

namespace App\Services;

use App\Models\Product; // Добавляем импорт модели Product
use App\Models\Review;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class ReviewService
{
    public function createReview(Product $product, array $data): Review
    {
        $user = Auth::user();

        if ($this->userHasReviewForProduct($user, $product)) {
            throw new \Exception('Вы уже оставили отзыв на этот товар.');
        }

        return $product->reviews()->create([
            'text' => $data['text'],
            'rating' => $data['rating'],
            'user_id' => $user->id
        ]);
    }

    public function updateReview(Review $review, array $data): Review
    {
        $this->ensureUserOwnsReview($review);
        $review->update($data);
        return $review;
    }

    public function deleteReview(Review $review): void
    {
        $this->ensureUserOwnsReview($review);
        $review->delete();
    }

    public function ensureUserOwnsReview(Review $review): void
    {
        if (Auth::id() !== $review->user_id) {
            throw new ModelNotFoundException('Доступ запрещён');
        }
    }

    protected function userHasReviewForProduct($user, Product $product): bool
    {
        return $product->reviews()
            ->where('user_id', $user->id)
            ->exists();
    }
}
