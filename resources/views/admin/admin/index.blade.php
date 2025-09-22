@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('admin.layouts.message')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $title ?? 'Admin Management' }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">{{ $title ?? 'Admin Management' }}</li>
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
                                <h3 class="card-title"><i class="fas fa-search"></i> Search Admins</h3>
                                <div class="card-tools d-md-none">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" id="searchCardBody">
                                <form method="GET" action="{{ route('admin.index') }}">
                                    <div class="row">
                                        <div class="col-lg-11 col-md-10">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6 col-12 mb-2">
                                                    <input type="text" class="form-control" name="search"
                                                        placeholder="Search by name or email..."
                                                        value="{{ request('search') }}">
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-6 mb-2">
                                                    <select class="form-control" name="status">
                                                        <option value="">All Status</option>
                                                        <option value="active"
                                                            {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="inactive"
                                                            {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-md-6 col-6 mb-2">
                                                    <input type="date" class="form-control" name="date_from"
                                                        value="{{ request('date_from') }}">
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-6 mb-2">
                                                    <input type="date" class="form-control" name="date_to"
                                                        value="{{ request('date_to') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="col-lg-1 col-md-2 col-12 d-flex align-items-lg-start align-items-center justify-content-center">
                                            <div class="d-flex flex-row justify-content-center">
                                                <button type="submit" class="btn btn-primary mr-2">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                                @if (request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                                                    <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Admin Table Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Admin Users</h3>
                                <div class="card-tools">
                                    <a href="{{ route('admin.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Add New Admin
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Last Login</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($admins as $admin)
                                            <tr>
                                                <td>{{ $admin->id }}</td>
                                                <td>
                                                    <strong>{{ $admin->name }}</strong>
                                                    @if ($admin->id === Auth::id())
                                                        <span class="badge badge-info badge-sm ml-1">You</span>
                                                    @endif
                                                </td>
                                                <td>{{ $admin->email }}</td>
                                                <td>
                                                    @if ($admin->is_active)
                                                        @if ($admin->isLocked())
                                                            <span class="badge badge-warning">
                                                                <i class="fas fa-lock"></i> Locked
                                                            </span>
                                                            <small class="text-muted d-block">
                                                                Until: {{ $admin->locked_until->format('M d, Y H:i') }}
                                                            </small>
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
                                                <td>
                                                    @if ($admin->last_login)
                                                        <span title="{{ $admin->last_login->format('M d, Y H:i:s') }}">
                                                            {{ $admin->last_login->diffForHumans() }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">Never</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span title="{{ $admin->created_at->format('M d, Y H:i:s') }}">
                                                        {{ $admin->created_at->format('M d, Y') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <!-- View Button -->
                                                        <a href="{{ route('admin.show', $admin->id) }}"
                                                            class="btn btn-primary btn-sm" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                        <!-- Edit Button -->
                                                        <a href="{{ route('admin.edit', $admin->id) }}"
                                                            class="btn btn-info btn-sm ml-1" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        <!-- Toggle Status Button -->
                                                        @if ($admin->id !== Auth::id())
                                                            <form action="{{ route('admin.toggle.status', $admin->id) }}"
                                                                method="POST" class="ml-1"
                                                                style="display: inline-block;">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-sm {{ $admin->is_active ? 'btn-warning' : 'btn-success' }}"
                                                                    title="{{ $admin->is_active ? 'Deactivate' : 'Activate' }}"
                                                                    onclick="return confirm('Are you sure you want to {{ $admin->is_active ? 'deactivate' : 'activate' }} this admin?')">
                                                                    <i
                                                                        class="fas fa-{{ $admin->is_active ? 'ban' : 'check' }}"></i>
                                                                </button>
                                                            </form>

                                                            <!-- Delete Button -->
                                                            <button type="button" class="btn btn-danger btn-sm ml-1"
                                                                title="Delete" data-toggle="modal"
                                                                data-target="#deleteModal{{ $admin->id }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @else
                                                            <span class="btn btn-secondary btn-sm disabled ml-1"
                                                                title="Cannot modify own account">
                                                                <i class="fas fa-shield-alt"></i>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    <i class="fas fa-users fa-3x mb-3"></i>
                                                    <p>No admin users found.</p>
                                                    <a href="{{ route('admin.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus"></i> Create First Admin
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            @if ($admins->hasPages())
                                <div class="card-footer clearfix">
                                    <div class="float-right">
                                        {{ $admins->links() }}
                                    </div>
                                    <div class="float-left">
                                        <small class="text-muted">
                                            Showing {{ $admins->firstItem() ?? 0 }} to {{ $admins->lastItem() ?? 0 }}
                                            of {{ $admins->total() }} results
                                            @if (request()->hasAny(['search', 'status', 'date_from', 'date_to']))
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
    @foreach ($admins as $admin)
        @if ($admin->id !== Auth::id())
            <div class="modal fade" id="deleteModal{{ $admin->id }}" tabindex="-1" role="dialog"
                aria-labelledby="deleteModalLabel{{ $admin->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $admin->id }}">
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                Confirm Deletion
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-3">Are you sure you want to delete this admin user?</p>

                            <div class="card card-outline card-danger">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Name:</strong></div>
                                        <div class="col-sm-8">{{ $admin->name }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Email:</strong></div>
                                        <div class="col-sm-8">{{ $admin->email }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Created:</strong></div>
                                        <div class="col-sm-8">{{ $admin->created_at->format('M d, Y H:i') }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-warning mt-3">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Warning:</strong> This action cannot be undone. All data associated with this admin
                                will be permanently deleted.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                            <form action="{{ route('admin.destroy', $admin->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Delete Admin
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            if ($(window).width() < 768) {
                $('#searchCardBody').hide();
                $('#searchCardBody').closest('.card').addClass('collapsed-card');
                $('#searchCardBody').closest('.card').find('.card-tools i').removeClass('fa-minus').addClass(
                    'fa-plus');
            }

            $(window).resize(function() {
                if ($(window).width() >= 768) {
                    $('#searchCardBody').show();
                    $('#searchCardBody').closest('.card').removeClass('collapsed-card');
                    $('#searchCardBody').closest('.card').find('.card-tools i').removeClass('fa-plus')
                        .addClass('fa-minus');
                } else {
                    $('#searchCardBody').hide();
                    $('#searchCardBody').closest('.card').addClass('collapsed-card');
                    $('#searchCardBody').closest('.card').find('.card-tools i').removeClass('fa-minus')
                        .addClass('fa-plus');
                }
            });
        });
    </script>
@endpush
