<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subcategory;
use App\Models\Category;

class SubcategorySeeder extends Seeder
{
    public function run()
    {
        $electronics = Category::where('name', 'Electronics')->first();
        $fashion = Category::where('name', 'Fashion')->first();
        $homeGarden = Category::where('name', 'Home & Garden')->first();
        $sports = Category::where('name', 'Sports & Outdoors')->first();
        $books = Category::where('name', 'Books')->first();
        $beauty = Category::where('name', 'Health & Beauty')->first();

        $subcategories = [
            // Electronics
            ['name' => 'Smartphones', 'category_id' => $electronics->id, 'meta_title' => 'Smartphones - Latest Mobile Phones', 'meta_description' => 'Shop the latest smartphones from top brands.', 'meta_keyword' => 'smartphones, mobile phones, android, iphone'],
            ['name' => 'Laptops', 'category_id' => $electronics->id, 'meta_title' => 'Laptops - Gaming & Business', 'meta_description' => 'Find the perfect laptop for work, gaming, or study.', 'meta_keyword' => 'laptops, computers, gaming, business'],
            ['name' => 'Headphones', 'category_id' => $electronics->id, 'meta_title' => 'Headphones - Audio & Music', 'meta_description' => 'Premium headphones for music lovers and professionals.', 'meta_keyword' => 'headphones, audio, music, wireless'],
            
            // Fashion
            ['name' => 'Men\'s Clothing', 'category_id' => $fashion->id, 'meta_title' => 'Men\'s Clothing - Shirts, Pants & More', 'meta_description' => 'Stylish men\'s clothing for every occasion.', 'meta_keyword' => 'mens clothing, shirts, pants, fashion'],
            ['name' => 'Women\'s Clothing', 'category_id' => $fashion->id, 'meta_title' => 'Women\'s Clothing - Dresses, Tops & More', 'meta_description' => 'Trendy women\'s clothing and accessories.', 'meta_keyword' => 'womens clothing, dresses, tops, fashion'],
            ['name' => 'Shoes', 'category_id' => $fashion->id, 'meta_title' => 'Shoes - Sneakers, Boots & Formal', 'meta_description' => 'Comfortable and stylish shoes for men and women.', 'meta_keyword' => 'shoes, sneakers, boots, footwear'],
            
            // Home & Garden
            ['name' => 'Furniture', 'category_id' => $homeGarden->id, 'meta_title' => 'Furniture - Sofas, Tables & Chairs', 'meta_description' => 'Quality furniture for your home and office.', 'meta_keyword' => 'furniture, sofas, tables, chairs, home'],
            ['name' => 'Kitchen', 'category_id' => $homeGarden->id, 'meta_title' => 'Kitchen - Appliances & Cookware', 'meta_description' => 'Essential kitchen appliances and cookware.', 'meta_keyword' => 'kitchen, appliances, cookware, home'],
            ['name' => 'Garden Tools', 'category_id' => $homeGarden->id, 'meta_title' => 'Garden Tools - Gardening Equipment', 'meta_description' => 'Professional garden tools and equipment.', 'meta_keyword' => 'garden tools, gardening, equipment, outdoor'],
            
            // Sports & Outdoors
            ['name' => 'Fitness Equipment', 'category_id' => $sports->id, 'meta_title' => 'Fitness Equipment - Home Gym', 'meta_description' => 'Build your home gym with quality fitness equipment.', 'meta_keyword' => 'fitness equipment, gym, exercise, health'],
            ['name' => 'Outdoor Gear', 'category_id' => $sports->id, 'meta_title' => 'Outdoor Gear - Camping & Hiking', 'meta_description' => 'Essential gear for camping, hiking, and outdoor adventures.', 'meta_keyword' => 'outdoor gear, camping, hiking, adventure'],
            
            // Books
            ['name' => 'Fiction', 'category_id' => $books->id, 'meta_title' => 'Fiction Books - Novels & Stories', 'meta_description' => 'Explore captivating fiction books and novels.', 'meta_keyword' => 'fiction books, novels, stories, literature'],
            ['name' => 'Non-Fiction', 'category_id' => $books->id, 'meta_title' => 'Non-Fiction Books - Educational & Informative', 'meta_description' => 'Learn with our collection of non-fiction books.', 'meta_keyword' => 'non-fiction books, educational, biography, history'],
            
            // Health & Beauty
            ['name' => 'Skincare', 'category_id' => $beauty->id, 'meta_title' => 'Skincare - Face & Body Care', 'meta_description' => 'Premium skincare products for healthy, glowing skin.', 'meta_keyword' => 'skincare, face care, body care, beauty'],
            ['name' => 'Makeup', 'category_id' => $beauty->id, 'meta_title' => 'Makeup - Cosmetics & Beauty', 'meta_description' => 'Professional makeup and cosmetics for every look.', 'meta_keyword' => 'makeup, cosmetics, beauty, lipstick, foundation'],
        ];

        foreach ($subcategories as $subcategory) {
            $subcategory['status'] = true;
            $subcategory['isdelete'] = false;
            Subcategory::create($subcategory);
        }
    }
}