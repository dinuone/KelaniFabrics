<?php

namespace App\Exports;

use App\Models\Category;
use App\Enums\StatusEnum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Category::select('cat_name', 'cat_status')->get()->map(function ($category) {
            return [
                'cat_name' => $category->cat_name,
                'cat_status' => $category->cat_status === StatusEnum::ACTIVE ? 'Active' : 'Inactive',
            ];
        });
    }

    public function headings(): array
    {
        return ['Category Name', 'Status'];
    }
}
