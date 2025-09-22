@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('admin.layouts.message')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Order Management</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Order Management</li>
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
                        <!-- Search Card -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-search"></i> Search Orders</h3>
                            </div>
                            <div class="card-body">
                                <form method="GET" action="{{ route('admin.order.index') }}" class="row g-3">
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="search"
                                            placeholder="Search by order number, customer name, email, phone..."
                                            value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control" name="status">
                                            <option value="">All Status</option>
                                            <option value="confirmed"
                                                {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="processing"
                                                {{ request('status') == 'processing' ? 'selected' : '' }}>Processing
                                            </option>
                                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>
                                                Shipped</option>
                                            <option value="delivered"
                                                {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled"
                                                {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control" name="payment_status">
                                            <option value="">All Payment Status</option>
                                            <option value="paid"
                                                {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="unpaid"
                                                {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" class="form-control" name="date_from" placeholder="From Date"
                                            value="{{ request('date_from') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" class="form-control" name="date_to" placeholder="To Date"
                                            value="{{ request('date_to') }}">
                                    </div>
                                    <div class="col-md-1">
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            @if (request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                                                <a href="{{ route('admin.order.index') }}" class="btn btn-secondary ml-1">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Orders Table Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Orders</h3>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Order Number</th>
                                            <th>Customer</th>
                                            <th>Total</th>
                                            <th>Payment Status</th>
                                            <th>Order Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($orders as $order)
                                            <tr>
                                                <td>
                                                    <strong>{{ $order->order_number }}</strong>
                                                </td>
                                                <td>
                                                    {{ $order->first_name }} {{ $order->last_name }}
                                                    @if ($order->user)
                                                        <br><small class="text-muted">{{ $order->user->email }}</small>
                                                    @else
                                                        <br><small class="text-muted">{{ $order->email }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>${{ number_format($order->total, 2) }}</strong>
                                                </td>
                                                <td>
                                                    @if ($order->is_payment)
                                                        <span class="badge badge-success">
                                                            <i class="fas fa-check-circle"></i> Paid
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger">
                                                            <i class="fas fa-times-circle"></i> Unpaid
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @switch($order->status)
                                                        @case('confirmed')
                                                            <span class="badge badge-success">
                                                                <i class="fas fa-check-circle"></i> Confirmed
                                                            </span>
                                                        @break

                                                        @case('processing')
                                                            <span class="badge badge-info">
                                                                <i class="fas fa-cog"></i> Processing
                                                            </span>
                                                        @break

                                                        @case('shipped')
                                                            <span class="badge badge-primary">
                                                                <i class="fas fa-shipping-fast"></i> Shipped
                                                            </span>
                                                        @break

                                                        @case('delivered')
                                                            <span class="badge badge-success">
                                                                <i class="fas fa-check"></i> Delivered
                                                            </span>
                                                        @break

                                                        @case('cancelled')
                                                            <span class="badge badge-danger">
                                                                <i class="fas fa-ban"></i> Cancelled
                                                            </span>
                                                        @break

                                                        @default
                                                            <span class="badge badge-secondary">Unknown</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    <span title="{{ $order->created_at->format('M d, Y H:i:s') }}">
                                                        {{ $order->created_at->format('M d, Y') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <!-- View Button -->
                                                        <a href="{{ route('admin.order.show', $order) }}"
                                                            class="btn btn-primary btn-sm" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                        <!-- Update Status Button -->
                                                        <button type="button" class="btn btn-info btn-sm ml-1"
                                                            title="Update Status" data-toggle="modal"
                                                            data-target="#statusModal{{ $order->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <!-- Toggle Payment Status Button (Only for COD) -->
                                                        @if ($order->payment_method == 'cash')
                                                            <button type="button"
                                                                class="btn btn-sm {{ $order->is_payment ? 'btn-warning' : 'btn-success' }} ml-1"
                                                                title="{{ $order->is_payment ? 'Mark as Unpaid' : 'Mark as Paid' }}"
                                                                data-toggle="modal"
                                                                data-target="#paymentModal{{ $order->id }}">
                                                                <i
                                                                    class="fas fa-{{ $order->is_payment ? 'times' : 'check' }}"></i>
                                                            </button>
                                                        @endif

                                                        <!-- Delete Button -->
                                                        <button type="button" class="btn btn-danger btn-sm ml-1"
                                                            title="Delete" data-toggle="modal"
                                                            data-target="#deleteModal{{ $order->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted py-4">
                                                        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                                        <p>No orders found.</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                @if ($orders->hasPages())
                                    <div class="card-footer clearfix">
                                        <div class="float-right">
                                            {{ $orders->links() }}
                                        </div>
                                        <div class="float-left">
                                            <small class="text-muted">
                                                Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }}
                                                of {{ $orders->total() }} results
                                                @if (request()->hasAny(['search', 'status', 'payment_status', 'date_from', 'date_to']))
                                                    (filtered)
                                                @endif
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
        @foreach ($orders as $order)
            <div class="modal fade" id="deleteModal{{ $order->id }}" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalLabel{{ $order->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $order->id }}">
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                Confirm Deletion
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-3">Are you sure you want to delete this order?</p>

                            <div class="card card-outline card-danger">
                                <div class="card-header">
                                    <h3 class="card-title">Order Details</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Order Number:</strong></div>
                                        <div class="col-sm-8">{{ $order->order_number }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Customer:</strong></div>
                                        <div class="col-sm-8">{{ $order->first_name }} {{ $order->last_name }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Total:</strong></div>
                                        <div class="col-sm-8">${{ number_format($order->total, 2) }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Status:</strong></div>
                                        <div class="col-sm-8">
                                            <span class="badge badge-secondary">{{ ucfirst($order->status) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-danger mt-3">
                                <i class="fas fa-exclamation-circle"></i>
                                <strong>This action cannot be undone!</strong> All data associated with this order will be
                                permanently deleted.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                            <form action="{{ route('admin.order.destroy', $order) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Delete Order
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Status Update Modals -->
        @foreach ($orders as $order)
            <div class="modal fade" id="statusModal{{ $order->id }}" tabindex="-1" role="dialog"
                aria-labelledby="statusModalLabel{{ $order->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="statusModalLabel{{ $order->id }}">
                                <i class="fas fa-edit text-info"></i>
                                Update Order Status
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.order.update', $order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="card card-outline card-info">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-sm-4"><strong>Order Number:</strong></div>
                                            <div class="col-sm-8">{{ $order->order_number }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4"><strong>Customer:</strong></div>
                                            <div class="col-sm-8">{{ $order->first_name }} {{ $order->last_name }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4"><strong>Current Status:</strong></div>
                                            <div class="col-sm-8">
                                                <span class="badge badge-secondary">{{ ucfirst($order->status) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="status{{ $order->id }}">New Status <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="status{{ $order->id }}" name="status" required>
                                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>
                                            Confirmed</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                            Processing</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped
                                        </option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                            Delivered</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-save"></i> Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Payment Status Toggle Modals (Only for COD) -->
        @foreach ($orders as $order)
            @if ($order->payment_method == 'cod')
                <div class="modal fade" id="paymentModal{{ $order->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="paymentModalLabel{{ $order->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="paymentModalLabel{{ $order->id }}">
                                    <i
                                        class="fas fa-{{ $order->is_payment ? 'times text-warning' : 'check text-success' }}"></i>
                                    {{ $order->is_payment ? 'Mark as Unpaid' : 'Mark as Paid' }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-3">Are you sure you want to
                                    {{ $order->is_payment ? 'mark this order as unpaid' : 'mark this order as paid' }}?</p>

                                <div class="card card-outline {{ $order->is_payment ? 'card-warning' : 'card-success' }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4"><strong>Order Number:</strong></div>
                                            <div class="col-sm-8">{{ $order->order_number }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4"><strong>Total:</strong></div>
                                            <div class="col-sm-8">${{ number_format($order->total, 2) }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4"><strong>Current Payment Status:</strong></div>
                                            <div class="col-sm-8">
                                                @if ($order->is_payment)
                                                    <span class="badge badge-success">Paid</span>
                                                @else
                                                    <span class="badge badge-danger">Unpaid</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4"><strong>New Payment Status:</strong></div>
                                            <div class="col-sm-8">
                                                @if ($order->is_payment)
                                                    <span class="badge badge-danger">Unpaid</span>
                                                @else
                                                    <span class="badge badge-success">Paid</span>
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
                                <form action="{{ route('admin.order.toggle.payment', $order) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    <button type="submit"
                                        class="btn {{ $order->is_payment ? 'btn-warning' : 'btn-success' }}">
                                        <i class="fas fa-{{ $order->is_payment ? 'times' : 'check' }}"></i>
                                        {{ $order->is_payment ? 'Mark as Unpaid' : 'Mark as Paid' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endsection
