@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                @include('admin.layouts.message')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Contact Messages</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Contact Messages</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
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
                                        <div class="col-lg-3 col-md-6 col-6 mb-2">
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($contacts as $contact)
                                        <tr class="{{ !$contact->is_read ? 'table-warning' : '' }}">
                                            <td>{{ $contact->name }}</td>
                                            <td>{{ $contact->email }}</td>
                                            <td>{{ $contact->subject ?? 'No subject' }}</td>
                                            <td>
                                                @if ($contact->is_read)
                                                    <span class="badge badge-success">Read</span>
                                                @else
                                                    <span class="badge badge-warning">Unread</span>
                                                @endif
                                            </td>
                                            <td>{{ $contact->created_at->format('M d, Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('admin.contact.show', $contact) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('admin.contact.toggle.status', $contact) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-{{ $contact->is_read ? 'warning' : 'success' }} btn-sm">
                                                        <i
                                                            class="fas fa-{{ $contact->is_read ? 'envelope' : 'envelope-open' }}"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.contact.destroy', $contact) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No contact messages found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $contacts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
