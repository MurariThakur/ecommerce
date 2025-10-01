@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                @include('admin.layouts.message')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">FAQ Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">FAQ Management</li>
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
                                <h3 class="card-title">FAQs</h3>
                                <div class="card-tools">
                                    <a href="{{ route('admin.faq.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Add New FAQ
                                    </a>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Sort Order</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($faqs as $faq)
                                            <tr>
                                                <td>
                                                    <strong>{{ Str::limit($faq->question, 50) }}</strong>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">{{ ucfirst($faq->category) }}</span>
                                                </td>
                                                <td>
                                                    @if ($faq->status)
                                                        <span class="badge badge-success">
                                                            <i class="fas fa-check-circle"></i> Active
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger">
                                                            <i class="fas fa-times-circle"></i> Inactive
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>{{ $faq->sort_order }}</td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="{{ route('admin.faq.show', $faq) }}"
                                                            class="btn btn-primary btn-sm" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.faq.edit', $faq) }}"
                                                            class="btn btn-info btn-sm ml-1" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button"
                                                            class="btn btn-sm {{ $faq->status ? 'btn-warning' : 'btn-success' }} ml-1"
                                                            title="{{ $faq->status ? 'Deactivate' : 'Activate' }}"
                                                            data-toggle="modal"
                                                            data-target="#statusModal{{ $faq->id }}">
                                                            <i class="fas fa-{{ $faq->status ? 'ban' : 'check' }}"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm ml-1"
                                                            title="Delete" data-toggle="modal"
                                                            data-target="#deleteModal{{ $faq->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    <i class="fas fa-question-circle fa-3x mb-3"></i>
                                                    <p>No FAQs found.</p>
                                                    <a href="{{ route('admin.faq.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus"></i> Create First FAQ
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($faqs as $faq)
        <!-- Status Toggle Modal -->
        <div class="modal fade" id="statusModal{{ $faq->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-{{ $faq->status ? 'ban text-warning' : 'check text-success' }}"></i>
                            {{ $faq->status ? 'Deactivate' : 'Activate' }} FAQ
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to {{ $faq->status ? 'deactivate' : 'activate' }} this FAQ?</p>
                        <div class="alert alert-info">
                            <strong>Question:</strong> {{ $faq->question }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.faq.toggle.status', $faq) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn {{ $faq->status ? 'btn-warning' : 'btn-success' }}">
                                <i class="fas fa-{{ $faq->status ? 'ban' : 'check' }}"></i>
                                {{ $faq->status ? 'Deactivate' : 'Activate' }} FAQ
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal{{ $faq->id }}" tabindex="-1" role="dialog">
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
                        <p>Are you sure you want to delete this FAQ?</p>
                        <div class="card card-outline card-danger">
                            <div class="card-body">
                                <strong>Question:</strong> {{ $faq->question }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form action="{{ route('admin.faq.destroy', $faq) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete FAQ</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
