<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubCategory;

class SubCategorySeeder extends Seeder
{
    public function run(): void
    {
        $subCategories = [
            ['sub_cat_name' => 'T-Shirts', 'cat_id' => 1, 'sub_cat_status' => 1],
            ['sub_cat_name' => 'Jeans', 'cat_id' => 1, 'sub_cat_status' => 1],
            ['sub_cat_name' => 'Dresses', 'cat_id' => 2, 'sub_cat_status' => 1],
            ['sub_cat_name' => 'Skirts', 'cat_id' => 2, 'sub_cat_status' => 1],
            ['sub_cat_name' => 'Toys', 'cat_id' => 3, 'sub_cat_status' => 1],
            ['sub_cat_name' => 'Baby Wear', 'cat_id' => 3, 'sub_cat_status' => 1],
            ['sub_cat_name' => 'Belts', 'cat_id' => 4, 'sub_cat_status' => 1],
            ['sub_cat_name' => 'Hats', 'cat_id' => 4, 'sub_cat_status' => 1],
            ['sub_cat_name' => 'Sneakers', 'cat_id' => 5, 'sub_cat_status' => 1],
            ['sub_cat_name' => 'Sandals', 'cat_id' => 5, 'sub_cat_status' => 1],
        ];

        foreach ($subCategories as $subCategory) {
            SubCategory::create($subCategory);
        }
    }
}
