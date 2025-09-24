@extends('frontend.layouts.app')
@section('title', 'About Us')
@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">About Us<span>Our Story</span></h1>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">About Us</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="contact-box text-center">
                            <h3>Our Mission</h3>
                            <p>To provide high-quality products at affordable prices while delivering exceptional customer
                                service and creating lasting relationships with our customers.</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="contact-box text-center">
                            <h3>Our Vision</h3>
                            <p>To become the leading e-commerce platform that transforms the way people shop online by
                                offering innovative solutions and unmatched convenience.</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="contact-box text-center">
                            <h3>Our Values</h3>
                            <p>Quality, integrity, customer satisfaction, and innovation drive everything we do. We believe
                                in building trust through transparency and excellence.</p>
                        </div>
                    </div>
                </div>

                <hr class="mt-3 mb-5 mt-md-1">

                <div class="touch-container row justify-content-center">
                    <div class="col-md-9 col-lg-7">
                        <div class="text-center">
                            <h2 class="title mb-1">Our Story</h2>
                            <p class="lead text-primary">
                                Founded with a passion for excellence and a commitment to customer satisfaction.
                            </p>
                            <p class="mb-3">We started our journey with a simple idea: to make online shopping easier,
                                more enjoyable, and more accessible for everyone. Today, we serve thousands of customers
                                worldwide, offering a carefully curated selection of products that meet the highest
                                standards of quality and value.</p>

                            <p class="mb-4">Our team is dedicated to continuously improving your shopping experience
                                through innovative technology, exceptional customer service, and a deep understanding of
                                what our customers need and want.</p>
                        </div>
                    </div>
                </div>

                <hr class="mt-3 mb-5">

                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="contact-box text-center">
                            <div class="icon-box-icon">
                                <i class="icon-users" style="font-size: 3rem; color: #c96; margin-bottom: 1rem;"></i>
                            </div>
                            <h4>10,000+</h4>
                            <p>Happy Customers</p>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="contact-box text-center">
                            <div class="icon-box-icon">
                                <i class="icon-bag" style="font-size: 3rem; color: #c96; margin-bottom: 1rem;"></i>
                            </div>
                            <h4>50,000+</h4>
                            <p>Products Sold</p>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="contact-box text-center">
                            <div class="icon-box-icon">
                                <i class="icon-truck" style="font-size: 3rem; color: #c96; margin-bottom: 1rem;"></i>
                            </div>
                            <h4>99%</h4>
                            <p>On-Time Delivery</p>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="contact-box text-center">
                            <div class="icon-box-icon">
                                <i class="icon-heart-o" style="font-size: 3rem; color: #c96; margin-bottom: 1rem;"></i>
                            </div>
                            <h4>5 Years</h4>
                            <p>Of Excellence</p>
                        </div>
                    </div>
                </div>

                <hr class="mt-3 mb-5">

                <div class="touch-container row justify-content-center">
                    <div class="col-md-9 col-lg-7">
                        <div class="text-center">
                            <h2 class="title mb-1">Why Choose Us?</h2>
                            <p class="lead text-primary mb-4">
                                We're committed to providing you with the best shopping experience possible.
                            </p>

                            <div class="row text-left">
                                <div class="col-md-6 mb-3">
                                    <h5><i class="icon-check text-primary mr-2"></i>Quality Guarantee</h5>
                                    <p>All our products undergo strict quality control to ensure you receive only the best.
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h5><i class="icon-check text-primary mr-2"></i>Fast Shipping</h5>
                                    <p>Quick and reliable delivery to get your orders to you as soon as possible.</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h5><i class="icon-check text-primary mr-2"></i>24/7 Support</h5>
                                    <p>Our customer service team is always ready to help you with any questions or concerns.
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h5><i class="icon-check text-primary mr-2"></i>Easy Returns</h5>
                                    <p>Hassle-free return policy to ensure your complete satisfaction with every purchase.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
