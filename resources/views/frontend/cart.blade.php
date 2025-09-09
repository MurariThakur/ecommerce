@extends('frontend.layouts.app')
@section('content')
<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Shopping Cart<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="cart">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        @if(Cart::isEmpty())
                            <div class="alert alert-info">
                                Your cart is empty. <a href="{{ route('frontend.home') }}">Continue shopping</a>
                            </div>
                        @else
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
                                @foreach(Cart::getContent() as $item)
                                <tr id="cart-item-{{ $item->id }}">
                                    <td class="product-col">
                                        <div class="product">
                                            <figure class="product-media">
                                                <a href="#">
                                                    <img src="{{ $item->attributes->image ?? 'assets/images/products/table/product-1.jpg' }}" alt="Product image">
                                                </a>
                                            </figure>

                                            <h3 class="product-title">
                                                <a href="#">{{ $item->name }}</a>
                                            </h3><!-- End .product-title -->

                                            @if($item->attributes->color || $item->attributes->size)
                                            <div class="product-details">
                                                @if($item->attributes->color)
                                                    <span class="color-dot" style="background: {{ $item->attributes->color }}; display: inline-block; width: 15px; height: 15px; border-radius: 50%;"></span>
                                                    {{ $item->attributes->color }}
                                                @endif
                                                @if($item->attributes->size)
                                                    {{ $item->attributes->size ? 'Size: ' . $item->attributes->size : '' }}
                                                @endif
                                            </div>
                                            @endif
                                        </div><!-- End .product -->
                                    </td>
                                    <td class="price-col">$<span class="item-price">{{ number_format($item->price, 2) }}</span></td>
                                    <td class="quantity-col">
                                        <div class="cart-product-quantity">
                                            <input type="number"
                                                   class="form-control quantity-input"
                                                   value="{{ $item->quantity }}"
                                                   min="1"
                                                   max="10"
                                                   step="1"
                                                   data-decimals="0"
                                                   data-rowid="{{ $item->id }}"
                                                   required>
                                        </div><!-- End .cart-product-quantity -->
                                    </td>
                                    <td class="total-col">$<span class="item-total">{{ number_format($item->price * $item->quantity, 2) }}</span></td>
                                    <td class="remove-col">
                                        <button class="btn-remove remove-item" data-rowid="{{ $item->id }}">
                                            <i class="icon-close"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table><!-- End .table table-wishlist -->

                        <div class="cart-bottom">

                            <a href="{{ route('cart.clear') }}" class="btn btn-outline-dark-2 clear-cart">
                                <span>CLEAR CART</span><i class="icon-trash"></i>
                            </a>
                        </div><!-- End .cart-bottom -->
                        @endif
                    </div><!-- End .col-lg-9 -->

                    <aside class="col-lg-3">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                            <table class="table table-summary">
                                <tbody>
                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td id="cart-subtotal">${{ number_format(Cart::getSubTotal(), 2) }}</td>
                                    </tr>

                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td id="cart-total">${{ number_format(Cart::getTotal(), 2) }}</td>
                                    </tr><!-- End .summary-total -->
                                </tbody>
                            </table><!-- End .table table-summary -->

                            <a href="{{ url('/checkout') }}"class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                        </div><!-- End .summary -->


                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .cart -->
    </div><!-- End .page-content -->
</main>
@endsection

@section('scripts')

@endsection
