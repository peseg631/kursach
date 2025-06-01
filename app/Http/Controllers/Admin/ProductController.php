<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Список товаров
    public function index(Request $request)
    {
        $query = Product::query();

        // Поиск
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        // Фильтр по категории
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Сортировка
        if ($request->filled('sort')) {
            switch ($request->input('sort')) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                // Можно добавить другие варианты сортировки
            }
        } else {
            // Сортировка по умолчанию
            $query->orderBy('id', 'asc');
        }

        $products = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }


    // Форма создания нового товара
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Сохранение нового товара
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Товар добавлен');
    }

    // Форма редактирования товара
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // Обновление товара (полное)
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Товар обновлён');
    }

    // Удаление товара
    public function destroy(Product $product)
    {
        // Удаляем связанные отзывы перед удалением продукта
        $product->reviews()->delete();

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Товар удалён');
    }
}
