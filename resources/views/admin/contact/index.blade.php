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
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-10">
                                <form method="GET" class="form-inline">
                                    <input type="text" name="search" class="form-control mr-2" placeholder="Search..."
                                        value="{{ request('search') }}">
                                    <select name="status" class="form-control mr-2">
                                        <option value="">All Status</option>
                                        <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread
                                        </option>
                                        <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read
                                        </option>
                                    </select>
                                    <button type="submit" class="btn btn-primary mr-2"><i
                                            class="fas fa-search"></i></button>
                                    <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary"><i
                                            class="fas fa-times"></i></a>
                                </form>
                            </div>
                        </div>
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
