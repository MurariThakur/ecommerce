@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Color</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.color.index') }}">Color Management</a></li>
                        <li class="breadcrumb-item active">Edit Color</li>
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Color</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="{{ route('admin.color.update', $color) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $color->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="color_code">Color Code <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="color" class="form-control @error('color_code') is-invalid @enderror" id="color_code" name="color_code" value="{{ old('color_code', $color->color_code) }}" style="height: 40px;" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="color-preview" style="background-color: {{ $color->color_code }}; width: 50px;"></span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Select a color or enter a hex color code</small>
                                    @error('color_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <div class="custom-control custom-switch">
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" {{ old('status', $color->status) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update Color</button>
                                <a href="{{ route('admin.color.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Update color preview
        $('#color_code').on('input', function() {
            var color = $(this).val();
            $('#color-preview').css('background-color', color);
        });
        
        // Initialize preview with current color
        var initialColor = $('#color_code').val();
        $('#color-preview').css('background-color', initialColor);
    });
</script>
@endpush
