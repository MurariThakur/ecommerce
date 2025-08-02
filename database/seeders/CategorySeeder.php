<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Clothing',
            'Home & Garden',
            'Sports & Outdoors',
            'Health & Beauty',
            'Books',
            'Toys & Games',
            'Jewelry',
            'Automotive',
            'Food & Beverages'
        ];

        foreach ($categories as $categoryName) {
            Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'meta_title' => $categoryName,
                'meta_description' => 'Sample description for ' . $categoryName,
                'meta_keyword' => strtolower(str_replace(' ', ',', $categoryName)),
                'status' => true,
                'isdelete' => false,
            ]);
        }
    }
}
