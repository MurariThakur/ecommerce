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
                        <div class="card">
                            <div class="card-body p-4">
                                <h3 class="text-center mb-4">Reset Your Password</h3>
                                <p class="text-center text-muted mb-4">
                                    Enter your email address and we'll send you a link to reset your password.
                                </p>

                                @if (session('status'))
                                    <div class="alert alert-success mb-1">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email Address *</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email') }}" required autofocus>
                                    </div>

                                    <div class="form-group mb-4">
                                        <button type="submit" class="btn btn-outline-primary-2 btn-block">
                                            <span>Send Reset Link</span>
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
