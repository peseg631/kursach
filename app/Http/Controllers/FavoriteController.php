<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\FavoriteService;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FavoriteController extends Controller
{
    public function __construct(
        private FavoriteService $favoriteService
    ) {}

    public function index(): View
    {
        $favorites = $this->favoriteService->getUserFavorites(auth()->user());
        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Product $product): RedirectResponse
    {
        $message = $this->favoriteService->toggle(
            auth()->user(),
            $product
        );

        return back()->with('success', $message);
    }
}
