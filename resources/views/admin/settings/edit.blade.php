@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Setting</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">Settings</a></li>
                            <li class="breadcrumb-item active">Edit</li>
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
                                <h3 class="card-title">Edit Setting</h3>
                            </div>
                            <form action="{{ route('admin.settings.update', $setting) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="key">Key <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('key') is-invalid @enderror"
                                               id="key" name="key" value="{{ old('key', $setting->key) }}">
                                        @error('key')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="value">Value <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('value') is-invalid @enderror"
                                               id="value" name="value" value="{{ old('value', $setting->value) }}">
                                        @error('value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" 
                                                   {{ $setting->status ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="status">
                                                <strong>Active Status</strong>
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">Toggle to activate or deactivate this setting</small>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Setting
                                    </button>
                                    <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection