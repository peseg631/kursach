<?php

namespace App\Http\Controllers;

use App\Services\Product\FrontProductService;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private FrontProductService $productService
    ) {}

    public function index(): View
    {
        return view('products.index', [
            'products' => $this->productService->filterProducts(request()->all()),
            'categories' => Category::all(),
            'featuredProduct' => $this->productService->getFeaturedProduct()
        ]);
    }

    public function byCategory(Category $category): View
    {
        return view('products.index', [
            'products' => $this->productService->filterProducts(
                array_merge(request()->all(), ['category_id' => $category->id]),
                true,
                12
            ),
            'categories' => Category::all(),
            'category' => $category
        ]);
    }

    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }
}
