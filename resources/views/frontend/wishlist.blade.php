@extends('frontend.layouts.app')

@section('title', 'My Wishlist')

@section('content')
    <main class="main">
        <div class="page-header text-center"
            style="background-image: url('{{ asset('frontend/assets/images/page-header-bg.jpg') }}')">
            <div class="container">
                <h1 class="page-title">My Wishlist</h1>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Wishlist</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="container">
                @if ($wishlists->count() > 0)
                    <div class="products mb-3">
                        <div class="row justify-content-center">
                            @foreach ($wishlists as $wishlist)
                                <div class="col-6 col-md-4 col-lg-4 col-xl-3"
                                    id="wishlist-item-{{ $wishlist->product->id }}">
                                    <div class="product product-7 text-center">
                                        <figure class="product-media">
                                            @if ($wishlist->product->hasDiscount())
                                                <span class="product-label label-sale">Sale</span>
                                            @endif
                                            <a
                                                href="{{ url($wishlist->product->category->slug . '/' . $wishlist->product->subcategory->slug . '/' . $wishlist->product->slug) }}">
                                                @if ($wishlist->product->productImages->count() > 0)
                                                    <img src="{{ $wishlist->product->productImages->first()->image_src }}"
                                                        alt="{{ $wishlist->product->title }}" class="product-image">
                                                @else
                                                    <img src="{{ asset('frontend/assets/images/no-image.jpg') }}"
                                                        alt="{{ $wishlist->product->title }}" class="product-image">
                                                @endif
                                            </a>

                                            <div class="product-action-vertical">
                                                <a href="#"
                                                    class="btn-product-icon btn-wishlist btn-expandable wishlist-remove-btn"
                                                    data-product-id="{{ $wishlist->product->id }}"
                                                    title="Remove from wishlist">
                                                    <span>remove from wishlist</span>
                                                </a>
                                            </div>

                                            <div class="product-action">
                                                <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                            </div>
                                        </figure>

                                        <div class="product-body">
                                            <div class="product-cat">
                                                <a
                                                    href="{{ url($wishlist->product->category->slug . '/' . $wishlist->product->subcategory->slug) }}">
                                                    {{ $wishlist->product->subcategory->name }}
                                                </a>
                                            </div>
                                            <h3 class="product-title">
                                                <a
                                                    href="{{ url($wishlist->product->category->slug . '/' . $wishlist->product->subcategory->slug . '/' . $wishlist->product->slug) }}">
                                                    {{ Str::limit($wishlist->product->title, 50) }}
                                                </a>
                                            </h3>
                                            <div class="product-price">
                                                @if ($wishlist->product->hasDiscount())
                                                    <span
                                                        class="new-price">${{ number_format($wishlist->product->price, 2) }}</span>
                                                    <span
                                                        class="old-price">${{ number_format($wishlist->product->old_price, 2) }}</span>
                                                @else
                                                    ${{ number_format($wishlist->product->price, 2) }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{ $wishlists->links() }}
                @else
                    <div class="text-center py-5">
                        <i class="icon-heart-o" style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;"></i>
                        <h4>Your wishlist is empty</h4>
                        <p class="text-muted">Start adding products you love to your wishlist</p>
                        <a href="{{ url('/') }}" class="btn btn-outline-primary-2">
                            <span>Continue Shopping</span>
                            <i class="icon-long-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const removeButtons = document.querySelectorAll('.wishlist-remove-btn');

            removeButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const productId = this.dataset.productId;
                    const productItem = document.getElementById(`wishlist-item-${productId}`);

                    this.style.pointerEvents = 'none';

                    fetch('{{ route('wishlist.remove') }}', {
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
                                productItem.style.transition = 'opacity 0.3s ease';
                                productItem.style.opacity = '0';

                                setTimeout(() => {
                                    productItem.remove();

                                    const remainingItems = document.querySelectorAll(
                                        '[id^="wishlist-item-"]');
                                    if (remainingItems.length === 0) {
                                        location.reload();
                                    }
                                }, 300);

                                const wishlistCount = document.getElementById('wishlist-count');
                                if (wishlistCount) {
                                    wishlistCount.textContent = `(${data.wishlist_count})`;
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.style.pointerEvents = 'auto';
                        });
                });
            });
        });
    </script>
@endsection
