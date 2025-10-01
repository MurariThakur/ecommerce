@extends('frontend.layouts.app')
@section('title', 'Payment Methods')
@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Payment Methods<span>Secure & Easy</span></h1>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Payment Methods</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="contact-box text-center">
                            <h3>Credit Cards</h3>
                            <p>We accept all major credit cards including Visa, MasterCard, and American Express for secure
                                online payments.</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="contact-box text-center">
                            <h3>PayPal</h3>
                            <p>Pay securely with your PayPal account or use PayPal's guest checkout for quick and safe
                                transactions.</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="contact-box text-center">
                            <h3>Cash on Delivery</h3>
                            <p>Pay when you receive your order. Available for select locations with no additional charges.
                            </p>
                        </div>
                    </div>
                </div>

                <hr class="mt-3 mb-5 mt-md-1">

                <div class="touch-container row justify-content-center">
                    <div class="col-md-9 col-lg-7">
                        <div class="text-center">
                            <h2 class="title mb-1">Secure Payment Processing</h2>
                            <p class="lead text-primary">Your payment information is always safe and secure with us.</p>
                            <p class="mb-4">We use industry-standard SSL encryption to protect your personal and payment
                                information. All transactions are processed through secure payment gateways to ensure your
                                data remains confidential.</p>

                            <div class="row text-left">
                                <div class="col-md-6 mb-3">
                                    <h5><i class="icon-shield text-primary mr-2"></i>SSL Encryption</h5>
                                    <p>All data transmitted is encrypted using 256-bit SSL technology.</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h5><i class="icon-check text-primary mr-2"></i>PCI Compliant</h5>
                                    <p>We meet all PCI DSS requirements for secure payment processing.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
