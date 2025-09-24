@extends('frontend.layouts.app')
@section('title', 'Shipping Information')
@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Shipping<span>Fast & Reliable Delivery</span></h1>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shipping</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="contact-box text-center">
                            <h3>Standard Shipping</h3>
                            <p><strong>3-5 Business Days</strong><br>Free on orders over $50<br>$5.99 for orders under $50
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="contact-box text-center">
                            <h3>Express Shipping</h3>
                            <p><strong>1-2 Business Days</strong><br>$12.99 flat rate<br>Order by 2 PM for same-day
                                processing</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="contact-box text-center">
                            <h3>Overnight Shipping</h3>
                            <p><strong>Next Business Day</strong><br>$24.99 flat rate<br>Order by 12 PM for next-day
                                delivery</p>
                        </div>
                    </div>
                </div>

                <hr class="mt-3 mb-5 mt-md-1">

                <div class="touch-container row justify-content-center">
                    <div class="col-md-9 col-lg-7">
                        <div class="text-center mb-5">
                            <h2 class="title mb-1">Shipping Information</h2>
                            <p class="lead text-primary">Everything you need to know about our shipping process.</p>
                        </div>

                        <div class="row text-left">
                            <div class="col-md-6 mb-4">
                                <h5><i class="icon-map text-primary mr-2"></i>Shipping Areas</h5>
                                <p>We ship nationwide and to select international destinations. Shipping costs vary by
                                    location.</p>
                            </div>
                            <div class="col-md-6 mb-4">
                                <h5><i class="icon-clock-o text-primary mr-2"></i>Processing Time</h5>
                                <p>Orders are processed within 1-2 business days. You'll receive tracking information once
                                    shipped.</p>
                            </div>
                            <div class="col-md-6 mb-4">
                                <h5><i class="icon-shield text-primary mr-2"></i>Package Protection</h5>
                                <p>All packages are insured and require signature confirmation for orders over $100.</p>
                            </div>
                            <div class="col-md-6 mb-4">
                                <h5><i class="icon-phone text-primary mr-2"></i>Delivery Updates</h5>
                                <p>Receive SMS and email notifications about your package status and delivery updates.</p>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <h4>Track Your Order</h4>
                            <p>Enter your order number to track your shipment in real-time.</p>
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <form class="contact-form">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter Order Number"
                                                required>
                                        </div>
                                        <button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm">
                                            <span>TRACK ORDER</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
