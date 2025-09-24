@extends('frontend.layouts.app')

@section('content')
    <main class="main">
        <div class="page-header text-center">
            <div class="container">
                <h1 class="page-title">Order Details</h1>
            </div>
        </div>

        <div class="page-content">
            <div class="account-dashboard">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 d-none d-md-block">
                            @include('frontend.user.partials.sidebar')
                        </div>
                        <div class="col-md-9 col-12">
                            <div class="account-content">
                                <div class="order-header-section">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div>
                                            <h2>Order #{{ $order->order_number }}</h2>
                                            <p class="text-muted">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <div class="order-status-badge">
                                            <span class="status-badge status-{{ $order->status }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Tracking -->
                                <div class="order-tracking mb-4">
                                    <h4>Order Status</h4>
                                    <div
                                        class="tracking-steps {{ $order->status === 'cancelled' || (in_array($order->status, ['refund_processing', 'refunded']) && $order->refunds->where('type', 'cancellation')->count() > 0) ? 'cancelled-flow' : 'normal-flow' }}">
                                        <div
                                            class="step {{ in_array($order->status, ['confirmed', 'processing', 'shipped', 'delivered']) || in_array($order->status, ['cancelled', 'return_requested', 'return_approved', 'return_rejected', 'refund_processing', 'refunded']) ? 'completed' : '' }}">
                                            <div class="step-icon">
                                                <i class="icon-check"></i>
                                            </div>
                                            <div class="step-content">
                                                <h5>Order Confirmed</h5>
                                                <p>Your order has been confirmed</p>
                                            </div>
                                        </div>

                                        @if (
                                            $order->status === 'cancelled' ||
                                                (in_array($order->status, ['refund_processing', 'refunded']) &&
                                                    $order->refunds->where('type', 'cancellation')->count() > 0))
                                            <div class="step completed">
                                                <div class="step-icon" style="background: #dc3545;">
                                                    <i class="icon-close"></i>
                                                </div>
                                                <div class="step-content">
                                                    <h5>Cancelled</h5>
                                                    <p>Order has been cancelled</p>
                                                </div>
                                            </div>

                                            @if (in_array($order->status, ['refund_processing', 'refunded']) &&
                                                    $order->refunds->where('type', 'cancellation')->count() > 0)
                                                <div class="step completed">
                                                    <div class="step-icon">
                                                        <i class="icon-cog"></i>
                                                    </div>
                                                    <div class="step-content">
                                                        <h5>Refund Processing</h5>
                                                        <p>Processing cancellation refund...</p>
                                                    </div>
                                                </div>

                                                @if ($order->status === 'refunded')
                                                    <div class="step completed">
                                                        <div class="step-icon">
                                                            <i class="icon-dollar"></i>
                                                        </div>
                                                        <div class="step-content">
                                                            <h5>Refunded</h5>
                                                            <p>Cancellation refund completed</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @else
                                            <div
                                                class="step {{ in_array($order->status, ['processing', 'shipped', 'delivered', 'return_requested', 'return_approved', 'return_rejected', 'refund_processing', 'refunded']) ? 'completed' : '' }}">
                                                <div class="step-icon">
                                                    <i class="icon-cog"></i>
                                                </div>
                                                <div class="step-content">
                                                    <h5>Processing</h5>
                                                    <p>Your order is being processed</p>
                                                </div>
                                            </div>
                                            <div
                                                class="step {{ in_array($order->status, ['shipped', 'delivered', 'return_requested', 'return_approved', 'return_rejected', 'refund_processing', 'refunded']) ? 'completed' : '' }}">
                                                <div class="step-icon">
                                                    <i class="icon-truck"></i>
                                                </div>
                                                <div class="step-content">
                                                    <h5>Shipped</h5>
                                                    <p>Your order has been shipped</p>
                                                </div>
                                            </div>
                                            <div
                                                class="step {{ in_array($order->status, ['delivered', 'return_requested', 'return_approved', 'return_rejected', 'refund_processing', 'refunded']) ? 'completed' : '' }}">
                                                <div class="step-icon">
                                                    <i class="icon-home"></i>
                                                </div>
                                                <div class="step-content">
                                                    <h5>Delivered</h5>
                                                    <p>Order delivered successfully</p>
                                                </div>
                                            </div>

                                            @if (in_array($order->status, [
                                                    'return_requested',
                                                    'return_approved',
                                                    'return_rejected',
                                                    'refund_processing',
                                                    'refunded',
                                                ]))
                                                <div
                                                    class="step {{ in_array($order->status, ['return_requested', 'return_approved', 'return_rejected', 'refund_processing', 'refunded']) ? 'completed' : '' }}">
                                                    <div class="step-icon" style="background: #ffc107;">
                                                        <i class="icon-refresh"></i>
                                                    </div>
                                                    <div class="step-content">
                                                        <h5>Return Requested</h5>
                                                        <p>Return request submitted</p>
                                                    </div>
                                                </div>

                                                @if (in_array($order->status, ['return_approved', 'refund_processing', 'refunded']))
                                                    <div class="step completed">
                                                        <div class="step-icon">
                                                            <i class="icon-check"></i>
                                                        </div>
                                                        <div class="step-content">
                                                            <h5>Return Approved</h5>
                                                            <p>Return request approved</p>
                                                        </div>
                                                    </div>
                                                @elseif($order->status === 'return_rejected')
                                                    <div class="step completed">
                                                        <div class="step-icon" style="background: #dc3545;">
                                                            <i class="icon-close"></i>
                                                        </div>
                                                        <div class="step-content">
                                                            <h5>Return Rejected</h5>
                                                            <p>Return request rejected</p>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if (in_array($order->status, ['refund_processing', 'refunded']))
                                                    <div class="step completed">
                                                        <div class="step-icon">
                                                            <i class="icon-cog"></i>
                                                        </div>
                                                        <div class="step-content">
                                                            <h5>Refund Processing</h5>
                                                            <p>Refund initiated, processing...</p>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($order->status === 'refunded')
                                                    <div class="step completed">
                                                        <div class="step-icon" style="background: #28a745;">
                                                            <i class="icon-dollar"></i>
                                                        </div>
                                                        <div class="step-content">
                                                            <h5>Refunded</h5>
                                                            <p>Money refunded successfully</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                <!-- Order Items -->
                                <div class="order-items mb-4">
                                    <h4>Items Ordered</h4>
                                    <div class="items-list">
                                        @foreach ($order->orderItems as $item)
                                            @if ($item->product)
                                                <a href="{{ route('product.details', [$item->product->category->slug, $item->product->subcategory->slug, $item->product->slug]) }}"
                                                    class="item-card-link" target="_blank">
                                            @endif
                                            <div class="item-card">
                                                <div class="item-image">
                                                    @if ($item->product && $item->product->productImages->first())
                                                        <img src="{{ $item->product->productImages->first()->image_url }}"
                                                            alt="{{ $item->product->title ?? $item->product_title }}">
                                                    @else
                                                        <div class="no-image">
                                                            <i class="icon-picture"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="item-details">
                                                    <h3 class="product-name">
                                                        {{ $item->product->title ?? $item->product_title }}</h3>
                                                    <div class="product-info">
                                                        @if ($item->color)
                                                            <span>Color: {{ $item->color }}</span>
                                                        @endif
                                                        @if ($item->size)
                                                            <span>Size: {{ $item->size }}</span>
                                                        @endif
                                                        <span>Qty: {{ $item->quantity }}</span>
                                                        <span>${{ number_format($item->price, 2) }} each</span>
                                                    </div>
                                                </div>
                                                <div class="item-total">
                                                    <strong>${{ number_format($item->price * $item->quantity, 2) }}</strong>
                                                </div>
                                            </div>
                                            @if ($item->product)
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Order Summary -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="shipping-address">
                                            <h4>Shipping Address</h4>
                                            <div class="address-card">
                                                <p><strong>{{ $order->first_name }} {{ $order->last_name }}</strong></p>
                                                <p>{{ $order->address_line_1 }}</p>
                                                @if ($order->address_line_2)
                                                    <p>{{ $order->address_line_2 }}</p>
                                                @endif
                                                <p>{{ $order->city }}, {{ $order->state }} {{ $order->postal_code }}</p>
                                                <p>{{ $order->country }}</p>
                                                <p>Phone: {{ $order->phone }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-1">
                                        <div class="order-summary">
                                            <h4>Order Summary</h4>
                                            <div class="summary-card">
                                                <div class="summary-row">
                                                    <span>Subtotal:</span>
                                                    <span>${{ number_format($order->total - $order->shipping_cost + $order->discount_amount, 2) }}</span>
                                                </div>
                                                @if ($order->discount_amount > 0)
                                                    <div class="summary-row discount">
                                                        <span>Discount ({{ $order->discount_name }}):</span>
                                                        <span>-${{ number_format($order->discount_amount, 2) }}</span>
                                                    </div>
                                                @endif
                                                <div class="summary-row">
                                                    <span>Shipping
                                                        ({{ $order->shipping->name ?? $order->shipping_method }}):</span>
                                                    <span>${{ number_format($order->shipping_cost, 2) }}</span>
                                                </div>
                                                <div class="summary-row total">
                                                    <span><strong>Total:</strong></span>
                                                    <span><strong>${{ number_format($order->total, 2) }}</strong></span>
                                                </div>
                                                <div class="payment-status">
                                                    <span>Payment Status:</span>
                                                    <span
                                                        class="payment-badge {{ $order->is_payment ? 'paid' : 'unpaid' }}">
                                                        {{ $order->is_payment ? 'Paid' : 'Unpaid' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Refund Information -->
                                @if ($order->refunds->count() > 0)
                                    <div class="refund-info mb-4">
                                        <h4>Refund Information</h4>
                                        @foreach ($order->refunds as $refund)
                                            <div class="refund-card">
                                                <div class="refund-header">
                                                    <span class="refund-number">{{ $refund->refund_number }}</span>
                                                    <span
                                                        class="refund-status status-{{ $refund->status }}">{{ ucfirst($refund->status) }}</span>
                                                </div>
                                                <div class="refund-details">
                                                    <p><strong>Amount:</strong> ${{ number_format($refund->amount, 2) }}
                                                    </p>
                                                    <p><strong>Type:</strong> {{ ucfirst($refund->type) }}</p>
                                                    <p><strong>Reason:</strong> {{ $refund->reason }}</p>
                                                    @if ($refund->processed_at)
                                                        <p><strong>Processed:</strong>
                                                            {{ $refund->processed_at->format('M d, Y H:i') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="order-actions-bottom mt-4">
                                    <a href="{{ route('user.orders') }}" class="btn btn-outline-primary-2">
                                        <i class="icon-arrow-left"></i> Back to Orders
                                    </a>
                                    @if (in_array($order->status, ['confirmed', 'processing', 'shipped']))
                                        <form action="{{ route('user.order.cancel', $order->id) }}" method="POST"
                                            class="d-inline ml-2"
                                            onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Cancel Order</button>
                                        </form>
                                    @endif
                                    @if ($order->status === 'delivered')
                                        <button type="button" class="btn btn-warning ml-2" data-toggle="modal"
                                            data-target="#returnModal">
                                            Request Return
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Return Request Modal -->
        <div class="modal fade" id="returnModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Request Return</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('user.order.return', $order->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="reason">Reason for Return *</label>
                                <textarea name="reason" id="reason" class="form-control" rows="4"
                                    placeholder="Please explain why you want to return this order..." required></textarea>
                            </div>
                            <div class="alert alert-info">
                                <small>Once submitted, your return request will be reviewed. Refund will be processed within
                                    3-5 business days after approval.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning">Submit Return Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
    </main>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/user-dashboard.css') }}">
    <style>
        .order-header-section h2 {
            color: #000000;
            margin-bottom: 0.25rem;
            font-size: 1.8rem;
        }

        .order-header-section p {
            color: #000000;
            font-size: 1.5rem;
        }

        .order-tracking {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
        }

        .order-tracking h4 {
            margin-bottom: 1.5rem;
            color: #000000;
            font-size: 1.3rem;
        }

        .tracking-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
        }

        .tracking-steps::before {
            content: '';
            position: absolute;
            top: 25px;
            left: 25px;
            height: 2px;
            background: #ddd;
            z-index: 1;
        }

        .tracking-steps.cancelled-flow::before {
            width: 75%;
        }

        .tracking-steps.cancelled-flow::after {
            width: @if ($order->status === 'cancelled')
                75%;
            @elseif($order->status === 'refund_processing')
                80%;
            @elseif($order->status === 'refunded')
                100%;
            @else
                25%;
            @endif
        }

        .tracking-steps.normal-flow::before {
            width: 85%;
        }

        .tracking-steps::after {
            content: '';
            position: absolute;
            top: 25px;
            left: 25px;
            height: 2px;
            background: #28a745;
            z-index: 2;
            transition: width 0.3s ease;

            width: @if ($order->status === 'confirmed')
                33%;
            @elseif($order->status === 'processing')
                60%;
            @elseif($order->status === 'shipped')
                82%;
            @elseif($order->status === 'delivered')
                85%;
            @elseif($order->status === 'cancelled')
                70%;
            @elseif($order->status === 'return_requested')
                85%;
            @elseif($order->status === 'return_approved')
                90%;
            @elseif($order->status === 'return_rejected')
                90%;
            @elseif($order->status === 'refund_processing')
                92%;
            @elseif($order->status === 'refunded')
                92%;
            @else
                0%;
            @endif
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            flex: 1;
            position: relative;
            z-index: 999;
        }

        .step-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
            color: #666;
        }

        .step.completed .step-icon {
            background: #28a745;
            color: white;
        }

        .step-content h5 {
            margin: 0 0 0.25rem;
            font-size: 1rem;
            color: #000000;
        }

        .step-content p {
            margin: 0;
            font-size: 1.5rem;
            color: #000000;
        }

        .order-items h4 {
            margin-bottom: 1rem;
            color: #000000;
            font-size: 1.3rem;
        }

        .items-list {
            border: 1px solid #eee;
            border-radius: 8px;
            overflow: hidden;
        }

        .item-card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .item-card-link:hover {
            text-decoration: none;
            color: inherit;
        }

        .item-card {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #eee;
            transition: background-color 0.3s;
        }

        .item-card:last-child {
            border-bottom: none;
        }

        .item-card-link:hover .item-card {
            background-color: #f8f9fa;
        }

        .item-image {
            width: 80px;
            height: 80px;
            margin-right: 1rem;
            border-radius: 8px;
            overflow: hidden;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .no-image {
            color: #ccc;
            font-size: 2rem;
        }

        .item-details {
            flex: 1;
        }

        .product-name {
            margin: 0 0 0.5rem;
            color: #000000;
            font-size: 1.6rem;
            font-weight: 600;
        }

        .product-info {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            color: #000000;
            font-size: 1.3rem;
        }

        .product-info span {
            color: #666;
        }

        .item-total {
            font-size: 1.3rem;
            font-weight: 600;
            color: #000000;
        }

        .shipping-address h4,
        .order-summary h4 {
            margin-bottom: 1rem;
            color: #000000;
            font-size: 1.3rem;
        }

        .address-card,
        .summary-card {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
        }

        .address-card p {
            margin: 0 0 0.5rem;
            color: #000000;
            font-size: 1.5rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            color: #000000;
            font-size: 1.5rem;
        }

        .summary-row.discount {
            color: #28a745;
        }

        .summary-row.total {
            border-top: 1px solid #ddd;
            padding-top: 0.75rem;
            margin-top: 0.75rem;
            font-size: 1.2rem;
        }

        .payment-status {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #ddd;
            font-size: 1.5rem;
            color: #000000;
        }

        .payment-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 1.5rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        .payment-badge.paid {
            background: #d4edda;
            color: #0f5132;
        }

        .payment-badge.unpaid {
            background: #f8d7da;
            color: #58151c;
        }

        .order-actions-bottom {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid #eee;
        }

        .refund-info h4 {
            margin-bottom: 1rem;
            color: #000000;
            font-size: 1.3rem;
        }

        .refund-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .refund-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #dee2e6;
        }

        .refund-number {
            font-weight: 600;
            color: #000000;
            font-size: 1.1rem;
        }

        .refund-status {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        .refund-status.status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .refund-status.status-processed {
            background: #d4edda;
            color: #0f5132;
        }

        .refund-status.status-failed {
            background: #f8d7da;
            color: #58151c;
        }

        .refund-details p {
            margin: 0.5rem 0;
            color: #000000;
            font-size: 1.4rem;
        }

        .modal-content {
            border-radius: 8px;
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
        }

        .modal-title {
            color: #000000;
            font-size: 1.25rem;
        }

        .modal-body .form-group label {
            color: #000000;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .modal-body .form-control {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 0.75rem;
        }

        .modal-body .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
            border-radius: 4px;
            padding: 0.75rem;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .tracking-steps {
                flex-direction: column;
                gap: 2rem;
                align-items: flex-start;
                position: relative;
            }

            .tracking-steps::before {
                content: '';
                position: absolute;
                top: 25px;
                left: 25px;
                width: 2px;
                height: calc(100% - 50px);
                background: #ddd;
                z-index: 1;
            }

            .tracking-steps::after {
                content: '';
                position: absolute;
                top: 25px;
                left: 25px;
                width: 2px;
                background: #28a745;
                z-index: 2;
                transition: height 0.3s ease;

                height: @if ($order->status === 'confirmed')
                    25%;
                @elseif($order->status === 'processing')
                    50%;
                @elseif($order->status === 'shipped')
                    75%;
                @elseif($order->status === 'delivered')
                    85%;
                @elseif($order->status === 'cancelled')
                    50%;
                @elseif($order->status === 'return_requested')
                    90%;
                @elseif($order->status === 'return_approved')
                    92%;
                @elseif($order->status === 'return_rejected')
                    92%;
                @elseif($order->status === 'refund_processing')
                    95%;
                @elseif($order->status === 'refunded')
                    95%;
                @else
                    0%;
                @endif
            }

            .step {
                flex-direction: row;
                align-items: center;
                text-align: left;
                width: 100%;
                position: relative;
                z-index: 999;
            }

            .step-icon {
                margin-right: 1rem;
                margin-bottom: 0;
            }

            .item-card {
                flex-direction: column;
                text-align: center;
            }

            .item-image {
                margin: 0 0 1rem 0;
            }

            .item-details {
                margin-bottom: 1rem;
            }

            .refund-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }
    </style>
@endsection
