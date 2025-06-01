<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Список категорий
    public function index()
    {
        $categories = Category::paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

}
