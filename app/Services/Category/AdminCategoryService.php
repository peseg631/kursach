<?php

namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdminCategoryService
{
    public function getPaginatedCategories(int $perPage = 15): LengthAwarePaginator
    {
        return Category::paginate($perPage);
    }
}
