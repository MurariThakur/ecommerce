@extends('frontend.layouts.app')
@section('title', 'FAQ')
@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">FAQ<span>Frequently Asked Questions</span></h1>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="container">
                <div class="touch-container row justify-content-center">
                    <div class="col-md-10 col-lg-8">
                        <div class="text-center mb-5">
                            <h2 class="title mb-1">Frequently Asked Questions</h2>
                            <p class="lead text-primary">Find answers to common questions about our products and services.
                            </p>
                        </div>

                        <div class="accordion" id="faqAccordion">
                            <div class="card">
                                <div class="card-header" id="faq1">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#collapse1">
                                            How do I place an order?
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapse1" class="collapse show" data-parent="#faqAccordion">
                                    <div class="card-body">
                                        Simply browse our products, add items to your cart, and proceed to checkout. Follow
                                        the step-by-step process to complete your order.
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="faq2">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                            data-target="#collapse2">
                                            What payment methods do you accept?
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapse2" class="collapse" data-parent="#faqAccordion">
                                    <div class="card-body">
                                        We accept all major credit cards, PayPal, and Cash on Delivery (COD) for your
                                        convenience.
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="faq3">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                            data-target="#collapse3">
                                            How long does shipping take?
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapse3" class="collapse" data-parent="#faqAccordion">
                                    <div class="card-body">
                                        Standard shipping takes 3-5 business days. Express shipping is available for 1-2
                                        business days delivery.
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="faq4">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                            data-target="#collapse4">
                                            Can I return or exchange items?
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapse4" class="collapse" data-parent="#faqAccordion">
                                    <div class="card-body">
                                        Yes, we offer a 30-day return policy. Items must be in original condition with tags
                                        attached.
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header" id="faq5">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                            data-target="#collapse5">
                                            How can I track my order?
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapse5" class="collapse" data-parent="#faqAccordion">
                                    <div class="card-body">
                                        Once your order ships, you'll receive a tracking number via email. You can also
                                        track orders in your account dashboard.
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
