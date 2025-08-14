<div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>

            <form action="#" method="get" class="mobile-search">
                <label for="mobile-search" class="sr-only">Search</label>
                <input type="search" class="form-control" name="mobile-search" id="mobile-search"
                    placeholder="Search in..." required>
                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
            </form>

            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <!-- Home Link -->
                    <li>
                        <a href="<?php echo e(url('/')); ?>">Home</a>
                    </li>
                    
                    <?php
                        $categories = App\Models\Category::getMenuCategories();
                    ?>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($category->activeSubcategories->count() > 0): ?>
                            <li>
                                <a href="<?php echo e(url($category->slug)); ?>"><?php echo e($category->name); ?></a>
                                <ul>
                                    <?php $__currentLoopData = $category->activeSubcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a href="<?php echo e(url($category->slug . '/' . $subcategory->slug)); ?>"><?php echo e($subcategory->name); ?></a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <a href="<?php echo e(asset('category.html')); ?>">Shop</a>
                        <ul>
                            <li><a href="<?php echo e(asset('category-list.html')); ?>">Shop List</a></li>
                            <li><a href="<?php echo e(asset('category-2cols.html')); ?>">Shop Grid 2 Columns</a></li>
                            <li><a href="<?php echo e(asset('category.html')); ?>">Shop Grid 3 Columns</a></li>
                            <li><a href="<?php echo e(asset('category-4cols.html')); ?>">Shop Grid 4 Columns</a></li>
                            <li><a href="<?php echo e(asset('category-boxed.html')); ?>"><span>Shop Boxed No Sidebar<span
                                            class="tip tip-hot">Hot</span></span></a></li>
                            <li><a href="<?php echo e(asset('category-fullwidth.html')); ?>">Shop Fullwidth No Sidebar</a></li>
                            <li><a href="<?php echo e(asset('product-category-boxed.html')); ?>">Product Category Boxed</a></li>
                            <li><a href="<?php echo e(asset('product-category-fullwidth.html')); ?>"><span>Product Category Fullwidth<span
                                            class="tip tip-new">New</span></span></a></li>
                            <li><a href="<?php echo e(asset('cart.html')); ?>">Cart</a></li>
                            <li><a href="<?php echo e(asset('checkout.html')); ?>">Checkout</a></li>
                            <li><a href="<?php echo e(asset('wishlist.html')); ?>">Wishlist</a></li>
                            <li><a href="#">Lookbook</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo e(asset('product.html')); ?>" class="sf-with-ul">Product</a>
                        <ul>
                            <li><a href="<?php echo e(asset('product.html')); ?>">Default</a></li>
                            <li><a href="<?php echo e(asset('product-centered.html')); ?>">Centered</a></li>
                            <li><a href="<?php echo e(asset('product-extended.html')); ?>"><span>Extended Info<span
                                            class="tip tip-new">New</span></span></a></li>
                            <li><a href="<?php echo e(asset('product-gallery.html')); ?>">Gallery</a></li>
                            <li><a href="<?php echo e(asset('product-sticky.html')); ?>">Sticky Info</a></li>
                            <li><a href="<?php echo e(asset('product-sidebar.html')); ?>">Boxed With Sidebar</a></li>
                            <li><a href="<?php echo e(asset('product-fullwidth.html')); ?>">Full Width</a></li>
                            <li><a href="<?php echo e(asset('product-masonry.html')); ?>">Masonry Sticky Info</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Pages</a>
                        <ul>
                            <li>
                                <a href="about.html">About</a>

                                <ul>
                                    <li><a href="about.html">About 01</a></li>
                                    <li><a href="about-2.html">About 02</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="contact.html">Contact</a>

                                <ul>
                                    <li><a href="contact.html">Contact 01</a></li>
                                    <li><a href="contact-2.html">Contact 02</a></li>
                                </ul>
                            </li>
                            <li><a href="login.html">Login</a></li>
                            <li><a href="faq.html">FAQs</a></li>
                            <li><a href="404.html">Error 404</a></li>
                            <li><a href="coming-soon.html">Coming Soon</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="blog.html">Blog</a>

                        <ul>
                            <li><a href="blog.html">Classic</a></li>
                            <li><a href="blog-listing.html">Listing</a></li>
                            <li>
                                <a href="#">Grid</a>
                                <ul>
                                    <li><a href="blog-grid-2cols.html">Grid 2 columns</a></li>
                                    <li><a href="blog-grid-3cols.html">Grid 3 columns</a></li>
                                    <li><a href="blog-grid-4cols.html">Grid 4 columns</a></li>
                                    <li><a href="blog-grid-sidebar.html">Grid sidebar</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Masonry</a>
                                <ul>
                                    <li><a href="blog-masonry-2cols.html">Masonry 2 columns</a></li>
                                    <li><a href="blog-masonry-3cols.html">Masonry 3 columns</a></li>
                                    <li><a href="blog-masonry-4cols.html">Masonry 4 columns</a></li>
                                    <li><a href="blog-masonry-sidebar.html">Masonry sidebar</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Mask</a>
                                <ul>
                                    <li><a href="blog-mask-grid.html">Blog mask grid</a></li>
                                    <li><a href="blog-mask-masonry.html">Blog mask masonry</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Single Post</a>
                                <ul>
                                    <li><a href="single.html">Default with sidebar</a></li>
                                    <li><a href="single-fullwidth.html">Fullwidth no sidebar</a></li>
                                    <li><a href="single-fullwidth-sidebar.html">Fullwidth with sidebar</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="elements-list.html">Elements</a>
                        <ul>
                            <li><a href="elements-products.html">Products</a></li>
                            <li><a href="elements-typography.html">Typography</a></li>
                            <li><a href="elements-titles.html">Titles</a></li>
                            <li><a href="elements-banners.html">Banners</a></li>
                            <li><a href="elements-product-category.html">Product Category</a></li>
                            <li><a href="elements-video-banners.html">Video Banners</a></li>
                            <li><a href="elements-buttons.html">Buttons</a></li>
                            <li><a href="elements-accordions.html">Accordions</a></li>
                            <li><a href="elements-tabs.html">Tabs</a></li>
                            <li><a href="elements-testimonials.html">Testimonials</a></li>
                            <li><a href="elements-blog-posts.html">Blog Posts</a></li>
                            <li><a href="elements-portfolio.html">Portfolio</a></li>
                            <li><a href="elements-cta.html">Call to Action</a></li>
                            <li><a href="elements-icon-boxes.html">Icon Boxes</a></li>
                        </ul>
                    </li>
                </ul>
            </nav><!-- End .mobile-nav -->

            <div class="social-icons">
                <a href="#" class="social-icon" target="_blank" title="Facebook"><i
                        class="icon-facebook-f"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Twitter"><i
                        class="icon-twitter"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Instagram"><i
                        class="icon-instagram"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Youtube"><i
                        class="icon-youtube"></i></a>
            </div><!-- End .social-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container --><?php /**PATH C:\xampp\htdocs\ecommerce\resources\views/frontend/layouts/mobile_menu.blade.php ENDPATH**/ ?>