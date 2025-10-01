@extends('frontend.layouts.app')
@section('styles')
    <style>
        /* Cart page only */

        .product-details {
            display: flex;
            align-items: center;
            /* vertically center dot + text */
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .color-dot {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            display: inline-block;
            flex: 0 0 15px;
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.06) inset;
        }

        .color-text {
            line-height: 1;
            font-size: 1.3rem;
            text-transform: capitalize;
        }
    </style>
@endsection
@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('{{ asset('frontend/assets/images/page-header-bg.jpg') }}')">
            <div class="container">
                <h1 class="page-title">Shopping Cart</h1>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="cart">
                <div class="container">
                    <div class="row">
                        @if (Cart::isEmpty())
                            <div class="col-lg-12">
                                <div class="text-center py-5">
                                    <h4>Your cart is empty</h4>
                                    <a href="/" class="btn btn-primary mt-3">Continue Shopping</a>
                                </div>
                            </div>
                        @else
                            <!-- Cart Items -->
                            <div class="col-lg-9">
                                <table class="table table-cart table-mobile">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (Cart::getContent() as $item)
                                            <tr id="cart-item-{{ $item->id }}">
                                                <td class="product-col">
                                                    <div class="product d-flex align-items-center">
                                                        <figure class="product-media me-3">
                                                            <a href="{{ $item->attributes->url ?? '#' }}">
                                                                <img src="{{ $item->attributes->image ?? 'assets/images/products/table/product-1.jpg' }}"
                                                                    alt="Product image">
                                                            </a>
                                                        </figure>
                                                        <div>
                                                            <h3 class="product-title">
                                                                <a href="{{ $item->attributes->url ?? '#' }}">{{ $item->name }}</a>
                                                            </h3>
                                                           @if ($item->attributes->color || $item->attributes->size)
                                                                <div class="d-flex align-items-center flex-wrap small text-muted">
                                                                    @if ($item->attributes->color)
                                                                        <span class="d-inline-block rounded-circle me-2 border"
                                                                              style="width:15px; height:15px; background: {{ $item->attributes->color }}">
                                                                        </span>
                                                                        <span style="font-size: 1.5rem;padding-left:0.5rem">{{ ucfirst($item->attributes->color) }}</span>
                                                                    @endif

                                                                    @if ($item->attributes->size)
                                                                        <span style="padding-left: 1.5rem;font-size: 1.3rem">Size: <strong>{{ strtoupper($item->attributes->size) }}</strong></span>
                                                                    @endif
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="price-col">
                                                    $<span class="item-price">{{ number_format($item->price, 2) }}</span>
                                                </td>
                                                <td class="quantity-col">
                                                    <div class="cart-product-quantity">
                                                        <input type="number" class="form-control quantity-input"
                                                            value="{{ $item->quantity }}" min="1" max="10"
                                                            step="1" data-decimals="0"
                                                            data-rowid="{{ $item->id }}" required>
                                                    </div>
                                                </td>
                                                <td class="total-col">
                                                    $<span
                                                        class="item-total">{{ number_format($item->price * $item->quantity, 2) }}</span>
                                                </td>
                                                <td class="remove-col">
                                                    <button class="btn-remove remove-item"
                                                        data-rowid="{{ $item->id }}">
                                                        <i class="icon-close"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="cart-bottom d-flex justify-content-between">
                                    <a href="{{ route('cart.clear') }}" class="btn btn-outline-dark-2 clear-cart">
                                        <span>CLEAR CART</span><i class="icon-trash ms-1"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Cart Summary -->
                            <aside class="col-lg-3">
                                <div class="summary summary-cart">
                                    <h3 class="summary-title">Cart Total</h3>
                                    <table class="table table-summary">
                                        <tbody>
                                            <tr class="summary-subtotal">
                                                <td>Subtotal:</td>
                                                <td id="cart-subtotal">${{ number_format(Cart::getSubTotal(), 2) }}</td>
                                            </tr>
                                            <tr class="summary-total">
                                                <td>Total:</td>
                                                <td id="cart-total">${{ number_format(Cart::getTotal(), 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <a href="{{ url('/checkout') }}" class="btn btn-outline-primary-2 btn-order btn-block">
                                        PROCEED TO CHECKOUT
                                    </a>
                                </div>
                            </aside>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Show success message from URL parameter using existing toast system
    const urlParams = new URLSearchParams(window.location.search);
    const successMessage = urlParams.get('success');
    if (successMessage) {
        CartManager.showToast(successMessage, 'success');
        
        // Clean URL by removing success parameter
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});
</script>
@endsection
