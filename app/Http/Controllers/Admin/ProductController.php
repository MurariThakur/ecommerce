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
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;

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
        // Create the product
        // dd($request->all());
        $productData = $request->validated();
        unset($productData['colors'], $productData['sizes']); // Remove colors and sizes from product data

        $product = Product::create($productData);

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
                    'size_value' => $sizeData['size_value'] ?? '', // Assuming size_value is the same as size_name
                    'additional_price' => $sizeData['additional_price'] ?? 0,
                    'quantity' => $sizeData['stock_quantity'] ?? 0
                ]);
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'subcategory']);
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
            ->get(['size_name','size_value', 'additional_price', 'quantity'])
            ->toArray();
            // dd($selectedSizes);

        return view('admin.product.edit', compact('product', 'categories', 'subcategories', 'brands', 'colors', 'selectedColors', 'selectedSizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        // Update the product
        $productData = $request->validated();
        unset($productData['colors'], $productData['sizes']); // Remove colors and sizes from product data

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
                    'size_value' => $sizeData['size_value'] ?? '',
                    'additional_price' => $sizeData['additional_price'] ?? 0,
                    'quantity' => $sizeData['stock_quantity'] ?? 0
                ]);
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
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
}
