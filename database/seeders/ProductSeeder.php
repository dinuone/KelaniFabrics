<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Storage::disk('public')->deleteDirectory('products');
        Storage::disk('public')->makeDirectory('products');

        $urls = [
            'https://picsum.photos/seed/shirt/300/300',
            'https://picsum.photos/seed/jeans/300/300',
            'https://picsum.photos/seed/jacket/300/300',
            'https://picsum.photos/seed/hat/300/300',
            'https://picsum.photos/seed/shoes/300/300',
            'https://picsum.photos/seed/dress/300/300',
        ];

        $names = ['shirt.jpg', 'jeans.jpg', 'jacket.jpg', 'hat.jpg', 'shoes.jpg', 'dress.jpg'];

        foreach ($urls as $index => $url) {
            $imageContent = file_get_contents($url);
            File::ensureDirectoryExists(public_path('images/products'));
            file_put_contents(public_path('images/products/' . $names[$index]), $imageContent);
        }

        $localImages = [
            'images/products/shirt.jpg',
            'images/products/jeans.jpg',
            'images/products/jacket.jpg',
            'images/products/hat.jpg',
            'images/products/shoes.jpg',
            'images/products/dress.jpg',
        ];

        // Fetch available colors and sizes for random association
        $allColors = Color::pluck('id')->toArray();
        $allSizes = Size::pluck('id')->toArray();

        for ($i = 1; $i <= 10; $i++) {
            $catId = rand(1, 5);
            $subCatId = rand(1, 10);

            $image = $localImages[array_rand($localImages)];
            $imageName = 'products/' . Str::random(20) . '.jpg';

            Storage::disk('public')->put(
                $imageName,
                file_get_contents(public_path($image))
            );

            $product = Product::create([
                'product_name' => 'Sample Product ' . $i,
                'price' => rand(1000, 10000) / 1,
                'status' => true,
                'description' => 'Description for product ' . $i,
                'cat_id' => $catId,
                'sub_cat_id' => $subCatId,
                'image' => $imageName,
            ]);

       
            $randomColor = $allColors[array_rand($allColors)];
            $product->colors()->attach($randomColor);

            // Attach random sizes (1-3 sizes)
            $randomSizes = (array)array_rand(array_flip($allSizes), rand(1, min(3, count($allSizes))));
            $product->sizes()->attach($randomSizes);
        }
    }
}
