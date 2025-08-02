<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\Color;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all available data
        $categories = Category::active()->get();
        $brands = Brand::active()->get();
        $colors = Color::active()->get();
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

        // Create 50 sample products
        for ($i = 1; $i <= 50; $i++) {
            $category = $categories->random();
            $subcategory = $category->subcategories()->active()->inRandomOrder()->first();
            $brand = $brands->random();

            $title = $faker->words(3, true) . ' - ' . $brand->name;
            $oldPrice = $faker->randomFloat(2, 50, 500);
            $price = $faker->randomFloat(2, 20, $oldPrice - 10);

            $product = Product::create([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . $i,
                'category_id' => $category->id,
                'subcategory_id' => $subcategory ? $subcategory->id : null,
                'brand_id' => $brand->id,
                'old_price' => $oldPrice,
                'price' => $price,
                'short_description' => $faker->sentence(10),
                'description' => $faker->paragraphs(3, true),
                'additional_information' => $faker->paragraph(),
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'status' => $faker->boolean(90), // 90% chance of being active
                'isdelete' => false,
            ]);

            // Assign random colors (1-4 colors per product)
            $productColors = $colors->random($faker->numberBetween(1, 4));
            foreach ($productColors as $color) {
                ProductColor::create([
                    'product_id' => $product->id,
                    'color_id' => $color->id,
                ]);
            }

            // Assign random sizes (2-5 sizes per product)
            $productSizes = $faker->randomElements($sizes, $faker->numberBetween(2, 5));
            foreach ($productSizes as $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size_name' => $size,
                    'size_value' =>  $faker->numberBetween(1, 100),// Assuming size_value is the same as size_name
                    'quantity' => $faker->numberBetween(1, 100),
                    'additional_price' => $faker->randomFloat(2, 0, 20),
                ]);
            }
        }
    }
}
