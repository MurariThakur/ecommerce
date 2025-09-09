@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">View Discount</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.discount.index') }}">Discount Management</a></li>
                        <li class="breadcrumb-item active">View Discount</li>
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
                                <i class="fas fa-eye"></i> Discount Details
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.discount.edit', $discount) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit Discount
                                </a>
                                <a href="{{ route('admin.discount.index') }}" class="btn btn-secondary btn-sm">
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
                                                <i class="fas fa-info-circle"></i> Basic Information
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td width="200"><strong>ID</strong></td>
                                                    <td>{{ $discount->id }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Name</strong></td>
                                                    <td>{{ $discount->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Type</strong></td>
                                                    <td>{{ ucfirst($discount->type) }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Amount/Percentage</strong></td>
                                                    <td>
                                                        @if($discount->type === 'percentage')
                                                            {{ $discount->amount_percentage }}%
                                                        @else
                                                            ${{ number_format($discount->amount_percentage, 2) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Expiry Date</strong></td>
                                                    <td>{{ $discount->expire_date->format('M d, Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status</strong></td>
                                                    <td>
                                                        @if($discount->status)
                                                            <span class="badge badge-success">
                                                                <i class="fas fa-check-circle"></i> Active
                                                            </span>
                                                        @else
                                                            <span class="badge badge-danger">
                                                                <i class="fas fa-times-circle"></i> Inactive
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Created At</strong></td>
                                                    <td>{{ $discount->created_at->format('M d, Y H:i:s') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Updated At</strong></td>
                                                    <td>{{ $discount->updated_at->format('M d, Y H:i:s') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <!-- Quick Actions -->
                                    <div class="card card-outline card-success">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-cogs"></i> Quick Actions
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-grid gap-2">
                                                <!-- Edit Button -->
                                                <a href="{{ route('admin.discount.edit', $discount) }}" class="btn btn-warning btn-block">
                                                    <i class="fas fa-edit"></i> Edit Discount
                                                </a>

                                                <!-- Toggle Status Button -->
                                                <button type="button"
                                                        class="btn btn-block {{ $discount->status ? 'btn-secondary' : 'btn-success' }}"
                                                        data-toggle="modal"
                                                        data-target="#statusModal">
                                                    <i class="fas fa-{{ $discount->status ? 'ban' : 'check' }}"></i>
                                                    {{ $discount->status ? 'Deactivate' : 'Activate' }} Discount
                                                </button>

                                                <!-- Delete Button -->
                                                <button type="button"
                                                        class="btn btn-danger btn-block"
                                                        data-toggle="modal"
                                                        data-target="#deleteModal">
                                                    <i class="fas fa-trash"></i> Delete Discount
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Discount Statistics -->
                                    <div class="card card-outline card-warning">
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
                                                    <span class="info-box-text">Days Until Expiry</span>
                                                    <span class="info-box-number">
                                                        {{ now()->diffInDays($discount->expire_date, false) > 0 ? now()->diffInDays($discount->expire_date) : 0 }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="info-box">
                                                <span class="info-box-icon bg-success">
                                                    <i class="fas fa-calendar-plus"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Days Since Created</span>
                                                    <span class="info-box-number">{{ $discount->created_at->diffInDays(now()) }}</span>
                                                </div>
                                            </div>

                                            <div class="info-box">
                                                <span class="info-box-icon bg-warning">
                                                    <i class="fas fa-clock"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Last Updated</span>
                                                    <span class="info-box-number text-sm">{{ $discount->updated_at->diffForHumans() }}</span>
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

<!-- Status Toggle Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">
                    <i class="fas fa-{{ $discount->status ? 'ban text-warning' : 'check text-success' }}"></i>
                    {{ $discount->status ? 'Deactivate' : 'Activate' }} Discount
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to {{ $discount->status ? 'deactivate' : 'activate' }} this discount?</p>
                <div class="alert alert-info">
                    <strong>Discount:</strong> {{ $discount->name }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <form action="{{ route('admin.discount.toggle.status', $discount) }}" method="POST" style="display: inline-block;">
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Deletion
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this discount?</p>
                <div class="alert alert-danger">
                    <strong>Warning:</strong> This action cannot be undone!<br>
                    <strong>Discount:</strong> {{ $discount->name }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <form action="{{ route('admin.discount.destroy', $discount) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete Discount
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
