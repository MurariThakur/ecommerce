@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Customer Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.customer.index') }}">Customer
                                    Management</a></li>
                            <li class="breadcrumb-item active">Customer Details</li>
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
                                    <i class="fas fa-user"></i> Customer Details
                                </h3>
                                <div class="card-tools">
                                    <a href="{{ route('admin.customer.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-arrow-left"></i> Back to List
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($customer->email))) }}?d=mp"
                                            class="img-fluid rounded-circle shadow-sm mb-3"
                                            alt="{{ $customer->name }}'s Avatar">
                                        <h3 class="profile-username">{{ $customer->name }}</h3>
                                        <p class="text-muted">{{ $customer->email }}</p>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="card card-outline card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <i class="fas fa-info-circle"></i> Customer Information
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td width="150"><strong>Name</strong></td>
                                                        <td>{{ $customer->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Email Address</strong></td>
                                                        <td>{{ $customer->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Role</strong></td>
                                                        <td><span class="badge badge-info">Customer</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Status</strong></td>
                                                        <td>
                                                            @if ($customer->is_active)
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
                                                        <td><strong>Email Verified At</strong></td>
                                                        <td>{{ $customer->email_verified_at ? $customer->email_verified_at->format('M d, Y H:i:s') : '-' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Joined At</strong></td>
                                                        <td>{{ $customer->created_at->format('M d, Y H:i:s') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Last Updated At</strong></td>
                                                        <td>{{ $customer->updated_at->format('M d, Y H:i:s') }}</td>
                                                    </tr>
                                                </table>
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
@endsection
