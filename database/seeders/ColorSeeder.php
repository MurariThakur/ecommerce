<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Color;
use Illuminate\Support\Str;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Red', 'color_code' => '#FF0000'],
            ['name' => 'Green', 'color_code' => '#00FF00'],
            ['name' => 'Blue', 'color_code' => '#0000FF'],
            ['name' => 'Yellow', 'color_code' => '#FFFF00'],
            ['name' => 'Black', 'color_code' => '#000000'],
        ];

        foreach ($colors as $color) {
            Color::create([
                'name' => $color['name'],
                'color_code' => $color['color_code'],
                'status' => true,
                'is_deleted' => false,
            ]);
        }
    }
}
