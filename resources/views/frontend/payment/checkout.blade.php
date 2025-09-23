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
                    <form action="{{ route('order.place') }}" method="POST" id="checkout-form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-9">
                                <h2 class="checkout-title">Billing Details</h2><!-- End .checkout-title -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>First Name *</label>
                                        <input type="text" name="first_name" class="form-control" value="{{ auth()->check() ? explode(' ', auth()->user()->name)[0] : '' }}" required>
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>Last Name *</label>
                                        <input type="text" name="last_name" class="form-control" value="{{ auth()->check() && count(explode(' ', auth()->user()->name)) > 1 ? explode(' ', auth()->user()->name)[1] : '' }}" required>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <label>Company Name (Optional)</label>
                                <input type="text" name="company" class="form-control" value="{{ auth()->user()->company ?? '' }}">

                                <label>Country *</label>
                                <input type="text" name="country" class="form-control" value="{{ auth()->user()->country ?? '' }}" required>

                                <label>Street address *</label>
                                <input type="text" name="address_line_1" class="form-control"
                                    placeholder="House number and Street name" value="{{ auth()->user()->address_line_1 ?? '' }}" required>
                                <input type="text" name="address_line_2" class="form-control"
                                    placeholder="Appartments, suite, unit etc ..." value="{{ auth()->user()->address_line_2 ?? '' }}">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Town / City *</label>
                                        <input type="text" name="city" class="form-control" value="{{ auth()->user()->city ?? '' }}" required>
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>State / County *</label>
                                        <input type="text" name="state" class="form-control" value="{{ auth()->user()->state ?? '' }}" required>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Postcode / ZIP *</label>
                                        <input type="text" name="postal_code" class="form-control" value="{{ auth()->user()->postal_code ?? '' }}" required>
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label>Phone *</label>
                                        <input type="tel" name="phone" class="form-control" value="{{ auth()->user()->phone ?? '' }}" required>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <label>Email address *</label>
                                <input type="email" name="email" class="form-control" value="{{ auth()->user()->email ?? '' }}" required>

                                @guest
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkout-create-acc">
                                        <label class="custom-control-label" for="checkout-create-acc">Create an account?</label>
                                    </div><!-- End .custom-checkbox -->

                                    <div id="password-field" style="display: none;">
                                        <label>Password *</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                @endguest

                                <label>Order notes (optional)</label>
                                <textarea name="notes" class="form-control" cols="30" rows="4"
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
                                                        <a
                                                            href="{{ $item->attributes->url ?? '#' }}">{{ $item->name }}</a>

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
                                                                placeholder="Enter discount code">
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
                                            @endif
                                            @if ($freeShippingEnabled && !$isFreeShipping)
                                                <tr>
                                                    <td colspan="2" class="text-center" style="border:none">

                                                        <span> Free shipping above
                                                            ${{ number_format($freeShippingThreshold, 2) }} </span>

                                                    </td>
                                                </tr>
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

                                        <div class="custom-control custom-radio" style="margin-top: 0px;">
                                            <input type="radio" value="cash" id="CashonDelivery"
                                                name="payment_method" class="custom-control-input" required>
                                            <label class="custom-control-label" for="CashonDelivery">
                                                Cash on delivery
                                            </label>
                                        </div>

                                        <div class="custom-control custom-radio" style="margin-top: 0px;">
                                            <input type="radio" value="paypal" id="paypal" name="payment_method"
                                                class="custom-control-input" required>
                                            <label class="custom-control-label" for="paypal">
                                                PayPal
                                            </label>
                                        </div>

                                        <div class="custom-control custom-radio" style="margin-top: 0px;">
                                            <input type="radio" value="stripe" id="CreditCard" name="payment_method"
                                                class="custom-control-input" required>
                                            <label class="custom-control-label" for="CreditCard">
                                                Credit Card (Stripe)
                                            </label>
                                            <img src="{{ asset('frontend/assets/images/payments-summary.png') }}"
                                                alt="payments cards">
                                        </div>

                                        <!-- Hidden fields for cart and shipping data -->
                                        <input type="hidden" name="shipping_method" id="selected-shipping"
                                            value="{{ $isFreeShipping ? '0' : $shippingMethods->first()->id ?? '0' }}">
                                        <input type="hidden" name="shipping_cost" id="selected-shipping-cost"
                                            value="{{ $isFreeShipping ? '0' : $shippingMethods->first()->price ?? '0' }}">

                                        <!-- Discount data from session -->
                                        @if (session('applied_discount'))
                                            <input type="hidden" name="discount_id"
                                                value="{{ session('applied_discount.id') }}">
                                            <input type="hidden" name="discount_name"
                                                value="{{ session('applied_discount.name') }}">
                                            <input type="hidden" name="discount_amount"
                                                value="{{ session('applied_discount.amount') }}">
                                        @endif
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

@section('scripts')
    <script>
        $(document).ready(function() {
            // Update hidden shipping fields when radio button changes
            $('input[name="shipping"]').change(function() {
                var shippingId = $(this).val();
                var shippingCost = $(this).data('price');

                $('#selected-shipping').val(shippingId);
                $('#selected-shipping-cost').val(shippingCost);
            });

            // Toggle password field when create account is checked
            $('#checkout-create-acc').change(function() {
                if ($(this).is(':checked')) {
                    $('#password-field').show();
                    $('#password-field input').prop('required', true);
                } else {
                    $('#password-field').hide();
                    $('#password-field input').prop('required', false);
                }
            });

            // AJAX form submission
            $('#checkout-form').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var submitBtn = $('.btn-order');

                // Disable submit button
                submitBtn.prop('disabled', true).html(
                    '<span class=" btn-outline-primary-2 btn-order btn-block">Processing...</span>');
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            window.location.href = response.redirect ||
                                '{{ route('frontend.home') }}';
                        } else if (response.email_exists) {
                            alert(response.message);
                            submitBtn.prop('disabled', false).html(
                                '<span class="btn-text">Place Order</span><span class="btn-hover-text">Proceed to Checkout</span>'
                            );
                        }
                    },
                    error: function(xhr) {
                        alert('Error placing order. Please try again.');
                        submitBtn.prop('disabled', false).html(
                            '<span class="btn-text">Place Order</span><span class="btn-hover-text">Proceed to Checkout</span>'
                        );
                    }
                });
            });
        });
    </script>
@endsection
