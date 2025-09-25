@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">View Refund</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.refunds.index') }}">Refund Management</a>
                            </li>
                            <li class="breadcrumb-item active">View Refund</li>
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
                                <h3 class="card-title">
                                    <i class="fas fa-eye"></i> Refund Details
                                </h3>
                                <div class="card-tools">
                                    <a href="{{ route('admin.refunds.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-arrow-left"></i> Back to List
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <!-- Basic Information -->
                                        <div class="card card-outline card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <i class="fas fa-info-circle"></i> Refund Information
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td width="150"><strong>Refund Number</strong></td>
                                                        <td>{{ $refund->refund_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Order Number</strong></td>
                                                        <td>{{ $refund->order->order_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Customer</strong></td>
                                                        <td>{{ $refund->order->user->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Email</strong></td>
                                                        <td><a href="mailto:{{ $refund->order->user->email }}"
                                                                class="text-primary">{{ $refund->order->user->email }}</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Amount</strong></td>
                                                        <td><strong
                                                                class="text-success">${{ number_format($refund->amount, 2) }}</strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Type</strong></td>
                                                        <td>
                                                            <span
                                                                class="badge badge-{{ $refund->type === 'cancellation' ? 'warning' : 'info' }}">
                                                                <i
                                                                    class="fas fa-{{ $refund->type === 'cancellation' ? 'times' : 'undo' }}"></i>
                                                                {{ ucfirst($refund->type) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Payment Method</strong></td>
                                                        <td>{{ ucfirst($refund->payment_method) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Status</strong></td>
                                                        <td>
                                                            <span
                                                                class="badge badge-{{ $refund->status === 'processed' ? 'success' : ($refund->status === 'failed' ? 'danger' : 'warning') }}">
                                                                <i
                                                                    class="fas fa-{{ $refund->status === 'processed' ? 'check-circle' : ($refund->status === 'failed' ? 'times-circle' : 'clock') }}"></i>
                                                                {{ ucfirst($refund->status) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Created At</strong></td>
                                                        <td>{{ $refund->created_at->format('M d, Y H:i:s') }}</td>
                                                    </tr>
                                                    @if ($refund->processed_at)
                                                        <tr>
                                                            <td><strong>Processed At</strong></td>
                                                            <td>{{ $refund->processed_at->format('M d, Y H:i:s') }}</td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Refund Reason -->
                                        <div class="card card-outline card-info">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <i class="fas fa-comment"></i> Refund Reason
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="text-wrap">{{ $refund->reason }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        @if ($refund->status === 'initiated')
                                            <!-- Quick Actions -->
                                            <div class="card card-outline card-success">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        <i class="fas fa-cogs"></i> Quick Actions
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <form action="{{ route('admin.refunds.approve', $refund->id) }}"
                                                        method="POST" class="mb-3">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label>Admin Notes</label>
                                                            <textarea name="notes" class="form-control" rows="3" placeholder="Optional notes..."></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-success btn-block"
                                                            onclick="return confirm('Approve this refund?')">
                                                            <i class="fas fa-check"></i> Approve Refund
                                                        </button>
                                                    </form>

                                                    <button type="button" class="btn btn-danger btn-block"
                                                        data-toggle="modal" data-target="#rejectModal">
                                                        <i class="fas fa-times"></i> Reject Refund
                                                    </button>
                                                </div>
                                            </div>
                                        @elseif($refund->status === 'approved' && $refund->payment_method === 'cod')
                                            <!-- Manual Processing -->
                                            <div class="card card-outline card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        <i class="fas fa-hand-paper"></i> Manual Processing
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <p class="text-info">COD refund approved. Process manually and mark as
                                                        completed.</p>
                                                    <form action="{{ route('admin.refunds.process', $refund->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-block">
                                                            <i class="fas fa-check-circle"></i> Mark as Completed
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Refund Statistics -->
                                        <div class="card card-outline card-info">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <i class="fas fa-chart-bar"></i> Statistics
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-info">
                                                        <i class="fas fa-calendar"></i>
                                                    </span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Days Since Created</span>
                                                        <span
                                                            class="info-box-number">{{ $refund->created_at->diffInDays(now()) }}</span>
                                                    </div>
                                                </div>

                                                <div class="info-box">
                                                    <span class="info-box-icon bg-success">
                                                        <i class="fas fa-clock"></i>
                                                    </span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Created</span>
                                                        <span
                                                            class="info-box-number text-sm">{{ $refund->created_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
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

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        Reject Refund
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.refunds.reject', $refund->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Rejection Reason <span class="text-danger">*</span></label>
                            <textarea name="reason" class="form-control" rows="4" required
                                placeholder="Please provide reason for rejection..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-ban"></i> Reject Refund
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
