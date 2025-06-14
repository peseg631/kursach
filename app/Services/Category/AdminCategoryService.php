<?php

namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminCategoryService
{
    public function getPaginatedCategories(): LengthAwarePaginator
    {
        return Category::paginate(15);
    }
}
