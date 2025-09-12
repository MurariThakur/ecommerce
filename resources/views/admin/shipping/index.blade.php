@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('admin.layouts.message')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Shipping Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Shipping Management</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Shipping Methods</h3>
                                <div class="card-tools">
                                    <a href="{{ route('admin.shipping.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Add Shipping Method
                                    </a>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($shippings as $shipping)
                                            <tr>
                                                <td><strong>{{ $shipping->name }}</strong></td>
                                                <td>${{ number_format($shipping->price, 2) }}</td>
                                                <td>
                                                    @if ($shipping->status)
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
                                                    <span title="{{ $shipping->created_at->format('M d, Y H:i:s') }}">
                                                        {{ $shipping->created_at->format('M d, Y') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="{{ route('admin.shipping.show', $shipping) }}"
                                                            class="btn btn-primary btn-sm" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.shipping.edit', $shipping) }}"
                                                            class="btn btn-info btn-sm ml-1" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button"
                                                            class="btn btn-sm {{ $shipping->status ? 'btn-warning' : 'btn-success' }} ml-1"
                                                            title="{{ $shipping->status ? 'Deactivate' : 'Activate' }}"
                                                            data-toggle="modal"
                                                            data-target="#statusModal{{ $shipping->id }}">
                                                            <i class="fas fa-{{ $shipping->status ? 'ban' : 'check' }}"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm ml-1"
                                                            title="Delete" data-toggle="modal"
                                                            data-target="#deleteModal{{ $shipping->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No shipping methods found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            @if($shippings->hasPages())
                                <div class="card-footer clearfix">
                                    {{ $shippings->links() }}
                                </div>
                            @endif
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Change Modals -->
    @foreach($shippings as $shipping)
        <div class="modal fade" id="statusModal{{ $shipping->id }}" tabindex="-1" role="dialog"
            aria-labelledby="statusModalLabel{{ $shipping->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel{{ $shipping->id }}">
                            {{ $shipping->status ? 'Deactivate' : 'Activate' }} Shipping Method
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to {{ $shipping->status ? 'deactivate' : 'activate' }} the shipping method
                        <strong>{{ $shipping->name }}</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.shipping.toggle.status', $shipping) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="btn {{ $shipping->status ? 'btn-warning' : 'btn-success' }}">
                                {{ $shipping->status ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modals -->
        <div class="modal fade" id="deleteModal{{ $shipping->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel{{ $shipping->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $shipping->id }}">Delete Shipping Method</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete shipping method <strong>{{ $shipping->name }}</strong>?
                        This action cannot be undone.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.shipping.destroy', $shipping) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
