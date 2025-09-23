@extends('frontend.layouts.app')

@section('title', 'Change Password')

@section('content')
    <main class="main">
        <div class="page-content">
            <div class="container">
                <div class="account-dashboard">
                    <div class="row">
                        <div class="col-md-3">
                            @include('frontend.user.partials.sidebar')
                        </div>
                        <div class="col-md-9">
                            <div class="account-content">
                                <div class="page-header-content">
                                    <h2>Change Password</h2>
                                    <p>Update your account password</p>
                                </div>
                                <div class="profile-section">
                                    <form action="{{ route('user.change-password.update') }}" method="POST">
                                        @csrf
                                        <div class="profile-card">
                                            <div class="profile-header">
                                                <h3>Password Information</h3>
                                            </div>
                                            <div class="profile-body">
                                                <label>Current Password *</label>
                                                <input type="password" name="current_password" class="form-control"
                                                    required>
                                                @error('current_password')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror

                                                <label>New Password *</label>
                                                <input type="password" name="password" class="form-control" required>
                                                @error('password')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror

                                                <label>Confirm New Password *</label>
                                                <input type="password" name="password_confirmation" class="form-control"
                                                    required>

                                                <div class="text-center mt-3">
                                                    <button type="submit" class="btn btn-outline-primary-2">
                                                        <span>Update Password</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
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

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/user-dashboard.css') }}">
@endsection
