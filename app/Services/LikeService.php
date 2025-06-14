<?php

namespace App\Services;

use App\Models\Like;
use App\Models\Review;
use App\Models\User;

class LikeService
{
    public function toggleLike(Review $review, User $user): void
    {
        $like = $review->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'review_id' => $review->id,
                'user_id' => $user->id
            ]);
        }
    }
}
