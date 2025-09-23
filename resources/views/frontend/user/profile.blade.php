@extends('frontend.layouts.app')

@section('title', 'Profile')

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
                                    <h2>Profile Information</h2>
                                    <p>Manage your account information</p>
                                </div>
                                <div class="profile-section">
                                    <form action="{{ route('user.profile.update') }}" method="POST">
                                        @csrf
                                        <div class="profile-card">
                                            <div class="profile-header">
                                                <h3>Personal Information</h3>
                                            </div>
                                            <div class="profile-body">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>Full Name *</label>
                                                        <input type="text" name="name" class="form-control"
                                                            value="{{ old('name', $user->name) }}" required>
                                                        @error('name')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Email Address</label>
                                                        <input type="email" class="form-control"
                                                            value="{{ $user->email }}" disabled>
                                                    </div>
                                                </div>

                                                <label>Company Name (Optional)</label>
                                                <input type="text" name="company" class="form-control"
                                                    value="{{ old('company', $user->company) }}">
                                                @error('company')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror

                                                <label>Country</label>
                                                <input type="text" name="country" class="form-control"
                                                    value="{{ old('country', $user->country) }}">
                                                @error('country')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror

                                                <label>Street address</label>
                                                <input type="text" name="address_line_1" class="form-control"
                                                    placeholder="House number and Street name"
                                                    value="{{ old('address_line_1', $user->address_line_1) }}">
                                                @error('address_line_1')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror

                                                <input type="text" name="address_line_2" class="form-control"
                                                    placeholder="Appartments, suite, unit etc ..."
                                                    value="{{ old('address_line_2', $user->address_line_2) }}">
                                                @error('address_line_2')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>Town / City</label>
                                                        <input type="text" name="city" class="form-control"
                                                            value="{{ old('city', $user->city) }}">
                                                        @error('city')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>State / County</label>
                                                        <input type="text" name="state" class="form-control"
                                                            value="{{ old('state', $user->state) }}">
                                                        @error('state')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>Postcode / ZIP</label>
                                                        <input type="text" name="postal_code" class="form-control"
                                                            value="{{ old('postal_code', $user->postal_code) }}">
                                                        @error('postal_code')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Phone</label>
                                                        <input type="tel" name="phone" class="form-control"
                                                            value="{{ old('phone', $user->phone) }}">
                                                        @error('phone')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="text-center mt-3">
                                                    <button type="submit" class="btn btn-outline-primary-2">
                                                        <span>Update Profile</span>
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
