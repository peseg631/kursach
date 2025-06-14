<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Category\AdminCategoryService;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private AdminCategoryService $categoryService
    ) {}
    public function index(): View
    {
        $categories = $this->categoryService->getPaginatedCategories();
        return view('admin.categories.index', compact('categories'));
    }
}
