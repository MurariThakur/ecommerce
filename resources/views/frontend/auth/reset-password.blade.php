@extends('frontend.layouts.app')

@section('content')
    <main class="main">
        <div class="page-header text-center"
            style="background-image: url('{{ asset('frontend/assets/images/page-header-bg.jpg') }}')">
            <div class="container">
                <h1 class="page-title">Reset Password<span>Account</span></h1>
            </div>
        </div>

        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reset Password</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body p-4">
                                <h3 class="text-center mb-4">Create New Password</h3>
                                <p class="text-center text-muted mb-4">
                                    Enter your new password below to reset your account password.
                                </p>

                                @if ($errors->any())
                                    <div class="alert alert-danger mb-1">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <input type="hidden" name="email" value="{{ $email }}">

                                    <div class="form-group">
                                        <label for="email">Email Address *</label>
                                        <input type="email" class="form-control" id="email"
                                            value="{{ $email }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="password">New Password *</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm New Password *</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" required>
                                    </div>

                                    <div class="form-group mb-4">
                                        <button type="submit" class="btn btn-outline-primary-2 btn-block">
                                            <span>Reset Password</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>
                                    </div>

                                    <div class="text-center">
                                        <p class="mb-0">
                                            Remember your password?
                                            <a href="#signin-modal" data-toggle="modal">Sign In</a>
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
