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
    private $productTemplates = [
        // Clothing
        'clothing' => [
            'Men\'s {color} {material} {type}',
            'Women\'s {style} {type} with {feature}',
            'Unisex {brand} {type} - {color}',
            '{brand} {season} {type}',
            '{style} {type} for {occasion}',
            'Premium {material} {type} - {color}',
            'Classic {brand} {type} with {feature}',
            '{season} Collection {type}',
            'Trendy {color} {type} for {gender}',
            'Luxury {material} {type} by {brand}'
        ],

        // Footwear
        'footwear' => [
            '{brand} {style} Shoes - {color}',
            'Comfortable {type} for {occasion}',
            'Premium {material} {type} by {brand}',
            '{season} {style} {type}',
            'Athletic {type} with {feature}',
            'Classic {brand} {type} - {color}',
            'Trendy {style} {type} for {gender}',
            'Lightweight {material} {type}',
            '{brand} {style} Collection {type}',
            'Performance {type} with {feature}'
        ],

        // Electronics
        'electronics' => [
            '{brand} {model} {type} with {feature}',
            'Premium {type} - {color} {specs}',
            'Latest {brand} {type} {model}',
            'Smart {type} with {feature}',
            'High-Performance {brand} {type}',
            '{color} {type} by {brand}',
            'Professional {type} for {use}',
            'Advanced {brand} {type} {model}',
            'Portable {type} with {feature}',
            'Next-Gen {brand} {type}'
        ],

        // Home & Kitchen
        'home' => [
            '{material} {type} for {room}',
            'Premium {brand} {type} - {color}',
            'Modern {style} {type}',
            'Luxury {type} with {feature}',
            'Classic {brand} {type} for {use}',
            'Stylish {color} {type}',
            'Eco-Friendly {material} {type}',
            'Space-Saving {type} by {brand}',
            'Multi-Functional {type}',
            '{brand} {style} Collection {type}'
        ]
    ];

    private $productAttributes = [
        'color' => ['Black', 'White', 'Blue', 'Red', 'Green', 'Gray', 'Navy', 'Beige', 'Brown', 'Pink', 'Purple', 'Yellow'],
        'material' => ['Cotton', 'Polyester', 'Leather', 'Silk', 'Wool', 'Denim', 'Linen', 'Cashmere', 'Velvet', 'Spandex', 'Nylon'],
        'type' => [
            'clothing' => ['T-Shirt', 'Shirt', 'Jeans', 'Dress', 'Jacket', 'Hoodie', 'Sweater', 'Pants', 'Shorts', 'Skirt', 'Blouse'],
            'footwear' => ['Sneakers', 'Boots', 'Sandals', 'Loafers', 'Oxfords', 'Flip Flops', 'Athletic Shoes', 'High Heels', 'Slides'],
            'electronics' => ['Smartphone', 'Laptop', 'Headphones', 'Smart Watch', 'Tablet', 'Camera', 'Speaker', 'Monitor', 'Keyboard'],
            'home' => ['Sofa', 'Chair', 'Table', 'Lamp', 'Rug', 'Curtains', 'Bed', 'Cabinet', 'Shelves', 'Mirror']
        ],
        'style' => ['Casual', 'Formal', 'Sporty', 'Vintage', 'Bohemian', 'Minimalist', 'Urban', 'Classic', 'Contemporary'],
        'feature' => ['Zipper', 'Pockets', 'Wireless Charging', 'Noise Cancellation', 'Adjustable Straps', 'LED Display', 'Water Resistance'],
        'season' => ['Spring', 'Summer', 'Fall', 'Winter', 'All-Season'],
        'occasion' => ['Work', 'Party', 'Wedding', 'Travel', 'Sports', 'Everyday', 'Outdoor'],
        'gender' => ['Men', 'Women', 'Kids', 'Unisex'],
        'model' => ['Pro', 'Max', 'Air', 'Elite', 'Ultra', 'Lite', 'Plus', 'X', 'Z'],
        'specs' => ['8GB RAM', '4K Display', '512GB SSD', '20MP Camera', '10-hour Battery'],
        'room' => ['Living Room', 'Bedroom', 'Kitchen', 'Bathroom', 'Office', 'Dining Room'],
        'use' => ['Gaming', 'Office Work', 'Content Creation', 'Photography', 'Home Use']
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all available data
        $categories = Category::active()->get();
        $subcategoryies = Subcategory::active()->get();
        $brands = Brand::active()->get();
        $colors = Color::active()->get();
        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

        // Create 50 sample products
        for ($i = 1; $i <= 50; $i++) {
            $category = $categories->random();
            $subcategory = $category->subcategories()->active()->inRandomOrder()->first();
            $brand = $brands->random();

            // Determine product type based on category
            $categoryType = $this->getCategoryType($category);
            $title = $this->generateProductTitle($categoryType, $brand->name, $faker);

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
                    'size_value' => $faker->numberBetween(1, 100),
                    'quantity' => $faker->numberBetween(1, 100),
                    'additional_price' => $faker->randomFloat(2, 0, 20),
                ]);
            }
        }
    }

    private function getCategoryType($category)
    {
        $name = strtolower($category->name);

        if (str_contains($name, 'cloth') || str_contains($name, 'apparel')) {
            return 'clothing';
        } elseif (str_contains($name, 'shoe') || str_contains($name, 'foot')) {
            return 'footwear';
        } elseif (str_contains($name, 'electron') || str_contains($name, 'tech')) {
            return 'electronics';
        } elseif (str_contains($name, 'home') || str_contains($name, 'furniture')) {
            return 'home';
        }

        return 'clothing'; // default
    }

    private function generateProductTitle($categoryType, $brandName, $faker)
    {
        if (!isset($this->productTemplates[$categoryType])) {
            $categoryType = 'clothing'; // fallback to clothing if category type not found
        }

        $template = $faker->randomElement($this->productTemplates[$categoryType]);

        return preg_replace_callback('/\{([a-z_]+)\}/', function ($matches) use ($brandName, $faker, $categoryType) {
            $key = $matches[1];

            // Handle brand name replacement
            if ($key === 'brand') {
                return (string) $brandName;
            }

            // Handle type specifically as it's category-dependent
            if ($key === 'type') {
                if (isset($this->productAttributes['type'][$categoryType])) {
                    return (string) $faker->randomElement($this->productAttributes['type'][$categoryType]);
                }
                return ''; // return empty string if type not found
            }

            // Handle other attributes
            if (isset($this->productAttributes[$key])) {
                if (is_array($this->productAttributes[$key])) {
                    $value = $faker->randomElement($this->productAttributes[$key]);
                    return is_array($value) ? implode(' ', $value) : (string) $value;
                }
                return (string) $this->productAttributes[$key];
            }

            return ''; // return empty string if placeholder not found
        }, $template);
    }
}
