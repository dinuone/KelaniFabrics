<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Size; // Make sure this exists and matches your sizes table model
use Illuminate\Support\Str;

class SizeSeeder extends Seeder
{
    public function run()
    {
        $sizes = [
            'XS', 'S', 'M', 'L', 'XL',
            'XXL', 'XXXL', '26', '28',
            '30', '32', '34', '36',
            '38', '40', '42', '44',
            '46', '48', '50'
        ];

        foreach ($sizes as $size) {
            Size::create([
                'size' => $size,
            ]);
        }
    }
}
