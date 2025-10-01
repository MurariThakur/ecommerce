@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">View FAQ</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.faq.index') }}">FAQ Management</a></li>
                            <li class="breadcrumb-item active">View FAQ</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-eye"></i> FAQ Details
                                </h3>
                                <div class="card-tools">
                                    <a href="{{ route('admin.faq.edit', $faq) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit FAQ
                                    </a>
                                    <a href="{{ route('admin.faq.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-arrow-left"></i> Back to List
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="card card-outline card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <i class="fas fa-info-circle"></i> FAQ Information
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td width="150"><strong>Question</strong></td>
                                                        <td>{{ $faq->question }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Answer</strong></td>
                                                        <td>
                                                            <div class="text-wrap">{{ $faq->answer }}</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Category</strong></td>
                                                        <td><span
                                                                class="badge badge-info">{{ ucfirst($faq->category) }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Sort Order</strong></td>
                                                        <td>{{ $faq->sort_order }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Status</strong></td>
                                                        <td>
                                                            @if ($faq->status)
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
                                                        <td>{{ $faq->created_at->format('M d, Y H:i:s') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Updated At</strong></td>
                                                        <td>{{ $faq->updated_at->format('M d, Y H:i:s') }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card card-outline card-success">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <i class="fas fa-cogs"></i> Quick Actions
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-grid gap-2">
                                                    <a href="{{ route('admin.faq.edit', $faq) }}"
                                                        class="btn btn-warning btn-block">
                                                        <i class="fas fa-edit"></i> Edit FAQ
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-block"
                                                        data-toggle="modal" data-target="#deleteModal">
                                                        <i class="fas fa-trash"></i> Delete FAQ
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

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
                                                        <span class="info-box-text">Days Since Created</span>
                                                        <span
                                                            class="info-box-number">{{ $faq->created_at->diffInDays(now()) }}</span>
                                                    </div>
                                                </div>

                                                <div class="info-box">
                                                    <span class="info-box-icon bg-success">
                                                        <i class="fas fa-clock"></i>
                                                    </span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Last Updated</span>
                                                        <span
                                                            class="info-box-number text-sm">{{ $faq->updated_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
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
                    <p>Are you sure you want to delete this FAQ?</p>
                    <div class="alert alert-danger">
                        <strong>Warning:</strong> This action cannot be undone!<br>
                        <strong>Question:</strong> {{ $faq->question }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.faq.destroy', $faq) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete FAQ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
