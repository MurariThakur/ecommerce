<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;

class ProductController extends Controller
{
    public function getCategory($slug, $subslug = '')
    {
        // Load category with relationships if needed
        $category = Category::where('slug', $slug)->active()->first();
        if (!$category) {
            abort(404, 'Category not found');
        }

        // Get all subcategories for this category (used in both cases)
        $subcategories = Subcategory::where('category_id', $category->id)
            ->active()
            ->orderBy('name')
            ->get();

        $subcategory = null;

        if (!empty($subslug)) {
            // Handle subcategory page
            $subcategory = Subcategory::where('slug', $subslug)
                ->where('category_id', $category->id)
                ->active()
                ->first();

            if (!$subcategory) {
                abort(404, 'Subcategory not found');
            }

            // Get products by subcategory with images
            $products = Product::where('subcategory_id', $subcategory->id)
                ->where('status', true)
                ->where('isdelete', false)
                ->with(['category', 'subcategory', 'productImages' => function($query) {
                    $query->orderBy('order');
                }])
                ->latest()
                ->paginate(9);

            // Meta tags for subcategory page
            $meta_title = $subcategory->name . ' - ' . $category->name;
            $meta_description = 'Browse products in ' . $subcategory->name . ' under ' . $category->name . ' category.';
            $meta_keyword = $subcategory->name . ', ' . $category->name . ', products';

        } else {
            // Handle category page
            $products = Product::where('category_id', $category->id)
                ->where('status', true)
                ->where('isdelete', false)
                ->with(['category', 'subcategory', 'productImages' => function($query) {
                    $query->orderBy('order');
                }])
                ->latest()
                ->paginate(9);

            // Meta tags for category page
            $meta_title = $category->name;
            $meta_description = 'Browse products in the ' . $category->name . ' category.';
            $meta_keyword = $category->name . ', products';
        }

        return view('frontend.product.list', compact(
            'category',
            'subcategory',
            'products',
            'subcategories',
            'meta_title',
            'meta_description',
            'meta_keyword'
        ));
    }
}
