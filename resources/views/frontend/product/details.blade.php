@extends('frontend.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/nouislider/nouislider.css') }}">
@endsection

@section('title', $meta_title)
@section('meta_description', $meta_description)
@section('meta_keywords', $meta_keyword)

@section('content')
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container d-flex align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url($category->slug) }}">{{ $category->name }}</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ url($category->slug . '/' . $subcategory->slug) }}">{{ $subcategory->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
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

                                    @if ($product->productImages->count() > 0)
                                        <img id="product-zoom" src="{{ $product->productImages->first()->image_src }}"
                                            data-zoom-image="{{ $product->productImages->first()->image_src }}"
                                            alt="product image">
                                    @else
                                        <img src="{{ asset('frontend/assets/images/no-image.jpg') }}"
                                            alt="{{ $product->productImages->first()->original_name }}"
                                            class="product-image">
                                    @endif
                                    <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                        <i class="icon-arrows"></i>
                                    </a>
                                </figure><!-- End .product-main-image -->
                                @if ($product->productImages->count() > 1)
                                    <div id="product-zoom-gallery" class="product-image-gallery">
                                        @foreach ($product->productImages as $index => $image)
                                            <a class="product-gallery-item {{ $index == 0 ? 'active' : '' }}"
                                                href="#" data-image="{{ $image->image_src }}"
                                                data-zoom-image="{{ $image->image_src }}">
                                                <img src="{{ $image->image_src }}" alt="{{ $product->title }}">
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div><!-- End .product-gallery -->
                        </div><!-- End .col-md-6 -->

                        <div class="col-md-6">
                            <div class="product-details">
                                <h1 class="product-title">{{ $product->title }}</h1><!-- End .product-title -->

                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <a class="ratings-text" href="#product-review-link" id="review-link">( 2 Reviews )</a>
                                </div><!-- End .rating-container -->

                                <div class="product-price">
                                    @if ($product->hasDiscount())
                                        <span class="new-price">${{ number_format($product->price, 2) }}</span>
                                        <span class="old-price">${{ number_format($product->old_price, 2) }}</span>
                                    @else
                                        ${{ number_format($product->price, 2) }}
                                    @endif
                                </div><!-- End .product-price -->

                                @if ($product->short_description)
                                    <div class="product-content">
                                        <p>{{ $product->short_description }}</p>
                                    </div><!-- End .product-content -->
                                @endif

                                @if ($product->colors->count() > 0)
                                    <div class="details-filter-row details-row-size">
                                        <label>Color:</label>

                                        <div class="product-nav product-nav-dots">
                                            @foreach ($product->colors as $index => $color)
                                                <a href="#" class="{{ $index == 0 ? 'active' : '' }}"
                                                    style="background: {{ $color->color_code }};"
                                                    title="{{ $color->name }}">
                                                    <span class="sr-only">{{ $color->name }}</span>
                                                </a>
                                            @endforeach
                                        </div><!-- End .product-nav -->
                                    </div><!-- End .details-filter-row -->
                                @endif

                                @if ($product->productSizes->count() > 0)
                                    <div class="details-filter-row details-row-size">
                                        <label for="size">Size:</label>
                                        <div class="select-custom">
                                            <select name="size" id="size" class="form-control">
                                                <option value="#" selected="selected">Select a size</option>
                                                @foreach ($product->productSizes as $size)
                                                    <option value="{{ $size->size_name }}">{{ $size->size_name }}</option>
                                                @endforeach
                                            </select>
                                        </div><!-- End .select-custom -->

                                        <a href="#" class="size-guide"><i class="icon-th-list"></i>size guide</a>
                                    </div><!-- End .details-filter-row -->
                                @endif

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
                                    </div><!-- End .details-action-wrapper -->
                                </div><!-- End .product-details-action -->

                                <div class="product-details-footer">
                                    <div class="product-cat">
                                        <span>Category:</span>
                                        <a href="{{ url($category->slug) }}">{{ $category->name }}</a>,
                                        <a
                                            href="{{ url($category->slug . '/' . $subcategory->slug) }}">{{ $subcategory->name }}</a>
                                        @if ($product->brand)
                                            , <a href="#">{{ $product->brand->name }}</a>
                                        @endif
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
                        @if ($product->additional_information)
                            <li class="nav-item">
                                <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab"
                                    role="tab" aria-controls="product-info-tab" aria-selected="false">Additional
                                    information</a>
                            </li>
                        @endif
                        @if ($product->shipping_return)
                            <li class="nav-item">
                                <a class="nav-link" id="product-shipping-link" data-toggle="tab"
                                    href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab"
                                    aria-selected="false">Shipping & Returns</a>
                            </li>
                        @endif
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
                                        @if ($product->description)
                                            {!! nl2br(e($product->description)) !!}
                                        @else
                                            <p>No description available for this product.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div><!-- End .product-desc-content -->
                    </div><!-- .End .tab-pane -->

                    @if ($product->additional_information)
                        <div class="tab-pane fade" id="product-info-tab" role="tabpanel"
                            aria-labelledby="product-info-link">
                            <div class="product-desc-content">
                                <div class="container">
                                    <h3>Additional Information</h3>
                                    {!! nl2br(e($product->additional_information)) !!}
                                </div><!-- End .container -->
                            </div><!-- End .product-desc-content -->
                        </div><!-- .End .tab-pane -->
                    @endif

                    @if ($product->shipping_return)
                        <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel"
                            aria-labelledby="product-shipping-link">
                            <div class="product-desc-content">
                                <div class="container">
                                    <h3>Shipping & Returns</h3>
                                    {!! nl2br(e($product->shipping_return)) !!}
                                </div><!-- End .container -->
                            </div><!-- End .product-desc-content -->
                        </div><!-- .End .tab-pane -->
                    @endif

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

            @if ($relatedProducts->count() > 0)
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
                        @foreach ($relatedProducts as $relatedProduct)
                            <div class="product product-7">
                                <figure class="product-media">
                                    @if ($relatedProduct->hasDiscount())
                                        <span class="product-label label-sale">Sale</span>
                                    @endif
                                    <a
                                        href="{{ url($category->slug . '/' . $subcategory->slug . '/' . $relatedProduct->slug) }}">
                                        @if ($relatedProduct->productImages->count() > 0)
                                            <img src="{{ $relatedProduct->productImages->first()->image_src }}"
                                                alt="{{ $relatedProduct->title }}" class="product-image">
                                        @else
                                            <img src="{{ asset('assets/images/no-image.jpg') }}"
                                                alt="{{ $relatedProduct->title }}" class="product-image">
                                        @endif
                                    </a>

                                    <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                                to wishlist</span></a>
                                        <a href="#" class="btn-product-icon btn-quickview"
                                            title="Quick view"><span>Quick view</span></a>
                                    </div><!-- End .product-action-vertical -->

                                    <div class="product-action">
                                        <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                    </div><!-- End .product-action -->
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a
                                            href="{{ url($category->slug . '/' . $subcategory->slug) }}">{{ $subcategory->name }}</a>
                                    </div><!-- End .product-cat -->
                                    <h3 class="product-title">
                                        <a
                                            href="{{ url($category->slug . '/' . $subcategory->slug . '/' . $relatedProduct->slug) }}">
                                            {{ Str::limit($relatedProduct->title, 50) }}
                                        </a>
                                    </h3><!-- End .product-title -->
                                    <div class="product-price">
                                        @if ($relatedProduct->hasDiscount())
                                            <span class="new-price">${{ number_format($relatedProduct->price, 2) }}</span>
                                            <span
                                                class="old-price">${{ number_format($relatedProduct->old_price, 2) }}</span>
                                        @else
                                            ${{ number_format($relatedProduct->price, 2) }}
                                        @endif
                                    </div><!-- End .product-price -->
                                    <div class="ratings-container">
                                        <div class="ratings">
                                            <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                                        </div><!-- End .ratings -->
                                        <span class="ratings-text">( 2 Reviews )</span>
                                    </div><!-- End .rating-container -->

                                    @if ($relatedProduct->colors->count() > 0)
                                        <div class="product-nav product-nav-dots">
                                            @foreach ($relatedProduct->colors->take(3) as $color)
                                                <a href="#" style="background: {{ $color->color_code }};"><span
                                                        class="sr-only">{{ $color->name }}</span></a>
                                            @endforeach
                                        </div><!-- End .product-nav -->
                                    @endif
                                </div><!-- End .product-body -->
                            </div><!-- End .product -->
                        @endforeach

                    </div><!-- End .owl-carousel -->
                </div><!-- End .container -->
            @endif
        </div><!-- End .page-content -->
    </main><!-- End .main -->

@endsection

@section('scripts')
    <script src="{{ asset('frontend/assets/js/bootstrap-input-spinner.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.elevateZoom.min.js') }}"></script>>
    <script src="{{ asset('frontend/assets/js/bootstrap-input-spinner.js') }}"></script>
@endsection
