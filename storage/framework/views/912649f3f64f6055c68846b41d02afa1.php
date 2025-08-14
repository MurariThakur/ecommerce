<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('frontend/assets/css/plugins/nouislider/nouislider.css')); ?>">
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <main class="main">
        <div class="page-header text-center"
            style="background-image: url('<?php echo e(asset('frontend/assets/images/page-header-bg.jpg')); ?>')">
            <div class="container">
                <?php if(!empty($subcategory)): ?>
                    <h1 class="page-title"><?php echo e($subcategory->name); ?></h1>
                <?php else: ?>
                    <h1 class="page-title"><?php echo e($category->name); ?></h1>
                <?php endif; ?>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Shop</a></li>
                    <?php if(!empty($subcategory)): ?>
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(url($category->slug)); ?>"><?php echo e($category->name); ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo e($subcategory->name); ?></li>
                    <?php else: ?>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo e($category->name); ?></li>
                    <?php endif; ?>
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
                                    Showing <span><?php echo e($products->firstItem() ?? 0); ?> - <?php echo e($products->lastItem() ?? 0); ?> of
                                        <?php echo e($products->total() ?? 0); ?></span> Products
                                </div>
                            </div>

                            <div class="toolbox-right">
                                <div class="toolbox-sort">
                                    <label for="sortby">Sort by:</label>
                                    <div class="select-custom">
                                        <select name="sortby" id="sortby" class="form-control"
                                            onchange="updateSort(this.value)">
                                            <option value="latest" <?php echo e(request('sortby') == 'latest' ? 'selected' : ''); ?>>
                                                Latest</option>
                                            <option value="popularity"
                                                <?php echo e(request('sortby') == 'popularity' ? 'selected' : ''); ?>>Most Popular
                                            </option>
                                            <option value="rating" <?php echo e(request('sortby') == 'rating' ? 'selected' : ''); ?>>
                                                Most Rated</option>
                                            <option value="price_low_high"
                                                <?php echo e(request('sortby') == 'price_low_high' ? 'selected' : ''); ?>>Price: Low to
                                                High</option>
                                            <option value="price_high_low"
                                                <?php echo e(request('sortby') == 'price_high_low' ? 'selected' : ''); ?>>Price: High
                                                to Low</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="products mb-3">
                            <div class="row justify-content-center">
                                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="col-6 col-md-4 col-lg-4">
                                        <div class="product product-7 text-center">
                                            <figure class="product-media">
                                                <?php if($product->created_at->diffInDays(now()) < 7): ?>
                                                    <span class="product-label label-new">New</span>
                                                <?php endif; ?>
                                                <?php if($product->old_price > $product->price): ?>
                                                    <span class="product-label label-sale">Sale</span>
                                                <?php endif; ?>
                                                <a
                                                    href="<?php echo e(url($product->category->slug . '/' . $product->subcategory->slug . '/' . $product->slug)); ?>">
                                                    <?php if($product->productImages->count() > 0): ?>
                                                        <img src="<?php echo e($product->productImages->first()->image_src); ?>"
                                                            alt="<?php echo e($product->title); ?>" class="product-image"
                                                            style="width: 100%; height: 280px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <img src="https://via.placeholder.com/280x280/f8f9fa/6c757d?text=<?php echo e(urlencode($product->category->name)); ?>"
                                                            alt="Placeholder for <?php echo e($product->title); ?>"
                                                            class="product-image"
                                                            style="width: 100%; height: 280px; object-fit: cover;">
                                                    <?php endif; ?>
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
                                                    <?php if($product->subcategory): ?>
                                                        <a
                                                            href="<?php echo e(url($product->category->slug . '/' . $product->subcategory->slug)); ?>">
                                                            <?php echo e($product->subcategory->name); ?>

                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                                <h3 class="product-title">
                                                    <a
                                                        href="<?php echo e(url($product->category->slug . '/' . $product->subcategory->slug . '/' . $product->slug)); ?>">
                                                        <?php echo e($product->title); ?>

                                                    </a>
                                                </h3>
                                                <div class="product-price">
                                                    <?php if($product->old_price > $product->price): ?>
                                                        <span
                                                            class="new-price">$<?php echo e(number_format($product->price, 2)); ?></span>
                                                        <span
                                                            class="old-price">$<?php echo e(number_format($product->old_price, 2)); ?></span>
                                                    <?php else: ?>
                                                        $<?php echo e(number_format($product->price, 2)); ?>

                                                    <?php endif; ?>
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
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
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
                                                    <a href="<?php echo e(url('/')); ?>"
                                                        class="btn btn-outline-primary btn-lg mb-2">
                                                        <i class="fas fa-home mr-2"></i>
                                                        <span>BACK TO HOME</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <?php if($products->hasPages()): ?>
                                <ul class="pagination justify-content-center">
                                    <?php if($products->onFirstPage()): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link page-link-prev" aria-label="Previous" tabindex="-1"
                                                aria-disabled="true">
                                                <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
                                            </span>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item">
                                            <a class="page-link page-link-prev" href="<?php echo e($products->previousPageUrl()); ?>"
                                                aria-label="Previous">
                                                <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php for($i = 1; $i <= $products->lastPage(); $i++): ?>
                                        <?php if($i == $products->currentPage()): ?>
                                            <li class="page-item active" aria-current="page">
                                                <span class="page-link"><?php echo e($i); ?></span>
                                            </li>
                                        <?php else: ?>
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="<?php echo e($products->url($i)); ?>"><?php echo e($i); ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endfor; ?>

                                    <li class="page-item-total">of <?php echo e($products->lastPage()); ?></li>

                                    <?php if($products->hasMorePages()): ?>
                                        <li class="page-item">
                                            <a class="page-link page-link-next" href="<?php echo e($products->nextPageUrl()); ?>"
                                                aria-label="Next">
                                                Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item disabled">
                                            <span class="page-link page-link-next" aria-label="Next" tabindex="-1"
                                                aria-disabled="true">
                                                Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
                                            </span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            <?php endif; ?>
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

                            <form id="filter-form" method="GET" action="<?php echo e(request()->url()); ?>">
                                <!-- Hidden price inputs -->
                                <input type="hidden" name="price_min" value="<?php echo e(request('price_min', 0)); ?>">
                                <input type="hidden" name="price_max"
                                    value="<?php echo e(request('price_max', $priceRange->max_price ?? 1000)); ?>">

                                <!-- Category/Subcategory Filter Logic -->
                                <?php if(empty($subcategory)): ?>
                                    <!-- When on category page, show subcategories of that category -->
                                    <?php if(isset($subcategories) && $subcategories->count() > 1): ?>
                                        <div class="widget widget-collapsible">
                                            <h3 class="widget-title">
                                                <a data-toggle="collapse" href="#widget-1" role="button"
                                                    aria-expanded="true" aria-controls="widget-1">
                                                    <?php echo e($category->name); ?> Categories
                                                </a>
                                            </h3>

                                            <div class="collapse show" id="widget-1">
                                                <div class="widget-body">
                                                    <div class="filter-items filter-items-count">
                                                        <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="filter-item">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox"
                                                                        class="custom-control-input filter-checkbox"
                                                                        name="subcategories[]"
                                                                        value="<?php echo e($subcat->id); ?>"
                                                                        id="subcat-<?php echo e($subcat->id); ?>"
                                                                        <?php echo e(in_array($subcat->id, request('subcategories', [])) ? 'checked' : ''); ?>>
                                                                    <label class="custom-control-label"
                                                                        for="subcat-<?php echo e($subcat->id); ?>">
                                                                        <?php echo e($subcat->name); ?>

                                                                    </label>
                                                                </div>
                                                                <span
                                                                    class="item-count"><?php echo e($subcat->activeProducts()->count()); ?></span>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <!-- When on subcategory page, show all categories for direct navigation -->
                                    <?php if(isset($allCategories) && $allCategories->count() > 1): ?>
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
                                                        <?php $__currentLoopData = $allCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="filter-item">
                                                                <a href="<?php echo e(url($cat->slug)); ?>"
                                                                    class="category-link d-flex justify-content-between align-items-center text-decoration-none <?php echo e($cat->id == $category->id ? 'active' : ''); ?>">
                                                                    <span class="category-name"><?php echo e($cat->name); ?></span>
                                                                    <span
                                                                        class="item-count"><?php echo e($cat->activeProducts()->count()); ?></span>
                                                                </a>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Show subcategories when on subcategory page -->
                                    <?php if(isset($subcategories) && $subcategories->count() > 1): ?>
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
                                                        <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="filter-item">
                                                                <a href="<?php echo e(url($category->slug . '/' . $subcat->slug)); ?>"
                                                                    class="category-link d-flex justify-content-between align-items-center text-decoration-none <?php echo e(isset($subcategory) && $subcat->id == $subcategory->id ? 'active' : ''); ?>">
                                                                    <span class="category-name"><?php echo e($subcat->name); ?></span>
                                                                    <span
                                                                        class="item-count"><?php echo e($subcat->activeProducts()->count()); ?></span>
                                                                </a>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <!-- Size Filter -->
                                <?php if(isset($availableSizes) && $availableSizes->count() > 0): ?>
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
                                                    <?php $__currentLoopData = $availableSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="filter-item">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox"
                                                                    class="custom-control-input filter-checkbox"
                                                                    name="sizes[]" value="<?php echo e($size); ?>"
                                                                    id="size-<?php echo e($loop->index); ?>"
                                                                    <?php echo e(in_array($size, request('sizes', [])) ? 'checked' : ''); ?>>
                                                                <label class="custom-control-label"
                                                                    for="size-<?php echo e($loop->index); ?>"><?php echo e($size); ?></label>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Color Filter -->
                                <?php if(isset($availableColors) && $availableColors->count() > 0): ?>
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
                                                    <?php $__currentLoopData = $availableColors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <input type="checkbox" name="colors[]"
                                                            value="<?php echo e($color->id); ?>"
                                                            class="color-checkbox filter-checkbox"
                                                            <?php echo e(in_array($color->id, request('colors', [])) ? 'checked' : ''); ?>

                                                            style="display: none;" id="color-<?php echo e($color->id); ?>">
                                                        <a href="#"
                                                            class="color-filter-link <?php echo e(in_array($color->id, request('colors', [])) ? 'selected' : ''); ?>"
                                                            style="background: <?php echo e($color->color_code); ?>;"
                                                            data-color-id="<?php echo e($color->id); ?>"
                                                            title="<?php echo e($color->name); ?>">
                                                            <span class="sr-only"><?php echo e($color->name); ?></span>
                                                        </a>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div><!-- End .filter-colors -->
                                            </div><!-- End .widget-body -->
                                        </div><!-- End .collapse -->
                                    </div>
                                <?php endif; ?>



                                <!-- Brand Filter -->
                                <?php if(isset($availableBrands) && $availableBrands->count() > 0): ?>
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
                                                    <?php $__currentLoopData = $availableBrands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="filter-item">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox"
                                                                    class="custom-control-input filter-checkbox"
                                                                    name="brands[]" value="<?php echo e($brand->id); ?>"
                                                                    id="brand-<?php echo e($brand->id); ?>"
                                                                    <?php echo e(in_array($brand->id, request('brands', [])) ? 'checked' : ''); ?>>
                                                                <label class="custom-control-label"
                                                                    for="brand-<?php echo e($brand->id); ?>"><?php echo e($brand->name); ?></label>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Fixed Price Filter -->
                                <?php if(isset($priceRange) && $priceRange): ?>
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
                                <?php endif; ?>
                            </form>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('frontend/assets/js/nouislider.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/assets/js/wNumb.js')); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if(isset($priceRange) && $priceRange): ?>
                // Initialize price slider with fixed range from 0
                var priceSlider = document.getElementById('price-slider');
                var minPrice = 0; // Fixed to start from 0
                var maxPrice = <?php echo e($priceRange->max_price ?? 1000); ?>;
                var currentMin = <?php echo e(request('price_min', 0)); ?>; // Always start from 0
                var currentMax = <?php echo e(request('price_max', $priceRange->max_price ?? 1000)); ?>;

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
            <?php endif; ?>

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
            window.location.href = '<?php echo e($cleanAllUrl); ?>';
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ecommerce\resources\views/frontend/product/list.blade.php ENDPATH**/ ?>