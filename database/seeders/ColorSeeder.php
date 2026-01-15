<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    public function run()
    {
        $colors = [
            ['name' => 'Black', 'color_code' => '#000000', 'status' => true],
            ['name' => 'White', 'color_code' => '#FFFFFF', 'status' => true],
            ['name' => 'Red', 'color_code' => '#FF0000', 'status' => true],
            ['name' => 'Blue', 'color_code' => '#0000FF', 'status' => true],
            ['name' => 'Green', 'color_code' => '#008000', 'status' => true],
            ['name' => 'Yellow', 'color_code' => '#FFFF00', 'status' => true],
            ['name' => 'Purple', 'color_code' => '#800080', 'status' => true],
            ['name' => 'Orange', 'color_code' => '#FFA500', 'status' => true],
            ['name' => 'Pink', 'color_code' => '#FFC0CB', 'status' => true],
            ['name' => 'Gray', 'color_code' => '#808080', 'status' => true],
            ['name' => 'Brown', 'color_code' => '#A52A2A', 'status' => true],
            ['name' => 'Navy', 'color_code' => '#000080', 'status' => true],
            ['name' => 'Gold', 'color_code' => '#FFD700', 'status' => true],
            ['name' => 'Silver', 'color_code' => '#C0C0C0', 'status' => true],
        ];

        foreach ($colors as $color) {
            $color['is_deleted'] = false;
            Color::create($color);
        }
    }
}