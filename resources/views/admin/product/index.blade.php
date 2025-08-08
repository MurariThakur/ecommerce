@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('admin.layouts.message')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product Management</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Product Management</li>
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
                                <h3 class="card-title">Products</h3>
                                <div class="card-tools">
                                    <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Add New Product
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Sub</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($products as $product)
                                            <tr>
                                                <td>
                                                    <strong>{{ $product->title }}</strong>
                                                </td>
                                                <td>
                                                    {{ $product->category ? $product->category->name : 'N/A' }}
                                                </td>
                                                <td>
                                                    {{ $product->category ? $product->subcategory->name : 'N/A' }}
                                                </td>
                                                <td>
                                                    @if ($product->old_price && $product->old_price > $product->price)
                                                        <span class="text-muted"
                                                            style="text-decoration: line-through;">${{ number_format($product->old_price, 2) }}</span><br>
                                                        <span
                                                            class="text-success font-weight-bold">${{ number_format($product->price, 2) }}</span>
                                                        <small
                                                            class="badge badge-success">{{ $product->discount_percentage }}%
                                                            OFF</small>
                                                    @else
                                                        <span
                                                            class="font-weight-bold">${{ number_format($product->price, 2) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($product->status == 1)
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
                                                    <span title="{{ $product->created_at->format('M d, Y H:i:s') }}">
                                                        {{ $product->created_at->format('M d, Y') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <!-- View Button -->
                                                        <a href="{{ route('admin.product.show', $product) }}"
                                                            class="btn btn-primary btn-sm" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                        <!-- Edit Button -->
                                                        <a href="{{ route('admin.product.edit', $product) }}"
                                                            class="btn btn-info btn-sm ml-1" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        <!-- Toggle Status Button -->
                                                        <button type="button"
                                                            class="btn btn-sm {{ $product->status == 1 ? 'btn-warning' : 'btn-success' }} ml-1"
                                                            title="{{ $product->status == 1 ? 'Deactivate' : 'Activate' }}"
                                                            data-toggle="modal"
                                                            data-target="#statusModal{{ $product->id }}">
                                                            <i
                                                                class="fas fa-{{ $product->status == 1 ? 'ban' : 'check' }}"></i>
                                                        </button>

                                                        <!-- Delete Button -->
                                                        <button type="button" class="btn btn-danger btn-sm ml-1"
                                                            title="Delete" data-toggle="modal"
                                                            data-target="#deleteModal{{ $product->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                                    <p>No products found.</p>
                                                    <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus"></i> Create First Product
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            @if ($products->hasPages())
                                <div class="card-footer clearfix">
                                    <div class="float-right">
                                        {{ $products->links() }}
                                    </div>
                                    <div class="float-left">
                                        <small class="text-muted">
                                            Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }}
                                            of {{ $products->total() }} results
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
    @foreach ($products as $product)
        <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $product->id }}">
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                            Confirm Deletion
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">Are you sure you want to delete this product?</p>

                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Product Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Title:</strong></div>
                                    <div class="col-sm-8">{{ $product->title }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Category:</strong></div>
                                    <div class="col-sm-8">{{ $product->category ? $product->category->name : 'N/A' }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Price:</strong></div>
                                    <div class="col-sm-8">${{ number_format($product->price, 2) }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Status:</strong></div>
                                    <div class="col-sm-8">
                                        @if ($product->status == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-danger mt-3">
                            <i class="fas fa-exclamation-circle"></i>
                            <strong>This action cannot be undone!</strong> All data associated with this product will be
                            permanently deleted.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <form action="{{ route('admin.product.destroy', $product) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i>
                                Delete Product
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Status Toggle Confirmation Modals -->
    @foreach ($products as $product)
        <div class="modal fade" id="statusModal{{ $product->id }}" tabindex="-1" role="dialog"
            aria-labelledby="statusModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel{{ $product->id }}">
                            <i class="fas fa-{{ $product->status == 1 ? 'ban text-warning' : 'check text-success' }}"></i>
                            {{ $product->status == 1 ? 'Deactivate' : 'Activate' }} Product
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">Are you sure you want to {{ $product->status == 1 ? 'deactivate' : 'activate' }}
                            this product?</p>

                        <div class="card card-outline {{ $product->status == 1 ? 'card-warning' : 'card-success' }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Title:</strong></div>
                                    <div class="col-sm-8">{{ $product->title }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Category:</strong></div>
                                    <div class="col-sm-8">{{ $product->category ? $product->category->name : 'N/A' }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Current Status:</strong></div>
                                    <div class="col-sm-8">
                                        @if ($product->status == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>New Status:</strong></div>
                                    <div class="col-sm-8">
                                        @if ($product->status == 1)
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
                        <form action="{{ route('admin.product.toggle.status', $product) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            <button type="submit"
                                class="btn {{ $product->status == 1 ? 'btn-warning' : 'btn-success' }}">
                                <i class="fas fa-{{ $product->status == 1 ? 'ban' : 'check' }}"></i>
                                {{ $product->status == 1 ? 'Deactivate' : 'Activate' }} Product
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
