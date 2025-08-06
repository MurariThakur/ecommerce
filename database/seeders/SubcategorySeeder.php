<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategory;
use App\Models\Category;
use Illuminate\Support\Str;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subcategories = [
            // Electronics (category_id: 1)
            1 => ['Smartphones', 'Laptops', 'Tablets', 'Headphones', 'Cameras'],
            // Clothing (category_id: 2)
            2 => ['Men\'s Clothing', 'Women\'s Clothing', 'Kids Clothing', 'Shoes', 'Accessories'],
            // Home & Garden (category_id: 3)
            3 => ['Furniture', 'Home Decor', 'Kitchen', 'Garden Tools', 'Bedding'],
            // Sports & Outdoors (category_id: 4)
            4 => ['Fitness Equipment', 'Outdoor Gear', 'Sports Apparel', 'Team Sports', 'Water Sports'],
            // Books (category_id: 6)
            5 => ['Fiction', 'Non-Fiction', 'Educational', 'Children\'s Books', 'Comics'],
            // Toys & Games (category_id: 7)
        ];

        foreach ($subcategories as $categoryId => $subs) {
            foreach ($subs as $subName) {
                $slug = Str::slug($subName);
                $counter = 1;
                $originalSlug = $slug;

                // Ensure unique slug
                while (Subcategory::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                Subcategory::create([
                    'name' => $subName,
                    'slug' => $slug,
                    'category_id' => $categoryId,
                    'meta_title' => $subName,
                    'meta_description' => 'Sample description for ' . $subName,
                    'meta_keyword' => strtolower(str_replace(' ', ',', $subName)),
                    'status' => true,
                    'isdelete' => false,
                ]);
            }
        }
    }
}
