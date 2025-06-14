<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Services\Product\AdminProductService;
use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public function __construct(
        private AdminProductService $productService
    ) {}

    public function index(): View
    {
        return view('admin.products.index', [
            'products' => $this->productService->filterProducts(
                request()->all(),
                true,
                10
            ),
            'categories' => Category::all()
        ]);
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $this->productService->createProduct($request->validated());
        return redirect()->route('admin.products.index')
            ->with('success', 'Товар добавлен');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $this->productService->updateProduct($product, $request->validated());
        return redirect()->route('admin.products.index')
            ->with('success', 'Товар обновлён');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->productService->deleteProduct($product);
        return redirect()->route('admin.products.index')
            ->with('success', 'Товар удалён');
    }
}
