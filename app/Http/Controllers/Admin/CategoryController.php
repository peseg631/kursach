<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\CategoryService;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService
    ) {}
    public function index(): View
    {
        $categories = $this->categoryService->getPaginatedCategories();
        return view('admin.categories.index', compact('categories'));
    }
}
