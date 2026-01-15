@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                @include('admin.layouts.message')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Blog Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Blog Management</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-search"></i> Search Blogs</h3>
                                <div class="card-tools d-md-none">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" id="searchCardBody">
                                <form method="GET" action="{{ route('admin.blog.index') }}">
                                    <div class="row">
                                        <div class="col-lg-11 col-md-10">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6 col-12 mb-2">
                                                    <input type="text" class="form-control" name="search"
                                                        placeholder="Search by blog title..."
                                                        value="{{ request('search') }}">
                                                </div>
                                                <div class="col-lg-2 col-md-6 col-6 mb-2">
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
                                                    <select class="form-control" name="category">
                                                        <option value="">All Categories</option>
                                                        @foreach ($categories as $id => $name)
                                                            <option value="{{ $id }}"
                                                                {{ request('category') == $id ? 'selected' : '' }}>
                                                                {{ $name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-md-6 col-6 mb-2">
                                                    <input type="date" class="form-control" name="date_from"
                                                        value="{{ request('date_from') }}">
                                                </div>
                                                <div class="col-lg-2 col-md-6 col-6 mb-2">
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
                                                @if (request()->hasAny(['search', 'status', 'category', 'date_from', 'date_to']))
                                                    <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Blogs</h3>
                                <div class="card-tools">
                                    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Add New Blog
                                    </a>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($blogs as $blog)
                                            <tr>
                                                <td>
                                                    @if ($blog->image)
                                                        <img src="{{ $blog->image_url }}"
                                                            alt="{{ $blog->title }}" class="img-thumbnail"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>
                                                <td><strong>{{ $blog->title }}</strong></td>
                                                <td>{{ $blog->blogCategory->name }}</td>
                                                <td>
                                                    @if ($blog->status)
                                                        <span class="badge badge-success">
                                                            <i class="fas fa-check-circle"></i> Active
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger">
                                                            <i class="fas fa-times-circle"></i> Inactive
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>{{ $blog->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="{{ route('admin.blog.show', $blog) }}"
                                                            class="btn btn-primary btn-sm" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.blog.edit', $blog) }}"
                                                            class="btn btn-info btn-sm ml-1" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button"
                                                            class="btn btn-sm {{ $blog->status ? 'btn-warning' : 'btn-success' }} ml-1"
                                                            title="{{ $blog->status ? 'Deactivate' : 'Activate' }}"
                                                            data-toggle="modal"
                                                            data-target="#statusModal{{ $blog->id }}">
                                                            <i class="fas fa-{{ $blog->status ? 'ban' : 'check' }}"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm ml-1"
                                                            title="Delete" data-toggle="modal"
                                                            data-target="#deleteModal{{ $blog->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    <i class="fas fa-blog fa-3x mb-3"></i>
                                                    <p>No blogs found.</p>
                                                    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus"></i> Create First Blog
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($blogs->hasPages())
                                <div class="card-footer clearfix">
                                    <div class="float-right">
                                        {{ $blogs->links() }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($blogs as $blog)
        <div class="modal fade" id="deleteModal{{ $blog->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Deletion</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete "<strong>{{ $blog->title }}</strong>"?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.blog.destroy', $blog) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="statusModal{{ $blog->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $blog->status ? 'Deactivate' : 'Activate' }} Blog</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to {{ $blog->status ? 'deactivate' : 'activate' }}
                            "<strong>{{ $blog->title }}</strong>"?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.blog.toggle.status', $blog) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn {{ $blog->status ? 'btn-warning' : 'btn-success' }}">
                                {{ $blog->status ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
