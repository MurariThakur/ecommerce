@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Contact Message Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.contact.index') }}">Contact Messages</a>
                            </li>
                            <li class="breadcrumb-item active">View Message</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Message from {{ $contact->name }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="120"><strong>Name:</strong></td>
                                        <td>{{ $contact->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phone:</strong></td>
                                        <td>{{ $contact->phone ?? 'Not provided' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Subject:</strong></td>
                                        <td>{{ $contact->subject ?? 'No subject' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            @if ($contact->is_read)
                                                <span class="badge badge-success">Read</span>
                                            @else
                                                <span class="badge badge-warning">Unread</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Date:</strong></td>
                                        <td>{{ $contact->created_at->format('M d, Y H:i A') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Message:</h5>
                                <div class="card">
                                    <div class="card-body">
                                        {{ $contact->message }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <form action="{{ route('admin.contact.toggle.status', $contact) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-{{ $contact->is_read ? 'warning' : 'success' }}">
                                        <i class="fas fa-{{ $contact->is_read ? 'envelope' : 'envelope-open' }}"></i>
                                        Mark as {{ $contact->is_read ? 'Unread' : 'Read' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.contact.destroy', $contact) }}" method="POST"
                                    class="d-inline ml-2"
                                    onsubmit="return confirm('Are you sure you want to delete this message?')">
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
            </div>
        </div>
    </div>
@endsection
