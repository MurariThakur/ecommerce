<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\Color;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductImage;
use App\Models\Notification;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'subcategory', 'brand'])->notDeleted();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('subcategory', function ($subcategoryQuery) use ($search) {
                        $subcategoryQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('brand', function ($brandQuery) use ($search) {
                        $brandQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status === 'active');
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Brand filter
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        // Subcategory filter
        if ($request->filled('subcategory')) {
            $query->where('subcategory_id', $request->subcategory);
        }

        // Stock status filter
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'in_stock') {
                $query->where('stock_quantity', '>', 0);
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where('stock_quantity', '<=', 0);
            }
        }

        // Date filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $products = $query->latest()->paginate(10)->appends($request->query());

        // Get filter options
        $categories = Category::active()->pluck('name', 'id');
        $brands = Brand::active()->pluck('name', 'id');
        $subcategories = Subcategory::active()->pluck('name', 'id');

        return view('admin.product.index', compact('products', 'categories', 'brands', 'subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = Category::active()->pluck('name', 'id');
        $brands = Brand::active()->pluck('name', 'id');
        $colors = Color::active()->pluck('name', 'id');
        return view('admin.product.create', compact('categories', 'brands', 'colors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // Create the product
        // dd($request->all());
        $productData = $request->validated();
        unset($productData['colors'], $productData['sizes'], $productData['images']); // Remove colors, sizes, and images from product data

        $product = Product::create($productData);

        Notification::createNotification(
            'product',
            'New Product Added',
            'Product "' . $product->title . '" has been added to inventory',
            route('product.detail', $product->slug),
            null,
            'fas fa-box',
            'success'
        );

        // Store colors if provided
        if ($request->has('colors') && !empty($request->colors)) {
            foreach ($request->colors as $colorId) {
                ProductColor::create([
                    'product_id' => $product->id,
                    'color_id' => $colorId
                ]);
            }
        }

        // Store sizes if provided
        if ($request->has('sizes') && !empty($request->sizes)) {
            foreach ($request->sizes as $sizeData) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size_name' => $sizeData['size_name'],
                    'additional_price' => $sizeData['additional_price'] ?? 0,
                    'quantity' => $sizeData['stock_quantity'] ?? 0
                ]);
            }
        }

        // Store images if provided
        if ($request->has('images') && !empty($request->images)) {
            foreach ($request->images as $imageData) {
                if (isset($imageData['image_data']) && !empty($imageData['image_data'])) {
                    // Extract the base64 data
                    $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $imageData['image_data']);
                    $imageContent = base64_decode($base64Data);

                    // Generate a unique filename
                    $filename = uniqid('product_') . '_' . time() . '.' . $this->getExtensionFromMimeType($imageData['mime_type']);
                    $path = 'products/' . $filename;

                    // Store the file
                    Storage::disk('public')->put($path, $imageContent);

                    // Create database record
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'mime_type' => $imageData['mime_type'],
                        'original_name' => $imageData['original_name'],
                        'file_size' => strlen($imageContent),
                        'order' => $imageData['order'] ?? 0
                    ]);
                }
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load([
            'category',
            'subcategory',
            'brand',
            'productImages' => function ($query) {
                $query->orderBy('order');
            },
            'colors',
            'productSizes'
        ]);

        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->pluck('name', 'id');
        $brands = Brand::active()->pluck('name', 'id');
        $colors = Color::active()->pluck('name', 'id');

        // Load subcategories for the selected category only
        $subcategories = [];
        if ($product->category_id) {
            $subcategories = Subcategory::where('category_id', $product->category_id)
                ->active()
                ->pluck('name', 'id');
        }

        // Load current product colors
        $selectedColors = ProductColor::where('product_id', $product->id)
            ->pluck('color_id')
            ->toArray();

        // Load current product sizes with full data
        $selectedSizes = ProductSize::where('product_id', $product->id)
            ->get(['size_name', 'additional_price', 'quantity'])
            ->toArray();
        // dd($selectedSizes);

        // Load product with images
        $product->load('productImages');

        return view('admin.product.edit', compact('product', 'categories', 'subcategories', 'brands', 'colors', 'selectedColors', 'selectedSizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        // Update the product
        $productData = $request->validated();
        unset($productData['colors'], $productData['sizes'], $productData['images'], $productData['existing_images'], $productData['deleted_images']); // Remove colors, sizes, and images from product data

        $product->update($productData);

        // Update colors - first remove previous data, then add new data
        ProductColor::where('product_id', $product->id)->delete();

        // Add new colors if provided
        if ($request->has('colors') && !empty($request->colors)) {
            foreach ($request->colors as $colorId) {
                ProductColor::create([
                    'product_id' => $product->id,
                    'color_id' => $colorId
                ]);
            }
        }

        // Update sizes - first remove previous data, then add new data
        ProductSize::where('product_id', $product->id)->delete();

        // Add new sizes if provided
        if ($request->has('sizes') && !empty($request->sizes)) {
            foreach ($request->sizes as $sizeData) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size_name' => $sizeData['size_name'],
                    'additional_price' => $sizeData['additional_price'] ?? 0,
                    'quantity' => $sizeData['stock_quantity'] ?? 0
                ]);
            }
        }

        // Handle image updates
        $this->handleImageUpdates($request, $product);

        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete all associated product images when soft deleting the product
        ProductImage::where('product_id', $product->id)->delete();

        // Soft delete the product
        $product->softDelete();

        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(Product $product)
    {
        $product->toggleStatus();
        return back()->with('success', 'Product status updated successfully.');
    }

    /**
     * Get subcategories by category (AJAX)
     */
    public function getSubcategories(Request $request)
    {
        $subcategories = Subcategory::where('category_id', $request->category_id)
            ->active()
            ->pluck('name', 'id');
        return response()->json($subcategories);
    }

    /**
     * Handle image updates for product edit
     */
    /**
     * Get file extension from MIME type
     */
    private function getExtensionFromMimeType($mimeType)
    {
        $map = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            'image/svg+xml' => 'svg'
        ];

        return $map[$mimeType] ?? 'jpg';
    }

    private function handleImageUpdates(Request $request, Product $product)
    {
        // Handle deleted images - they will be automatically deleted through the model's boot method
        if ($request->has('deleted_images') && !empty($request->deleted_images)) {
            ProductImage::whereIn('id', $request->deleted_images)
                ->where('product_id', $product->id)
                ->delete();
        }

        // Update existing images order only (don't recreate them)
        if ($request->has('existing_images') && !empty($request->existing_images)) {
            foreach ($request->existing_images as $imageId => $imageData) {
                ProductImage::where('id', $imageId)
                    ->where('product_id', $product->id)
                    ->update([
                        'order' => $imageData['order'] ?? 0
                    ]);
            }
        }

        // Add only genuinely new images (those with image_data)
        if ($request->has('images') && !empty($request->images)) {
            foreach ($request->images as $imageData) {
                // Only create if it has image_data (new images)
                if (isset($imageData['image_data']) && !empty($imageData['image_data'])) {
                    // Extract the base64 data
                    $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $imageData['image_data']);
                    $imageContent = base64_decode($base64Data);

                    // Generate a unique filename
                    $filename = uniqid('product_') . '_' . time() . '.' . $this->getExtensionFromMimeType($imageData['mime_type']);
                    $path = 'products/' . $filename;

                    // Store the file
                    Storage::disk('public')->put($path, $imageContent);

                    // Create database record
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'mime_type' => $imageData['mime_type'],
                        'original_name' => $imageData['original_name'],
                        'file_size' => strlen($imageContent),
                        'order' => $imageData['order'] ?? 0
                    ]);
                }
            }
        }
    }
}
