<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Disable foreign key checks for truncating
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductColor::truncate();
        ProductSize::truncate();
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Fetch active data
        $categories = Category::where('status', true)->get();
        $brands = Brand::where('status', true)->get();
        $colors = Color::where('status', true)->get();
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

        $descriptiveWords = [
            'Pro',
            'Max',
            'Ultra',
            'Classic',
            'Eco',
            'Premium',
            'Smart',
            'Lite',
            'Air',
            'Elite'
        ];

        if ($categories->isEmpty() || $brands->isEmpty() || $colors->isEmpty()) {
            $this->command->warn('Make sure categories, brands, and colors exist before seeding products.');
            return;
        }

        // Create 50 sample products
        for ($i = 1; $i <= 50; $i++) {
            $category = $categories->random();
            $subcategory = $category->subcategories()
                ->where('status', true)
                ->inRandomOrder()
                ->first();
            $brand = $brands->random();
            $descriptor = $faker->randomElement($descriptiveWords);

            // Build product title
            $titleParts = [$brand->name];
            $titleParts[] = $subcategory ? $subcategory->name : $category->name;
            $titleParts[] = $descriptor;
            $title = implode(' ', $titleParts);

            $oldPrice = $faker->randomFloat(2, 50, 500);
            $price = $faker->randomFloat(2, 20, $oldPrice - 10);

            $product = Product::create([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . $i,
                'category_id' => $category->id,
                'subcategory_id' => $subcategory?->id,
                'brand_id' => $brand->id,
                'old_price' => $oldPrice,
                'price' => $price,
                'short_description' => $faker->sentence(10),
                'description' => $faker->paragraphs(3, true),
                'additional_information' => $faker->paragraph(),
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'status' => $faker->boolean(90),
                'isdelete' => false,
            ]);

            // Assign random colors
            $numColors = $faker->numberBetween(1, min(4, $colors->count()));
            $selectedColors = $colors->random($numColors);
            $selectedColors = $selectedColors instanceof \Illuminate\Support\Collection
                ? $selectedColors
                : collect([$selectedColors]);

            foreach ($selectedColors as $color) {
                ProductColor::create([
                    'product_id' => $product->id,
                    'color_id' => $color->id,
                ]);
            }

            // Assign random sizes
            $selectedSizes = collect($sizes)
                ->shuffle()
                ->take($faker->numberBetween(2, count($sizes)));
            foreach ($selectedSizes as $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size_name' => $size,
                    'quantity' => $faker->numberBetween(1, 100),
                    'additional_price' => $faker->randomFloat(2, 0, 20),
                ]);
            }
        }
    }
}
