<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function CategoryList()
    {
        $categories = Category::select('id', 'cat_name')->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}
