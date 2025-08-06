<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;

class ProductController extends Controller
{
    public function getCategory($slug,$subslug = '')
    {
        // Get single category by slug
        $category = Category::where('slug', $slug)->active()->first();
        $subcategory = Subcategory::where('slug', $subslug)->active()->first();
        if (!$category) {
            abort(404, 'Category not found');
        }
        return view('frontend.product.list', compact('category', 'slug', 'subcategory'));
    }
}
