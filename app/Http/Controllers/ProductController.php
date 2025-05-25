<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // Список товаров для покупателей
    public function index()
    {
        $products = Product::paginate(12);
        return view('products.index', compact('products'));
    }

    // Детальная страница товара
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function byCategory(Category $category)
    {
        $products = $category->products()->paginate(12);
        return view('products.index', compact('products', 'category'));
    }
}
