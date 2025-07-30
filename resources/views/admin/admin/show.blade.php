@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin Management</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
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
                                <i class="fas fa-user-shield"></i> Admin Details
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit Admin
                                </a>
                                <a href="{{ route('admin.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <img src="{{ $admin->avatar_url ?? 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($admin->email))) . '?d=mp' }}" class="img-fluid rounded-circle shadow-sm mb-3" alt="{{ $admin->name }}'s Avatar">
                                    <h3 class="profile-username">{{ $admin->name }}</h3>
                                    <p class="text-muted">{{ $admin->email }}</p>
                                </div>

                                <div class="col-md-8">
                                    <!-- Admin Information -->
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-info-circle"></i> Admin Information
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td width="150"><strong>Name</strong></td>
                                                    <td>{{ $admin->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Email Address</strong></td>
                                                    <td>{{ $admin->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Role</strong></td>
                                                    <td>
                                                        @if($admin->is_admin)
                                                            <span class="badge badge-info">Admin</span>
                                                        @else
                                                            <span class="badge badge-secondary">User</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status</strong></td>
                                                    <td>
                                                        @if($admin->is_active)
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
                                                    <td>{{ $admin->email_verified_at ? $admin->email_verified_at->format('M d, Y H:i:s') : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Joined At</strong></td>
                                                    <td>{{ $admin->created_at->format('M d, Y H:i:s') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Last Updated At</strong></td>
                                                    <td>{{ $admin->updated_at->format('M d, Y H:i:s') }}</td>
                                                </tr>
                                            </table>
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
@endsection
