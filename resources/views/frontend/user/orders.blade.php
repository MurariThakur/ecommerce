@extends('frontend.layouts.app')

@section('title', 'My Orders')

@section('content')
    <main class="main">
        <div class="page-content">
            <div class="container">
                <div class="account-dashboard">
                    <div class="row">
                        <div class="col-md-3">
                            @include('frontend.user.partials.sidebar')
                        </div>
                        <div class="col-md-9">
                            <div class="account-content">
                                <div class="welcome-section">
                                    <h2>My Orders</h2>
                                    <p>Track and manage your orders</p>
                                </div>

                                @if ($orders->count() > 0)
                                    <div class="orders-list">
                                        @foreach ($orders as $order)
                                            <div class="order-card">
                                                <div class="order-header">
                                                    <div class="order-info">
                                                        <h4>Order #{{ $order->order_number }}</h4>
                                                        <p>{{ $order->created_at->format('M d, Y') }}</p>
                                                        @if ($order->orderItems->count() > 0)
                                                            <div class="order-products">
                                                                @foreach ($order->orderItems->take(2) as $item)
                                                                    <span
                                                                        class="product-name">{{ $item->product->title ?? $item->product_title }}</span>
                                                                    @if (!$loop->last)
                                                                        ,
                                                                    @endif
                                                                @endforeach
                                                                @if ($order->orderItems->count() > 2)
                                                                    <span
                                                                        class="more-items">+{{ $order->orderItems->count() - 2 }}
                                                                        more</span>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="order-status">
                                                        <span class="status-badge status-{{ $order->status }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="order-details">
                                                    <div class="order-total">
                                                        <strong>${{ number_format($order->total, 2) }}</strong>
                                                    </div>
                                                    <div class="order-actions">
                                                        <a href="{{ route('user.order.details', $order->id) }}"
                                                            class="btn btn-outline-primary-2 btn-sm">View
                                                            Details</a>
                                                        @if ($order->status === 'delivered')
                                                            @foreach ($order->orderItems as $item)
                                                                @if ($item->product && !$item->has_review)
                                                                    <a href="{{ url($item->product->category->slug . '/' . $item->product->subcategory->slug . '/' . $item->product->slug) }}#product-review-tab"
                                                                        class="btn btn-success btn-sm ml-1 review-btn"
                                                                        target="_blank">Rate & Review</a>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="pagination-wrapper">
                                        {{ $orders->links() }}
                                    </div>
                                @else
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="icon-bag"></i>
                                        </div>
                                        <h4>No orders found</h4>
                                        <p>You haven't placed any orders yet. Start shopping to see your orders here.</p>
                                        <a href="{{ route('frontend.home') }}" class="btn btn-primary">Start Shopping</a>
                                    </div>
                                @endif
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
@endsection
