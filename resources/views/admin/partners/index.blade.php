@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                @include('admin.layouts.message')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Partner Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Partner Management</li>
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
                                <h3 class="card-title"><i class="fas fa-search"></i> Search Partners</h3>
                                <div class="card-tools d-md-none">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" id="searchCardBody">
                                <form method="GET" action="{{ route('admin.partners.index') }}">
                                    <div class="row">
                                        <div class="col-lg-11 col-md-10">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-12 mb-2">
                                                    <input type="text" class="form-control" name="search"
                                                        placeholder="Search by partner name..."
                                                        value="{{ request('search') }}">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12 mb-2">
                                                    <select class="form-control" name="status">
                                                        <option value="">All Status</option>
                                                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-md-2 col-12 d-flex align-items-lg-start align-items-center justify-content-center">
                                            <div class="d-flex flex-row justify-content-center">
                                                <button type="submit" class="btn btn-primary mr-2">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                                @if (request()->hasAny(['search', 'status']))
                                                    <a href="{{ route('admin.partners.index') }}" class="btn btn-secondary">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Partners Table Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Partners</h3>
                                <div class="card-tools">
                                    <a href="{{ route('admin.partners.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Add New Partner
                                    </a>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Logo</th>
                                            <th>Name</th>
                                            <th>Link</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($partners as $partner)
                                            <tr>
                                                <td>
                                                    <img src="{{ $partner->logo_url }}"
                                                        alt="{{ $partner->name }}" class="img-thumbnail"
                                                        style="width: 50px; height: 50px; object-fit: contain;">
                                                </td>
                                                <td>
                                                    <strong>{{ $partner->name }}</strong>
                                                </td>
                                                <td>
                                                    @if($partner->link)
                                                        <a href="{{ $partner->link }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Visit Website">
                                                            <i class="fas fa-external-link-alt"></i>
                                                        </a>
                                                    @else
                                                        <span class="text-muted">No link</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($partner->status)
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
                                                    <span title="{{ $partner->created_at->format('M d, Y H:i:s') }}">
                                                        {{ $partner->created_at->format('M d, Y') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="{{ route('admin.partners.show', $partner) }}"
                                                            class="btn btn-primary btn-sm" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.partners.edit', $partner) }}"
                                                            class="btn btn-info btn-sm ml-1" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.partners.toggle.status', $partner) }}" method="POST" style="display: inline-block;" class="ml-1">
                                                            @csrf
                                                            <button type="submit" class="btn btn-{{ $partner->status ? 'warning' : 'success' }} btn-sm" title="{{ $partner->status ? 'Deactivate' : 'Activate' }}">
                                                                <i class="fas fa-{{ $partner->status ? 'ban' : 'check' }}"></i>
                                                            </button>
                                                        </form>
                                                        <button type="button" class="btn btn-danger btn-sm ml-1"
                                                            title="Delete" data-toggle="modal"
                                                            data-target="#deleteModal{{ $partner->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    <i class="fas fa-handshake fa-3x mb-3"></i>
                                                    <p>No partners found.</p>
                                                    <a href="{{ route('admin.partners.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus"></i> Create First Partner
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if ($partners->hasPages())
                                <div class="card-footer clearfix">
                                    <div class="float-right">
                                        {{ $partners->appends(request()->query())->links() }}
                                    </div>
                                    <div class="float-left">
                                        <small class="text-muted">
                                            Showing {{ $partners->firstItem() ?? 0 }} to
                                            {{ $partners->lastItem() ?? 0 }}
                                            of {{ $partners->total() }} results
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
    @foreach ($partners as $partner)
        <div class="modal fade" id="deleteModal{{ $partner->id }}" tabindex="-1" role="dialog">
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
                        <p>Are you sure you want to delete this partner?</p>
                        <div class="card card-outline card-danger">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4"><strong>Name:</strong></div>
                                    <div class="col-sm-8">{{ $partner->name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Status:</strong></div>
                                    <div class="col-sm-8">
                                        @if($partner->status)
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
                        <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete Partner
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
                $('#searchCardBody').closest('.card').find('.card-tools i').removeClass('fa-minus').addClass('fa-plus');
            }

            $(window).resize(function() {
                if ($(window).width() >= 768) {
                    $('#searchCardBody').show();
                    $('#searchCardBody').closest('.card').removeClass('collapsed-card');
                    $('#searchCardBody').closest('.card').find('.card-tools i').removeClass('fa-plus').addClass('fa-minus');
                } else {
                    $('#searchCardBody').hide();
                    $('#searchCardBody').closest('.card').addClass('collapsed-card');
                    $('#searchCardBody').closest('.card').find('.card-tools i').removeClass('fa-minus').addClass('fa-plus');
                }
            });
        });
    </script>
@endpush