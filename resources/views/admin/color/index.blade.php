@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            @include('admin.layouts.message')
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Color Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Color Management</li>
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
                            <h3 class="card-title">Colors</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.color.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add New Color
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Color Code</th>
                                        <th>Preview</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($colors as $color)
                                        <tr>
                                            <td>
                                                <strong>{{ $color->name }}</strong>
                                            </td>
                                            <td>
                                                <code>{{ $color->color_code }}</code>
                                            </td>
                                            <td>
                                                <div style="width: 30px; height: 30px; background-color: {{ $color->color_code }}; border: 1px solid #ddd; border-radius: 4px;"></div>
                                            </td>
                                            <td>
                                                @if($color->status == 1)
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
                                                <span title="{{ $color->created_at->format('M d, Y H:i:s') }}">
                                                    {{ $color->created_at->format('M d, Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <!-- View Button -->
                                                    <a href="{{ route('admin.color.show', $color) }}"
                                                       class="btn btn-primary btn-sm" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <!-- Edit Button -->
                                                    <a href="{{ route('admin.color.edit', $color) }}"
                                                       class="btn btn-info btn-sm ml-1" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <!-- Toggle Status Button -->
                                                    <button type="button"
                                                            class="btn btn-sm {{ $color->status == 1 ? 'btn-warning' : 'btn-success' }} ml-1"
                                                            title="{{ $color->status == 1 ? 'Deactivate' : 'Activate' }}"
                                                            data-toggle="modal"
                                                            data-target="#statusModal{{ $color->id }}">
                                                        <i class="fas fa-{{ $color->status == 1 ? 'ban' : 'check' }}"></i>
                                                    </button>

                                                    <!-- Delete Button -->
                                                    <button type="button"
                                                            class="btn btn-danger btn-sm ml-1"
                                                            title="Delete"
                                                            data-toggle="modal"
                                                            data-target="#deleteModal{{ $color->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="fas fa-palette fa-3x mb-3"></i>
                                                <p>No colors found.</p>
                                                <a href="{{ route('admin.color.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Create First Color
                                                </a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        @if($colors->hasPages())
                            <div class="card-footer clearfix">
                                <div class="float-right">
                                    {{ $colors->links() }}
                                </div>
                                <div class="float-left">
                                    <small class="text-muted">
                                        Showing {{ $colors->firstItem() ?? 0 }} to {{ $colors->lastItem() ?? 0 }}
                                        of {{ $colors->total() }} results
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
@foreach($colors as $color)
    <div class="modal fade" id="deleteModal{{ $color->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $color->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel{{ $color->id }}">
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        Confirm Deletion
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Are you sure you want to delete this color?</p>

                    {{-- @if($color->products->count() > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Warning:</strong> Deleting this color will also delete <strong>{{ $color->products->count() }}</strong> associated product(s).
                        </div>
                    @endif --}}

                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Color Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4"><strong>Name:</strong></div>
                                <div class="col-sm-8">{{ $color->name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>Color Code:</strong></div>
                                <div class="col-sm-8">{{ $color->color_code }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>Status:</strong></div>
                                <div class="col-sm-8">
                                    @if($color->status == 1)
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
                        <strong>This action cannot be undone!</strong> All data associated with this color will be permanently deleted.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <form action="{{ route('admin.color.destroy', $color) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                            Delete Color
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Status Toggle Confirmation Modals -->
@foreach($colors as $color)
    <div class="modal fade" id="statusModal{{ $color->id }}" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel{{ $color->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel{{ $color->id }}">
                        <i class="fas fa-{{ $color->status == 1 ? 'ban text-warning' : 'check text-success' }}"></i>
                        {{ $color->status == 1 ? 'Deactivate' : 'Activate' }} Color
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Are you sure you want to {{ $color->status == 1 ? 'deactivate' : 'activate' }} this color?</p>

                    <div class="card card-outline {{ $color->status == 1 ? 'card-warning' : 'card-success' }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4"><strong>Name:</strong></div>
                                <div class="col-sm-8">{{ $color->name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>Color Code:</strong></div>
                                <div class="col-sm-8">{{ $color->color_code }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>Current Status:</strong></div>
                                <div class="col-sm-8">
                                    @if($color->status == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>New Status:</strong></div>
                                <div class="col-sm-8">
                                    @if($color->status == 1)
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
                    <form action="{{ route('admin.color.toggle.status', $color) }}" method="POST" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn {{ $color->status == 1 ? 'btn-warning' : 'btn-success' }}">
                            <i class="fas fa-{{ $color->status == 1 ? 'ban' : 'check' }}"></i>
                            {{ $color->status == 1 ? 'Deactivate' : 'Activate' }} Color
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
