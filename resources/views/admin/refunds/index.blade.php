@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Refunds Management</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Search Card -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-search"></i> Search Refunds</h3>
                            <div class="card-tools d-md-none">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" id="searchCardBody">
                            <form method="GET" action="{{ route('admin.refunds.index') }}">
                                <div class="row">
                                    <div class="col-lg-11 col-md-10">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-12 mb-2">
                                                <input type="text" class="form-control" name="search"
                                                    placeholder="Search by refund #, order #, customer..."
                                                    value="{{ request('search') }}">
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-6 mb-2">
                                                <select class="form-control" name="status">
                                                    <option value="">All Status</option>
                                                    <option value="initiated" {{ request('status') === 'initiated' ? 'selected' : '' }}>Initiated</option>
                                                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                                                    <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                                                    <option value="processed" {{ request('status') === 'processed' ? 'selected' : '' }}>Processed</option>
                                                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-6 mb-2">
                                                <select class="form-control" name="type">
                                                    <option value="">All Types</option>
                                                    <option value="cancellation" {{ request('type') === 'cancellation' ? 'selected' : '' }}>Cancellation</option>
                                                    <option value="return" {{ request('type') === 'return' ? 'selected' : '' }}>Return</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-6 mb-2">
                                                <input type="date" class="form-control" name="date_from"
                                                    value="{{ request('date_from') }}" placeholder="From Date">
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-6 mb-2">
                                                <input type="date" class="form-control" name="date_to"
                                                    value="{{ request('date_to') }}" placeholder="To Date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-md-2 col-12 d-flex align-items-lg-start align-items-center justify-content-center">
                                        <div class="d-flex flex-row justify-content-center">
                                            <button type="submit" class="btn btn-primary mr-2">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            @if (request()->hasAny(['search', 'status', 'type', 'date_from', 'date_to']))
                                                <a href="{{ route('admin.refunds.index') }}" class="btn btn-secondary">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Refunds Table Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Refunds</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Refund #</th>
                                            <th>Order #</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($refunds as $refund)
                                            <tr>
                                                <td>{{ $refund->refund_number }}</td>
                                                <td>{{ $refund->order->order_number }}</td>
                                                <td>{{ $refund->order->user->name }}</td>
                                                <td>${{ number_format($refund->amount, 2) }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $refund->type === 'cancellation' ? 'warning' : 'info' }}">
                                                        {{ ucfirst($refund->type) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ $refund->status === 'processed' ? 'success' : ($refund->status === 'failed' ? 'danger' : 'warning') }}">
                                                        {{ ucfirst($refund->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $refund->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.refunds.show', $refund->id) }}" class="btn btn-sm btn-primary">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No refunds found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $refunds->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection