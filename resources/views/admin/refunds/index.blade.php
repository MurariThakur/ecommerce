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