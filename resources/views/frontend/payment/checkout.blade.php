@extends('frontend.layouts.app')
@section('styles')
    <style>
        .table.table-summary .summary-shipping-estimate td {
            padding-bottom: 0;
        }
    </style>
@endsection
@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Checkout<span>Shop</span></h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="checkout">
                <div class="container">
                    <form action="#" id="checkout-form">
                        <div class="row">
                            <div class="col-lg-9">
                                <h2 class="checkout-title">Billing Details</h2><!-- End .checkout-title -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>First Name *</label>
                                        <input type="text" class="form-control" required>
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>Last Name *</label>
                                        <input type="text" class="form-control" required>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <label>Company Name (Optional)</label>
                                <input type="text" class="form-control">

                                <label>Country *</label>
                                <input type="text" class="form-control" required>

                                <label>Street address *</label>
                                <input type="text" class="form-control" placeholder="House number and Street name"
                                    required>
                                <input type="text" class="form-control" placeholder="Appartments, suite, unit etc ..."
                                    required>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Town / City *</label>
                                        <input type="text" class="form-control" required>
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>State / County *</label>
                                        <input type="text" class="form-control" required>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Postcode / ZIP *</label>
                                        <input type="text" class="form-control" required>
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>Phone *</label>
                                        <input type="tel" class="form-control" required>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <label>Email address *</label>
                                <input type="email" class="form-control" required>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkout-create-acc">
                                    <label class="custom-control-label" for="checkout-create-acc">Create an account?</label>
                                </div><!-- End .custom-checkbox -->

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkout-diff-address">
                                    <label class="custom-control-label" for="checkout-diff-address">Ship to a different
                                        address?</label>
                                </div><!-- End .custom-checkbox -->

                                <label>Order notes (optional)</label>
                                <textarea class="form-control" cols="30" rows="4"
                                    placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                            </div><!-- End .col-lg-9 -->
                            <aside class="col-lg-3">
                                <div class="summary">
                                    <h3 class="summary-title">Your Order</h3><!-- End .summary-title -->

                                    <table class="table table-summary">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach (Cart::getContent() as $item)
                                                <tr>
                                                    <td>
                                                        <a href="#">{{ $item->name }}</a>

                                                        @if ($item->attributes->color || $item->attributes->size)
                                                            <div
                                                                class="d-flex align-items-center flex-wrap small text-muted">
                                                                @if ($item->attributes->color)
                                                                    <span class="d-inline-block rounded-circle me-2 border"
                                                                        style="width:15px; height:15px; background: {{ $item->attributes->color }}">
                                                                    </span>
                                                                    <span
                                                                        style="font-size: 1.5rem;padding-left:0.5rem">{{ ucfirst($item->attributes->color) }}</span>
                                                                @endif

                                                                @if ($item->attributes->size)
                                                                    <span
                                                                        style="padding-left: 1.5rem;font-size: 1.3rem">Size:
                                                                        <strong>{{ strtoupper($item->attributes->size) }}</strong></span>
                                                                @endif
                                                            </div>
                                                        @endif

                                                        <div>
                                                            <span class="fw-semibold">{{ $item->quantity }}</span>
                                                            <span class="text-muted">x</span>
                                                            <span
                                                                class="fw-semibold">${{ number_format($item->price, 2) }}</span>
                                                        </div>
                                                    </td>

                                                    {{-- Line total = price × quantity --}}
                                                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                                </tr>
                                            @endforeach

                                            <tr class="summary-subtotal">
                                                <td>Subtotal:</td>
                                                <td>${{ number_format(Cart::getSubTotal(), 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="cart-discount mt-1">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="discount_code"
                                                                name="discount_code" placeholder="Enter discount code">
                                                            <div class="input-group-append" style="height:40px">
                                                                <button class="btn btn-outline-primary-2" type="button"
                                                                    id="apply-discount-btn">
                                                                    <i class="icon-long-arrow-right"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div id="discount-error" class="text-danger mb-1 text-center"
                                                            style="display: none;"></div>
                                                        <div id="discount-success" class="text-success mb-1 text-center"
                                                            style="display: none;"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="display: none;" id="discount-row">
                                                <td colspan="2">
                                                    <div
                                                        class="d-flex justify-content-between align-items-center mb-2 mt-1">
                                                        <span>Discount: <strong id="applied-discount-name"></strong></span>
                                                        <span class="text-right">-$<span
                                                                id="discount-amount">0.00</span></span>
                                                    </div>
                                                    <div class="text-center">
                                                        <button type="button" id="remove-discount"
                                                            class="btn btn-outline-primary-2 mb-1">
                                                            Remove Discount
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tr>
                                            <tr class="summary-shipping">
                                                <td>Shipping:</td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            @if ($isFreeShipping)
                                                <tr class="summary-shipping-row">
                                                    <td>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="free-shipping" name="shipping"
                                                                class="custom-control-input" value="0"
                                                                data-price="0" checked>
                                                            <label class="custom-control-label" for="free-shipping">
                                                                Free Shipping
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>$0.00</td>
                                                </tr>
                                            @else
                                                @forelse($shippingMethods as $shipping)
                                                    <tr class="summary-shipping-row">
                                                        <td>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="shipping-{{ $shipping->id }}"
                                                                    name="shipping" class="custom-control-input"
                                                                    value="{{ $shipping->id }}"
                                                                    data-price="{{ $shipping->price }}"
                                                                    {{ $loop->first ? 'checked' : '' }}>
                                                                <label class="custom-control-label"
                                                                    for="shipping-{{ $shipping->id }}">
                                                                    {{ $shipping->name }}
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>${{ number_format($shipping->price, 2) }}</td>
                                                    </tr>
                                                @empty
                                                    <tr class="summary-shipping-row">
                                                        <td>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="free-shipping" name="shipping"
                                                                    class="custom-control-input" value="0"
                                                                    data-price="0" checked>
                                                                <label class="custom-control-label" for="free-shipping">
                                                                    Free Shipping
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>$0.00</td>
                                                    </tr>
                                                @endforelse
                                                @if ($freeShippingEnabled)
                                                    <tr>
                                                        <td colspan="2">
                                                            <small class="text-muted">
                                                                <i class="fas fa-info-circle"></i>
                                                                Free shipping above
                                                                ${{ number_format($freeShippingThreshold, 2) }}
                                                            </small>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif

                                            <tr class="summary-shipping-estimate">
                                                <td style="padding-bottom: 0"></td>
                                                <td></td>
                                            </tr><!-- End .summary-shipping-estimate -->
                                            <tr class="summary-total">
                                                <td>Total:</td>
                                                <td>${{ number_format($total, 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>


                                    <div class="accordion-summary" id="accordion-payment">

                                        <div class="card">
                                            <div class="card-header" id="heading-3">
                                                <h2 class="card-title">
                                                    <a class="collapsed" role="button" data-toggle="collapse"
                                                        href="#collapse-3" aria-expanded="false"
                                                        aria-controls="collapse-3">
                                                        Cash on delivery
                                                    </a>
                                                </h2>
                                            </div><!-- End .card-header -->
                                            <div id="collapse-3" class="collapse" aria-labelledby="heading-3"
                                                data-parent="#accordion-payment">

                                            </div><!-- End .collapse -->
                                        </div><!-- End .card -->

                                        <div class="card">
                                            <div class="card-header" id="heading-4">
                                                <h2 class="card-title">
                                                    <a class="collapsed" role="button" data-toggle="collapse"
                                                        href="#collapse-4" aria-expanded="false"
                                                        aria-controls="collapse-4">
                                                        PayPal
                                                    </a>
                                                </h2>
                                            </div><!-- End .card-header -->
                                            <div id="collapse-4" class="collapse" aria-labelledby="heading-4"
                                                data-parent="#accordion-payment">
                                            </div><!-- End .collapse -->
                                        </div><!-- End .card -->

                                        <div class="card">
                                            <div class="card-header" id="heading-5">
                                                <h2 class="card-title">
                                                    <a class="collapsed" role="button" data-toggle="collapse"
                                                        href="#collapse-5" aria-expanded="false"
                                                        aria-controls="collapse-5">
                                                        Credit Card (Stripe)
                                                        <img src="{{ asset('frontend/assets/images/payments-summary.png') }}"
                                                            alt="payments cards">
                                                    </a>
                                                </h2>
                                            </div><!-- End .card-header -->
                                            <div id="collapse-5" class="collapse" aria-labelledby="heading-5"
                                                data-parent="#accordion-payment">
                                            </div><!-- End .collapse -->
                                        </div><!-- End .card -->
                                    </div><!-- End .accordion -->

                                    <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                                        <span class="btn-text">Place Order</span>
                                        <span class="btn-hover-text">Proceed to Checkout</span>
                                    </button>
                                </div><!-- End .summary -->
                            </aside><!-- End .col-lg-3 -->
                        </div><!-- End .row -->
                    </form>
                </div><!-- End .container -->
            </div><!-- End .checkout -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection
