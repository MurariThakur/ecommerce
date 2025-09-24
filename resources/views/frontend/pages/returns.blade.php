@extends('frontend.layouts.app')
@section('title', 'Returns & Exchanges')
@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Returns<span>Easy Returns & Exchanges</span></h1>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Returns</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="container">
                <div class="touch-container row justify-content-center">
                    <div class="col-md-9 col-lg-7">
                        <div class="text-center mb-5">
                            <h2 class="title mb-1">Return Policy</h2>
                            <p class="lead text-primary">We want you to be completely satisfied with your purchase.</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h4><i class="icon-calendar text-primary mr-2"></i>30-Day Return Window</h4>
                                <p>You have 30 days from the delivery date to return items for a full refund or exchange.
                                </p>
                            </div>
                            <div class="col-md-6 mb-4">
                                <h4><i class="icon-tag text-primary mr-2"></i>Original Condition</h4>
                                <p>Items must be unused, unworn, and in original packaging with all tags attached.</p>
                            </div>
                            <div class="col-md-6 mb-4">
                                <h4><i class="icon-truck text-primary mr-2"></i>Free Return Shipping</h4>
                                <p>We provide prepaid return labels for your convenience at no additional cost.</p>
                            </div>
                            <div class="col-md-6 mb-4">
                                <h4><i class="icon-dollar text-primary mr-2"></i>Quick Refunds</h4>
                                <p>Refunds are processed within 3-5 business days after we receive your return.</p>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h3>How to Return an Item</h3>
                        <ol class="mb-4">
                            <li>Log into your account and go to "My Orders"</li>
                            <li>Find your order and click "Request Return"</li>
                            <li>Select the items you want to return and provide a reason</li>
                            <li>Print the prepaid return label we email you</li>
                            <li>Package the items securely and attach the label</li>
                            <li>Drop off at any authorized shipping location</li>
                        </ol>

                        <div class="text-center">
                            <p class="mb-3">Need help with a return? Our customer service team is here to assist you.</p>
                            <a href="{{ route('contact') }}" class="btn btn-outline-primary-2 btn-minwidth-sm">
                                <span>CONTACT US</span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
