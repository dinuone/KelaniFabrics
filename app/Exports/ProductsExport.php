<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Load relationships you want to export
        return Product::with(['category', 'subCategory', 'colors'])
            ->get()
            ->map(function ($product) {
                return [
                    'ID'             => $product->id,
                    'Product Ref'    => $product->product_ref,
                    'Product Name'   => $product->product_name,
                    'Category'       => $product->category->cat_name ?? 'N/A',
                    'Sub Category'   => $product->subCategory->sub_cat_name ?? 'N/A',
                    'Price'          => $product->price,
                    'Colors'         => $product->colors->pluck('color_name')->implode(', '),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Product Ref',
            'Product Name',
            'Category',
            'Sub Category',
            'Price',
            'Colors',
        ];
    }
}
