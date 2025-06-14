<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

class BaseProductService
{
    public function filterProducts(
        array $filters,
        bool $paginate = false,
        int $perPage = 12
    ): Paginator|Collection {
        $query = Product::query()
            ->when($filters['search'] ?? null, fn($q, $search) =>
            $q->where('name', 'like', "%{$search}%"))
            ->when($filters['category_id'] ?? null, fn($q, $categoryId) =>
            $q->where('category_id', $categoryId));

        $this->applySorting($query, $filters);

        return $paginate
            ? $query->paginate($perPage)->withQueryString()
            : $query->get();
    }

    protected function applySorting($query, array $filters): void
    {
        if (isset($filters['price_sort'])) {
            $query->orderBy('price', $filters['price_sort']);
        } elseif (isset($filters['sort'])) {
            match($filters['sort']) {
                'price_asc' => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                default => $query->orderBy('id', 'asc')
            };
        } else {
            $query->orderBy('id', 'asc');
        }
    }
}
