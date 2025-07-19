<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Category;

class SubCategoryController extends Controller
{
     public function SubCategoryList($id)
    {
        $subcategories = SubCategory::where('cat_id', $id)
            ->select('id', 'sub_cat_name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $subcategories
        ]);
    }

   
}
