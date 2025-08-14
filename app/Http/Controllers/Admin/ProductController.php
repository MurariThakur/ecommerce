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
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'subcategory'])
            ->notDeleted()
            ->latest()
            ->paginate(10);
        return view('admin.product.index', compact('products'));
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
        $productData = $request->validated();
        unset($productData['colors'], $productData['sizes'], $productData['images']);

        $product = Product::create($productData);

        // Store colors
        if (!empty($request->colors)) {
            foreach ($request->colors as $colorId) {
                ProductColor::create([
                    'product_id' => $product->id,
                    'color_id' => $colorId
                ]);
            }
        }

        // Store sizes
        if (!empty($request->sizes)) {
            foreach ($request->sizes as $sizeData) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size_name' => $sizeData['size_name'],
                    'size_value' => $sizeData['size_value'] ?? '',
                    'additional_price' => $sizeData['additional_price'] ?? 0,
                    'quantity' => $sizeData['stock_quantity'] ?? 0
                ]);
            }
        }

        // Store images to public storage
        if (!empty($request->images)) {
            foreach ($request->images as $imageFile) {
                if ($imageFile instanceof \Illuminate\Http\UploadedFile) {
                    $originalName = $imageFile->getClientOriginalName();
                    $mimeType = $imageFile->getClientMimeType();
                    $filename = uniqid() . '.' . $imageFile->getClientOriginalExtension();
                    $imageFile->storeAs('product_images', $filename, 'public');


                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $filename,
                        'mime_type' => $mimeType,
                        'original_name' => $originalName,
                        'order' => 0
                    ]);
                }
            }
        }

        return redirect()->route('admin.product.index')
            ->with('success', 'Product created successfully.');
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

        $subcategories = [];
        if ($product->category_id) {
            $subcategories = Subcategory::where('category_id', $product->category_id)
                ->active()
                ->pluck('name', 'id');
        }

        $selectedColors = ProductColor::where('product_id', $product->id)
            ->pluck('color_id')
            ->toArray();

        $selectedSizes = ProductSize::where('product_id', $product->id)
            ->get(['size_name', 'size_value', 'additional_price', 'quantity'])
            ->toArray();

        $product->load('productImages');

        return view('admin.product.edit', compact(
            'product',
            'categories',
            'subcategories',
            'brands',
            'colors',
            'selectedColors',
            'selectedSizes'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $productData = $request->validated();
        unset($productData['colors'], $productData['sizes'], $productData['images'], $productData['existing_images'], $productData['deleted_images']);

        $product->update($productData);

        // Update colors
        ProductColor::where('product_id', $product->id)->delete();
        if (!empty($request->colors)) {
            foreach ($request->colors as $colorId) {
                ProductColor::create([
                    'product_id' => $product->id,
                    'color_id' => $colorId
                ]);
            }
        }

        // Update sizes
        ProductSize::where('product_id', $product->id)->delete();
        if (!empty($request->sizes)) {
            foreach ($request->sizes as $sizeData) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size_name' => $sizeData['size_name'],
                    'size_value' => $sizeData['size_value'] ?? '',
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
        // Delete files from storage
        foreach ($product->productImages as $img) {
            Storage::disk('public')->delete('product_images/' . $img->image_path);
        }

        ProductImage::where('product_id', $product->id)->delete();

        $product->softDelete();

        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Toggle Product Status
     */
    public function toggleStatus(Product $product)
    {
        $product->toggleStatus();
        return back()->with('success', 'Product status updated successfully.');
    }

    /**
     * Get subcategories by category
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
    private function handleImageUpdates(Request $request, Product $product)
    {
        // Delete images
        if (!empty($request->deleted_images)) {
            $images = ProductImage::whereIn('id', $request->deleted_images)
                ->where('product_id', $product->id)
                ->get();

            foreach ($images as $img) {
                Storage::disk('public')->delete('product_images/' . $img->image_path);
                $img->delete();
            }
        }

        // Update orders for existing images
        if (!empty($request->existing_images)) {
            foreach ($request->existing_images as $imageId => $imageData) {
                ProductImage::where('id', $imageId)
                    ->where('product_id', $product->id)
                    ->update([
                        'order' => $imageData['order'] ?? 0
                    ]);
            }
        }

        // New images
        if (!empty($request->images)) {

            foreach ($request->images as $imageFile) {
                if ($imageFile instanceof \Illuminate\Http\UploadedFile) {
                    $originalName = $imageFile->getClientOriginalName();
                    $mimeType = $imageFile->getClientMimeType();
                    $filename = uniqid() . '.' . $imageFile->getClientOriginalExtension();
                     $imageFile->storeAs('product_images', $filename, 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $filename,
                        'mime_type' => $mimeType,
                        'original_name' => $originalName,
                        'order' => 0
                    ]);
                }
            }
        }
    }
}
