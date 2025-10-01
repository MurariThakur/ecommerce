@extends('frontend.layouts.app')
@section('title', 'Terms and Conditions')
@section('content')
    <main class="main">
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Terms & Conditions<span>Legal Information</span></h1>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Terms & Conditions</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="container">
                <div class="touch-container row justify-content-center">
                    <div class="col-md-10 col-lg-8">
                        <div class="text-center mb-5">
                            <h2 class="title mb-1">Terms and Conditions</h2>
                            <p class="lead text-primary">Please read these terms carefully before using our services.</p>
                            <p><small>Last updated: {{ date('F d, Y') }}</small></p>
                        </div>

                        <div class="text-left">
                            <h4>1. Acceptance of Terms</h4>
                            <p class="mb-4">By accessing and using this website, you accept and agree to be bound by the
                                terms and provision of this agreement.</p>

                            <h4>2. Use License</h4>
                            <p class="mb-4">Permission is granted to temporarily download one copy of the materials on our
                                website for personal, non-commercial transitory viewing only. This is the grant of a
                                license, not a transfer of title.</p>

                            <h4>3. Disclaimer</h4>
                            <p class="mb-4">The materials on our website are provided on an 'as is' basis. We make no
                                warranties, expressed or implied, and hereby disclaim and negate all other warranties
                                including without limitation, implied warranties or conditions of merchantability, fitness
                                for a particular purpose, or non-infringement of intellectual property or other violation of
                                rights.</p>

                            <h4>4. Limitations</h4>
                            <p class="mb-4">In no event shall our company or its suppliers be liable for any damages
                                (including, without limitation, damages for loss of data or profit, or due to business
                                interruption) arising out of the use or inability to use the materials on our website.</p>

                            <h4>5. Privacy Policy</h4>
                            <p class="mb-4">Your privacy is important to us. Our Privacy Policy explains how we collect,
                                use, and protect your information when you use our service.</p>

                            <h4>6. Governing Law</h4>
                            <p class="mb-4">These terms and conditions are governed by and construed in accordance with
                                the laws and you irrevocably submit to the exclusive jurisdiction of the courts in that
                                state or location.</p>

                            <h4>7. Changes to Terms</h4>
                            <p class="mb-4">We reserve the right to revise these terms of service at any time without
                                notice. By using this website, you are agreeing to be bound by the then current version of
                                these terms of service.</p>

                            <div class="text-center mt-5">
                                <p>If you have any questions about these Terms and Conditions, please contact us.</p>
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
