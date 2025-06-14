<?php

namespace App\Services\Admin;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function getFilteredProducts(array $filters)
    {
        return Product::query()
            ->when($filters['search'] ?? null, fn($q, $search) =>
            $q->where('name', 'like', "%{$search}%"))
            ->when($filters['category_id'] ?? null, fn($q, $categoryId) =>
            $q->where('category_id', $categoryId))
            ->when($filters['sort'] ?? null, function ($q, $sort) {
                switch ($sort) {
                    case 'price_asc': return $q->orderBy('price', 'asc');
                    case 'price_desc': return $q->orderBy('price', 'desc');
                    default: return $q->orderBy('id', 'asc');
                }
            })
            ->paginate(10)
            ->withQueryString();
    }

    public function createProduct(array $data): Product
    {
        $validData = collect($data)->only([
            'name', 'description', 'price', 'image', 'category_id'
        ])->toArray();

        if (isset($data['image'])) {
            $validData['image'] = $this->storeImage($data['image']);
        }

        return Product::create($validData);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        $validData = collect($data)->only([
            'name', 'description', 'price', 'image', 'category_id'
        ])->toArray();

        if (isset($data['image'])) {
            $this->deleteImage($product->image);
            $validData['image'] = $this->storeImage($data['image']);
        }

        $product->update($validData);
        return $product;
    }

    public function deleteProduct(Product $product): void
    {
        $this->deleteImage($product->image);
        $product->reviews()->delete();
        $product->delete();
    }

    protected function storeImage(UploadedFile $image): string
    {
        return $image->store('products', 'public');
    }

    protected function deleteImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
