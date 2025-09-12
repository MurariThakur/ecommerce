@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add New Discount</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.discount.index') }}">Discount
                                    Management</a></li>
                            <li class="breadcrumb-item active">Add New Discount</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Create Discount</h3>
                            </div>
                            <!-- /.card-header -->
                            <form action="{{ route('admin.discount.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="type">Type <span class="text-danger">*</span></label>
                                        <select class="form-control @error('type') is-invalid @enderror" id="type"
                                            name="type" required>
                                            <option value="">-- Select Type --</option>
                                            <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>
                                                Percentage</option>
                                            <option value="amount" {{ old('type') == 'amount' ? 'selected' : '' }}>Amount
                                            </option>
                                        </select>
                                        @error('type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="value">Value <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" min="0"
                                            class="form-control @error('value') is-invalid @enderror" id="value"
                                            name="value" value="{{ old('value') }}" required>
                                        @error('value')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="min_order_amount">Minimum Order Amount</label>
                                        <input type="number" step="0.01" min="0"
                                            class="form-control @error('min_order_amount') is-invalid @enderror"
                                            id="min_order_amount" name="min_order_amount"
                                            value="{{ old('min_order_amount') }}">
                                        @error('min_order_amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="max_discount_amount">Maximum Discount Amount</label>
                                        <input type="number" step="0.01" min="0"
                                            class="form-control @error('max_discount_amount') is-invalid @enderror"
                                            id="max_discount_amount" name="max_discount_amount"
                                            value="{{ old('max_discount_amount') }}">
                                        @error('max_discount_amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="usage_limit">Usage Limit</label>
                                        <input type="number" min="1"
                                            class="form-control @error('usage_limit') is-invalid @enderror" id="usage_limit"
                                            name="usage_limit" value="{{ old('usage_limit') }}">
                                        @error('usage_limit')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="per_user_limit">Per User Limit</label>
                                        <input type="number" min="1"
                                            class="form-control @error('per_user_limit') is-invalid @enderror"
                                            id="per_user_limit" name="per_user_limit" value="{{ old('per_user_limit') }}">
                                        @error('per_user_limit')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="expire_date">Expire Date <span class="text-danger">*</span></label>
                                        <input type="date"
                                            class="form-control @error('expire_date') is-invalid @enderror"
                                            id="expire_date" name="expire_date" value="{{ old('expire_date') }}"
                                            required>
                                        @error('expire_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" name="status" value="0">
                                            <input type="checkbox" class="custom-control-input" id="status"
                                                name="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="status">
                                                Active
                                            </label>
                                        </div>
                                        @error('status')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Create Discount</button>
                                    <a href="{{ route('admin.discount.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
