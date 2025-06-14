<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AdminProductService extends BaseProductService
{
    public function createProduct(array $data): Product
    {
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->storeImage($data['image']);
        }

        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        if (isset($data['image'])) {
            $this->deleteImage($product->image);
            $data['image'] = $this->storeImage($data['image']);
        }

        $product->update($data);
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
