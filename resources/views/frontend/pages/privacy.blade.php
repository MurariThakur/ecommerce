@extends('frontend.layouts.app')
@section('title', 'Privacy Policy')
@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Privacy Policy<span>Your Privacy Matters</span></h1>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="container">
                <div class="touch-container row justify-content-center">
                    <div class="col-md-10 col-lg-8">
                        <div class="text-center mb-5">
                            <h2 class="title mb-1">Privacy Policy</h2>
                            <p class="lead text-primary">We are committed to protecting your privacy and personal
                                information.</p>
                            <p><small>Last updated: {{ date('F d, Y') }}</small></p>
                        </div>

                        <div class="text-left">
                            <h4>Information We Collect</h4>
                            <p class="mb-4">We collect information you provide directly to us, such as when you create an
                                account, make a purchase, or contact us for support. This may include your name, email
                                address, phone number, shipping address, and payment information.</p>

                            <h4>How We Use Your Information</h4>
                            <p class="mb-2">We use the information we collect to:</p>
                            <ul class="mb-4">
                                <li>Process and fulfill your orders</li>
                                <li>Communicate with you about your account or transactions</li>
                                <li>Provide customer support</li>
                                <li>Send you promotional emails (with your consent)</li>
                                <li>Improve our products and services</li>
                            </ul>

                            <h4>Information Sharing</h4>
                            <p class="mb-4">We do not sell, trade, or otherwise transfer your personal information to
                                third parties without your consent, except as described in this policy. We may share your
                                information with trusted service providers who assist us in operating our website and
                                conducting our business.</p>

                            <h4>Data Security</h4>
                            <p class="mb-4">We implement appropriate security measures to protect your personal
                                information against unauthorized access, alteration, disclosure, or destruction. However, no
                                method of transmission over the internet is 100% secure.</p>

                            <h4>Cookies</h4>
                            <p class="mb-4">We use cookies to enhance your browsing experience, analyze site traffic, and
                                personalize content. You can choose to disable cookies through your browser settings, but
                                this may affect some functionality of our website.</p>

                            <h4>Your Rights</h4>
                            <p class="mb-2">You have the right to:</p>
                            <ul class="mb-4">
                                <li>Access and update your personal information</li>
                                <li>Request deletion of your personal data</li>
                                <li>Opt-out of marketing communications</li>
                                <li>Request a copy of your data</li>
                            </ul>

                            <h4>Contact Us</h4>
                            <p class="mb-4">If you have any questions about this Privacy Policy or our data practices,
                                please contact us using the information provided on our Contact page.</p>

                            <div class="text-center mt-5">
                                <a href="{{ route('contact') }}" class="btn btn-outline-primary-2 btn-minwidth-sm">
                                    <span>CONTACT US</span>
                                    <i class="icon-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
