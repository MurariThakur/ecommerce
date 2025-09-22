@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('admin.layouts.message')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Category Management</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Category Management</li>
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
                                <h3 class="card-title"><i class="fas fa-search"></i> Search Categories</h3>
                                <div class="card-tools d-md-none">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" id="searchCardBody">
                                <form method="GET" action="{{ route('admin.category.index') }}">
                                    <div class="row">
                                        <div class="col-lg-11 col-md-10">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6 col-12 mb-2">
                                                    <input type="text" class="form-control" name="search"
                                                        placeholder="Search by category name..."
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
                                                    <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Categories Table Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Categories</h3>
                                <div class="card-tools">
                                    <a href="{{ route('admin.category.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Add New Category
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($categories as $category)
                                            <tr>
                                                <td>
                                                    <strong>{{ $category->name }}</strong>
                                                </td>
                                                <td>
                                                    <code>{{ $category->slug }}</code>
                                                </td>
                                                <td>
                                                    @if ($category->status == 1)
                                                        <span class="badge badge-success">
                                                            <i class="fas fa-check-circle"></i> Active
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger">
                                                            <i class="fas fa-times-circle"></i> Inactive
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span title="{{ $category->created_at->format('M d, Y H:i:s') }}">
                                                        {{ $category->created_at->format('M d, Y') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <!-- View Button -->
                                                        <a href="{{ route('admin.category.show', $category) }}"
                                                            class="btn btn-primary btn-sm" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                        <!-- Edit Button -->
                                                        <a href="{{ route('admin.category.edit', $category) }}"
                                                            class="btn btn-info btn-sm ml-1" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        <!-- Toggle Status Button -->
                                                        <button type="button"
                                                            class="btn btn-sm {{ $category->status == 1 ? 'btn-warning' : 'btn-success' }} ml-1"
                                                            title="{{ $category->status == 1 ? 'Deactivate' : 'Activate' }}"
                                                            data-toggle="modal"
                                                            data-target="#statusModal{{ $category->id }}">
                                                            <i
                                                                class="fas fa-{{ $category->status == 1 ? 'ban' : 'check' }}"></i>
                                                        </button>

                                                        <!-- Delete Button -->
                                                        <button type="button" class="btn btn-danger btn-sm ml-1"
                                                            title="Delete" data-toggle="modal"
                                                            data-target="#deleteModal{{ $category->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    <i class="fas fa-tags fa-3x mb-3"></i>
                                                    <p>No categories found.</p>
                                                    <a href="{{ route('admin.category.create') }}"
                                                        class="btn btn-primary">
                                                        <i class="fas fa-plus"></i> Create First Category
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            @if ($categories->hasPages())
                                <div class="card-footer clearfix">
                                    <div class="float-right">
                                        {{ $categories->links() }}
                                    </div>
                                    <div class="float-left">
                                        <small class="text-muted">
                                            Showing {{ $categories->firstItem() ?? 0 }} to
                                            {{ $categories->lastItem() ?? 0 }}
                                            of {{ $categories->total() }} results
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
    @foreach ($categories as $category)
        <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel{{ $category->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $category->id }}">
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                            Confirm Deletion
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">Are you sure you want to delete this category?</p>

                        @if ($category->subcategories->count() > 0)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Warning:</strong> Deleting this category will also delete
                                <strong>{{ $category->subcategories->count() }}</strong> associated subcategory(ies).
                            </div>
                        @endif

                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Category Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Name:</strong></div>
                                    <div class="col-sm-8">{{ $category->name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Slug:</strong></div>
                                    <div class="col-sm-8">{{ $category->slug }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Status:</strong></div>
                                    <div class="col-sm-8">
                                        @if ($category->status == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($category->subcategories->count() > 0)
                            <div class="card card-outline card-warning mt-3">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-list"></i> Subcategories to be Deleted
                                        ({{ $category->subcategories->count() }})
                                    </h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                        <table class="table table-sm table-striped mb-0">
                                            <thead class="bg-light sticky-top">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th>Created</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($category->subcategories as $subcategory)
                                                    <tr>
                                                        <td>{{ $subcategory->name }}</td>
                                                        <td>
                                                            @if ($subcategory->status)
                                                                <span class="badge badge-success badge-sm">Active</span>
                                                            @else
                                                                <span class="badge badge-danger badge-sm">Inactive</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $subcategory->created_at->format('M d, Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="alert alert-danger mt-3">
                            <i class="fas fa-exclamation-circle"></i>
                            <strong>This action cannot be undone!</strong> All data associated with this category and its
                            subcategories will be permanently deleted.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <form action="{{ route('admin.category.destroy', $category) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i>
                                Delete Category @if ($category->subcategories->count() > 0)
                                    & {{ $category->subcategories->count() }} Subcategory(ies)
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Status Toggle Confirmation Modals -->
    @foreach ($categories as $category)
        <div class="modal fade" id="statusModal{{ $category->id }}" tabindex="-1" role="dialog"
            aria-labelledby="statusModalLabel{{ $category->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel{{ $category->id }}">
                            <i
                                class="fas fa-{{ $category->status == 1 ? 'ban text-warning' : 'check text-success' }}"></i>
                            {{ $category->status == 1 ? 'Deactivate' : 'Activate' }} Category
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">Are you sure you want to
                            {{ $category->status == 1 ? 'deactivate' : 'activate' }} this category?</p>

                        <div class="card card-outline {{ $category->status == 1 ? 'card-warning' : 'card-success' }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Name:</strong></div>
                                    <div class="col-sm-8">{{ $category->name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Slug:</strong></div>
                                    <div class="col-sm-8">{{ $category->slug }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Current Status:</strong></div>
                                    <div class="col-sm-8">
                                        @if ($category->status == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>New Status:</strong></div>
                                    <div class="col-sm-8">
                                        @if ($category->status == 1)
                                            <span class="badge badge-danger">Inactive</span>
                                        @else
                                            <span class="badge badge-success">Active</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <form action="{{ route('admin.category.toggle.status', $category) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            <button type="submit"
                                class="btn {{ $category->status == 1 ? 'btn-warning' : 'btn-success' }}">
                                <i class="fas fa-{{ $category->status == 1 ? 'ban' : 'check' }}"></i>
                                {{ $category->status == 1 ? 'Deactivate' : 'Activate' }} Category
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
