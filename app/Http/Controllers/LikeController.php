<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LikeController extends Controller
{
    public function toggle(Review $review)
    {
        $user = Auth::user();

        $like = $review->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'review_id' => $review->id,
                'user_id' => $user->id
            ]);
        }

        return redirect()->back();
    }
}
