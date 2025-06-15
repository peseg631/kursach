<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductIndexRequest;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(ProductIndexRequest $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('price_sort')) {
            $query->orderBy('price', $request->price_sort);
        }

        $featuredProduct = Product::where('name', 'LIKE', '%Air Max 97%')->first() ?? Product::first();

        return view('products.index', [
            'products' => $query->get(),
            'categories' => Category::all(),
            'featuredProduct' => $featuredProduct
        ]);
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function byCategory(Category $category)
    {
        $products = $category->products()->paginate(12);
        $categories = Category::all();
        return view('products.index', compact('products', 'category', 'categories'));
    }
}
