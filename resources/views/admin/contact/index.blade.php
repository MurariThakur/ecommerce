@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Contact Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Contact Management</li>
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
                            <h3 class="card-title"><i class="fas fa-search"></i> Search Contact Messages</h3>
                            <div class="card-tools d-md-none">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" id="searchCardBody">
                            <form method="GET" action="{{ route('admin.contact.index') }}">
                                <div class="row">
                                    <div class="col-lg-11 col-md-10">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-12 mb-2">
                                                <input type="text" class="form-control" name="search"
                                                    placeholder="Search by name, email, subject..."
                                                    value="{{ request('search') }}">
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-12 mb-2">
                                                <select class="form-control" name="status">
                                                    <option value="">All Status</option>
                                                    <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                                                    <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
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
                                    <div class="col-lg-1 col-md-2 col-12 d-flex align-items-lg-start align-items-center justify-content-center">
                                        <div class="d-flex flex-row justify-content-center">
                                            <button type="submit" class="btn btn-primary mr-2">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            @if (request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                                                <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Contact Messages Table Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Contact Messages</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($contacts as $contact)
                                        <tr class="{{ !$contact->is_read ? 'table-warning' : '' }}">
                                            <td>
                                                <strong>{{ $contact->name }}</strong>
                                            </td>
                                            <td>{{ $contact->email }}</td>
                                            <td>{{ $contact->subject ?? 'No subject' }}</td>
                                            <td>
                                                @if($contact->is_read)
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check-circle"></i> Read
                                                    </span>
                                                @else
                                                    <span class="badge badge-warning">
                                                        <i class="fas fa-envelope"></i> Unread
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span title="{{ $contact->created_at->format('M d, Y H:i:s') }}">
                                                    {{ $contact->created_at->format('M d, Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('admin.contact.show', $contact) }}"
                                                        class="btn btn-primary btn-sm" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <form action="{{ route('admin.contact.toggle.status', $contact) }}" method="POST" style="display: inline-block;" class="ml-1">
                                                        @csrf
                                                        <button type="submit" class="btn btn-{{ $contact->is_read ? 'warning' : 'success' }} btn-sm" title="{{ $contact->is_read ? 'Mark as Unread' : 'Mark as Read' }}">
                                                            <i class="fas fa-{{ $contact->is_read ? 'envelope' : 'envelope-open' }}"></i>
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-danger btn-sm ml-1"
                                                        title="Delete" data-toggle="modal"
                                                        data-target="#deleteModal{{ $contact->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="fas fa-envelope fa-3x mb-3"></i>
                                                <p>No contact messages found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if ($contacts->hasPages())
                            <div class="card-footer clearfix">
                                <div class="float-right">
                                    {{ $contacts->appends(request()->query())->links() }}
                                </div>
                                <div class="float-left">
                                    <small class="text-muted">
                                        Showing {{ $contacts->firstItem() ?? 0 }} to
                                        {{ $contacts->lastItem() ?? 0 }}
                                        of {{ $contacts->total() }} results
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
@foreach ($contacts as $contact)
    <div class="modal fade" id="deleteModal{{ $contact->id }}" tabindex="-1" role="dialog">
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
                    <p>Are you sure you want to delete this contact message?</p>
                    <div class="card card-outline card-danger">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4"><strong>Name:</strong></div>
                                <div class="col-sm-8">{{ $contact->name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>Email:</strong></div>
                                <div class="col-sm-8">{{ $contact->email }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>Subject:</strong></div>
                                <div class="col-sm-8">{{ $contact->subject ?? 'No subject' }}</div>
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
                    <form action="{{ route('admin.contact.destroy', $contact) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Message
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