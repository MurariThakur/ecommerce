@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('admin.layouts.message')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Discount Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Discount Management</li>
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
                                <h3 class="card-title">Discounts</h3>
                                <div class="card-tools">
                                    <a href="{{ route('admin.discount.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Add New Discount
                                    </a>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Amount/Percentage</th>
                                            <th>Expire Date</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($discounts as $discount)
                                            <tr>
                                                <td><strong>{{ $discount->name }}</strong></td>
                                                <td>{{ ucfirst($discount->type) }}</td>
                                                <td>
                                                    @if ($discount->type === 'percentage')
                                                        {{ $discount->value }}%
                                                    @else
                                                        ${{ number_format($discount->value, 2) }}
                                                    @endif
                                                </td>
                                                <td>{{ $discount->expire_date->format('M d, Y') }}</td>
                                                <td>
                                                    @if ($discount->status)
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
                                                    <span title="{{ $discount->created_at->format('M d, Y H:i:s') }}">
                                                        {{ $discount->created_at->format('M d, Y') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="{{ route('admin.discount.show', $discount) }}"
                                                            class="btn btn-primary btn-sm" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.discount.edit', $discount) }}"
                                                            class="btn btn-info btn-sm ml-1" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button"
                                                            class="btn btn-sm {{ $discount->status ? 'btn-warning' : 'btn-success' }} ml-1"
                                                            title="{{ $discount->status ? 'Deactivate' : 'Activate' }}"
                                                            data-toggle="modal"
                                                            data-target="#statusModal{{ $discount->id }}">
                                                            <i
                                                                class="fas fa-{{ $discount->status ? 'ban' : 'check' }}"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm ml-1"
                                                            title="Delete" data-toggle="modal"
                                                            data-target="#deleteModal{{ $discount->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    <i class="fas fa-tags fa-3x mb-3"></i>
                                                    <p>No discounts found.</p>
                                                    <a href="{{ route('admin.discount.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus"></i> Create First Discount
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($discounts->hasPages())
                                <div class="card-footer clearfix">
                                    <div class="float-right">
                                        {{ $discounts->links() }}
                                    </div>
                                    <div class="float-left">
                                        <small class="text-muted">
                                            Showing {{ $discounts->firstItem() ?? 0 }} to
                                            {{ $discounts->lastItem() ?? 0 }}
                                            of {{ $discounts->total() }} results
                                        </small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modals -->
    @foreach ($discounts as $discount)
        <div class="modal fade" id="deleteModal{{ $discount->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel{{ $discount->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle text-warning"></i> Confirm Deletion
                        </h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this discount?</p>
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Discount Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Name:</strong></div>
                                    <div class="col-sm-8">{{ $discount->name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Type:</strong></div>
                                    <div class="col-sm-8">{{ ucfirst($discount->type) }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Amount:</strong></div>
                                    <div class="col-sm-8">
                                        @if ($discount->type === 'percentage')
                                            {{ $discount->amount_percentage }}%
                                        @else
                                            ${{ number_format($discount->amount_percentage, 2) }}
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Expire Date:</strong></div>
                                    <div class="col-sm-8">{{ $discount->expire_date->format('M d, Y') }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Status:</strong></div>
                                    <div class="col-sm-8">
                                        @if ($discount->status)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-danger mt-3">
                            <i class="fas fa-exclamation-circle"></i> <strong>This action cannot be undone!</strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fas fa-times"></i> Cancel</button>
                        <form action="{{ route('admin.discount.destroy', $discount) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete
                                Discount</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Status Toggle Modals -->
    @foreach ($discounts as $discount)
        <div class="modal fade" id="statusModal{{ $discount->id }}" tabindex="-1" role="dialog"
            aria-labelledby="statusModalLabel{{ $discount->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-{{ $discount->status ? 'ban text-warning' : 'check text-success' }}"></i>
                            {{ $discount->status ? 'Deactivate' : 'Activate' }} Discount
                        </h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to {{ $discount->status ? 'deactivate' : 'activate' }} this discount?</p>
                        <div class="card card-outline {{ $discount->status ? 'card-warning' : 'card-success' }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Name:</strong></div>
                                    <div class="col-sm-8">{{ $discount->name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Current Status:</strong></div>
                                    <div class="col-sm-8">
                                        @if ($discount->status)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>New Status:</strong></div>
                                    <div class="col-sm-8">
                                        @if ($discount->status)
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fas fa-times"></i> Cancel</button>
                        <form action="{{ route('admin.discount.toggle.status', $discount) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn {{ $discount->status ? 'btn-warning' : 'btn-success' }}">
                                <i class="fas fa-{{ $discount->status ? 'ban' : 'check' }}"></i>
                                {{ $discount->status ? 'Deactivate' : 'Activate' }} Discount
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
