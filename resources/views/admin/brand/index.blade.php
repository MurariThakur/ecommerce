@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            @include('admin.layouts.message')
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Brand Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Brand Management</li>
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
                            <h3 class="card-title">Brands</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.brand.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add New Brand
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($brands as $brand)
                                        <tr>
                                            <td>
                                                <strong>{{ $brand->name }}</strong>
                                            </td>
                                            <td>
                                                <code>{{ $brand->slug }}</code>
                                            </td>
                                            <td>
                                                @if($brand->status == 1)
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check-circle"></i> Active
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger">
                                                        <i class="fas fa-times-circle"></i> Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span title="{{ $brand->created_at->format('M d, Y H:i:s') }}">
                                                    {{ $brand->created_at->format('M d, Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <!-- View Button -->
                                                    <a href="{{ route('admin.brand.show', $brand) }}"
                                                       class="btn btn-primary btn-sm" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <!-- Edit Button -->
                                                    <a href="{{ route('admin.brand.edit', $brand) }}"
                                                       class="btn btn-info btn-sm ml-1" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <!-- Toggle Status Button -->
                                                    <button type="button"
                                                            class="btn btn-sm {{ $brand->status == 1 ? 'btn-warning' : 'btn-success' }} ml-1"
                                                            title="{{ $brand->status == 1 ? 'Deactivate' : 'Activate' }}"
                                                            data-toggle="modal"
                                                            data-target="#statusModal{{ $brand->id }}">
                                                        <i class="fas fa-{{ $brand->status == 1 ? 'ban' : 'check' }}"></i>
                                                    </button>

                                                    <!-- Delete Button -->
                                                    <button type="button"
                                                            class="btn btn-danger btn-sm ml-1"
                                                            title="Delete"
                                                            data-toggle="modal"
                                                            data-target="#deleteModal{{ $brand->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="fas fa-tags fa-3x mb-3"></i>
                                                <p>No brands found.</p>
                                                <a href="{{ route('admin.brand.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Create First Brand
                                                </a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        @if($brands->hasPages())
                            <div class="card-footer clearfix">
                                <div class="float-right">
                                    {{ $brands->links() }}
                                </div>
                                <div class="float-left">
                                    <small class="text-muted">
                                        Showing {{ $brands->firstItem() ?? 0 }} to {{ $brands->lastItem() ?? 0 }}
                                        of {{ $brands->total() }} results
                                    </small>
                                </div>
                            </div>
                        @endif
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

<!-- Delete Confirmation Modals -->
@foreach($brands as $brand)
    <div class="modal fade" id="deleteModal{{ $brand->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $brand->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel{{ $brand->id }}">
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
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Warning:</strong> Deleting this brand will also delete <strong>{{ $brand->products->count() }}</strong> associated product(s).
                        </div>
                    @endif

                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Brand Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4"><strong>Name:</strong></div>
                                <div class="col-sm-8">{{ $brand->name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>Slug:</strong></div>
                                <div class="col-sm-8">{{ $brand->slug }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>Status:</strong></div>
                                <div class="col-sm-8">
                                    @if($brand->status == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($brand->products->count() > 0)
                        <div class="card card-outline card-warning mt-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-list"></i> Products to be Deleted ({{ $brand->products->count() }})
                                </h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                    <table class="table table-sm table-striped mb-0">
                                        <thead class="bg-light sticky-top">
                                            <tr>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($brand->products as $product)
                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td>
                                                        @if($product->status)
                                                            <span class="badge badge-success badge-sm">Active</span>
                                                        @else
                                                            <span class="badge badge-danger badge-sm">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $product->created_at->format('M d, Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="alert alert-danger mt-3">
                        <i class="fas fa-exclamation-circle"></i>
                        <strong>This action cannot be undone!</strong> All data associated with this brand and its products will be permanently deleted.
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
                            <i class="fas fa-trash"></i> 
                            Delete Brand @if($brand->products->count() > 0) & {{ $brand->products->count() }} Product(s) @endif
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Status Toggle Confirmation Modals -->
@foreach($brands as $brand)
    <div class="modal fade" id="statusModal{{ $brand->id }}" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel{{ $brand->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel{{ $brand->id }}">
                        <i class="fas fa-{{ $brand->status == 1 ? 'ban text-warning' : 'check text-success' }}"></i>
                        {{ $brand->status == 1 ? 'Deactivate' : 'Activate' }} Brand
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Are you sure you want to {{ $brand->status == 1 ? 'deactivate' : 'activate' }} this brand?</p>

                    <div class="card card-outline {{ $brand->status == 1 ? 'card-warning' : 'card-success' }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4"><strong>Name:</strong></div>
                                <div class="col-sm-8">{{ $brand->name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>Slug:</strong></div>
                                <div class="col-sm-8">{{ $brand->slug }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>Current Status:</strong></div>
                                <div class="col-sm-8">
                                    @if($brand->status == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>New Status:</strong></div>
                                <div class="col-sm-8">
                                    @if($brand->status == 1)
                                        <span class="badge badge-danger">Inactive</span>
                                    @else
                                        <span class="badge badge-success">Active</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <form action="{{ route('admin.brand.toggle.status', $brand) }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn {{ $brand->status == 1 ? 'btn-warning' : 'btn-success' }}">
                            <i class="fas fa-{{ $brand->status == 1 ? 'ban' : 'check' }}"></i> 
                            {{ $brand->status == 1 ? 'Deactivate' : 'Activate' }} Brand
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
