@extends('frontend.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/nouislider/nouislider.css') }}">
    <style>
        .category-link {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 10px 15px;
            margin: 5px 0;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: #495057 !important;
            text-decoration: none !important;
            background: transparent;
        }

        .category-link.active {
            background: #bf8040;
            color: white !important;
            font-weight: 600;
        }

        .category-link.active:hover {
            background: #a6c76c;
            color: white !important;
        }

        .category-link .item-count {
            background: rgba(0, 0, 0, 0.1);
            color: inherit;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            min-width: 24px;
            text-align: center;
        }

        .category-link.active .item-count {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Filter loading styles */
        .filter-loading {
            opacity: 0.6;
            pointer-events: none;
        }

        #price-slider {
            margin: 20px 0;
        }

        .filter-price-text {
            margin-bottom: 15px;
            font-weight: 500;
        }

        /* Responsive design */
        @media (max-width: 768px) {}
    </style>
@endsection

@section('content')
    <main class="main">
        <div class="page-header text-center"
            style="background-image: url('{{ asset('frontend/assets/images/page-header-bg.jpg') }}')">
            <div class="container">
                @if (!empty($subcategory))
                    <h1 class="page-title">{{ $subcategory->name }}</h1>
                @else
                    <h1 class="page-title">{{ $category->name }}</h1>
                @endif
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Shop</a></li>
                    @if (!empty($subcategory))
                        <li class="breadcrumb-item">
                            <a href="{{ url($category->slug) }}">{{ $category->name }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $subcategory->name }}</li>
                    @else
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                    @endif
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="toolbox">
                            <div class="toolbox-left">
                                <div class="toolbox-info">
                                    Showing <span>{{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of
                                        {{ $products->total() ?? 0 }}</span> Products
                                </div>
                            </div>

                            <div class="toolbox-right">
                                <div class="toolbox-sort">
                                    <label for="sortby">Sort by:</label>
                                    <div class="select-custom">
                                        <select name="sortby" id="sortby" class="form-control"
                                            onchange="updateSort(this.value)">
                                            <option value="latest" {{ request('sortby') == 'latest' ? 'selected' : '' }}>
                                                Latest</option>
                                            <option value="popularity"
                                                {{ request('sortby') == 'popularity' ? 'selected' : '' }}>Most Popular
                                            </option>
                                            <option value="rating" {{ request('sortby') == 'rating' ? 'selected' : '' }}>
                                                Most Rated</option>
                                            <option value="price_low_high"
                                                {{ request('sortby') == 'price_low_high' ? 'selected' : '' }}>Price: Low to
                                                High</option>
                                            <option value="price_high_low"
                                                {{ request('sortby') == 'price_high_low' ? 'selected' : '' }}>Price: High
                                                to Low</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="products mb-3">
                            <div class="row justify-content-center">
                                @forelse($products as $product)
                                    <div class="col-6 col-md-4 col-lg-4">
                                        <div class="product product-7 text-center">
                                            <figure class="product-media">
                                                @if ($product->created_at->diffInDays(now()) < 7)
                                                    <span class="product-label label-new">New</span>
                                                @endif
                                                @if ($product->old_price > $product->price)
                                                    <span class="product-label label-sale">Sale</span>
                                                @endif
                                                <a
                                                    href="{{ url($product->category->slug . '/' . $product->subcategory->slug . '/' . $product->slug) }}">
                                                    @if ($product->productImages->count() > 0)
                                                        <img src="{{ $product->productImages->first()->image_src }}"
                                                            alt="{{ $product->title }}" class="product-image"
                                                            style="width: 100%; height: 280px; object-fit: cover;">
                                                    @else
                                                        <img src="https://via.placeholder.com/280x280/f8f9fa/6c757d?text={{ urlencode($product->category->name) }}"
                                                            alt="Placeholder for {{ $product->title }}"
                                                            class="product-image"
                                                            style="width: 100%; height: 280px; object-fit: cover;">
                                                    @endif
                                                </a>

                                                <div class="product-action-vertical">
                                                    <a href="#" class="btn-product-icon btn-wishlist btn-expandable">
                                                        <span>add to wishlist</span>
                                                    </a>
                                                </div>

                                                <div class="product-action">
                                                    <a href="#" class="btn-product btn-cart">
                                                        <span>add to cart</span>
                                                    </a>
                                                </div>
                                            </figure>

                                            <div class="product-body">
                                                <div class="product-cat">
                                                    @if ($product->subcategory)
                                                        <a
                                                            href="{{ url($product->category->slug . '/' . $product->subcategory->slug) }}">
                                                            {{ $product->subcategory->name }}
                                                        </a>
                                                    @endif
                                                </div>
                                                <h3 class="product-title">
                                                    <a
                                                        href="{{ url($product->category->slug . '/' . $product->subcategory->slug . '/' . $product->slug) }}">
                                                        {{ $product->title }}
                                                    </a>
                                                </h3>
                                                <div class="product-price">
                                                    @if ($product->old_price > $product->price)
                                                        <span
                                                            class="new-price">${{ number_format($product->price, 2) }}</span>
                                                        <span
                                                            class="old-price">${{ number_format($product->old_price, 2) }}</span>
                                                    @else
                                                        ${{ number_format($product->price, 2) }}
                                                    @endif
                                                </div>
                                                <div class="ratings-container">
                                                    <div class="ratings">
                                                        <div class="ratings-val" style="width: 80%;"></div>
                                                    </div>
                                                    <span class="ratings-text">( 4 Reviews )</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 col-md-6">
                                        <div class="no-products-found text-center py-5">
                                            <div class="no-products-icon mb-4">
                                                <div class="icon-wrapper">
                                                    <i class="fas fa-search fa-4x text-primary"></i>
                                                    <div class="icon-overlay">
                                                        <i class="fas fa-times-circle fa-2x text-danger"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="no-products-content">
                                                <h2 class="no-products-title mb-3">No Products Found</h2>
                                                <p class="no-products-subtitle text-muted mb-4">
                                                    We couldn't find any products matching your current filters.
                                                </p>

                                                <div class="no-products-actions">
                                                    <a href="javascript:void(0)" onclick="cleanAllFilters()"
                                                        class="btn btn-primary btn-lg mr-3 mb-2">
                                                        <i class="fas fa-filter mr-2"></i>
                                                        <span>CLEAR ALL FILTERS</span>
                                                    </a>
                                                    <a href="{{ url('/') }}"
                                                        class="btn btn-outline-primary btn-lg mb-2">
                                                        <i class="fas fa-home mr-2"></i>
                                                        <span>BACK TO HOME</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            @if ($products->hasPages())
                                <ul class="pagination justify-content-center">
                                    @if ($products->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link page-link-prev" aria-label="Previous" tabindex="-1"
                                                aria-disabled="true">
                                                <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link page-link-prev" href="{{ $products->previousPageUrl() }}"
                                                aria-label="Previous">
                                                <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
                                            </a>
                                        </li>
                                    @endif

                                    @for ($i = 1; $i <= $products->lastPage(); $i++)
                                        @if ($i == $products->currentPage())
                                            <li class="page-item active" aria-current="page">
                                                <span class="page-link">{{ $i }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $products->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endif
                                    @endfor

                                    <li class="page-item-total">of {{ $products->lastPage() }}</li>

                                    @if ($products->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link page-link-next" href="{{ $products->nextPageUrl() }}"
                                                aria-label="Next">
                                                Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link page-link-next" aria-label="Next" tabindex="-1"
                                                aria-disabled="true">
                                                Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            @endif
                        </nav>
                    </div>

                    <!-- Sidebar -->
                    <aside class="col-lg-3 order-lg-first">
                        <div class="sidebar sidebar-shop">
                            <div class="widget widget-clean">
                                <label>Filters:</label>
                                <a href="javascript:void(0)" onclick="cleanAllFilters()" class="sidebar-filter-clear"
                                    id="clean-all-filters">Clean
                                    All</a>
                            </div>

                            <form id="filter-form" method="GET" action="{{ request()->url() }}">
                                <!-- Hidden price inputs -->
                                <input type="hidden" name="price_min" value="{{ request('price_min', 0) }}">
                                <input type="hidden" name="price_max"
                                    value="{{ request('price_max', $priceRange->max_price ?? 1000) }}">

                                <!-- Category/Subcategory Filter Logic -->
                                @if (empty($subcategory))
                                    <!-- When on category page, show subcategories of that category -->
                                    @if (isset($subcategories) && $subcategories->count() > 1)
                                        <div class="widget widget-collapsible">
                                            <h3 class="widget-title">
                                                <a data-toggle="collapse" href="#widget-1" role="button"
                                                    aria-expanded="true" aria-controls="widget-1">
                                                    {{ $category->name }} Categories
                                                </a>
                                            </h3>

                                            <div class="collapse show" id="widget-1">
                                                <div class="widget-body">
                                                    <div class="filter-items filter-items-count">
                                                        @foreach ($subcategories as $subcat)
                                                            <div class="filter-item">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input filter-checkbox"
                                                                        name="subcategories[]"
                                                                        value="{{ $subcat->id }}"
                                                                        id="subcat-{{ $subcat->id }}"
                                                                        {{ in_array($subcat->id, request('subcategories', [])) ? 'checked' : '' }}>
                                                                    <label class="custom-control-label"
                                                                        for="subcat-{{ $subcat->id }}">
                                                                        {{ $subcat->name }}
                                                                    </label>
                                                                </div>
                                                                <span
                                                                    class="item-count">{{ $subcat->activeProducts()->count() }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <!-- When on subcategory page, show all categories for direct navigation -->
                                    @if (isset($allCategories) && $allCategories->count() > 1)
                                        <div class="widget widget-collapsible">
                                            <h3 class="widget-title">
                                                <a data-toggle="collapse" href="#widget-1" role="button"
                                                    aria-expanded="true" aria-controls="widget-1">
                                                    Categories
                                                </a>
                                            </h3>

                                            <div class="collapse show" id="widget-1">
                                                <div class="widget-body">
                                                    <div class="filter-items filter-items-count">
                                                        @foreach ($allCategories as $cat)
                                                            <div class="filter-item">
                                                                <a href="{{ url($cat->slug) }}"
                                                                    class="category-link d-flex justify-content-between align-items-center text-decoration-none {{ $cat->id == $category->id ? 'active' : '' }}">
                                                                    <span class="category-name">{{ $cat->name }}</span>
                                                                    <span
                                                                        class="item-count">{{ $cat->activeProducts()->count() }}</span>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Show subcategories when on subcategory page -->
                                    @if (isset($subcategories) && $subcategories->count() > 1)
                                        <div class="widget widget-collapsible">
                                            <h3 class="widget-title">
                                                <a data-toggle="collapse" href="#widget-1a" role="button"
                                                    aria-expanded="true" aria-controls="widget-1a">
                                                    Subcategories
                                                </a>
                                            </h3>

                                            <div class="collapse show" id="widget-1a">
                                                <div class="widget-body">
                                                    <div class="filter-items filter-items-count">
                                                        @foreach ($subcategories as $subcat)
                                                            <div class="filter-item">
                                                                <a href="{{ url($category->slug . '/' . $subcat->slug) }}"
                                                                    class="category-link d-flex justify-content-between align-items-center text-decoration-none {{ isset($subcategory) && $subcat->id == $subcategory->id ? 'active' : '' }}">
                                                                    <span class="category-name">{{ $subcat->name }}</span>
                                                                    <span
                                                                        class="item-count">{{ $subcat->activeProducts()->count() }}</span>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                <!-- Size Filter -->
                                @if (isset($availableSizes) && $availableSizes->count() > 0)
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title">
                                            <a data-toggle="collapse" href="#widget-2" role="button"
                                                aria-expanded="true" aria-controls="widget-2">
                                                Size
                                            </a>
                                        </h3>

                                        <div class="collapse show" id="widget-2">
                                            <div class="widget-body">
                                                <div class="filter-items">
                                                    @foreach ($availableSizes as $size)
                                                        <div class="filter-item">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox"
                                                                    class="custom-control-input filter-checkbox"
                                                                    name="sizes[]" value="{{ $size }}"
                                                                    id="size-{{ $loop->index }}"
                                                                    {{ in_array($size, request('sizes', [])) ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="size-{{ $loop->index }}">{{ $size }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Color Filter -->
                                @if (isset($availableColors) && $availableColors->count() > 0)
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title">
                                            <a data-toggle="collapse" href="#widget-3" role="button"
                                                aria-expanded="true" aria-controls="widget-3">
                                                Colour
                                            </a>
                                        </h3>

                                        <div class="collapse show" id="widget-3">
                                            <div class="widget-body">
                                                <div class="filter-colors">
                                                    @foreach ($availableColors as $color)
                                                        <input type="checkbox" name="colors[]"
                                                            value="{{ $color->id }}"
                                                            class="color-checkbox filter-checkbox"
                                                            {{ in_array($color->id, request('colors', [])) ? 'checked' : '' }}
                                                            style="display: none;" id="color-{{ $color->id }}">
                                                        <a href="#"
                                                            class="color-filter-link {{ in_array($color->id, request('colors', [])) ? 'selected' : '' }}"
                                                            style="background: {{ $color->color_code }};"
                                                            data-color-id="{{ $color->id }}"
                                                            title="{{ $color->name }}">
                                                            <span class="sr-only">{{ $color->name }}</span>
                                                        </a>
                                                    @endforeach
                                                </div><!-- End .filter-colors -->
                                            </div><!-- End .widget-body -->
                                        </div><!-- End .collapse -->
                                    </div>
                                @endif



                                <!-- Brand Filter -->
                                @if (isset($availableBrands) && $availableBrands->count() > 0)
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title">
                                            <a data-toggle="collapse" href="#widget-4" role="button"
                                                aria-expanded="true" aria-controls="widget-4">
                                                Brand
                                            </a>
                                        </h3>

                                        <div class="collapse show" id="widget-4">
                                            <div class="widget-body">
                                                <div class="filter-items">
                                                    @foreach ($availableBrands as $brand)
                                                        <div class="filter-item">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox"
                                                                    class="custom-control-input filter-checkbox"
                                                                    name="brands[]" value="{{ $brand->id }}"
                                                                    id="brand-{{ $brand->id }}"
                                                                    {{ in_array($brand->id, request('brands', [])) ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="brand-{{ $brand->id }}">{{ $brand->name }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Fixed Price Filter -->
                                @if (isset($priceRange) && $priceRange)
                                    <div class="widget widget-collapsible">
                                        <h3 class="widget-title">
                                            <a data-toggle="collapse" href="#widget-5" role="button"
                                                aria-expanded="true" aria-controls="widget-5">
                                                Price
                                            </a>
                                        </h3>

                                        <div class="collapse show" id="widget-5">
                                            <div class="widget-body">
                                                <div class="filter-price">
                                                    <div class="filter-price-text">
                                                        Price Range: <span id="filter-price-range"></span>
                                                    </div>

                                                    <!-- Only the slider, no input boxes -->
                                                    <div id="price-slider"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('frontend/assets/js/nouislider.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/wNumb.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (isset($priceRange) && $priceRange)
                // Initialize price slider with fixed range from 0
                var priceSlider = document.getElementById('price-slider');
                var minPrice = 0; // Fixed to start from 0
                var maxPrice = {{ $priceRange->max_price ?? 1000 }};
                var currentMin = {{ request('price_min', 0) }}; // Always start from 0
                var currentMax = {{ request('price_max', $priceRange->max_price ?? 1000) }};

                if (priceSlider) {
                    noUiSlider.create(priceSlider, {
                        start: [currentMin, currentMax],
                        connect: true,
                        range: {
                            'min': minPrice, // Always 0
                            'max': maxPrice
                        },
                        step: 1,
                        format: {
                            to: function(value) {
                                return Math.round(value);
                            },
                            from: function(value) {
                                return Math.round(value);
                            }
                        }
                    });

                    // Update price range text
                    var priceRangeText = document.getElementById('filter-price-range');
                    priceSlider.noUiSlider.on('update', function(values, handle) {
                        priceRangeText.textContent = '$' + values[0] + ' - $' + values[1];
                    });

                    // Handle slider change
                    priceSlider.noUiSlider.on('change', function(values, handle) {
                        document.querySelector('input[name="price_min"]').value = values[0];
                        document.querySelector('input[name="price_max"]').value = values[1];
                        submitFilters();
                    });
                }
            @endif

            // Handle filter changes - allow multiple selections with delay
            const filterCheckboxes = document.querySelectorAll('.filter-checkbox');
            let filterTimeout;

            filterCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Clear any existing timeout
                    clearTimeout(filterTimeout);

                    // Set a delay to allow multiple selections
                    filterTimeout = setTimeout(() => {
                        submitFilters();
                    }, 1000); // 1 second delay to allow multiple selections
                });
            });

            // Handle color filter clicks with improved visual feedback
            document.querySelectorAll('.color-filter-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const colorId = this.getAttribute('data-color-id');
                    const checkbox = document.getElementById('color-' + colorId);

                    checkbox.checked = !checkbox.checked;

                    // Toggle selected class
                    if (checkbox.checked) {
                        this.classList.add('selected');
                    } else {
                        this.classList.remove('selected');
                    }

                    submitFilters();
                });
            });

            // Initialize color links on page load
            document.querySelectorAll('.color-checkbox').forEach(checkbox => {
                const colorId = checkbox.value;
                const link = document.querySelector('.color-filter-link[data-color-id="' + colorId + '"]');
                if (checkbox.checked && link) {
                    link.classList.add('selected');
                }
            });

            function submitFilters() {
                // Add loading class
                document.querySelector('.sidebar').classList.add('filter-loading');

                // Get form data
                const form = document.getElementById('filter-form');
                const formData = new FormData(form);

                // Build URL with parameters
                const url = new URL(form.action);

                // Clear existing search params except for page-specific ones
                const currentParams = new URLSearchParams(window.location.search);

                // Group form data by parameter name to handle multiple values correctly
                const paramGroups = {};
                for (let [key, value] of formData.entries()) {
                    if (value && value.trim() !== '') {
                        if (!paramGroups[key]) {
                            paramGroups[key] = [];
                        }
                        paramGroups[key].push(value);
                    }
                }

                // Add grouped parameters to URL
                for (let [key, values] of Object.entries(paramGroups)) {
                    // Remove any existing parameters with this key
                    url.searchParams.delete(key);

                    // Add all values for this parameter
                    values.forEach(value => {
                        url.searchParams.append(key, value);
                    });
                }

                // Preserve sort parameter if it exists
                if (currentParams.has('sortby')) {
                    url.searchParams.set('sortby', currentParams.get('sortby'));
                }

                // Navigate to the new URL
                window.location.href = url.toString();
            }

            // Make submitFilters available globally
            window.submitFilters = submitFilters;
        });

        function updateSort(sortValue) {
            const url = new URL(window.location);
            url.searchParams.set('sortby', sortValue);
            window.location.href = url.toString();
        }

        // Clean all filters function
        function cleanAllFilters() {
            window.location.href = '{{ $cleanAllUrl }}';
        }
    </script>
@endsection
