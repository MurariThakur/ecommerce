@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                @include('admin.layouts.message')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Free Shipping Settings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Free Shipping Settings</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Free Shipping Configuration</h3>
                                <div class="card-tools">
                                    @if ($freeShippingSetting->status)
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
                            <form action="{{ route('admin.settings.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="status"
                                                name="status" {{ $freeShippingSetting->status ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="status">
                                                <strong>Enable Free Shipping</strong>
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">Toggle to enable or disable free shipping
                                            feature</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="value">Free Shipping Threshold <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" step="0.01" min="0"
                                                class="form-control @error('value') is-invalid @enderror" id="value"
                                                name="value" value="{{ old('value', $freeShippingSetting->value) }}"
                                                placeholder="0.00">
                                            @error('value')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="form-text text-muted">Minimum order amount required for free
                                            shipping</small>
                                    </div>

                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        <strong>How it works:</strong> When enabled and order total exceeds the threshold,
                                        customers will see "Free Shipping" instead of paid shipping options.
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Settings
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
