<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Review $review)
    {
        $like = $review->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
            return redirect()->back()->with('success', 'Лайк удалён');
        }

        Like::create([
            'review_id' => $review->id,
            'user_id' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Лайк добавлен');
    }
}
