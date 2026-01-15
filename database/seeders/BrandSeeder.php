<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            ['name' => 'Apple', 'status' => true],
            ['name' => 'Samsung', 'status' => true],
            ['name' => 'Sony', 'status' => true],
            ['name' => 'Nike', 'status' => true],
            ['name' => 'Adidas', 'status' => true],
            ['name' => 'Zara', 'status' => true],
            ['name' => 'H&M', 'status' => true],
            ['name' => 'IKEA', 'status' => true],
            ['name' => 'Dell', 'status' => true],
            ['name' => 'HP', 'status' => true],
            ['name' => 'Canon', 'status' => true],
            ['name' => 'Nikon', 'status' => true],
            ['name' => 'Bose', 'status' => true],
            ['name' => 'JBL', 'status' => true],
            ['name' => 'Levi\'s', 'status' => true],
        ];

        foreach ($brands as $brand) {
            $brand['is_deleted'] = false;
            Brand::create($brand);
        }
    }
}