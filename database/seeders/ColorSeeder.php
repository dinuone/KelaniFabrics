<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            'Red',
            'Blue',
            'Green',
            'Yellow',
            'Black',
            'Orange',
            'Pink',
        ];

        foreach ($colors as $color) {
            DB::table('colors')->insert([
                'color_name' => $color,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
