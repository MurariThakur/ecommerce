@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            @include('admin.layouts.message')
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title ?? 'Edit Admin' }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Admin Management</a></li>
                        <li class="breadcrumb-item active">{{ $title ?? 'Edit Admin' }}</li>
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
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Admin Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" action="{{ route('admin.update', $admin->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" placeholder="Enter full name"
                                           value="{{ old('name', $admin->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" placeholder="Enter email address"
                                           value="{{ old('email', $admin->email) }}" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">New Password <small class="text-muted">(Leave blank to keep current password)</small></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           id="password" name="password" placeholder="Enter new password"
                                           minlength="6">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">Password must be at least 6 characters long if provided.</small>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Confirm New Password</label>
                                    <input type="password" class="form-control"
                                           id="password_confirmation" name="password_confirmation"
                                           placeholder="Confirm new password" minlength="6">
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                               id="is_active" name="is_active"
                                               {{ old('is_active', $admin->is_active) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">
                                            Active Status
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        Active admins can login and access the admin panel.
                                    </small>
                                </div>

                                @if($admin->locked_until && $admin->locked_until->isFuture())
                                    <div class="alert alert-warning">
                                        <i class="fas fa-lock"></i>
                                        <strong>Account Locked:</strong> This admin account is currently locked until
                                        {{ $admin->locked_until->format('M d, Y H:i') }}
                                        ({{ $admin->locked_until->diffForHumans() }}).

                                        <form method="POST" action="{{ route('admin.unlock', $admin->id) }}" class="d-inline ml-2">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-unlock"></i> Unlock Account
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Admin
                                </button>
                                <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>

                                @if($admin->id !== Auth::id())
                                    <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteModal">
                                        <i class="fas fa-trash"></i> Delete Admin
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle"></i> Admin Information
                            </h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>ID:</strong></td>
                                    <td>{{ $admin->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $admin->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Last Updated:</strong></td>
                                    <td>{{ $admin->updated_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Last Login:</strong></td>
                                    <td>
                                        @if($admin->last_login)
                                            {{ $admin->last_login->format('M d, Y H:i') }}
                                            <small class="text-muted d-block">
                                                ({{ $admin->last_login->diffForHumans() }})
                                            </small>
                                        @else
                                            <span class="text-muted">Never</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($admin->is_active)
                                            @if($admin->isLocked())
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-lock"></i> Locked
                                                </span>
                                            @else
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check-circle"></i> Active
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times-circle"></i> Inactive
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-exclamation-triangle"></i> Edit Guidelines
                            </h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success"></i>
                                    <strong>Email:</strong> Must remain unique
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success"></i>
                                    <strong>Password:</strong> Leave blank to keep current
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success"></i>
                                    <strong>Status:</strong> Inactive admins cannot login
                                </li>
                            </ul>
                            @if($admin->id === Auth::id())
                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-shield-alt"></i>
                                    <strong>Note:</strong> You cannot delete your own account.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

<!-- Delete Confirmation Modal -->
@if($admin->id !== Auth::id())
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle"></i> Confirm Admin Deletion
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-user-times text-danger mb-3" style="font-size: 4rem;"></i>
                    <h5 class="mb-3">Are you sure you want to delete this admin?</h5>
                    <div class="alert alert-warning">
                        <strong>Admin Details:</strong><br>
                        <strong>Name:</strong> {{ $admin->name }}<br>
                        <strong>Email:</strong> {{ $admin->email }}
                    </div>
                    <p class="text-muted">
                        This action cannot be undone. The admin will permanently lose access to the system.
                    </p>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <form method="POST" action="{{ route('admin.destroy', $admin->id) }}" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Yes, Delete Admin
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
