<?php

namespace App\Services\Admin;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function getPaginatedCategories(): LengthAwarePaginator
    {
        return Category::paginate(15);
    }
}
