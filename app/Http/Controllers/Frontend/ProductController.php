<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\Color;
use App\Models\Brand;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (empty($query)) {
            return redirect()->route('frontend.home');
        }

        // Build the base query with search
        $productsQuery = Product::where('status', true)
            ->where('isdelete', false)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('short_description', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhereHas('category', function ($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%");
                    })
                    ->orWhereHas('subcategory', function ($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%");
                    })
                    ->orWhereHas('brand', function ($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%");
                    });
            });

        // **SMART CATEGORY DETECTION**
        $detectedCategory = $this->detectCategoryFromQuery($query, $productsQuery);

        // Get search result product IDs for relevant filtering
        $searchResultIds = (clone $productsQuery)->pluck('id');

        // **SMART SUBCATEGORY FILTERING - Only for detected category**
        $relevantSubcategories = collect();
        if ($detectedCategory) {
            $relevantSubcategories = Subcategory::where('category_id', $detectedCategory->id)
                ->whereHas('products', function ($q) use ($searchResultIds) {
                    $q->whereIn('products.id', $searchResultIds);
                })
                ->withCount([
                    'products as search_result_count' => function ($q) use ($searchResultIds) {
                        $q->whereIn('products.id', $searchResultIds);
                    }
                ])
                ->having('search_result_count', '>', 0)
                ->orderBy('search_result_count', 'desc')
                ->get();
        }

        // Apply filters - same logic as getCategory method
        if ($request->filled('categories') && is_array($request->categories)) {
            $selectedCategories = array_filter($request->categories, 'is_numeric');
            if (!empty($selectedCategories)) {
                $productsQuery->whereIn('category_id', $selectedCategories);
            }
        }

        if ($request->filled('subcategories') && is_array($request->subcategories)) {
            $selectedSubcategories = array_filter($request->subcategories, 'is_numeric');
            if (!empty($selectedSubcategories)) {
                $productsQuery->whereIn('subcategory_id', $selectedSubcategories);
            }
        }

        if ($request->filled('sizes') && is_array($request->sizes)) {
            $productsQuery->whereHas('productSizes', function ($q) use ($request) {
                $q->whereIn('size_name', $request->sizes);
            });
        }

        if ($request->filled('colors') && is_array($request->colors)) {
            $colorIds = array_filter($request->colors, 'is_numeric');
            if (!empty($colorIds)) {
                $productsQuery->whereHas('colors', function ($q) use ($colorIds) {
                    $q->whereIn('colors.id', $colorIds);
                });
            }
        }

        if ($request->filled('brands') && is_array($request->brands)) {
            $brandIds = array_filter($request->brands, 'is_numeric');
            if (!empty($brandIds)) {
                $productsQuery->whereIn('brand_id', $brandIds);
            }
        }

        // Price filter
        $priceMin = $request->filled('price_min') ? max(0, (float) $request->price_min) : null;
        $priceMax = $request->filled('price_max') ? max(0, (float) $request->price_max) : null;

        if ($priceMin !== null && $priceMax !== null) {
            if ($priceMin > $priceMax) {
                $temp = $priceMin;
                $priceMin = $priceMax;
                $priceMax = $temp;
            }
            $productsQuery->whereBetween('price', [$priceMin, $priceMax]);
        } elseif ($priceMin !== null) {
            $productsQuery->where('price', '>=', $priceMin);
        } elseif ($priceMax !== null) {
            $productsQuery->where('price', '<=', $priceMax);
        }

        // Sorting
        $sortBy = $request->get('sortby', 'latest');
        switch ($sortBy) {
            case 'popularity':
            case 'rating':
                $productsQuery->orderBy('created_at', 'desc');
                break;
            case 'price_low_high':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'latest':
            default:
                $productsQuery->latest();
                break;
        }

        // Get products with pagination
        $products = $productsQuery->with([
            'category',
            'subcategory',
            'brand',
            'productImages' => function ($query) {
                $query->orderBy('order');
            }
        ])->paginate(12)->appends($request->query());

        // **FILTER DATA BASED ON SEARCH RESULTS ONLY**
        $availableSizes = ProductSize::whereHas('product', function ($q) use ($searchResultIds) {
            $q->whereIn('products.id', $searchResultIds);
        })->select('size_name')->distinct()->orderBy('size_name')->pluck('size_name');

        $availableColors = Color::whereHas('products', function ($q) use ($searchResultIds) {
            $q->whereIn('products.id', $searchResultIds);
        })->active()->get();

        $availableBrands = Brand::whereHas('products', function ($q) use ($searchResultIds) {
            $q->whereIn('products.id', $searchResultIds);
        })->active()->get();

        // Price range from search results
        $priceRange = Product::whereIn('id', $searchResultIds)
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        if (!$priceRange || $priceRange->min_price === null) {
            $priceRange = (object) ['min_price' => 0, 'max_price' => 1000];
        }

        // Meta tags
        $meta_title = "Search Results for '{$query}'";
        $meta_description = "Search results for '{$query}' - Browse our products";
        $meta_keyword = $query;

        // Clean URL
        $cleanAllUrl = $this->getCleanAllUrl();

        return view('frontend.product.list', compact(
            'products',
            'query',
            'meta_title',
            'meta_description',
            'meta_keyword',
            'detectedCategory',
            'relevantSubcategories',
            'availableColors',
            'availableBrands',
            'availableSizes',
            'priceRange',
            'cleanAllUrl'
        ));
    }
    private function getCleanAllUrl()
    {
        $previousUrl = url()->previous();

        // If previous URL contains 'search', redirect to home instead
        if (str_contains($previousUrl, '/search')) {
            return url('/');
        }

        // Otherwise, strip query parameters from previous URL
        return strtok($previousUrl, '?') ?: url('/');
    }

    /**
     * Detect category from search query using multiple strategies
     */
    private function detectCategoryFromQuery($query, $productsQuery)
    {
        $queryLower = strtolower(trim($query));

        // Strategy 1: Direct category name match
        $directMatch = Category::whereRaw('LOWER(name) LIKE ?', ["%{$queryLower}%"])
            ->active()
            ->first();

        if ($directMatch) {
            return $directMatch;
        }

        // Strategy 2: Subcategory name match (return parent category)
        $subcategoryMatch = Subcategory::whereRaw('LOWER(name) LIKE ?', ["%{$queryLower}%"])
            ->active()
            ->with('category')
            ->first();

        if ($subcategoryMatch && $subcategoryMatch->category) {
            return $subcategoryMatch->category;
        }

        // Strategy 3: Analyze product titles for common words per category
        $categoryWordScores = [];

        $categories = Category::active()->get();
        foreach ($categories as $category) {
            $score = 0;

            // Get sample product titles from this category
            $productTitles = Product::where('category_id', $category->id)
                ->active()
                ->take(20) // Sample size
                ->pluck('title')
                ->map(function ($title) {
                    return strtolower($title);
                });

            // Count how many words from query appear in product titles
            $queryWords = explode(' ', $queryLower);
            foreach ($queryWords as $word) {
                $word = trim($word);
                if (strlen($word) > 2) { // Skip very short words
                    $productTitles->each(function ($title) use ($word, &$score) {
                        if (str_contains($title, $word)) {
                            $score++;
                        }
                    });
                }
            }

            if ($score > 0) {
                $categoryWordScores[$category->id] = $score;
            }
        }

        // Return category with highest score
        if (!empty($categoryWordScores)) {
            $bestCategoryId = array_keys($categoryWordScores, max($categoryWordScores))[0];
            return Category::find($bestCategoryId);
        }

        // Strategy 4: Find category with most matching products (fallback)
        $categoryStats = (clone $productsQuery)
            ->select('category_id', \DB::raw('COUNT(*) as product_count'))
            ->groupBy('category_id')
            ->orderBy('product_count', 'desc')
            ->first();

        if ($categoryStats) {
            return Category::find($categoryStats->category_id);
        }

        return null;
    }

    public function getCategory($slug, $subslug = '', Request $request = null)
    {
        // Handle null request
        if (!$request) {
            $request = request();
        }

        $category = Category::where('slug', $slug)->active()->first();
        if (!$category) {
            abort(404, 'Category not found');
        }

        // Get all subcategories for this category
        $subcategories = Subcategory::where('category_id', $category->id)
            ->active()
            ->orderBy('name')
            ->get();

        $subcategory = null;

        if (!empty($subslug)) {
            $subcategory = Subcategory::where('slug', $subslug)
                ->where('category_id', $category->id)
                ->active()
                ->first();

            if (!$subcategory) {
                abort(404, 'Subcategory not found');
            }
        }

        // Build the base query
        $query = Product::where('status', true)->where('isdelete', false);

        // Base category/subcategory filter - more flexible approach
        if (!empty($subcategory)) {
            // If we're on a specific subcategory page, start with that subcategory
            $baseSubcategoryIds = [$subcategory->id];
            $baseCategoryIds = [$category->id];
        } else {
            // If we're on a category page, get all subcategories for this category
            $baseSubcategoryIds = $subcategories->pluck('id')->toArray();
            $baseCategoryIds = [$category->id];
        }

        // Apply category/subcategory filters - allow cross-category selection
        if ($request->filled('subcategories')) {
            // Allow selection of subcategories from any category for multi-category filtering
            $selectedSubcategories = array_filter($request->subcategories, 'is_numeric');
            if (!empty($selectedSubcategories)) {
                $query->whereIn('subcategory_id', $selectedSubcategories);
            } else {
                // If no valid subcategories selected, use base filter
                $query->whereIn('subcategory_id', $baseSubcategoryIds);
            }
        } elseif ($request->filled('categories')) {
            // Allow selection of multiple categories
            $selectedCategories = array_filter($request->categories, 'is_numeric');
            if (!empty($selectedCategories)) {
                $query->whereIn('category_id', $selectedCategories);
            } else {
                // Use base category filter
                $query->whereIn('category_id', $baseCategoryIds);
            }
        } else {
            // No category/subcategory filter applied, use base filter
            if (!empty($subcategory)) {
                $query->where('subcategory_id', $subcategory->id);
            } else {
                $query->where('category_id', $category->id);
            }
        }

        // Apply size filter
        if ($request->filled('sizes') && is_array($request->sizes)) {
            $query->whereHas('productSizes', function ($q) use ($request) {
                $q->whereIn('size_name', $request->sizes);
            });
        }

        // Apply color filter
        if ($request->filled('colors') && is_array($request->colors)) {
            $colorIds = array_filter($request->colors, 'is_numeric');
            if (!empty($colorIds)) {
                $query->whereHas('colors', function ($q) use ($colorIds) {
                    $q->whereIn('colors.id', $colorIds);
                });
            }
        }

        // Apply brand filter
        if ($request->filled('brands') && is_array($request->brands)) {
            $brandIds = array_filter($request->brands, 'is_numeric');
            if (!empty($brandIds)) {
                $query->whereIn('brand_id', $brandIds);
            }
        }

        // Apply price filter with validation
        $priceMin = $request->filled('price_min') ? max(0, (float) $request->price_min) : null;
        $priceMax = $request->filled('price_max') ? max(0, (float) $request->price_max) : null;

        if ($priceMin !== null && $priceMax !== null) {
            // Ensure min is not greater than max
            if ($priceMin > $priceMax) {
                $temp = $priceMin;
                $priceMin = $priceMax;
                $priceMax = $temp;
            }
            $query->whereBetween('price', [$priceMin, $priceMax]);
        } elseif ($priceMin !== null) {
            $query->where('price', '>=', $priceMin);
        } elseif ($priceMax !== null) {
            $query->where('price', '<=', $priceMax);
        }

        // Apply sorting
        $sortBy = $request->get('sortby', 'latest');
        switch ($sortBy) {
            case 'popularity':
                $query->orderBy('created_at', 'desc');
                break;
            case 'rating':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        // Get products with pagination
        $products = $query->with([
            'category',
            'subcategory',
            'brand',
            'productImages' => function ($query) {
                $query->orderBy('order');
            }
        ])->paginate(9)->appends($request->query());

        // Get dynamic filter data - show all available options for better filtering
        $filterBaseQuery = function ($q) {
            $q->where('status', true)->where('isdelete', false);
        };

        // Get all available sizes (not limited to current category)
        $availableSizes = ProductSize::whereHas('product', $filterBaseQuery)
            ->select('size_name')
            ->distinct()
            ->orderBy('size_name')
            ->pluck('size_name');

        // Get all available colors (not limited to current category)
        $availableColors = Color::whereHas('products', $filterBaseQuery)
            ->active()
            ->get();

        // Get all available brands (not limited to current category)
        $availableBrands = Brand::whereHas('products', $filterBaseQuery)
            ->active()
            ->get();

        // Get all categories for cross-category filtering
        $allCategories = Category::active()->get();

        // Get price range from all products
        $priceQuery = Product::where('status', true)->where('isdelete', false);
        $priceRange = $priceQuery->selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();

        // Ensure price range has valid values
        if (!$priceRange || $priceRange->min_price === null) {
            $priceRange = (object) [
                'min_price' => 0,
                'max_price' => 1000
            ];
        }

        // Meta tags
        if (!empty($subcategory)) {
            $meta_title = $subcategory->name . ' - ' . $category->name;
            $meta_description = 'Browse products in ' . $subcategory->name . ' under ' . $category->name . ' category.';
            $meta_keyword = $subcategory->name . ', ' . $category->name . ', products';
        } else {
            $meta_title = $category->name;
            $meta_description = 'Browse products in the ' . $category->name . ' category.';
            $meta_keyword = $category->name . ', products';
        }

        // Clean URL for "Clean All" button - removes all query parameters
        $cleanAllUrl = $subcategory
            ? url($category->slug . '/' . $subcategory->slug)
            : url($category->slug);

        return view('frontend.product.list', compact(
            'category',
            'subcategory',
            'products',
            'subcategories',
            'allCategories',
            'meta_title',
            'meta_description',
            'meta_keyword',
            'availableColors',
            'availableBrands',
            'availableSizes',
            'priceRange',
            'cleanAllUrl'
        ));
    }

    public function getProductDetails($category_slug, $subcategory_slug, $product_slug)
    {
        try {
            // Find the category
            $category = Category::where('slug', $category_slug)->active()->first();
            if (!$category) {
                abort(404, 'Category not found');
            }

            // Find the subcategory
            $subcategory = Subcategory::where('slug', $subcategory_slug)
                ->where('category_id', $category->id)
                ->active()
                ->first();
            if (!$subcategory) {
                abort(404, 'Subcategory not found');
            }

            // Find the product with all necessary relationships
            $product = Product::where('slug', $product_slug)
                ->where('category_id', $category->id)
                ->where('subcategory_id', $subcategory->id)
                ->where('status', true)
                ->where('isdelete', false)
                ->with([
                    'category',
                    'subcategory',
                    'brand',
                    'productImages' => function ($query) {
                        $query->orderBy('order', 'asc');
                    },
                    'colors' => function ($query) {
                        $query->where('status', true); // assuming colors table has status
                    },
                    'productSizes' => function ($query) {
                        $query->orderBy('size_name', 'asc');
                    }
                ])
                ->first();

            if (!$product) {
                abort(404, 'Product not found');
            }

            // Get related products from same subcategory
            $relatedProducts = Product::where('subcategory_id', $subcategory->id)
                ->where('id', '!=', $product->id)
                ->where('status', true)
                ->where('isdelete', false)
                ->with([
                    'productImages' => function ($query) {
                        $query->orderBy('order', 'asc')->limit(1);
                    },
                    'brand'
                ])
                ->limit(10)
                ->get();

            // Meta tags for SEO
            $meta_title = $product->title . ' - ' . $subcategory->name . ' - ' . $category->name;
            $meta_description = $product->short_description ?: 'Buy ' . $product->title . ' online';
            $meta_keyword = $product->title . ', ' . $subcategory->name . ', ' . $category->name;

            return view('frontend.product.details', compact(
                'product',
                'category',
                'subcategory',
                'relatedProducts',
                'meta_title',
                'meta_description',
                'meta_keyword'
            ));

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Product details error: ' . $e->getMessage(), [
                'category_slug' => $category_slug,
                'subcategory_slug' => $subcategory_slug,
                'product_slug' => $product_slug
            ]);

            abort(500, 'An error occurred while loading the product');
        }
    }


}

