<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('frontend/assets/css/plugins/nouislider/nouislider.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', $meta_title); ?>
<?php $__env->startSection('meta_description', $meta_description); ?>
<?php $__env->startSection('meta_keywords', $meta_keyword); ?>

<?php $__env->startSection('content'); ?>
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container d-flex align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(url($category->slug)); ?>"><?php echo e($category->name); ?></a></li>
                    <li class="breadcrumb-item"><a
                            href="<?php echo e(url($category->slug . '/' . $subcategory->slug)); ?>"><?php echo e($subcategory->name); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo e($product->title); ?></li>
                </ol>

                <nav class="product-pager ml-auto" aria-label="Product">
                    <a class="product-pager-link product-pager-prev" href="#" aria-label="Previous" tabindex="-1">
                        <i class="icon-angle-left"></i>
                        <span>Prev</span>
                    </a>

                    <a class="product-pager-link product-pager-next" href="#" aria-label="Next" tabindex="-1">
                        <span>Next</span>
                        <i class="icon-angle-right"></i>
                    </a>
                </nav><!-- End .pager-nav -->
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="container">
                <div class="product-details-top mb-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-gallery">
                                <figure class="product-main-image">
                                    <?php
                                        // dd($product->productImages->first()->image_src);
                                    ?>
                                    <img id="product-zoom" src="<?php echo e($product->productImages->first()->image_src); ?>"
                                        data-zoom-image="<?php echo e($product->productImages->first()->image_src); ?>"
                                        alt="product image">
<img id="product-zoom" src="/storage/product_images/<?php echo e($product->productImages); ?>"
         data-zoom-image="/storage/product_images/<?php echo e($product->productImages); ?>"
         class="product-zoom-image"
         alt="cvc">
                                    <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                        <i class="icon-arrows"></i>
                                    </a>
                                </figure><!-- End .product-main-image -->
                                <?php if($product->productImages->count() > 1): ?>
                                    <div id="product-zoom-gallery" class="product-image-gallery">
                                        <?php $__currentLoopData = $product->productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a class="product-gallery-item <?php echo e($index == 0 ? 'active' : ''); ?>"
                                                href="#" data-image="<?php echo e($image->image_src); ?>"
                                                data-zoom-image="<?php echo e($image->image_src); ?>">
                                                <img src="<?php echo e($image->image_src); ?>" alt="<?php echo e($product->title); ?>">
                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            </div><!-- End .product-gallery -->
                        </div><!-- End .col-md-6 -->

                        <div class="col-md-6">
                            <div class="product-details">
                                <h1 class="product-title"><?php echo e($product->title); ?></h1><!-- End .product-title -->

                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <a class="ratings-text" href="#product-review-link" id="review-link">( 2 Reviews )</a>
                                </div><!-- End .rating-container -->

                                <div class="product-price">
                                    <?php if($product->hasDiscount()): ?>
                                        <span class="new-price">$<?php echo e(number_format($product->price, 2)); ?></span>
                                        <span class="old-price">$<?php echo e(number_format($product->old_price, 2)); ?></span>
                                    <?php else: ?>
                                        $<?php echo e(number_format($product->price, 2)); ?>

                                    <?php endif; ?>
                                </div><!-- End .product-price -->

                                <?php if($product->short_description): ?>
                                    <div class="product-content">
                                        <p><?php echo e($product->short_description); ?></p>
                                    </div><!-- End .product-content -->
                                <?php endif; ?>

                                <?php if($product->colors->count() > 0): ?>
                                    <div class="details-filter-row details-row-size">
                                        <label>Color:</label>

                                        <div class="product-nav product-nav-dots">
                                            <?php $__currentLoopData = $product->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="#" class="<?php echo e($index == 0 ? 'active' : ''); ?>"
                                                    style="background: <?php echo e($color->color_code); ?>;"
                                                    title="<?php echo e($color->name); ?>">
                                                    <span class="sr-only"><?php echo e($color->name); ?></span>
                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div><!-- End .product-nav -->
                                    </div><!-- End .details-filter-row -->
                                <?php endif; ?>

                                <?php if($product->productSizes->count() > 0): ?>
                                    <div class="details-filter-row details-row-size">
                                        <label for="size">Size:</label>
                                        <div class="select-custom">
                                            <select name="size" id="size" class="form-control">
                                                <option value="#" selected="selected">Select a size</option>
                                                <?php $__currentLoopData = $product->productSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($size->size_name); ?>"><?php echo e($size->size_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div><!-- End .select-custom -->

                                        <a href="#" class="size-guide"><i class="icon-th-list"></i>size guide</a>
                                    </div><!-- End .details-filter-row -->
                                <?php endif; ?>

                                <div class="details-filter-row details-row-size">
                                    <label for="qty">Qty:</label>
                                    <div class="product-details-quantity">
                                        <input type="number" id="qty" class="form-control" value="1"
                                            min="1" max="10" step="1" data-decimals="0" required>
                                    </div><!-- End .product-details-quantity -->
                                </div><!-- End .details-filter-row -->

                                <div class="product-details-action">
                                    <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>

                                    <div class="details-action-wrapper">
                                        <a href="#" class="btn-product btn-wishlist" title="Wishlist"><span>Add to
                                                Wishlist</span></a>
                                        <a href="#" class="btn-product btn-compare" title="Compare"><span>Add to
                                                Compare</span></a>
                                    </div><!-- End .details-action-wrapper -->
                                </div><!-- End .product-details-action -->

                                <div class="product-details-footer">
                                    <div class="product-cat">
                                        <span>Category:</span>
                                        <a href="<?php echo e(url($category->slug)); ?>"><?php echo e($category->name); ?></a>,
                                        <a
                                            href="<?php echo e(url($category->slug . '/' . $subcategory->slug)); ?>"><?php echo e($subcategory->name); ?></a>
                                        <?php if($product->brand): ?>
                                            , <a href="#"><?php echo e($product->brand->name); ?></a>
                                        <?php endif; ?>
                                    </div><!-- End .product-cat -->

                                    <div class="social-icons social-icons-sm">
                                        <span class="social-label">Share:</span>
                                        <a href="#" class="social-icon" title="Facebook" target="_blank"><i
                                                class="icon-facebook-f"></i></a>
                                        <a href="#" class="social-icon" title="Twitter" target="_blank"><i
                                                class="icon-twitter"></i></a>
                                        <a href="#" class="social-icon" title="Instagram" target="_blank"><i
                                                class="icon-instagram"></i></a>
                                        <a href="#" class="social-icon" title="Pinterest" target="_blank"><i
                                                class="icon-pinterest"></i></a>
                                    </div>
                                </div><!-- End .product-details-footer -->
                            </div><!-- End .product-details -->
                        </div><!-- End .col-md-6 -->
                    </div><!-- End .row -->
                </div><!-- End .product-details-top -->
            </div><!-- End .container -->

            <div class="product-details-tab product-details-extended">
                <div class="container">
                    <ul class="nav nav-pills justify-content-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab"
                                role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                        </li>
                        <?php if($product->additional_information): ?>
                            <li class="nav-item">
                                <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab"
                                    role="tab" aria-controls="product-info-tab" aria-selected="false">Additional
                                    information</a>
                            </li>
                        <?php endif; ?>
                        <?php if($product->shipping_return): ?>
                            <li class="nav-item">
                                <a class="nav-link" id="product-shipping-link" data-toggle="tab"
                                    href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab"
                                    aria-selected="false">Shipping & Returns</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab"
                                role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews (2)</a>
                        </li>
                    </ul>
                </div><!-- End .container -->

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel"
                        aria-labelledby="product-desc-link">
                        <div class="product-desc-content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?php if($product->description): ?>
                                            <?php echo nl2br(e($product->description)); ?>

                                        <?php else: ?>
                                            <p>No description available for this product.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->

                    <?php if($product->additional_information): ?>
                        <div class="tab-pane fade" id="product-info-tab" role="tabpanel"
                            aria-labelledby="product-info-link">
                            <div class="product-desc-content">
                                <div class="container">
                                    <h3>Additional Information</h3>
                                    <?php echo nl2br(e($product->additional_information)); ?>

                                </div><!-- End .container -->
                            </div><!-- End .product-desc-content -->
                        </div><!-- .End .tab-pane -->
                    <?php endif; ?>

                    <?php if($product->shipping_return): ?>
                        <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel"
                            aria-labelledby="product-shipping-link">
                            <div class="product-desc-content">
                                <div class="container">
                                    <h3>Shipping & Returns</h3>
                                    <?php echo nl2br(e($product->shipping_return)); ?>

                                </div><!-- End .container -->
                            </div><!-- End .product-desc-content -->
                        </div><!-- .End .tab-pane -->
                    <?php endif; ?>

                    <div class="tab-pane fade" id="product-review-tab" role="tabpanel"
                        aria-labelledby="product-review-link">
                        <div class="reviews">
                            <div class="container">
                                <h3>Reviews (2)</h3>
                                <!-- Static reviews for now - you can make this dynamic later -->
                                <div class="review">
                                    <div class="row no-gutters">
                                        <div class="col-auto">
                                            <h4><a href="#">Samanta J.</a></h4>
                                            <div class="ratings-container">
                                                <div class="ratings">
                                                    <div class="ratings-val" style="width: 80%;"></div>
                                                    <!-- End .ratings-val -->
                                                </div><!-- End .ratings -->
                                            </div><!-- End .rating-container -->
                                            <span class="review-date">6 days ago</span>
                                        </div><!-- End .col -->
                                        <div class="col">
                                            <h4>Good, perfect size</h4>
                                            <div class="review-content">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus cum
                                                    dolores assumenda asperiores facilis porro reprehenderit animi culpa
                                                    atque blanditiis commodi perspiciatis doloremque, possimus, explicabo,
                                                    autem fugit beatae quae voluptas!</p>
                                            </div><!-- End .review-content -->
                                            <div class="review-action">
                                                <a href="#"><i class="icon-thumbs-up"></i>Helpful (2)</a>
                                                <a href="#"><i class="icon-thumbs-down"></i>Unhelpful (0)</a>
                                            </div><!-- End .review-action -->
                                        </div><!-- End .col-auto -->
                                    </div><!-- End .row -->
                                </div><!-- End .review -->
                            </div><!-- End .container -->
                        </div><!-- End .reviews -->
                    </div><!-- .End .tab-pane -->
                </div><!-- End .tab-content -->
            </div><!-- End .product-details-tab -->

            <?php if($relatedProducts->count() > 0): ?>
                <div class="container">
                    <h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->
                    <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                        data-owl-options='{
                    "nav": false,
                    "dots": true,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":1
                        },
                        "480": {
                            "items":2
                        },
                        "768": {
                            "items":3
                        },
                        "992": {
                            "items":4
                        },
                        "1200": {
                            "items":4,
                            "nav": true,
                            "dots": false
                        }
                    }
                }'>
                        <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="product product-7">
                                <figure class="product-media">
                                    <?php if($relatedProduct->hasDiscount()): ?>
                                        <span class="product-label label-sale">Sale</span>
                                    <?php endif; ?>
                                    <a
                                        href="<?php echo e(url($category->slug . '/' . $subcategory->slug . '/' . $relatedProduct->slug)); ?>">
                                        <?php if($relatedProduct->productImages->count() > 0): ?>
                                            <img src="<?php echo e($relatedProduct->productImages->first()->image_src); ?>"
                                                alt="<?php echo e($relatedProduct->title); ?>" class="product-image">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('assets/images/no-image.jpg')); ?>"
                                                alt="<?php echo e($relatedProduct->title); ?>" class="product-image">
                                        <?php endif; ?>
                                    </a>

                                    <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                                to wishlist</span></a>
                                        <a href="#" class="btn-product-icon btn-quickview"
                                            title="Quick view"><span>Quick view</span></a>
                                        <a href="#" class="btn-product-icon btn-compare"
                                            title="Compare"><span>Compare</span></a>
                                    </div><!-- End .product-action-vertical -->

                                    <div class="product-action">
                                        <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                    </div><!-- End .product-action -->
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a
                                            href="<?php echo e(url($category->slug . '/' . $subcategory->slug)); ?>"><?php echo e($subcategory->name); ?></a>
                                    </div><!-- End .product-cat -->
                                    <h3 class="product-title">
                                        <a
                                            href="<?php echo e(url($category->slug . '/' . $subcategory->slug . '/' . $relatedProduct->slug)); ?>">
                                            <?php echo e(Str::limit($relatedProduct->title, 50)); ?>

                                        </a>
                                    </h3><!-- End .product-title -->
                                    <div class="product-price">
                                        <?php if($relatedProduct->hasDiscount()): ?>
                                            <span class="new-price">$<?php echo e(number_format($relatedProduct->price, 2)); ?></span>
                                            <span
                                                class="old-price">$<?php echo e(number_format($relatedProduct->old_price, 2)); ?></span>
                                        <?php else: ?>
                                            $<?php echo e(number_format($relatedProduct->price, 2)); ?>

                                        <?php endif; ?>
                                    </div><!-- End .product-price -->
                                    <div class="ratings-container">
                                        <div class="ratings">
                                            <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                                        </div><!-- End .ratings -->
                                        <span class="ratings-text">( 2 Reviews )</span>
                                    </div><!-- End .rating-container -->

                                    <?php if($relatedProduct->colors->count() > 0): ?>
                                        <div class="product-nav product-nav-dots">
                                            <?php $__currentLoopData = $relatedProduct->colors->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="#" style="background: <?php echo e($color->color_code); ?>;"><span
                                                        class="sr-only"><?php echo e($color->name); ?></span></a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div><!-- End .product-nav -->
                                    <?php endif; ?>
                                </div><!-- End .product-body -->
                            </div><!-- End .product -->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div><!-- End .owl-carousel -->
                </div><!-- End .container -->
            <?php endif; ?>
        </div><!-- End .page-content -->
    </main><!-- End .main -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('frontend/assets/js/bootstrap-input-spinner.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/assets/js/jquery.elevateZoom.min.js')); ?>"></script>>
    <script src="<?php echo e(asset('frontend/assets/js/bootstrap-input-spinner.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ecommerce\resources\views/frontend/product/details.blade.php ENDPATH**/ ?>