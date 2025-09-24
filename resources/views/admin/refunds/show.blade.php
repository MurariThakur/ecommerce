@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Refund Details</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Refund Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Refund Number:</strong> {{ $refund->refund_number }}<br>
                                    <strong>Order Number:</strong> {{ $refund->order->order_number }}<br>
                                    <strong>Customer:</strong> {{ $refund->order->user->name }}<br>
                                    <strong>Email:</strong> {{ $refund->order->user->email }}<br>
                                </div>
                                <div class="col-md-6">
                                    <strong>Amount:</strong> ${{ number_format($refund->amount, 2) }}<br>
                                    <strong>Type:</strong> {{ ucfirst($refund->type) }}<br>
                                    <strong>Payment Method:</strong> {{ ucfirst($refund->payment_method) }}<br>
                                    <strong>Status:</strong> 
                                    <span class="badge badge-{{ $refund->status === 'processed' ? 'success' : ($refund->status === 'failed' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($refund->status) }}
                                    </span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <strong>Reason:</strong><br>
                                    <p>{{ $refund->reason }}</p>
                                </div>
                            </div>
                            @if($refund->processed_at)
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <strong>Processed At:</strong> {{ $refund->processed_at->format('M d, Y H:i') }}<br>
                                        @if($refund->refund_data && isset($refund->refund_data['processed_by']))
                                            <strong>Processed By:</strong> {{ $refund->refund_data['processed_by'] }}
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    @if($refund->status === 'initiated')
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Actions</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.refunds.approve', $refund->id) }}" method="POST" class="mb-3">
                                    @csrf
                                    <div class="form-group">
                                        <label>Admin Notes</label>
                                        <textarea name="notes" class="form-control" rows="3" placeholder="Optional notes..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block" 
                                        onclick="return confirm('Approve this refund?')">
                                        Approve Refund
                                    </button>
                                </form>
                                
                                <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#rejectModal">
                                    Reject Refund
                                </button>
                            </div>
                        </div>
                    @elseif($refund->status === 'approved' && $refund->payment_method === 'cod')
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Manual Processing</h3>
                            </div>
                            <div class="card-body">
                                <p class="text-info">COD refund approved. Process manually and mark as completed.</p>
                                <form action="{{ route('admin.refunds.process', $refund->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Mark as Completed
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Refund</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.refunds.reject', $refund->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Rejection Reason *</label>
                        <textarea name="reason" class="form-control" rows="4" required 
                            placeholder="Please provide reason for rejection..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Refund</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection