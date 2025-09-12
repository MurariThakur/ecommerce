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
                        <div class="card shadow-lg border-0">
                            <div class="card-body p-5">
                                <div class="text-center mb-4">
                                    <div class="mb-3">
                                        <i class="icon-key" style="font-size: 3rem; color: #28a745;"></i>
                                    </div>
                                    <h3 class="mb-2">Create New Password</h3>
                                    <p class="text-muted">
                                        Choose a strong password to secure your account.
                                    </p>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show">
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

                                <form method="POST" action="{{ route('password.update') }}" id="reset-password-form">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <input type="hidden" name="email" value="{{ $email }}">

                                    <div class="form-group">
                                        <label for="email" class="font-weight-bold">Email Address *</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control form-control-lg" id="email"
                                                value="{{ $email }}" readonly style="background-color: #f8f9fa;">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="font-weight-bold">New Password *</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-lock"></i></span>
                                            </div>
                                            <input type="password" class="form-control form-control-lg" id="password"
                                                name="password" placeholder="Enter new password" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation" class="font-weight-bold">Confirm New Password
                                            *</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-lock"></i></span>
                                            </div>
                                            <input type="password" class="form-control form-control-lg"
                                                id="password_confirmation" name="password_confirmation"
                                                placeholder="Confirm new password" required>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <button type="submit" class="btn btn-outline-primary-2 btn-block" id="submit-btn">
                                            <span id="btn-text">Reset Password</span>
                                            <i class="icon-long-arrow-right" id="btn-icon"></i>
                                        </button>
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

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#reset-password-form').on('submit', function(e) {
                var $submitBtn = $('#submit-btn');
                var $btnText = $('#btn-text');
                var $btnIcon = $('#btn-icon');

                // Store original content
                var originalText = $btnText.text();
                var originalIcon = $btnIcon.get(0).outerHTML;

                // Change button to loading state
                $btnText.text('Updating');
                $btnIcon.removeClass('icon-long-arrow-right')
                    .addClass('spinner-border spinner-border-sm')
                    .attr('role', 'status')
                    .attr('aria-hidden', 'true');

                // Disable button
                $submitBtn.prop('disabled', true).addClass('disabled');

                // Optional: Add timeout fallback (30 seconds)
                setTimeout(function() {
                    if ($submitBtn.prop('disabled')) {
                        $btnText.text(originalText);
                        $btnIcon.removeClass('spinner-border spinner-border-sm')
                            .addClass('icon-long-arrow-right')
                            .removeAttr('role')
                            .removeAttr('aria-hidden');
                        $submitBtn.prop('disabled', false).removeClass('disabled');
                    }
                }, 30000);
            });

            // Handle validation errors - reset button if form returns with erroDrs
            @if ($errors->any())
                $('#btn-text').text('Reset Password');
                $('#btn-icon').removeClass('spinner-border spinner-border-sm')
                    .addClass('icon-long-arrow-right')
                    .removeAttr('role')
                    .removeAttr('aria-hidden');
                $('#submit-btn').prop('disabled', false).removeClass('disabled');
            @endif
        });
    </script>
@endsection
