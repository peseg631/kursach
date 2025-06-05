<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('price_sort')) {
            $sortDirection = $request->input('price_sort');
            $query->orderBy('price', $sortDirection);
        }

        $featuredProduct = Product::where('name', 'LIKE', '%Air Max 97%')->first();
        if (!$featuredProduct) {
            $featuredProduct = Product::first();
        }

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
