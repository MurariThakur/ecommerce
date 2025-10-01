@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit FAQ</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.faq.index') }}">FAQ Management</a></li>
                            <li class="breadcrumb-item active">Edit FAQ</li>
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
                                <h3 class="card-title">FAQ Information</h3>
                            </div>
                            <form action="{{ route('admin.faq.update', $faq) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="question">Question <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('question') is-invalid @enderror"
                                            id="question" name="question" value="{{ old('question', $faq->question) }}"
                                            required>
                                        @error('question')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="answer">Answer <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('answer') is-invalid @enderror" id="answer" name="answer" rows="4"
                                            required>{{ old('answer', $faq->answer) }}</textarea>
                                        @error('answer')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="category">Category <span class="text-danger">*</span></label>
                                        <select class="form-control @error('category') is-invalid @enderror" id="category"
                                            name="category" required>
                                            <option value="">Select Category</option>
                                            <option value="orders"
                                                {{ old('category', $faq->category) == 'orders' ? 'selected' : '' }}>Orders
                                            </option>
                                            <option value="shipping"
                                                {{ old('category', $faq->category) == 'shipping' ? 'selected' : '' }}>
                                                Shipping</option>
                                            <option value="returns"
                                                {{ old('category', $faq->category) == 'returns' ? 'selected' : '' }}>Returns
                                            </option>
                                            <option value="account"
                                                {{ old('category', $faq->category) == 'account' ? 'selected' : '' }}>
                                                Account</option>
                                        </select>
                                        @error('category')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sort_order">Sort Order</label>
                                                <input type="number"
                                                    class="form-control @error('sort_order') is-invalid @enderror"
                                                    id="sort_order" name="sort_order"
                                                    value="{{ old('sort_order', $faq->sort_order) }}" min="0">
                                                @error('sort_order')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="hidden" name="status" value="0">
                                                    <input type="checkbox" class="custom-control-input" id="status"
                                                        name="status" value="1"
                                                        {{ old('status', $faq->status) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="status">
                                                        Active
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update FAQ
                                    </button>
                                    <a href="{{ route('admin.faq.index') }}" class="btn btn-secondary ml-2">
                                        <i class="fas fa-times"></i> Cancel
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
