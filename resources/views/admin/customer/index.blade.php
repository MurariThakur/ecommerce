@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                @include('admin.layouts.message')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Customer Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Customer Management</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Search Card -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-search"></i> Search Customers</h3>
                                <div class="card-tools d-md-none">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="GET" action="{{ route('admin.customer.index') }}">
                                    <div class="row">
                                        <div class="col-lg-11 col-md-10">
                                            <div class="row mb-3">
                                                <div class="col-lg-4 col-md-6 col-12 mb-2">
                                                    <input type="text" class="form-control" name="search"
                                                        placeholder="Search customers..." value="{{ request('search') }}">
                                                </div>
                                                <div class="col-lg-2 col-md-6 col-6 mb-2">
                                                    <select class="form-control" name="status">
                                                        <option value="">Status</option>
                                                        <option value="active"
                                                            {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="inactive"
                                                            {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-6 mb-2">
                                                    <input type="date" class="form-control" name="date_from"
                                                        value="{{ request('date_from') }}">
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-6 mb-2">
                                                    <input type="date" class="form-control" name="date_to"
                                                        value="{{ request('date_to') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="col-lg-1 col-md-2 col-12 d-flex align-items-lg-start align-items-center justify-content-center">
                                            <div class="d-flex flex-row justify-content-center">
                                                <button type="submit" class="btn btn-primary mr-2">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                                @if (request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                                                    <a href="{{ route('admin.customer.index') }}" class="btn btn-secondary">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Customers Table Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Customers</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Email Verified</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($customers as $customer)
                                            <tr>
                                                <td><strong>{{ $customer->name }}</strong></td>
                                                <td>{{ $customer->email }}</td>
                                                <td>
                                                    @if ($customer->is_active)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($customer->email_verified_at)
                                                        <span class="badge badge-success">
                                                            <i class="fas fa-check-circle"></i> Verified
                                                        </span>
                                                    @else
                                                        <span class="badge badge-warning">
                                                            <i class="fas fa-clock"></i> Pending
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>{{ $customer->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="{{ route('admin.customer.show', $customer) }}"
                                                            class="btn btn-primary btn-sm" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm ml-1"
                                                            title="Delete" data-toggle="modal"
                                                            data-target="#deleteModal{{ $customer->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <form
                                                            action="{{ route('admin.customer.toggle.status', $customer) }}"
                                                            method="POST" style="display: inline-block;">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-sm {{ $customer->is_active ? 'btn-warning' : 'btn-success' }} ml-1"
                                                                title="{{ $customer->is_active ? 'Deactivate' : 'Activate' }}">
                                                                <i
                                                                    class="fas fa-{{ $customer->is_active ? 'ban' : 'check' }}"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    <i class="fas fa-users fa-3x mb-3"></i>
                                                    <p>No customers found.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($customers->hasPages())
                                <div class="card-footer clearfix">
                                    <div class="float-right">
                                        {{ $customers->links() }}
                                    </div>
                                    <div class="float-left">
                                        <small class="text-muted">
                                            Showing {{ $customers->firstItem() ?? 0 }} to
                                            {{ $customers->lastItem() ?? 0 }}
                                            of {{ $customers->total() }} results
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

    <!-- Delete Confirmation Modals -->
    @foreach ($customers as $customer)
        <div class="modal fade" id="deleteModal{{ $customer->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                            Confirm Deletion
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete customer <strong>{{ $customer->name }}</strong>?</p>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone!
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.customer.destroy', $customer) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete Customer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
