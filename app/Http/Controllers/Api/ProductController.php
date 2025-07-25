<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Color;
use App\Models\Size;
use App\Models\Stock;

class ProductController extends Controller
{
    public function ProductList()
    {
        $stock = Stock::with(['product', 'color', 'size'])
            ->select('id', 'price', 'availability')
            ->where('availability','=','In Stock')
            ->get();

        $stock->product->transform(function ($product) {
            $product->image = $product->image ? asset('storage/' . $product->image) : null;
            return $product;
        });

        return response()->json([
            'success' => true,
            'data' => $stock,
        ]);
    }

    public function ProductDetails($id)
    {
        $product = Product::with(['category', 'subCategory', 'colors', 'sizes'])->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        $product->image = $product->image ? asset('storage/' . $product->image) : null;

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    public function searchProducts(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'Search query is required.'
            ], 400);
        }

        $products = Product::where('product_name', 'like', "%{$query}%")
            ->orWhere('product_ref', 'like', "%{$query}%")
            ->limit(10)
            ->with(['category', 'subCategory', 'colors', 'sizes'])
            ->get(['id', 'product_name', 'product_ref', 'price', 'image']);

        $products->transform(function ($product) {
            $product->image = $product->image ? asset('storage/' . $product->image) : null;
            return $product;
        });

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    public function SubCategoryProducts($id)
    {
        $products = Product::with(['category', 'availableStocks.color', 'availableStocks.size'])
            ->where('sub_cat_id', $id)
            ->select('id', 'product_name', 'product_ref', 'price', 'image')
            ->get();

        $filteredProducts = $products->filter(function ($product) {
            return $product->availableStocks->isNotEmpty(); // Only products with stock
        })->map(function ($product) {
            $product->image = $product->image ? asset('storage/' . $product->image) : null;

            // Replace product colors/sizes with those from stock entries
            $product->colors = $product->availableStocks->pluck('color')->unique('id')->values();
            $product->sizes = $product->availableStocks->pluck('size')->unique('id')->values();

            return $product;
        })->values();

        return response()->json([
            'success' => true,
            'data' => $filteredProducts
        ]);
    }
}
