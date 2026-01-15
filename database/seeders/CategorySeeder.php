<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Electronics',
                'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=400',
                'button_name' => 'Shop Electronics',
                'is_home' => true,
                'meta_title' => 'Electronics - Latest Gadgets & Tech',
                'meta_description' => 'Discover the latest electronics, smartphones, laptops, and tech gadgets at unbeatable prices.',
                'meta_keyword' => 'electronics, gadgets, smartphones, laptops, tech',
                'status' => true,
            ],
            [
                'name' => 'Fashion',
                'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=400',
                'button_name' => 'Shop Fashion',
                'is_home' => true,
                'meta_title' => 'Fashion - Trendy Clothing & Accessories',
                'meta_description' => 'Explore the latest fashion trends, clothing, shoes, and accessories for men and women.',
                'meta_keyword' => 'fashion, clothing, shoes, accessories, trends',
                'status' => true,
            ],
            [
                'name' => 'Home & Garden',
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=400',
                'button_name' => 'Shop Home',
                'is_home' => true,
                'meta_title' => 'Home & Garden - Furniture & Decor',
                'meta_description' => 'Transform your home with our collection of furniture, decor, and garden essentials.',
                'meta_keyword' => 'home, garden, furniture, decor, interior',
                'status' => true,
            ],
            [
                'name' => 'Sports & Outdoors',
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400',
                'button_name' => 'Shop Sports',
                'is_home' => true,
                'meta_title' => 'Sports & Outdoors - Fitness & Adventure Gear',
                'meta_description' => 'Get active with our sports equipment, fitness gear, and outdoor adventure essentials.',
                'meta_keyword' => 'sports, fitness, outdoor, equipment, adventure',
                'status' => true,
            ],
            [
                'name' => 'Books',
                'image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400',
                'button_name' => 'Shop Books',
                'is_home' => false,
                'meta_title' => 'Books - Fiction, Non-fiction & Educational',
                'meta_description' => 'Discover a vast collection of books across all genres and subjects.',
                'meta_keyword' => 'books, fiction, non-fiction, educational, literature',
                'status' => true,
            ],
            [
                'name' => 'Health & Beauty',
                'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=400',
                'button_name' => 'Shop Beauty',
                'is_home' => false,
                'meta_title' => 'Health & Beauty - Skincare & Wellness',
                'meta_description' => 'Enhance your beauty routine with our premium skincare, makeup, and wellness products.',
                'meta_keyword' => 'health, beauty, skincare, makeup, wellness',
                'status' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}