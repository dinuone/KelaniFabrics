<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Stock::with(['product.category', 'product.subCategory', 'color', 'size'])
            ->get()
            ->map(function ($stock) {
                return [
                    'Product Name'   => $stock->product->product_name ?? 'N/A',
                    'Category'       => $stock->product->category->cat_name ?? 'N/A',
                    'Sub Category'   => $stock->product->subCategory->sub_cat_name ?? 'N/A',
                    'Color'          => $stock->color->color_name ?? 'N/A',
                    'Size'           => $stock->size->size ?? 'N/A',
                    'Quantity'       => $stock->receive_qty,
                    'Availability'   => $stock->availability,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Product Name',
            'Category',
            'Sub Category',
            'Color',
            'Size',
            'Quantity',
            'Availability',
        ];
    }
}
