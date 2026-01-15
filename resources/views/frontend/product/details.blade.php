@extends('frontend.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/nouislider/nouislider.css') }}">
    <style>
        .btn-wishlist.btn-wishlist-add:before {
            content: '\f233';
            color: #c96;
        }

        .btn-wishlist.btn-wishlist-add:before {
            content: '\f233';
            color: #c96;
        }

        /* Default state - add to wishlist */
        .btn-product-icon:hover span,
        .btn-product-icon:focus span {
            color: #fff;
            background-color: #c96;
        }

        /* When in wishlist - remove from wishlist */
        .btn-wishlist-add:hover,
        .btn-wishlist-add:focus {
            color: #fff;
            background-color: #fff;
        }

        .btn-wishlist-add:hover span,
        .btn-wishlist-add:focus span {
            color: #c96 !important;
            background-color: #fff !important;
        }

        .rating-input {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .rating-input input {
            display: none;
        }

        .rating-input label {
            font-size: 2rem;
            color: #ddd;
            cursor: pointer;
            margin-right: 5px;
        }

        .rating-input input:checked~label,
        .rating-input label:hover,
        .rating-input label:hover~label {
            color: #ffc107;
        }

        .review-avatar {
            min-width: 50px;
        }

        .review-form {
            background-color: #f8f9fa;
        }

        @media (max-width: 768px) {
            .product-details-top .row {
                margin: 0;
            }

            .product-details {
                padding: 1rem 0;
            }

            .product-title {
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }

            .product-price {
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }

            .details-filter-row {
                margin-bottom: 1rem;
            }

            .product-details-action {
                margin-top: 1.5rem;
            }

            .btn-product {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            .details-action-wrapper {
                margin-top: 0.5rem;
            }

            .details-action-wrapper .btn-product {
                width: 100%;
            }

            .product-details-footer {
                margin-top: 2rem;
                padding-top: 1rem;
            }

            .review-form {
                margin: 1rem;
                padding: 1rem;
            }

            .review {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .review-avatar {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
        }
    </style>
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
                                        <img src="{{ asset('frontend/assets/images/no-image.jpg') }}" alt="vb"
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
                                <h1 class="product-title">{{ $product->title }}</h1>

                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: {{ $product->averageRating() * 20 }}%;">
                                        </div>
                                    </div>
                                    <a class="ratings-text" href="#product-review-link" id="review-link">(
                                        {{ $product->reviewsCount() }} Reviews )</a>
                                </div>

                                <div class="product-price" data-base-price="{{ $product->price }}">
                                    @if ($product->hasDiscount())
                                        <span class="new-price">${{ number_format($product->price, 2) }}</span>
                                        <span class="old-price">${{ number_format($product->old_price, 2) }}</span>
                                    @else
                                        ${{ number_format($product->price, 2) }}
                                    @endif
                                </div>

                                @if ($product->short_description)
                                    <div class="product-content">
                                        <p>{{ $product->short_description }}</p>
                                    </div>
                                @endif

                                <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="color" id="selected-color"
                                        value="{{ $product->colors->first()->name ?? '' }}">

                                    @if ($product->colors->count() > 0)
                                        <div class="details-filter-row details-row-size">
                                            <label>Color:</label>
                                            <div class="product-nav product-nav-dots" id="color-options">
                                                @foreach ($product->colors as $index => $color)
                                                    <a href="javascript:void(0)" class="{{ $index == 0 ? 'active' : '' }}"
                                                        data-color="{{ $color->name }}"
                                                        style="background: {{ $color->color_code }};"
                                                        title="{{ $color->name }}">
                                                        <span class="sr-only">{{ $color->name }}</span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if ($product->productSizes->count() > 0)
                                        <div class="details-filter-row details-row-size">
                                            <label for="size">Size:</label>
                                            <div class="select-custom">
                                                <select name="size" id="size" class="form-control" required>
                                                    <option value="" data-price="0">Select a size</option>
                                                    @foreach ($product->productSizes as $size)
                                                        <option value="{{ $size->size_name }}"
                                                            data-price="{{ $size->additional_price }}">
                                                            {{ $size->size_name }}
                                                            (+${{ number_format($size->additional_price, 2) }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <a href="#" class="size-guide"><i class="icon-th-list"></i> size guide</a>
                                        </div>
                                    @endif

                                    <div class="details-filter-row details-row-size">
                                        <label for="qty">Qty:</label>
                                        <div class="product-details-quantity">
                                            <input type="number" name="qty" id="qty" class="form-control"
                                                value="1" min="1" max="10" step="1"
                                                data-decimals="0" required>
                                        </div>
                                    </div>

                                    <div class="product-details-action">
                                        <button type="submit" class="btn-product btn-cart" id="add-to-cart-button">
                                            <span id="cart-button-text">Add to Cart</span>
                                        </button>
                                        <div class="details-action-wrapper">
                                            <a href="#" class="btn-product btn-wishlist" id="wishlist-btn"
                                                data-product-id="{{ $product->id }}" title="Wishlist">
                                                <span id="wishlist-text">Add to Wishlist</span>
                                            </a>
                                        </div>
                                    </div>
                                </form>


                                {{-- <div class="product-details-footer">
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
                                </div><!-- End .product-details-footer --> --}}
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
                                role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews
                                ({{ $product->reviewsCount() }})</a>
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
                                <h3>Reviews ({{ $product->reviewsCount() }})</h3>

                                @auth
                                    @if ($hasPurchased && !$hasReviewed)
                                        <div class="review-form mb-4 p-3 border rounded">
                                            <h4 class="mb-3">Write a Review</h4>
                                            <form id="review-form">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <div class="form-group">
                                                    <label>Rating:</label>
                                                    <div class="rating-input">
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <input type="radio" name="rating" value="{{ $i }}"
                                                                id="star{{ $i }}" required>
                                                            <label for="star{{ $i }}">★</label>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="comment">Comment:</label>
                                                    <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Share your experience..."
                                                        required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit Review</button>
                                            </form>
                                        </div>
                                    @elseif(!$hasPurchased)
                                        <div class="text-center py-3 mb-4">
                                            <p class="text-muted mb-0">Only verified buyers can write reviews</p>
                                        </div>
                                    @elseif($hasReviewed)
                                        <div class="text-center py-3 mb-4">
                                            <p class="text-success mb-0">✓ You have reviewed this product</p>
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center py-3 mb-4">
                                        <p class="mb-0"><a href="#signin-modal" data-toggle="modal">Login</a> to write a
                                            review</p>
                                    </div>
                                @endauth

                                @if ($reviews->count() > 0)
                                    @foreach ($reviews as $review)
                                        <div class="review border-bottom pb-3 mb-3">
                                            <div class="row no-gutters">
                                                <div class="col-auto pr-3">
                                                    <div class="review-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 50px; height: 50px; font-size: 1.2rem; font-weight: bold;">
                                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <div>
                                                            <h5 class="mb-1">{{ $review->user->name }}</h5>
                                                            <div class="ratings-container mb-1">
                                                                <div class="ratings">
                                                                    <div class="ratings-val"
                                                                        style="width: {{ $review->rating * 20 }}%;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <small
                                                            class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                                    </div>
                                                    <div class="review-content">
                                                        <p class="mb-0">{{ $review->comment }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $reviews->links() }}
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="icon-star-o fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No reviews yet</h5>
                                        <p class="text-muted">Be the first to review this product!</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
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
                                        <a href="#"
                                            class="btn-product-icon btn-wishlist btn-expandable related-wishlist-btn"
                                            data-product-id="{{ $relatedProduct->id }}"><span>add to wishlist</span></a>

                                    </div><!-- End .product-action-vertical -->

                                    {{-- <div class="product-action">
                                        <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                    </div><!-- End .product-action --> --}}
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
                                            <div class="ratings-val" style="width: {{ $relatedProduct->averageRating() * 20 }}%;"></div><!-- End .ratings-val -->
                                        </div><!-- End .ratings -->
                                        <span class="ratings-text">( {{ $relatedProduct->reviewsCount() }} Reviews )</span>
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
    <script src="{{ asset('frontend/assets/js/jquery.elevateZoom.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap-input-spinner.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
                // Price update functionality
                const sizeSelector = document.getElementById('size');
                const priceContainer = document.querySelector('.product-price');

                if (sizeSelector && priceContainer) {
                    const basePrice = parseFloat(priceContainer.getAttribute('data-base-price'));
                    const originalPriceHTML = priceContainer.innerHTML;

                    sizeSelector.addEventListener('change', function() {
                        const selectedOption = this.options[this.selectedIndex];
                        const additionalPrice = parseFloat(selectedOption.getAttribute('data-price'));

                        if (!isNaN(additionalPrice) && additionalPrice >= 0) {
                            if (additionalPrice === 0) {
                                priceContainer.innerHTML = originalPriceHTML;
                            } else {
                                const totalPrice = basePrice + additionalPrice;
                                const newPriceHTML = `<span class="new-price">$${totalPrice.toFixed(2)}</span>`;
                                priceContainer.innerHTML = newPriceHTML;
                            }
                        }

                        // Check cart status when size changes
                        checkCartStatus();
                    });
                }

                // Color selection
                const colorOptions = document.querySelectorAll('#color-options a');
                const selectedColorInput = document.getElementById('selected-color');

                colorOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        // Update active class
                        colorOptions.forEach(opt => opt.classList.remove('active'));
                        this.classList.add('active');

                        // Update hidden input value
                        selectedColorInput.value = this.dataset.color;

                        // Check cart status when color changes
                        checkCartStatus();
                    });
                });

                // AJAX Add to Cart functionality
                const addToCartForm = document.getElementById('add-to-cart-form');
                const addToCartButton = document.getElementById('add-to-cart-button');
                const buttonText = document.getElementById('cart-button-text');

                addToCartForm.addEventListener('submit', function(e) {
                    e.preventDefault(); // Prevent default form submission

                    // Disable button to prevent double submission
                    addToCartButton.disabled = true;
                    const originalText = buttonText.textContent;
                    buttonText.textContent = 'Adding...';

                    // Get form data
                    const formData = new FormData(addToCartForm);

                    // Convert FormData to JSON
                    const formObject = {};
                    formData.forEach((value, key) => {
                        formObject[key] = value;
                    });

                    // Make AJAX request
                    fetch('{{ route('cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify(formObject)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success toast
                                if (window.CartManager) {
                                    window.CartManager.showToast(data.message, 'success');

                                    // Update header cart count
                                    window.CartManager.updateHeaderCart({
                                        itemsCount: data.itemsCount,
                                        cartTotal: data.cartTotal
                                    });

                                    // Refresh cart dropdown
                                    window.CartManager.refreshCartDropdown();
                                }

                                // Re-check cart status to update button
                                checkCartStatus();
                            } else {
                                // Show error toast
                                if (window.CartManager) {
                                    window.CartManager.showToast(data.message, 'error');
                                }

                                // Re-enable button
                                addToCartButton.disabled = false;
                                buttonText.textContent = originalText;
                            }
                        })
                        .catch(error => {
                            console.error('Error adding to cart:', error);

                            // Show error toast
                            if (window.CartManager) {
                                window.CartManager.showToast('Error adding product to cart', 'error');
                            }

                            // Re-enable button
                            addToCartButton.disabled = false;
                            buttonText.textContent = originalText;
                        });
                });

                // Function to check if current variant is in cart
                function checkCartStatus() {
                    const color = document.getElementById('selected-color').value;
                    const sizeSelect = document.getElementById('size');
                    const size = sizeSelect ? sizeSelect.value : 'no-size';
                    const productId = {{ $product->id }};

                    // If size is required but not selected yet, reset button and don't check
                    if (sizeSelect && sizeSelect.required && !size) {
                        resetToAddButton();
                        return;
                    }

                    // Make AJAX request to check cart status
                    fetch('{{ route('cart.check') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                color: color,
                                size: size
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.in_cart) {
                                convertToViewCartLink();
                            } else {
                                resetToAddButton();
                            }
                        })
                        .catch(error => {
                            console.error('Error checking cart status:', error);
                            resetToAddButton();
                        });
                }

                // Helper function to reset back to original Add to Cart button
                function resetToAddButton() {
                    const addButton = document.getElementById('add-to-cart-button');
                    const buttonText = document.getElementById('cart-button-text');

                    if (addButton.tagName === 'A') {
                        // If it's currently a link, replace it with original button
                        const newButton = document.createElement('button');
                        newButton.type = 'submit';
                        newButton.className = 'btn-product btn-cart';
                        newButton.id = 'add-to-cart-button';
                        newButton.innerHTML = '<span id="cart-button-text">Add to Cart</span>';

                        addButton.parentNode.replaceChild(newButton, addButton);
                    } else {
                        addButton.classList.remove('disabled');
                        addButton.disabled = false;
                        buttonText.textContent = 'Add to Cart';
                    }
                }

                // Helper function to convert button to View Cart link
                function convertToViewCartLink() {
                    const addButton = document.getElementById('add-to-cart-button');

                    // Create a new <a> element styled as button
                    const viewCartLink = document.createElement('a');
                    viewCartLink.href = '{{ route('cart.index') }}';
                    viewCartLink.className = 'btn-product btn-cart'; // Reuse same classes for styling
                    viewCartLink.id = 'add-to-cart-button'; // Keep same ID for consistency
                    viewCartLink.innerHTML = '<span id="cart-button-text">View Cart</span>';

                    // Replace the button with the link
                    addButton.parentNode.replaceChild(viewCartLink, addButton);
                }

                // Initial check on page load
                setTimeout(checkCartStatus, 500);
                document.addEventListener('cartUpdated', function() {
                    checkCartStatus();
                });

                // Wishlist functionality
                const wishlistBtn = document.getElementById('wishlist-btn');
                const wishlistText = document.getElementById('wishlist-text');

                if (wishlistBtn) {
                    // Check initial wishlist status
                    checkWishlistStatus();

                    wishlistBtn.addEventListener('click', function(e) {
                            e.preventDefault();

                            @guest
                            // Show login modal for guests
                            $('#signin-modal').modal('show');
                            return;
                        @endguest

                        const productId = this.dataset.productId;

                        // Disable button during request
                        wishlistBtn.style.pointerEvents = 'none'; wishlistText.textContent = 'Processing...';

                        fetch('{{ route('wishlist.toggle') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                product_id: productId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update button state
                                if (data.in_wishlist) {
                                    wishlistBtn.classList.add('btn-wishlist-add');
                                    wishlistText.textContent = 'Remove from Wishlist';
                                } else {
                                    wishlistBtn.classList.remove('btn-wishlist-add');
                                    wishlistText.textContent = 'Add to Wishlist';
                                }

                                // Update header heart icon
                                updateHeaderHeartIcon(data.wishlist_count > 0);

                                // Update header wishlist count
                                const wishlistCount = document.getElementById('wishlist-count');
                                if (wishlistCount) {
                                    wishlistCount.textContent = `(${data.wishlist_count})`;
                                }

                                // Show toast message
                                if (window.CartManager) {
                                    window.CartManager.showToast(data.message, 'success');
                                }
                            } else {
                                if (window.CartManager) {
                                    window.CartManager.showToast(data.message, 'error');
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            if (window.CartManager) {
                                window.CartManager.showToast('Error updating wishlist', 'error');
                            }
                        })
                        .finally(() => {
                            // Re-enable button
                            wishlistBtn.style.pointerEvents = 'auto';
                        });
                    });
            }

            function checkWishlistStatus() {
                @auth
                const productId = {{ $product->id }};

                fetch('{{ route('wishlist.toggle') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            check_only: true
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.in_wishlist) {
                            wishlistBtn.classList.add('btn-wishlist-add');
                            wishlistText.textContent = 'Remove from Wishlist';
                        }
                        // Update header heart icon on page load
                        updateHeaderHeartIcon(data.in_wishlist);
                    })
                    .catch(error => {
                        console.error('Error checking wishlist status:', error);
                    });
            @endauth
        }

        // Related products wishlist functionality
        const relatedWishlistBtns = document.querySelectorAll('.related-wishlist-btn');

        relatedWishlistBtns.forEach(btn => {
            // Check initial wishlist status for related products
            @auth
            const productId = btn.dataset.productId;
            fetch('{{ route('wishlist.toggle') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        check_only: true
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.in_wishlist) {
                        btn.classList.add('btn-wishlist-add');
                        btn.querySelector('span').textContent = 'remove from wishlist';
                    }
                })
                .catch(error => {
                    console.error('Error checking related product wishlist status:', error);
                });
        @endauth

        btn.addEventListener('click', function(e) {
                e.preventDefault();

                @guest
                $('#signin-modal').modal('show');
                return;
            @endguest

            const productId = this.dataset.productId;
            const span = this.querySelector('span');

            this.style.pointerEvents = 'none'; span.textContent = 'processing...';

            fetch('{{ route('wishlist.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.in_wishlist) {
                        this.classList.add('btn-wishlist-add');
                        span.textContent = 'remove from wishlist';
                    } else {
                        this.classList.remove('btn-wishlist-add');
                        span.textContent = 'add to wishlist';
                    }

                    const wishlistCount = document.getElementById('wishlist-count');
                    if (wishlistCount) {
                        wishlistCount.textContent = `(${data.wishlist_count})`;
                    }

                    if (window.CartManager) {
                        window.CartManager.showToast(data.message, 'success');
                    }
                } else {
                    if (window.CartManager) {
                        window.CartManager.showToast(data.message, 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (window.CartManager) {
                    window.CartManager.showToast('Error updating wishlist', 'error');
                }
            })
            .finally(() => {
                this.style.pointerEvents = 'auto';
            });
        });
        });

        function updateHeaderHeartIcon(hasItems) {
            const heartIcon = document.getElementById('header-wishlist-icon');
            if (heartIcon) {
                if (hasItems) {
                    heartIcon.className = 'icon-heart';
                    heartIcon.style.color = 'rgb(204, 153, 102)';
                } else {
                    heartIcon.className = 'icon-heart-o';
                    heartIcon.style.color = '';
                }
            }
        }

        // Check if we should show review tab (for pagination or direct link)
        const urlParams = new URLSearchParams(window.location.search);
        const hash = window.location.hash;

        if (urlParams.has('page') || hash === '#product-review-tab') {
            // Activate review tab
            const reviewTab = document.getElementById('product-review-link');
            const reviewTabPane = document.getElementById('product-review-tab');
            const descTab = document.getElementById('product-desc-link');
            const descTabPane = document.getElementById('product-desc-tab');

            if (reviewTab && reviewTabPane && descTab && descTabPane) {
                // Remove active from description tab
                descTab.classList.remove('active');
                descTabPane.classList.remove('show', 'active');

                // Add active to review tab
                reviewTab.classList.add('active');
                reviewTabPane.classList.add('show', 'active');

                // Update aria attributes
                descTab.setAttribute('aria-selected', 'false');
                reviewTab.setAttribute('aria-selected', 'true');
            }
        }

        // Review form functionality
        const reviewForm = document.getElementById('review-form');
        if (reviewForm) {
            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(reviewForm);
                const formObject = {};
                formData.forEach((value, key) => {
                    formObject[key] = value;
                });

                fetch('{{ route('review.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify(formObject)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error submitting review');
                    });
            });
        }
        });
    </script>
@endsection
