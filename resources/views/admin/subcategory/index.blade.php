@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            @include('admin.layouts.message')
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Subcategory Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Subcategory Management</li>
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
                            <h3 class="card-title">Subcategories</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.subcategory.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add New Subcategory
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subcategories as $subcategory)
                                        <tr>
                                            <td>
                                                <strong>{{ $subcategory->name }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $subcategory->category->name }}</span>
                                            </td>
                                            <td>
                                                @if($subcategory->status == 1)
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
                                                <span title="{{ $subcategory->created_at->format('M d, Y H:i:s') }}">
                                                    {{ $subcategory->created_at->format('M d, Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <!-- View Button -->
                                                    <a href="{{ route('admin.subcategory.show', $subcategory) }}"
                                                       class="btn btn-primary btn-sm" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <!-- Edit Button -->
                                                    <a href="{{ route('admin.subcategory.edit', $subcategory) }}"
                                                       class="btn btn-info btn-sm ml-1" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <!-- Toggle Status Button -->
                                                    <button type="button"
                                                            class="btn btn-sm {{ $subcategory->status == 1 ? 'btn-warning' : 'btn-success' }} ml-1"
                                                            title="{{ $subcategory->status == 1 ? 'Deactivate' : 'Activate' }}"
                                                            data-toggle="modal"
                                                            data-target="#statusModal{{ $subcategory->id }}">
                                                        <i class="fas fa-{{ $subcategory->status == 1 ? 'ban' : 'check' }}"></i>
                                                    </button>

                                                    <!-- Delete Button -->
                                                    <button type="button"
                                                            class="btn btn-danger btn-sm ml-1"
                                                            title="Delete"
                                                            data-toggle="modal"
                                                            data-target="#deleteModal{{ $subcategory->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="fas fa-tags fa-3x mb-3"></i>
                                                <p>No subcategories found.</p>
                                                <a href="{{ route('admin.subcategory.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Create First Subcategory
                                                </a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        @if($subcategories->hasPages())
                            <div class="card-footer clearfix">
                                <div class="float-right">
                                    {{ $subcategories->links() }}
                                </div>
                                <div class="float-left">
                                    <small class="text-muted">
                                        Showing {{ $subcategories->firstItem() ?? 0 }} to {{ $subcategories->lastItem() ?? 0 }}
                                        of {{ $subcategories->total() }} results
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
@foreach($subcategories as $subcategory)
    <div class="modal fade" id="deleteModal{{ $subcategory->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $subcategory->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel{{ $subcategory->id }}">
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        Confirm Deletion
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Are you sure you want to delete this subcategory?</p>

                    <div class="card card-outline card-danger">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4"><strong>Name:</strong></div>
                                <div class="col-sm-8">{{ $subcategory->name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>Category:</strong></div>
                                <div class="col-sm-8">{{ $subcategory->category->name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>Status:</strong></div>
                                <div class="col-sm-8">
                                    @if($subcategory->status == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
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
                    <form action="{{ route('admin.subcategory.destroy', $subcategory) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Subcategory
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Status Toggle Confirmation Modals -->
@foreach($subcategories as $subcategory)
    <div class="modal fade" id="statusModal{{ $subcategory->id }}" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel{{ $subcategory->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel{{ $subcategory->id }}">
                        <i class="fas fa-{{ $subcategory->status == 1 ? 'ban text-warning' : 'check text-success' }}"></i>
                        {{ $subcategory->status == 1 ? 'Deactivate' : 'Activate' }} Subcategory
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Are you sure you want to {{ $subcategory->status == 1 ? 'deactivate' : 'activate' }} this subcategory?</p>

                    <div class="card card-outline {{ $subcategory->status == 1 ? 'card-warning' : 'card-success' }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4"><strong>Name:</strong></div>
                                <div class="col-sm-8">{{ $subcategory->name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>Category:</strong></div>
                                <div class="col-sm-8">{{ $subcategory->category->name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>Current Status:</strong></div>
                                <div class="col-sm-8">
                                    @if($subcategory->status == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>New Status:</strong></div>
                                <div class="col-sm-8">
                                    @if($subcategory->status == 1)
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
                    <form action="{{ route('admin.subcategory.toggle.status', $subcategory) }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn {{ $subcategory->status == 1 ? 'btn-warning' : 'btn-success' }}">
                            <i class="fas fa-{{ $subcategory->status == 1 ? 'ban' : 'check' }}"></i> 
                            {{ $subcategory->status == 1 ? 'Deactivate' : 'Activate' }} Subcategory
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
