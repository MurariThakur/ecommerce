@extends('frontend.layouts.app')

@section('styles')
    <style>
        .empty-wishlist {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .empty-wishlist-icon {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 1.5rem;
        }

        .product-item {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .product-7 {
            border: none;
            box-shadow: none;
        }

        .wishlist-item-remove {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #dc3545;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .wishlist-item-remove:hover {
            background: #dc3545;
            color: white;
            transform: scale(1.1);
        }

        .product-media {
            position: relative;
            overflow: hidden;
        }

        .product-image {
            transition: transform 0.3s ease;
        }

        .product-item:hover .product-image {
            transform: scale(1.05);
        }


        .btn-continue-shopping {
            background: linear-gradient(135deg, #c96 0%, #bf8040 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-continue-shopping:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(201, 153, 102, 0.4);
            color: white;
        }

        .btn-clear-wishlist {
            background: #dc3545;
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-clear-wishlist:hover {
            background: #c82333;
            transform: translateY(-1px);
            color: white;
        }
    </style>
@endsection

@section('title', 'My Wishlist')

@section('content')
    <main class="main">
        <div class="page-header text-center"
            style="background-image: url('{{ asset('frontend/assets/images/page-header-bg.jpg') }}')">
            <div class="container">
                <h1 class="page-title">My Wishlist</h1>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav">
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
                    <div class="products mb-4">
                        <div class="row">
                            @foreach ($wishlists as $wishlist)
                                <div class="col-6 col-md-4 col-lg-3" id="wishlist-item-{{ $wishlist->product->id }}">
                                    <div class="product-item">
                                        <div class="product product-7 text-center">
                                            <figure class="product-media">
                                                @if ($wishlist->product->hasDiscount())
                                                    <span class="product-label label-sale">Sale</span>
                                                @endif

                                                <div class="wishlist-item-remove"
                                                    onclick="removeFromWishlist({{ $wishlist->product->id }})">
                                                    <i class="icon-close"></i>
                                                </div>

                                                <a
                                                    href="{{ url($wishlist->product->category->slug . '/' . $wishlist->product->subcategory->slug . '/' . $wishlist->product->slug) }}">
                                                    @if ($wishlist->product->productImages->count() > 0)
                                                        <img src="{{ $wishlist->product->productImages->first()->image_src }}"
                                                            alt="{{ $wishlist->product->title }}" class="product-image"
                                                            style="width: 100%; height: 250px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('frontend/assets/images/no-image.jpg') }}"
                                                            alt="{{ $wishlist->product->title }}" class="product-image"
                                                            style="width: 100%; height: 250px; object-fit: cover;">
                                                    @endif
                                                </a>

                                            </figure>

                                            <div class="product-body p-3">
                                                <div class="product-cat">
                                                    <a
                                                        href="{{ url($wishlist->product->category->slug . '/' . $wishlist->product->subcategory->slug) }}">
                                                        {{ $wishlist->product->subcategory->name }}
                                                    </a>
                                                </div>
                                                <h3 class="product-title">
                                                    <a
                                                        href="{{ url($wishlist->product->category->slug . '/' . $wishlist->product->subcategory->slug . '/' . $wishlist->product->slug) }}">
                                                        {{ Str::limit($wishlist->product->title, 40) }}
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
                                                <div class="text-muted small mt-2">
                                                    Added {{ $wishlist->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>



                    <div class="d-flex justify-content-center mt-4">
                        {{ $wishlists->links() }}
                    </div>
                @else
                    <div class="empty-wishlist">
                        <div class="empty-wishlist-icon">
                            <i class="icon-heart-o"></i>
                        </div>
                        <h3 class="mb-3">Your wishlist is empty</h3>
                        <p class="text-muted mb-4">Discover amazing products and save your favorites for later</p>
                        <a href="{{ url('/') }}" class="btn btn-continue-shopping">
                            <i class="icon-shopping-cart mr-2"></i>Start Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        function removeFromWishlist(productId) {
            const productItem = document.getElementById(`wishlist-item-${productId}`);

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
                        productItem.style.transition = 'all 0.3s ease';
                        productItem.style.transform = 'scale(0.8)';
                        productItem.style.opacity = '0';

                        setTimeout(() => {
                            productItem.remove();

                            const remainingItems = document.querySelectorAll('[id^="wishlist-item-"]');
                            if (remainingItems.length === 0) {
                                location.reload();
                            }
                        }, 300);

                        const wishlistCount = document.getElementById('wishlist-count');
                        if (wishlistCount) {
                            wishlistCount.textContent = `(${data.wishlist_count})`;
                        }

                        if (window.CartManager) {
                            window.CartManager.showToast('Item removed from wishlist', 'success');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (window.CartManager) {
                        window.CartManager.showToast('Error removing item', 'error');
                    }
                });
        }

        function clearAllWishlist() {
            if (!confirm('Are you sure you want to clear your entire wishlist?')) return;

            // This would need a backend route to clear all wishlist items
            if (window.CartManager) {
                window.CartManager.showToast('Feature coming soon!', 'info');
            }
        }
    </script>
@endsection
