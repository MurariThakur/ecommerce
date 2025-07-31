@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">View Brand</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.brand.index') }}">Brand Management</a></li>
                        <li class="breadcrumb-item active">View Brand</li>
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
                            <h3 class="card-title">
                                <i class="fas fa-eye"></i> Brand Details
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.brand.edit', $brand) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit Brand
                                </a>
                                <a href="{{ route('admin.brand.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Basic Information -->
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-info-circle"></i> Basic Information
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td width="150"><strong>Name</strong></td>
                                                    <td>{{ $brand->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Slug</strong></td>
                                                    <td><code>{{ $brand->slug }}</code></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status</strong></td>
                                                    <td>
                                                        @if($brand->status)
                                                            <span class="badge badge-success">
                                                                <i class="fas fa-check-circle"></i> Active
                                                            </span>
                                                        @else
                                                            <span class="badge badge-danger">
                                                                <i class="fas fa-times-circle"></i> Inactive
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Created At</strong></td>
                                                    <td>{{ $brand->created_at->format('M d, Y H:i:s') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Updated At</strong></td>
                                                    <td>{{ $brand->updated_at->format('M d, Y H:i:s') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Products Information -->
                                    @if($brand->products->count() > 0)
                                        <div class="card card-outline card-info">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <i class="fas fa-box"></i> Associated Products
                                                </h3>
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                                    <table class="table table-striped table-hover mb-0">
                                                        <thead class="bg-light sticky-top">
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Status</th>
                                                                <th>Created</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($brand->products as $product)
                                                                <tr>
                                                                    <td><strong>{{ $product->name }}</strong></td>
                                                                    <td>
                                                                        @if($product->status)
                                                                            <span class="badge badge-success badge-sm">Active</span>
                                                                        @else
                                                                            <span class="badge badge-danger badge-sm">Inactive</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $product->created_at->format('M d, Y') }}</td>
                                                                    <td>
                                                                        <a href="{{ route('admin.product.show', $product) }}" class="btn btn-primary btn-xs" title="View Product">
                                                                            <i class="fas fa-eye"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <!-- Quick Actions -->
                                    <div class="card card-outline card-success">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-cogs"></i> Quick Actions
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-grid gap-2">
                                                <!-- Edit Button -->
                                                <a href="{{ route('admin.brand.edit', $brand) }}" class="btn btn-warning btn-block">
                                                    <i class="fas fa-edit"></i> Edit Brand
                                                </a>

                                                <!-- Toggle Status Button -->
                                                <button type="button" 
                                                        class="btn btn-block {{ $brand->status ? 'btn-secondary' : 'btn-success' }}"
                                                        data-toggle="modal"
                                                        data-target="#statusModal">
                                                    <i class="fas fa-{{ $brand->status ? 'ban' : 'check' }}"></i> 
                                                    {{ $brand->status ? 'Deactivate' : 'Activate' }} Brand
                                                </button>

                                                <!-- Delete Button -->
                                                <button type="button" 
                                                        class="btn btn-danger btn-block"
                                                        data-toggle="modal"
                                                        data-target="#deleteModal">
                                                    <i class="fas fa-trash"></i> Delete Brand
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Brand Statistics -->
                                    <div class="card card-outline card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-chart-bar"></i> Statistics
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-info">
                                                    <i class="fas fa-box"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Products</span>
                                                    <span class="info-box-number">{{ $brand->products->count() }}</span>
                                                </div>
                                            </div>

                                            <div class="info-box">
                                                <span class="info-box-icon bg-success">
                                                    <i class="fas fa-calendar"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Days Since Created</span>
                                                    <span class="info-box-number">{{ $brand->created_at->diffInDays(now()) }}</span>
                                                </div>
                                            </div>

                                            <div class="info-box">
                                                <span class="info-box-icon bg-warning">
                                                    <i class="fas fa-clock"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Last Updated</span>
                                                    <span class="info-box-number text-sm">{{ $brand->updated_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
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

<!-- Status Toggle Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">
                    <i class="fas fa-{{ $brand->status ? 'ban text-warning' : 'check text-success' }}"></i>
                    {{ $brand->status ? 'Deactivate' : 'Activate' }} Brand
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to {{ $brand->status ? 'deactivate' : 'activate' }} this brand?</p>
                <div class="alert alert-info">
                    <strong>Brand:</strong> {{ $brand->name }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <form action="{{ route('admin.brand.toggle.status', $brand) }}" method="POST" style="display: inline-block;">
                    @csrf
                    <button type="submit" class="btn {{ $brand->status ? 'btn-warning' : 'btn-success' }}">
                        <i class="fas fa-{{ $brand->status ? 'ban' : 'check' }}"></i> 
                        {{ $brand->status ? 'Deactivate' : 'Activate' }} Brand
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Deletion
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Are you sure you want to delete this brand?</p>
                @if($brand->products->count() > 0)
                    <div class="alert alert-warning">
                        <strong>Warning:</strong> This brand has {{ $brand->products->count() }} associated product(s). They will also be deleted.
                    </div>
                @endif
                <div class="alert alert-danger">
                    <strong>Warning:</strong> This action cannot be undone!<br>
                    <strong>Brand:</strong> {{ $brand->name }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <form action="{{ route('admin.brand.destroy', $brand) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete Brand
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
