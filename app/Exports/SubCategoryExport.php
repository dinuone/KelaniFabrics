<?php

namespace App\Exports;

use App\Models\SubCategory;
use App\Enums\StatusEnum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubCategoryExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return SubCategory::with('category')->get()->map(function ($subCategory) {
            return [
                'sub_category_name' => $subCategory->sub_cat_name,
                'parent_category' => $subCategory->category->cat_name ?? 'N/A',
                'status' => $subCategory->sub_cat_status === StatusEnum::ACTIVE ? 'Active' : 'Inactive',
            ];
        });
    }

    public function headings(): array
    {
        return ['Sub Category Name', 'Parent Category', 'Status'];
    }
}
