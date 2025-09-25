@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                @include('admin.layouts.message')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Website Settings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Settings</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- General Settings -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">General Settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="website_name">Website Name <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('website_name') is-invalid @enderror"
                                            id="website_name" name="website_name"
                                            value="{{ old('website_name', $settings['website_name']->value) }}">
                                        @error('website_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="website_logo">Website Logo</label>
                                        <input type="file"
                                            class="form-control @error('website_logo') is-invalid @enderror"
                                            id="website_logo" name="website_logo" accept="image/*">
                                        @if ($settings['website_logo']->value)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $settings['website_logo']->value) }}"
                                                    alt="Website Logo" class="img-thumbnail" style="max-height: 100px;">
                                            </div>
                                        @endif
                                        @error('website_logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="favicon">Favicon</label>
                                        <input type="file" class="form-control @error('favicon') is-invalid @enderror"
                                            id="favicon" name="favicon" accept=".ico,.png">
                                        @if ($settings['favicon']->value)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $settings['favicon']->value) }}"
                                                    alt="Favicon" class="img-thumbnail" style="max-height: 50px;">
                                            </div>
                                        @endif
                                        @error('favicon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="footer_payment_icon">Footer Payment Icons</label>
                                        <input type="file"
                                            class="form-control @error('footer_payment_icon') is-invalid @enderror"
                                            id="footer_payment_icon" name="footer_payment_icon" accept="image/*">
                                        @if ($settings['footer_payment_icon']->value)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $settings['footer_payment_icon']->value) }}"
                                                    alt="Payment Icons" class="img-thumbnail" style="max-height: 80px;">
                                            </div>
                                        @endif
                                        @error('footer_payment_icon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="footer_description">Footer Description</label>
                                <textarea class="form-control" id="footer_description" name="footer_description" rows="3">{{ old('footer_description', $settings['footer_description']->value) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Contact Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="office_address">Office Address</label>
                                <textarea class="form-control" id="office_address" name="office_address" rows="3">{{ old('office_address', $settings['office_address']->value) }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">Mobile Number</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile"
                                            value="{{ old('mobile', $settings['mobile']->value) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="alternative_mobile">Alternative Mobile</label>
                                        <input type="text" class="form-control" id="alternative_mobile"
                                            name="alternative_mobile"
                                            value="{{ old('alternative_mobile', $settings['alternative_mobile']->value) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email"
                                            value="{{ old('email', $settings['email']->value) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="alternative_email">Alternative Email</label>
                                        <input type="email"
                                            class="form-control @error('alternative_email') is-invalid @enderror"
                                            id="alternative_email" name="alternative_email"
                                            value="{{ old('alternative_email', $settings['alternative_email']->value) }}">
                                        @error('alternative_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="working_hours">Working Hours</label>
                                <input type="text" class="form-control" id="working_hours" name="working_hours"
                                    value="{{ old('working_hours', $settings['working_hours']->value) }}"
                                    placeholder="e.g., Mon-Fri: 9:00 AM - 6:00 PM">
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Links -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Social Media Links</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="facebook_link">Facebook Link</label>
                                        <input type="url" class="form-control" id="facebook_link"
                                            name="facebook_link"
                                            value="{{ old('facebook_link', $settings['facebook_link']->value) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="instagram_link">Instagram Link</label>
                                        <input type="url" class="form-control" id="instagram_link"
                                            name="instagram_link"
                                            value="{{ old('instagram_link', $settings['instagram_link']->value) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="twitter_link">Twitter Link</label>
                                        <input type="url" class="form-control" id="twitter_link" name="twitter_link"
                                            value="{{ old('twitter_link', $settings['twitter_link']->value) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="youtube_link">YouTube Link</label>
                                        <input type="url" class="form-control" id="youtube_link" name="youtube_link"
                                            value="{{ old('youtube_link', $settings['youtube_link']->value) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pinterest_link">Pinterest Link</label>
                                        <input type="url" class="form-control" id="pinterest_link"
                                            name="pinterest_link"
                                            value="{{ old('pinterest_link', $settings['pinterest_link']->value) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="turnstile_site_key">Turnstile Site Key</label>
                                        <input type="text" class="form-control" id="turnstile_site_key"
                                            name="turnstile_site_key"
                                            value="{{ old('turnstile_site_key', $settings['turnstile_site_key']->value) }}"
                                            placeholder="Cloudflare Turnstile Site Key">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Free Shipping Settings -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Free Shipping Settings</h3>
                            <div class="card-tools">
                                @if ($settings['free_shipping_threshold']->status)
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i> Enabled
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="fas fa-times-circle"></i> Disabled
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="free_shipping_status"
                                        name="free_shipping_status"
                                        {{ $settings['free_shipping_threshold']->status ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="free_shipping_status">
                                        <strong>Enable Free Shipping</strong>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="free_shipping_threshold">Free Shipping Threshold <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" step="0.01" min="0"
                                        class="form-control @error('free_shipping_threshold') is-invalid @enderror"
                                        id="free_shipping_threshold" name="free_shipping_threshold"
                                        value="{{ old('free_shipping_threshold', $settings['free_shipping_threshold']->value) }}">
                                    @error('free_shipping_threshold')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Gateway Settings -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Payment Gateway Settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5>Stripe Settings</h5>
                                        @if ($settings['stripe_status']->status)
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle"></i> Enabled
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times-circle"></i> Disabled
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="stripe_status"
                                                name="stripe_status"
                                                {{ $settings['stripe_status']->status ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="stripe_status">
                                                <strong>Enable Stripe</strong>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="stripe_public_key">Stripe Public Key</label>
                                        <input type="text" class="form-control" id="stripe_public_key"
                                            name="stripe_public_key"
                                            value="{{ old('stripe_public_key', $settings['stripe_public_key']->value) }}"
                                            placeholder="pk_test_...">
                                    </div>
                                    <div class="form-group">
                                        <label for="stripe_secret_key">Stripe Secret Key</label>
                                        <input type="password" class="form-control" id="stripe_secret_key"
                                            name="stripe_secret_key"
                                            value="{{ old('stripe_secret_key', $settings['stripe_secret_key']->value) }}"
                                            placeholder="sk_test_...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5>PayPal Settings</h5>
                                        @if ($settings['paypal_status']->status)
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle"></i> Enabled
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times-circle"></i> Disabled
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="paypal_status"
                                                name="paypal_status"
                                                {{ $settings['paypal_status']->status ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="paypal_status">
                                                <strong>Enable PayPal</strong>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="paypal_client_id">PayPal Client ID</label>
                                        <input type="text" class="form-control" id="paypal_client_id"
                                            name="paypal_client_id"
                                            value="{{ old('paypal_client_id', $settings['paypal_client_id']->value) }}"
                                            placeholder="PayPal Client ID">
                                    </div>
                                    <div class="form-group">
                                        <label for="paypal_client_secret">PayPal Client Secret</label>
                                        <input type="password" class="form-control" id="paypal_client_secret"
                                            name="paypal_client_secret"
                                            value="{{ old('paypal_client_secret', $settings['paypal_client_secret']->value) }}"
                                            placeholder="PayPal Client Secret">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5>Razorpay Settings</h5>
                                        @if ($settings['razorpay_status']->status)
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle"></i> Enabled
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times-circle"></i> Disabled
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="razorpay_status"
                                                name="razorpay_status"
                                                {{ $settings['razorpay_status']->status ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="razorpay_status">
                                                <strong>Enable Razorpay</strong>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="razorpay_key_id">Razorpay Key ID</label>
                                        <input type="text" class="form-control" id="razorpay_key_id"
                                            name="razorpay_key_id"
                                            value="{{ old('razorpay_key_id', $settings['razorpay_key_id']->value) }}"
                                            placeholder="rzp_test_...">
                                    </div>
                                    <div class="form-group">
                                        <label for="razorpay_key_secret">Razorpay Key Secret</label>
                                        <input type="password" class="form-control" id="razorpay_key_secret"
                                            name="razorpay_key_secret"
                                            value="{{ old('razorpay_key_secret', $settings['razorpay_key_secret']->value) }}"
                                            placeholder="Razorpay Key Secret">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
