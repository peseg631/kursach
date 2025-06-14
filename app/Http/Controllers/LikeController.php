<?php

namespace App\Http\Controllers;

use App\Services\LikeService;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function __construct(
        private LikeService $likeService
    ) {}

    public function toggle(Review $review): RedirectResponse
    {
        $this->likeService->toggleLike($review, Auth::user());
        return redirect()->back();
    }
}
