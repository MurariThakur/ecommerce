@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">View Blog</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.blog.index') }}">Blog Management</a></li>
                            <li class="breadcrumb-item active">View Blog</li>
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
                                    <i class="fas fa-eye"></i> Blog Details
                                </h3>
                                <div class="card-tools">
                                    <a href="{{ route('admin.blog.edit', $blog) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit Blog
                                    </a>
                                    <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary btn-sm">
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
                                                    <i class="fas fa-info-circle"></i> Basic Information
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td width="150"><strong>Title</strong></td>
                                                        <td>{{ $blog->title }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Slug</strong></td>
                                                        <td>{{ $blog->slug }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Category</strong></td>
                                                        <td>{{ $blog->blogCategory->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Status</strong></td>
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
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Created At</strong></td>
                                                        <td>{{ $blog->created_at->format('M d, Y H:i:s') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Updated At</strong></td>
                                                        <td>{{ $blog->updated_at->format('M d, Y H:i:s') }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        @if ($blog->image)
                                            <div class="card card-outline card-success">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        <i class="fas fa-image"></i> Blog Image
                                                    </h3>
                                                </div>
                                                <div class="card-body text-center">
                                                    <img src="{{ $blog->image_url }}"
                                                        alt="{{ $blog->title }}" class="img-fluid"
                                                        style="max-width: 100%; height: auto;">
                                                </div>
                                            </div>
                                        @endif

                                        <div class="card card-outline card-info">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <i class="fas fa-align-left"></i> Content
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                @if ($blog->short_description)
                                                    <div class="mb-3">
                                                        <strong>Short Description:</strong>
                                                        <p>{{ $blog->short_description }}</p>
                                                    </div>
                                                @endif
                                                <div>
                                                    <strong>Description:</strong>
                                                    <div class="mt-2">{!! $blog->description !!}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card card-outline card-warning">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <i class="fas fa-tags"></i> SEO Information
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td width="150"><strong>Meta Title</strong></td>
                                                        <td>{{ $blog->meta_title ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Meta Description</strong></td>
                                                        <td>{{ $blog->meta_description ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Meta Keywords</strong></td>
                                                        <td>{{ $blog->meta_keyword ?? '-' }}</td>
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
                                                    <a href="{{ route('admin.blog.edit', $blog) }}"
                                                        class="btn btn-warning btn-block">
                                                        <i class="fas fa-edit"></i> Edit Blog
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-block {{ $blog->status ? 'btn-secondary' : 'btn-success' }}"
                                                        data-toggle="modal" data-target="#statusModal">
                                                        <i class="fas fa-{{ $blog->status ? 'ban' : 'check' }}"></i>
                                                        {{ $blog->status ? 'Deactivate' : 'Activate' }} Blog
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-block"
                                                        data-toggle="modal" data-target="#deleteModal">
                                                        <i class="fas fa-trash"></i> Delete Blog
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

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
                                                            class="info-box-number">{{ $blog->created_at->diffInDays(now()) }}</span>
                                                    </div>
                                                </div>
                                                <div class="info-box">
                                                    <span class="info-box-icon bg-success">
                                                        <i class="fas fa-clock"></i>
                                                    </span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Last Updated</span>
                                                        <span
                                                            class="info-box-number text-sm">{{ $blog->updated_at->diffForHumans() }}</span>
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

    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $blog->status ? 'Deactivate' : 'Activate' }} Blog</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to {{ $blog->status ? 'deactivate' : 'activate' }} this blog?</p>
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

    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this blog?</p>
                    <div class="alert alert-danger">
                        <strong>Warning:</strong> This action cannot be undone!<br>
                        <strong>Blog:</strong> {{ $blog->title }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.blog.destroy', $blog) }}" method="POST"
                        style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Blog</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
