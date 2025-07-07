<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['cat_name' => 'Men', 'cat_status' => 1],
            ['cat_name' => 'Women', 'cat_status' => 1],
            ['cat_name' => 'Kids', 'cat_status' => 1],
            ['cat_name' => 'Accessories', 'cat_status' => 1],
            ['cat_name' => 'Footwear', 'cat_status' => 1],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
