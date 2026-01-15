<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\Color;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            // Electronics - Smartphones
            [
                'title' => 'iPhone 15 Pro Max',
                'category' => 'Electronics',
                'subcategory' => 'Smartphones',
                'brand' => 'Apple',
                'old_price' => 1299.00,
                'price' => 1199.00,
                'short_description' => 'The most advanced iPhone ever with titanium design and A17 Pro chip.',
                'description' => 'Experience the power of the iPhone 15 Pro Max with its revolutionary titanium design, A17 Pro chip, and advanced camera system. Features a 6.7-inch Super Retina XDR display, 5G connectivity, and all-day battery life.',
                'additional_information' => 'Storage: 256GB, 512GB, 1TB\nDisplay: 6.7-inch Super Retina XDR\nCamera: 48MP Main, 12MP Ultra Wide, 12MP Telephoto\nBattery: Up to 29 hours video playback',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=500',
                    'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=500',
                ],
                'colors' => ['Black', 'White', 'Blue', 'Gold'],
                'sizes' => []
            ],
            [
                'title' => 'Samsung Galaxy S24 Ultra',
                'category' => 'Electronics',
                'subcategory' => 'Smartphones',
                'brand' => 'Samsung',
                'old_price' => 1399.00,
                'price' => 1299.00,
                'short_description' => 'Ultimate productivity with S Pen and AI-powered features.',
                'description' => 'The Samsung Galaxy S24 Ultra combines cutting-edge technology with productivity features. Built-in S Pen, 200MP camera, and AI-enhanced performance make it perfect for professionals and creators.',
                'additional_information' => 'Storage: 256GB, 512GB, 1TB\nDisplay: 6.8-inch Dynamic AMOLED 2X\nCamera: 200MP Main, 50MP Periscope Telephoto\nS Pen: Built-in with advanced features',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=500',
                    'https://images.unsplash.com/photo-1580910051074-3eb694886505?w=500',
                ],
                'colors' => ['Black', 'Gray', 'Purple'],
                'sizes' => []
            ],

            // Electronics - Laptops
            [
                'title' => 'MacBook Pro 16-inch M3',
                'category' => 'Electronics',
                'subcategory' => 'Laptops',
                'brand' => 'Apple',
                'old_price' => 2699.00,
                'price' => 2499.00,
                'short_description' => 'Supercharged for pros with M3 chip and Liquid Retina XDR display.',
                'description' => 'The MacBook Pro 16-inch with M3 chip delivers exceptional performance for professional workflows. Features a stunning Liquid Retina XDR display, advanced thermal design, and all-day battery life.',
                'additional_information' => 'Processor: Apple M3 chip\nMemory: 18GB unified memory\nStorage: 512GB SSD\nDisplay: 16.2-inch Liquid Retina XDR\nBattery: Up to 22 hours',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500',
                    'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500',
                ],
                'colors' => ['Silver', 'Gray'],
                'sizes' => []
            ],

            // Fashion - Men's Clothing
            [
                'title' => 'Classic Denim Jacket',
                'category' => 'Fashion',
                'subcategory' => 'Men\'s Clothing',
                'brand' => 'Levi\'s',
                'old_price' => 89.99,
                'price' => 69.99,
                'short_description' => 'Timeless denim jacket perfect for any casual outfit.',
                'description' => 'This classic denim jacket is a wardrobe essential. Made from premium denim with a comfortable fit, it features traditional styling with modern updates. Perfect for layering in any season.',
                'additional_information' => 'Material: 100% Cotton Denim\nFit: Regular\nCare: Machine wash cold\nOrigin: Made in USA',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=500',
                    'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=500',
                ],
                'colors' => ['Blue', 'Black'],
                'sizes' => ['S', 'M', 'L', 'XL', 'XXL']
            ],

            // Fashion - Women's Clothing
            [
                'title' => 'Elegant Summer Dress',
                'category' => 'Fashion',
                'subcategory' => 'Women\'s Clothing',
                'brand' => 'Zara',
                'old_price' => 79.99,
                'price' => 59.99,
                'short_description' => 'Flowing summer dress perfect for warm weather occasions.',
                'description' => 'This elegant summer dress combines comfort with style. Made from lightweight, breathable fabric with a flattering silhouette. Perfect for brunches, dates, or casual summer events.',
                'additional_information' => 'Material: 100% Viscose\nFit: Regular\nLength: Midi\nCare: Hand wash recommended',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=500',
                    'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=500',
                ],
                'colors' => ['White', 'Pink', 'Yellow'],
                'sizes' => ['XS', 'S', 'M', 'L', 'XL']
            ],

            // Fashion - Shoes
            [
                'title' => 'Air Max Running Shoes',
                'category' => 'Fashion',
                'subcategory' => 'Shoes',
                'brand' => 'Nike',
                'old_price' => 149.99,
                'price' => 129.99,
                'short_description' => 'Comfortable running shoes with Air Max cushioning technology.',
                'description' => 'Experience ultimate comfort with these Air Max running shoes. Featuring Nike\'s signature Air Max cushioning, breathable mesh upper, and durable rubber outsole for superior performance.',
                'additional_information' => 'Upper: Mesh and synthetic materials\nSole: Rubber with Air Max cushioning\nFit: True to size\nActivity: Running, Training, Casual',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500',
                    'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=500',
                ],
                'colors' => ['Black', 'White', 'Red', 'Blue'],
            ],

            // Home & Garden - Furniture
            [
                'title' => 'Modern Sectional Sofa',
                'category' => 'Home & Garden',
                'subcategory' => 'Furniture',
                'brand' => 'IKEA',
                'old_price' => 899.99,
                'price' => 799.99,
                'short_description' => 'Comfortable L-shaped sectional sofa perfect for modern living rooms.',
                'description' => 'This modern sectional sofa combines style and comfort. Features high-quality upholstery, sturdy frame construction, and modular design. Perfect centerpiece for any contemporary living space.',
                'additional_information' => 'Dimensions: 120" W x 85" D x 35" H\nSeating: 5-6 people\nFrame: Solid wood and metal\nUpholstery: Premium fabric\nAssembly: Required',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=500',
                    'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500',
                ],
                'colors' => ['Gray', 'Navy', 'Brown'],
                'sizes' => []
            ],

            // Sports & Outdoors
            [
                'title' => 'Professional Yoga Mat',
                'category' => 'Sports & Outdoors',
                'subcategory' => 'Fitness Equipment',
                'brand' => 'Adidas',
                'old_price' => 49.99,
                'price' => 39.99,
                'short_description' => 'Premium yoga mat with superior grip and cushioning.',
                'description' => 'This professional yoga mat provides excellent grip and cushioning for all yoga practices. Made from eco-friendly materials with non-slip surface and optimal thickness for comfort and stability.',
                'additional_information' => 'Dimensions: 72" L x 24" W x 6mm thick\nMaterial: Natural rubber\nWeight: 2.5 lbs\nCare: Wipe clean with damp cloth',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=500',
                    'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500',
                ],
                'colors' => ['Purple', 'Blue', 'Green', 'Pink'],
                'sizes' => []
            ],

            // Books
            [
                'title' => 'The Great Gatsby',
                'category' => 'Books',
                'subcategory' => 'Fiction',
                'brand' => null,
                'old_price' => 14.99,
                'price' => 12.99,
                'short_description' => 'Classic American novel by F. Scott Fitzgerald.',
                'description' => 'Set in the summer of 1922, The Great Gatsby follows Nick Carraway as he observes the tragic story of Jay Gatsby and his obsession with Daisy Buchanan. A masterpiece of American literature.',
                'additional_information' => 'Author: F. Scott Fitzgerald\nPages: 180\nPublisher: Scribner\nLanguage: English\nISBN: 978-0-7432-7356-5',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=500',
                    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=500',
                ],
                'colors' => [],
                'sizes' => []
            ],

            // Health & Beauty
            [
                'title' => 'Vitamin C Serum',
                'category' => 'Health & Beauty',
                'subcategory' => 'Skincare',
                'brand' => null,
                'old_price' => 29.99,
                'price' => 24.99,
                'short_description' => 'Brightening vitamin C serum for radiant, youthful skin.',
                'description' => 'This powerful vitamin C serum helps brighten skin, reduce dark spots, and promote collagen production. Formulated with 20% vitamin C, hyaluronic acid, and vitamin E for maximum effectiveness.',
                'additional_information' => 'Volume: 30ml\nIngredients: 20% Vitamin C, Hyaluronic Acid, Vitamin E\nSkin Type: All skin types\nUsage: Apply morning and evening',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=500',
                    'https://images.unsplash.com/photo-1570194065650-d99fb4bedf0a?w=500',
                ],
                'colors' => [],
                'sizes' => []
            ],

            // Additional Electronics
            [
                'title' => 'Wireless Bluetooth Headphones',
                'category' => 'Electronics',
                'subcategory' => 'Headphones',
                'brand' => 'Sony',
                'old_price' => 199.99,
                'price' => 149.99,
                'short_description' => 'Premium wireless headphones with noise cancellation.',
                'description' => 'Experience superior sound quality with these wireless Bluetooth headphones. Features active noise cancellation, 30-hour battery life, and premium comfort for extended listening sessions.',
                'additional_information' => 'Battery: 30 hours playback\nConnectivity: Bluetooth 5.0\nNoise Cancellation: Active\nWeight: 254g',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500',
                    'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=500',
                ],
                'colors' => ['Black', 'White', 'Silver'],
                'sizes' => []
            ],
            [
                'title' => '4K Smart TV 55 inch',
                'category' => 'Electronics',
                'subcategory' => 'Laptops',
                'brand' => 'Samsung',
                'old_price' => 799.99,
                'price' => 699.99,
                'short_description' => 'Ultra HD 4K Smart TV with HDR and streaming apps.',
                'description' => 'Immerse yourself in stunning 4K resolution with this 55-inch Smart TV. Features HDR technology, built-in streaming apps, and voice control for the ultimate viewing experience.',
                'additional_information' => 'Screen Size: 55 inches\nResolution: 4K Ultra HD\nSmart Features: Built-in WiFi, Netflix, Prime Video\nHDR: HDR10+',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=500',
                    'https://images.unsplash.com/photo-1461151304267-38535e780c79?w=500',
                ],
                'colors' => ['Black'],
                'sizes' => []
            ],

            // Additional Fashion Items
            [
                'title' => 'Leather Crossbody Bag',
                'category' => 'Fashion',
                'subcategory' => 'Women\'s Clothing',
                'brand' => 'Coach',
                'old_price' => 299.99,
                'price' => 249.99,
                'short_description' => 'Elegant leather crossbody bag perfect for everyday use.',
                'description' => 'This sophisticated leather crossbody bag combines style and functionality. Made from genuine leather with adjustable strap and multiple compartments for organization.',
                'additional_information' => 'Material: Genuine Leather\nDimensions: 10" W x 8" H x 3" D\nStrap: Adjustable 22"-26"\nClosure: Zip top',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500',
                    'https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=500',
                ],
                'colors' => ['Brown', 'Black', 'Tan'],
                'sizes' => []
            ],
            [
                'title' => 'Classic White Sneakers',
                'category' => 'Fashion',
                'subcategory' => 'Shoes',
                'brand' => 'Adidas',
                'old_price' => 89.99,
                'price' => 79.99,
                'short_description' => 'Timeless white sneakers perfect for casual wear.',
                'description' => 'These classic white sneakers are a wardrobe essential. Made with premium materials and comfortable cushioning, perfect for everyday wear and casual outfits.',
                'additional_information' => 'Upper: Leather and synthetic\nSole: Rubber\nFit: True to size\nStyle: Low-top sneakers',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=500',
                    'https://images.unsplash.com/photo-1560769629-975ec94e6a86?w=500',
                ],
                'colors' => ['White', 'Off-White'],
                'sizes' => []
            ],

            // Additional Home & Garden
            [
                'title' => 'Ceramic Table Lamp',
                'category' => 'Home & Garden',
                'subcategory' => 'Furniture',
                'brand' => null,
                'old_price' => 79.99,
                'price' => 59.99,
                'short_description' => 'Modern ceramic table lamp with fabric shade.',
                'description' => 'Add warmth to your space with this elegant ceramic table lamp. Features a modern design with textured ceramic base and neutral fabric shade that complements any decor.',
                'additional_information' => 'Height: 24 inches\nBase: Ceramic\nShade: Fabric\nBulb: E26 (not included)\nSwitch: On/off switch',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=500',
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=500',
                ],
                'colors' => ['White', 'Gray', 'Beige'],
                'sizes' => []
            ],
            [
                'title' => 'Indoor Plant Collection',
                'category' => 'Home & Garden',
                'subcategory' => 'Garden Tools',
                'brand' => null,
                'old_price' => 49.99,
                'price' => 39.99,
                'short_description' => 'Set of 3 low-maintenance indoor plants perfect for beginners.',
                'description' => 'Bring life to your home with this collection of three beautiful indoor plants. Includes snake plant, pothos, and peace lily - all known for their air-purifying qualities and easy care.',
                'additional_information' => 'Plants: Snake Plant, Pothos, Peace Lily\nPot Size: 4-6 inches\nCare: Low to medium light, water weekly\nBenefits: Air purifying',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=500',
                    'https://images.unsplash.com/photo-1463320726281-696a485928c7?w=500',
                ],
                'colors' => ['Green'],
                'sizes' => []
            ],

            // Additional Sports & Outdoors
            [
                'title' => 'Adjustable Dumbbells Set',
                'category' => 'Sports & Outdoors',
                'subcategory' => 'Fitness Equipment',
                'brand' => null,
                'old_price' => 299.99,
                'price' => 249.99,
                'short_description' => 'Space-saving adjustable dumbbells for home workouts.',
                'description' => 'Transform your home into a gym with this adjustable dumbbell set. Each dumbbell adjusts from 5 to 50 pounds, replacing 15 sets of weights in one compact design.',
                'additional_information' => 'Weight Range: 5-50 lbs per dumbbell\nTotal Weight: 100 lbs\nAdjustment: Quick-change dial system\nSpace: Compact design',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500',
                    'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=500',
                ],
                'colors' => ['Black', 'Gray'],
                'sizes' => []
            ],

            // Additional Books
            [
                'title' => 'To Kill a Mockingbird',
                'category' => 'Books',
                'subcategory' => 'Fiction',
                'brand' => null,
                'old_price' => 16.99,
                'price' => 13.99,
                'short_description' => 'Timeless classic by Harper Lee about justice and morality.',
                'description' => 'Harper Lee\'s Pulitzer Prize-winning novel explores themes of racial injustice and moral growth through the eyes of Scout Finch in 1930s Alabama. A must-read American classic.',
                'additional_information' => 'Author: Harper Lee\nPages: 376\nPublisher: Harper Perennial\nLanguage: English\nAwards: Pulitzer Prize',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=500',
                    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=500',
                ],
                'colors' => [],
                'sizes' => []
            ],

            // Additional Health & Beauty
            [
                'title' => 'Moisturizing Face Cream',
                'category' => 'Health & Beauty',
                'subcategory' => 'Skincare',
                'brand' => null,
                'old_price' => 39.99,
                'price' => 29.99,
                'short_description' => 'Hydrating face cream for all skin types with SPF 30.',
                'description' => 'Keep your skin hydrated and protected with this daily moisturizing face cream. Formulated with hyaluronic acid and SPF 30 for all-day hydration and sun protection.',
                'additional_information' => 'Volume: 50ml\nSPF: 30\nIngredients: Hyaluronic Acid, Ceramides\nSkin Type: All skin types',
                'shipping_return' => 'Free shipping on orders over $50. 30-day return policy.',
                'images' => [
                    'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=500',
                    'https://images.unsplash.com/photo-1570194065650-d99fb4bedf0a?w=500',
                ],
                'colors' => [],
                'sizes' => []
            ],
        ];

        foreach ($products as $productData) {
            // Find related models
            $category = Category::where('name', $productData['category'])->first();
            $subcategory = Subcategory::where('name', $productData['subcategory'])->first();
            $brand = $productData['brand'] ? Brand::where('name', $productData['brand'])->first() : null;

            // Create product
            $product = Product::create([
                'title' => $productData['title'],
                'category_id' => $category->id,
                'subcategory_id' => $subcategory->id,
                'brand_id' => $brand ? $brand->id : null,
                'old_price' => $productData['old_price'],
                'price' => $productData['price'],
                'short_description' => $productData['short_description'],
                'description' => $productData['description'],
                'additional_information' => $productData['additional_information'],
                'shipping_return' => $productData['shipping_return'],
                'status' => true,
                'is_trendy' => rand(0, 1),
                'isdelete' => false,
            ]);

            // Add product images
            foreach ($productData['images'] as $index => $imageUrl) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imageUrl,
                    'mime_type' => 'image/jpeg',
                    'original_name' => $product->slug . '_' . ($index + 1) . '.jpg',
                    'order' => $index + 1,
                ]);
            }

            // Add product colors
            if (!empty($productData['colors'])) {
                foreach ($productData['colors'] as $colorName) {
                    $color = Color::where('name', $colorName)->first();
                    if ($color) {
                        ProductColor::create([
                            'product_id' => $product->id,
                            'color_id' => $color->id,
                        ]);
                    }
                }
            }

            // Add product sizes
            if (!empty($productData['sizes'])) {
                foreach ($productData['sizes'] as $sizeName) {
                    ProductSize::create([
                        'product_id' => $product->id,
                        'size_name' => $sizeName,
                        'additional_price' => rand(0, 20),
                        'quantity' => rand(10, 100),
                    ]);
                }
            }
        }
    }
}