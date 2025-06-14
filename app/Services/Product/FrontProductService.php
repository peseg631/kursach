<?php

namespace App\Services\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

class FrontProductService extends BaseProductService
{
    public function getFeaturedProduct(): ?Product
    {
        return Product::where('name', 'LIKE', '%Air Max 97%')->first()
            ?? Product::first();
    }
}
