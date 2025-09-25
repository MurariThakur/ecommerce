@extends('frontend.layouts.app')

@section('content')
    <main class="main">
        @if ($sliders->count() > 0)
            <div class="intro-section bg-lighter pb-6">
                <div class="">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="intro-slider-container slider-container-ratio slider-container-1 mb-2 mb-lg-0">
                                <div class="intro-slider intro-slider-1 owl-carousel owl-simple owl-light owl-nav-inside"
                                    data-toggle="owl"
                                    data-owl-options='{
                                        "nav": false,
                                        "responsive": {
                                            "768": {
                                                "nav": true
                                            }
                                        }
                                    }'>
                                    @foreach ($sliders as $slider)
                                        <div class="intro-slide">
                                            <figure class="slide-image">
                                                <img src="{{ asset('storage/' . $slider->image) }}"
                                                    alt="{{ $slider->title }}">
                                            </figure><!-- End .slide-image -->

                                            <div class="intro-content">
                                                <h1 class="intro-title">{!! $slider->title !!}</h1>
                                                <!-- End .intro-title -->

                                                @if ($slider->button_name && $slider->button_link)
                                                    <a href="{{ $slider->button_link }}" class="btn btn-outline-white">
                                                        <span>{{ $slider->button_name }}</span>
                                                        <i class="icon-long-arrow-right"></i>
                                                    </a>
                                                @endif
                                            </div><!-- End .intro-content -->
                                        </div><!-- End .intro-slide -->
                                    @endforeach
                                </div><!-- End .intro-slider owl-carousel owl-simple -->

                                <span class="slider-loader"></span><!-- End .slider-loader -->
                            </div><!-- End .intro-slider-container -->
                        </div><!-- End .col-lg-8 -->
                    </div><!-- End .row -->


                    @if ($partners->count() > 0)
                        <div class="mb-6"></div><!-- End .mb-6 -->
                        <div class="owl-carousel owl-simple" data-toggle="owl"
                            data-owl-options='{
                            "nav": false,
                            "dots": false,
                            "margin": 30,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":2
                                },
                                "420": {
                                    "items":3
                                },
                                "600": {
                                    "items":4
                                },
                                "900": {
                                    "items":5
                                },
                                "1024": {
                                    "items":6
                                }
                            }
                        }'>
                            @foreach ($partners as $partner)
                                @if ($partner->link)
                                    <a href="{{ $partner->link }}" target="_blank" class="brand">
                                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}">
                                    </a>
                                @else
                                    <div class="brand">
                                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}">
                                    </div>
                                @endif
                            @endforeach
                        </div><!-- End .owl-carousel -->
                    @endif
                </div><!-- End .container -->
            </div><!-- End .bg-lighter -->
        @endif

        <div class="mb-6"></div><!-- End .mb-6 -->

        @if ($trendyProducts->count() > 0)
            <div class="container">
                <div class="heading heading-center mb-3">
                    <h2 class="title-lg">Trendy Products</h2><!-- End .title -->
                </div><!-- End .heading -->

                <div class="tab-content tab-content-carousel">
                    <div class="tab-pane p-0 fade show active" id="trendy-all-tab" role="tabpanel"
                        aria-labelledby="trendy-all-link">
                        <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                            data-owl-options='{
                                    "nav": false,
                                    "dots": true,
                                    "margin": 20,
                                    "loop": false,
                                    "responsive": {
                                        "0": {
                                            "items":2
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
                            @foreach ($trendyProducts as $product)
                                <div class="product product-11 text-center">
                                    <figure class="product-media">
                                        <a
                                            href="{{ url($product->category->slug . '/' . ($product->subcategory->slug ?? '') . '/' . $product->slug) }}">
                                            @if ($product->productImages->first())
                                                <img src="{{ $product->productImages->first()->image_src }}"
                                                    alt="{{ $product->title }}" class="product-image">
                                            @else
                                                <img src="{{ asset('frontend/assets/images/no-image.png') }}"
                                                    alt="{{ $product->title }}" class="product-image">
                                            @endif
                                        </a>

                                        <div class="product-action-vertical">
                                            <a href="#" class="btn-product-icon btn-wishlist"><span>add to
                                                    wishlist</span></a>
                                        </div><!-- End .product-action-vertical -->
                                    </figure><!-- End .product-media -->

                                    <div class="product-body">
                                        <h3 class="product-title"><a
                                                href="{{ url($product->category->slug . '/' . ($product->subcategory->slug ?? '') . '/' . $product->slug) }}">{{ $product->title }}</a>
                                        </h3>
                                        <!-- End .product-title -->
                                        <div class="product-price">
                                            @if ($product->old_price && $product->old_price > $product->price)
                                                <span class="old-price">${{ number_format($product->old_price, 2) }}</span>
                                            @endif
                                            ${{ number_format($product->price, 2) }}
                                        </div><!-- End .product-price -->
                                    </div><!-- End .product-body -->
                                    <div class="product-action">
                                        <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                    </div><!-- End .product-action -->
                                </div><!-- End .product -->
                            @endforeach
                        </div><!-- End .owl-carousel -->
                    </div><!-- End .tab-pane -->
                </div><!-- End .tab-content -->
            </div><!-- End .container -->
        @endif


        @if ($homeCategories->count() > 0)
            <div class="container categories pt-6">
                <h2 class="title-lg text-center mb-4">Shop by Categories</h2><!-- End .title-lg text-center -->

                <div class="row">
                    @foreach ($homeCategories as $category)
                        <div class="col-sm-12 col-lg-4 banners-sm mb-3">
                            <div class="row">
                                <div class="banner banner-display banner-link-anim col-lg-12 col-6">
                                    <a href="{{ url($category->slug) }}">
                                        @if ($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                alt="{{ $category->name }}">
                                        @else
                                            <img src="{{ asset('frontend/assets/images/banners/home/banner-2.jpg') }}"
                                                alt="{{ $category->name }}">
                                        @endif
                                    </a>

                                    <div class="banner-content banner-content-center">
                                        <h3 class="banner-title text-white"><a
                                                href="{{ url($category->slug) }}">{{ $category->name }}</a>
                                        </h3><!-- End .banner-title -->
                                        @if ($category->button_name)
                                            <a href="{{ url($category->slug) }}"
                                                class="btn btn-outline-white banner-link">{{ $category->button_name }}<i
                                                    class="icon-long-arrow-right"></i></a>
                                        @endif
                                    </div><!-- End .banner-content -->
                                </div><!-- End .banner -->
                            </div>
                        </div><!-- End .col-sm-6 col-lg-3 -->
                    @endforeach
                </div><!-- End .row -->
            </div><!-- End .container -->
        @endif

        <div class="mb-5"></div><!-- End .mb-6 -->


        <div class="container">
            <div class="heading heading-center mb-6">
                <h2 class="title">Recent Arrivals</h2><!-- End .title -->

                <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="top-all-link" data-toggle="tab" href="#top-all-tab" role="tab"
                            aria-controls="top-all-tab" aria-selected="true">All</a>
                    </li>
                    @foreach ($navCategories as $category)
                        <li class="nav-item">
                            <a class="nav-link" id="top-{{ $category->slug }}-link" data-toggle="tab"
                                href="#top-{{ $category->slug }}-tab" role="tab"
                                aria-controls="top-{{ $category->slug }}-tab"
                                aria-selected="false">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div><!-- End .heading -->

            <div class="tab-content">
                <div class="tab-pane p-0 fade show active" id="top-all-tab" role="tabpanel"
                    aria-labelledby="top-all-link">
                    <div class="products">
                        <div class="row justify-content-center">
                            @forelse($allProducts as $product)
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="product product-11 mt-v3 text-center">
                                        <figure class="product-media">
                                            <a
                                                href="{{ url($product->category->slug . '/' . ($product->subcategory->slug ?? '') . '/' . $product->slug) }}">
                                                @if ($product->productImages->count() > 0)
                                                    <img src="{{ $product->productImages->first()->image_src }}"
                                                        alt="{{ $product->title }}" class="product-image">
                                                @endif
                                            </a>

                                            <div class="product-action-vertical">
                                                <a href="#" class="btn-product-icon btn-wishlist "><span>add to
                                                        wishlist</span></a>
                                            </div><!-- End .product-action-vertical -->
                                        </figure><!-- End .product-media -->

                                        <div class="product-body">
                                            <h3 class="product-title"><a
                                                    href="{{ url($product->category->slug . '/' . ($product->subcategory->slug ?? '') . '/' . $product->slug) }}">{{ $product->title }}</a>
                                            </h3><!-- End .product-title -->
                                            <div class="product-price">
                                                ${{ number_format($product->price, 2) }}
                                            </div><!-- End .product-price -->
                                        </div><!-- End .product-body -->
                                        <div class="product-action">
                                            <a href="#" class="btn-product btn-cart"><span>add to
                                                    cart</span></a>
                                        </div><!-- End .product-action -->
                                    </div><!-- End .product -->
                                </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                            @empty
                                <div class="col-12 text-center">
                                    <p class="text-muted">No products found.</p>
                                </div>
                            @endforelse
                        </div><!-- End .row -->
                    </div><!-- End .products -->
                </div><!-- .End .tab-pane -->

                @foreach ($navCategories as $category)
                    <div class="tab-pane p-0 fade" id="top-{{ $category->slug }}-tab" role="tabpanel"
                        aria-labelledby="top-{{ $category->slug }}-link">
                        <div class="products">
                            <div class="row justify-content-center">
                                @forelse($categoryProducts[$category->slug] as $product)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="product product-11 mt-v3 text-center">
                                            <figure class="product-media">
                                                <a
                                                    href="{{ url($product->category->slug . '/' . ($product->subcategory->slug ?? '') . '/' . $product->slug) }}">
                                                    @if ($product->productImages->count() > 0)
                                                        <img src="{{ $product->productImages->first()->image_src }}"
                                                            alt="{{ $product->title }}" class="product-image">
                                                    @endif
                                                </a>

                                                <div class="product-action-vertical">
                                                    <a href="#" class="btn-product-icon btn-wishlist "><span>add to
                                                            wishlist</span></a>
                                                </div><!-- End .product-action-vertical -->
                                            </figure><!-- End .product-media -->

                                            <div class="product-body">
                                                <h3 class="product-title"><a
                                                        href="{{ url($product->category->slug . '/' . ($product->subcategory->slug ?? '') . '/' . $product->slug) }}">{{ $product->title }}</a>
                                                </h3><!-- End .product-title -->
                                                <div class="product-price">
                                                    ${{ number_format($product->price, 2) }}
                                                </div><!-- End .product-price -->
                                            </div><!-- End .product-body -->
                                            <div class="product-action">
                                                <a href="#" class="btn-product btn-cart"><span>add to
                                                        cart</span></a>
                                            </div><!-- End .product-action -->
                                        </div><!-- End .product -->
                                    </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                                @empty
                                    <div class="col-12 text-center">
                                        <p class="text-muted">No products found in {{ $category->name }}.</p>
                                    </div>
                                @endforelse
                            </div><!-- End .row -->
                        </div><!-- End .products -->
                    </div><!-- .End .tab-pane -->
                @endforeach
            </div><!-- End .tab-content -->

        </div><!-- End .row -->
        </div><!-- End .products -->
        </div><!-- .End .tab-pane -->


        </div><!-- .End .tab-pane -->
        </div><!-- End .tab-content -->
        <!-- <div class="more-container text-center">
                        <button id="load-more-btn" class="btn btn-outline-darker btn-more" data-offset="4" data-category="all">
                            <span>Load more products</span><i class="icon-long-arrow-down"></i>
                        </button>
                    </div><!-- End .more-container -->
        </div><!-- End .container -->

        <div class="container">
            <hr>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-sm-6">
                    <div class="icon-box icon-box-card text-center">
                        <span class="icon-box-icon">
                            <i class="icon-rocket"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Payment & Delivery</h3><!-- End .icon-box-title -->
                            <p>Free shipping for orders over $50</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-lg-4 col-sm-6 -->

                <div class="col-lg-4 col-sm-6">
                    <div class="icon-box icon-box-card text-center">
                        <span class="icon-box-icon">
                            <i class="icon-rotate-left"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Return & Refund</h3><!-- End .icon-box-title -->
                            <p>Free 100% money back guarantee</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-lg-4 col-sm-6 -->

                <div class="col-lg-4 col-sm-6">
                    <div class="icon-box icon-box-card text-center">
                        <span class="icon-box-icon">
                            <i class="icon-life-ring"></i>
                        </span>
                        <div class="icon-box-content">
                            <h3 class="icon-box-title">Quality Support</h3><!-- End .icon-box-title -->
                            <p>Alway online feedback 24/7</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-lg-4 col-sm-6 -->
            </div><!-- End .row -->

            <div class="mb-2"></div><!-- End .mb-2 -->
        </div><!-- End .container -->
        <div class="blog-posts pt-7 pb-7" style="background-color: #fafafa;">
            <div class="container">
                <h2 class="title-lg text-center mb-3 mb-md-4">From Our Blog</h2><!-- End .title-lg text-center -->

                @if ($homeBlogs->count() > 0)
                    <div class="owl-carousel owl-simple carousel-with-shadow" data-toggle="owl"
                        data-owl-options='{
                            "nav": false,
                            "dots": true,
                            "items": 3,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "600": {
                                    "items":2
                                },
                                "992": {
                                    "items":3
                                }
                            }
                        }'>
                        @foreach ($homeBlogs as $blog)
                            <article class="entry entry-display">
                                <figure class="entry-media">
                                    <a href="{{ route('frontend.blog.detail', $blog->slug) }}">
                                        <img src="{{ $blog->image ? asset('storage/' . $blog->image) : asset('frontend/assets/images/blog/home/post-1.jpg') }}"
                                            alt="{{ $blog->title }}">
                                    </a>
                                </figure>

                                <div class="entry-body pb-4 text-center">
                                    <div class="entry-meta">
                                        <a href="#">{{ $blog->created_at->format('M d, Y') }}</a>,
                                        {{ $blog->comments->where('status', true)->count() }} Comments
                                    </div>

                                    <h3 class="entry-title">
                                        <a
                                            href="{{ route('frontend.blog.detail', $blog->slug) }}">{{ Str::limit($blog->title, 30) }}</a>
                                    </h3>

                                    <div class="entry-content">
                                        <p>{{ Str::limit(strip_tags($blog->short_description ?: $blog->description), 80) }}
                                        </p>
                                        <a href="{{ route('frontend.blog.detail', $blog->slug) }}" class="read-more">Read
                                            More</a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="text-center">
                        <p>No blog posts available.</p>
                    </div>
                @endif
            </div><!-- container -->

            <div class="more-container text-center mb-0 mt-3">
                <a href="{{ route('frontend.blog') }}" class="btn btn-outline-darker btn-more"><span>View more
                        articles</span><i class="icon-long-arrow-right"></i></a>
            </div>
        </div>
        <div class="cta cta-display bg-image pt-4 pb-4"
            style="background-image: url({{ asset('frontend/assets/images/backgrounds/cta/bg-6.jpg') }});">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-9 col-xl-8">
                        <div class="row no-gutters flex-column flex-sm-row align-items-sm-center">
                            <div class="col">
                                <h3 class="cta-title text-white">Sign Up & Get 10% Off</h3><!-- End .cta-title -->
                                <p class="cta-desc text-white">Molla presents the best in interior design</p>
                                <!-- End .cta-desc -->
                            </div><!-- End .col -->

                            <div class="col-auto">
                                <a href="{{ asset('login.html') }}" class="btn btn-outline-white"><span>SIGN UP</span><i
                                        class="icon-long-arrow-right"></i></a>
                            </div><!-- End .col-auto -->
                        </div><!-- End .row no-gutters -->
                    </div><!-- End .col-md-10 col-lg-9 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .cta -->
    </main>
@endsection
