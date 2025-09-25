@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Notifications</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Notifications</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Notifications</h3>
                                <div class="card-tools">
                                    <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-check-double"></i> Mark All Read
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                @forelse($notifications as $notification)
                                    <div
                                        class="notification-item {{ $notification->is_read ? 'read' : 'unread' }} border-bottom p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="notification-icon mr-3">
                                                <i class="{{ $notification->icon }} text-{{ $notification->color }}"></i>
                                            </div>
                                            <div class="notification-content flex-grow-1">
                                                <h6 class="notification-title mb-1">{{ $notification->title }}</h6>
                                                <p class="notification-message mb-1">{{ $notification->message }}</p>
                                                <small
                                                    class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div class="notification-actions">
                                                @if ($notification->url)
                                                    <form
                                                        action="{{ route('admin.notifications.read', $notification->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-external-link-alt"></i> View
                                                        </button>
                                                    </form>
                                                @endif
                                                @if (!$notification->is_read)
                                                    <span class="badge badge-warning ml-2">New</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center p-4">
                                        <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No notifications found</p>
                                    </div>
                                @endforelse
                            </div>

                            @if ($notifications->hasPages())
                                <div class="card-footer">
                                    {{ $notifications->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        .notification-item.unread {
            background-color: #f8f9fa;
        }

        .notification-item.read {
            opacity: 0.7;
        }

        .notification-icon {
            width: 40px;
            text-align: center;
        }
    </style>
@endsection
