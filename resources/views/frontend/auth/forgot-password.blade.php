@extends('frontend.layouts.app')

@section('content')
    <main class="main">
        <div class="page-header text-center"
            style="background-image: url('{{ asset('frontend/assets/images/page-header-bg.jpg') }}')">
            <div class="container">
                <h1 class="page-title">Forgot Password<span>Account</span></h1>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Forgot Password</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card shadow-lg border-0">
                            <div class="card-body p-5">
                                <div class="text-center mb-4">
                                    <div class="mb-3">
                                        <i class="icon-lock" style="font-size: 3rem; color: #007bff;"></i>
                                    </div>
                                    <h3 class="mb-2">Forgot Password?</h3>
                                    <p class="text-muted">
                                        No worries! Enter your email and we'll send you a reset link.
                                    </p>
                                </div>

                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show mb-1">
                                        <i class="icon-check-circle me-2"></i>{{ session('status') }}
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show mb-1">
                                        <i class="icon-times-circle me-2"></i>
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.email') }}" id="forgot-password-form">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email" class="font-weight-bold">Email Address *</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control form-control-lg" id="email"
                                                name="email" value="{{ old('email') }}"
                                                placeholder="Enter your email address" required autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <button type="submit" class="btn btn-outline-primary-2 btn-block" id="submit-btn">
                                            <span class="button-text">Send Reset Link</span>
                                            <i class="icon-long-arrow-right arrow-icon"></i>
                                        </button>
                                    </div>

                                    <div class="text-center">
                                        <p class="mb-0">
                                            Remember your password? <a href="#signin-modal" data-toggle="modal"
                                                class="font-weight-bold">Sign In</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('forgot-password-form');
        const submitButton = document.getElementById('submit-btn');
        const buttonText = submitButton.querySelector('.button-text');
        const arrowIcon = submitButton.querySelector('.arrow-icon');

        form.addEventListener('submit', function(e) {
            // Disable button and change text
            submitButton.disabled = true;
            submitButton.classList.add('loading');
            buttonText.textContent = 'Sending...';

            // Hide arrow icon and show spinner
            arrowIcon.style.display = 'none';
            const spinner = document.createElement('i');
            spinner.className = 'fas fa-spinner fa-spin';
            spinner.id = 'loading-spinner';
            submitButton.appendChild(spinner);
        });

        // Handle success state
        @if (session('status'))
            submitButton.disabled = true;
            buttonText.textContent = 'Sent';
            submitButton.classList.add('btn-success');
            submitButton.classList.remove('btn-outline-primary-2');
            arrowIcon.className = 'fas fa-check';

            // Remove any existing spinner
            const existingSpinner = document.getElementById('loading-spinner');
            if (existingSpinner) {
                existingSpinner.remove();
            }
        @endif
    });
</script>
