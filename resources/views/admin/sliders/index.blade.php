@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                @include('admin.layouts.message')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Slider Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Slider Management</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Search Card -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-search"></i> Search Sliders</h3>
                                <div class="card-tools d-md-none">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" id="searchCardBody">
                                <form method="GET" action="{{ route('admin.sliders.index') }}">
                                    <div class="row">
                                        <div class="col-lg-11 col-md-10">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-12 mb-2">
                                                    <input type="text" class="form-control" name="search"
                                                        placeholder="Search by slider title..."
                                                        value="{{ request('search') }}">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12 mb-2">
                                                    <select class="form-control" name="status">
                                                        <option value="">All Status</option>
                                                        <option value="1"
                                                            {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                                        <option value="0"
                                                            {{ request('status') == '0' ? 'selected' : '' }}>Inactive
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="col-lg-1 col-md-2 col-12 d-flex align-items-lg-start align-items-center justify-content-center">
                                            <div class="d-flex flex-row justify-content-center">
                                                <button type="submit" class="btn btn-primary mr-2">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                                @if (request()->hasAny(['search', 'status']))
                                                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Sliders Table Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Sliders</h3>
                                <div class="card-tools">
                                    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Add New Slider
                                    </a>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Button</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($sliders as $slider)
                                            <tr>
                                                <td>
                                                    <img src="{{ $slider->image_url }}"
                                                        alt="{{ $slider->title }}" class="img-thumbnail"
                                                        style="width: 80px; height: 50px; object-fit: cover;">
                                                </td>
                                                <td>
                                                    <strong>{{ Str::limit($slider->title, 30) }}</strong>
                                                </td>
                                                <td>
                                                    @if ($slider->button_name)
                                                        <span class="badge badge-info">{{ $slider->button_name }}</span>
                                                    @else
                                                        <span class="text-muted">No button</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($slider->status)
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
                                                    <span title="{{ $slider->created_at->format('M d, Y H:i:s') }}">
                                                        {{ $slider->created_at->format('M d, Y') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="{{ route('admin.sliders.show', $slider) }}"
                                                            class="btn btn-primary btn-sm" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.sliders.edit', $slider) }}"
                                                            class="btn btn-info btn-sm ml-1" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.sliders.toggle.status', $slider) }}"
                                                            method="POST" style="display: inline-block;" class="ml-1">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-{{ $slider->status ? 'warning' : 'success' }} btn-sm"
                                                                title="{{ $slider->status ? 'Deactivate' : 'Activate' }}">
                                                                <i
                                                                    class="fas fa-{{ $slider->status ? 'ban' : 'check' }}"></i>
                                                            </button>
                                                        </form>
                                                        <button type="button" class="btn btn-danger btn-sm ml-1"
                                                            title="Delete" data-toggle="modal"
                                                            data-target="#deleteModal{{ $slider->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    <i class="fas fa-images fa-3x mb-3"></i>
                                                    <p>No sliders found.</p>
                                                    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus"></i> Create First Slider
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($sliders->hasPages())
                                <div class="card-footer clearfix">
                                    <div class="float-right">
                                        {{ $sliders->appends(request()->query())->links() }}
                                    </div>
                                    <div class="float-left">
                                        <small class="text-muted">
                                            Showing {{ $sliders->firstItem() ?? 0 }} to
                                            {{ $sliders->lastItem() ?? 0 }}
                                            of {{ $sliders->total() }} results
                                            @if (request()->hasAny(['search', 'status']))
                                                (filtered)
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modals -->
    @foreach ($sliders as $slider)
        <div class="modal fade" id="deleteModal{{ $slider->id }}" tabindex="-1" role="dialog">
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
                        <p>Are you sure you want to delete this slider?</p>
                        <div class="card card-outline card-danger">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Title:</strong></div>
                                    <div class="col-sm-8">{{ $slider->title }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Status:</strong></div>
                                    <div class="col-sm-8">
                                        @if ($slider->status)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-danger mt-3">
                            <i class="fas fa-exclamation-circle"></i>
                            <strong>This action cannot be undone!</strong>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete Slider
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
