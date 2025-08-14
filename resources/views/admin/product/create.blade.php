@extends('admin.layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ url('assets/plugins/summernote/summernote-lite.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/sortable/jquery-ui.css') }}">
@endpush

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                @include('admin.layouts.message')
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add New Product</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Product Management</a>
                            </li>
                            <li class="breadcrumb-item active">Add New Product</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                @include('admin.layouts.message')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Create Product</h3>
                            </div>
                            <!-- /.card-header -->
                            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title') }}" required>
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="slug">Slug <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                            id="slug" name="slug" value="{{ old('slug') }}" required>
                                        @error('slug')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category">Category <span class="text-danger">*</span></label>
                                                <select name="category_id"
                                                    class="form-control @error('category_id') is-invalid @enderror"
                                                    id="category" required>
                                                    <option value="">-- Select Category --</option>
                                                    @foreach ($categories as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ old('category_id') == $key ? 'selected' : '' }}>
                                                            {{ $value }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="subcategory">Subcategory <span
                                                        class="text-danger">*</span></label>
                                                <select name="subcategory_id"
                                                    class="form-control @error('subcategory_id') is-invalid @enderror"
                                                    id="subcategory" required>
                                                    <option value="">-- Select Subcategory --</option>
                                                </select>
                                                @error('subcategory_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Colors</label>
                                                <div class="@error('colors') is-invalid @enderror">
                                                    <div class="row">
                                                        @foreach ($colors as $key => $value)
                                                            <div class="col-md-6 col-lg-4">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="colors[]" value="{{ $key }}"
                                                                        id="color_{{ $key }}"
                                                                        {{ in_array($key, old('colors', [])) ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="color_{{ $key }}">
                                                                        {{ $value }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @error('colors')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="brand_id">Brand</label>
                                        <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror"
                                            id="brand_id">
                                            <option value="">-- Select Brand --</option>
                                            @foreach ($brands as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ old('brand_id') == $key ? 'selected' : '' }}>{{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('brand_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="old_price">Old Price</label>
                                        <input type="number" class="form-control @error('old_price') is-invalid @enderror"
                                            id="old_price" name="old_price" value="{{ old('old_price') }}"
                                            step="0.01">
                                        @error('old_price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="price">Price <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror"
                                            id="price" name="price" value="{{ old('price') }}" step="0.01"
                                            required>
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Product Sizes Section -->
                                    <div class="form-group">
                                        <label>Product Sizes</label>
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">Size Variations</h6>
                                                <button type="button" class="btn btn-primary btn-sm float-right"
                                                    id="add-size">Add Size</button>
                                            </div>
                                            <div class="card-body">
                                                <div id="sizes-container">
                                                    <!-- Dynamic size rows will be added here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Product Images Section -->
                                    <div class="form-group">
                                        <label>Product Images</label>
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">Image Gallery</h6>
                                                <button type="button" class="btn btn-primary btn-sm float-right"
                                                    id="add-image">Add Images</button>
                                            </div>
                                            <div class="card-body">
                                                <input type="file" id="image-input" name="images[]" accept="image/*"
                                                    multiple style="display: none;">
                                                <div id="images-container">
                                                    <div class="text-center p-4" id="no-images-message">
                                                        <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                                        <p class="text-muted">No images uploaded yet. Click "Add Images" to
                                                            start.</p>
                                                    </div>
                                                </div>
                                                <div id="sortable" class="row" style="display: none;">
                                                    <!-- Sortable images will be displayed here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="short_description">Short Description</label>
                                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                                            name="short_description" rows="3">{{ old('short_description') }}</textarea>
                                        @error('short_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control summernote @error('description') is-invalid @enderror" id="description"
                                            name="description" rows="5">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="additional_information">Additional Information</label>
                                        <textarea class="form-control summernote @error('additional_information') is-invalid @enderror"
                                            id="additional_information" name="additional_information" rows="3">{{ old('additional_information') }}</textarea>
                                        @error('additional_information')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="shipping_return">Shipping & Return</label>
                                        <textarea class="form-control summernote @error('shipping_return') is-invalid @enderror" id="shipping_return"
                                            name="shipping_return" rows="3">{{ old('shipping_return') }}</textarea>
                                        @error('shipping_return')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" name="status" value="0">
                                            <input type="checkbox" class="custom-control-input" id="status"
                                                name="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="status">
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Create Product</button>
                                    <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Cancel</a>
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
    <script src="{{ url('assets/plugins/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ url('assets/sortable/jquery-ui.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize Summernote editor
            $('.summernote').summernote();

            // Setup CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Auto-generate slug from title
            $('#title').on('input', function() {
                var title = $(this).val();
                var slug = title.toLowerCase().replace(/\\s+/g, '-').replace(/[^a-z0-9-]/g, '');
                $('#slug').val(slug);
            });

            // Load subcategories when category changes
            $('#category').on('change', function() {
                var categoryId = $(this).val();
                var subcategorySelect = $('#subcategory');
                var currentSubcategoryId = '{{ old('subcategory_id') }}';

                console.log('Category changed to:', categoryId);

                subcategorySelect.html('<option value="">-- Select Subcategory --</option>');

                if (categoryId) {
                    console.log('Making AJAX request to load subcategories');
                    $.ajax({
                        url: '{{ route('admin.product.subcategories') }}',
                        type: 'GET',
                        data: {
                            category_id: categoryId
                        },
                        success: function(data) {
                            console.log('Subcategories received:', data);
                            $.each(data, function(key, value) {
                                var selected = (key == currentSubcategoryId) ?
                                    'selected' : '';
                                subcategorySelect.append('<option value="' + key +
                                    '" ' + selected + '>' + value + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log('Error loading subcategories:', error);
                            console.log('Status:', status);
                            console.log('Response:', xhr.responseText);
                        }
                    });
                }
            });

            // Load subcategories on page load if category is already selected (for validation errors)
            var initialCategoryId = $('#category').val();
            if (initialCategoryId) {
                $('#category').trigger('change');
            }

            // Size management
            let sizeIndex = 0;

            // Add size variation
            $('#add-size').on('click', function() {
                let sizeRow = `
            <div class="size-row border p-3 mb-3 rounded" data-index="${sizeIndex}">
                <div class="row">
                    <div class="col-md-3">
                        <label>Size Name <span class="text-danger">*</span></label>
                        <input type="text" name="sizes[${sizeIndex}][size_name]" class="form-control" placeholder="e.g., Small, Medium, Large" required>
                    </div>
                    <div class="col-md-3">
                        <label>Size Value</label>
                        <input type="text" name="sizes[${sizeIndex}][size_value]" class="form-control" placeholder="e.g., 28 inches">
                    </div>
                    <div class="col-md-2">
                        <label>Additional Price</label>
                        <input type="number" name="sizes[${sizeIndex}][additional_price]" class="form-control" step="0.01" value="0">
                    </div>
                    <div class="col-md-2">
                        <label>Stock Quantity</label>
                        <input type="number" name="sizes[${sizeIndex}][stock_quantity]" class="form-control" value="0" min="0">
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <div>
                            <button type="button" class="btn btn-danger btn-sm remove-size">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
                $('#sizes-container').append(sizeRow);
                sizeIndex++;
            });

            // Remove size variation
            $(document).on('click', '.remove-size', function() {
                $(this).closest('.size-row').remove();
            });

            // ====== FIXED IMAGE UPLOAD SECTION ======
            let uploadedFiles = []; // Track selected files for validation

            // Initialize sortable for images
            $("#sortable").sortable({
                update: function(event, ui) {
                    updateImageOrder();
                }
            });

            // Add image button click
            $('#add-image').on('click', function() {
                $('#image-input').click();
            });

            // Handle file selection - Fixed for proper file upload
            $('#image-input').on('change', function() {
                const files = this.files;
                if (files.length > 0) {
                    // Check if adding these files would exceed the limit
                    if (uploadedFiles.length + files.length > 10) {
                        showImageError(
                            'You can upload a maximum of 10 images. Please remove some images before adding new ones.'
                            );
                        this.value = ''; // Reset input
                        return;
                    }

                    for (let i = 0; i < files.length; i++) {
                        if (validateImageFile(files[i])) {
                            processImage(files[i], i);
                            uploadedFiles.push(files[i]); // Track the file for validation
                        }
                    }
                }
                // Don't reset input value to maintain files for form submission
            });

            // Validate image file before processing
            function validateImageFile(file) {
                // Check file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    showImageError(
                        `Invalid file type: ${file.name}. Only JPEG, PNG, GIF, and WebP images are allowed.`);
                    return false;
                }

                // Check file size (5MB limit)
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (file.size > maxSize) {
                    showImageError(`File too large: ${file.name}. Maximum size is 5MB.`);
                    return false;
                }

                // Check minimum file size (1KB)
                const minSize = 1024; // 1KB
                if (file.size < minSize) {
                    showImageError(`File too small: ${file.name}. Minimum size is 1KB.`);
                    return false;
                }

                // Check filename length
                if (file.name.length > 255) {
                    showImageError(`Filename too long: ${file.name}. Maximum length is 255 characters.`);
                    return false;
                }

                return true;
            }

            // Show image error message
            function showImageError(message) {
                // Remove any existing error messages
                $('.image-error-alert').remove();

                // Create error alert
                const errorAlert = `
            <div class="alert alert-danger alert-dismissible image-error-alert" role="alert">
                <strong>Image Upload Error:</strong> ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;

                // Insert error message before the images container
                $('#images-container').before(errorAlert);

                // Auto remove after 10 seconds
                setTimeout(function() {
                    $('.image-error-alert').fadeOut(500, function() {
                        $(this).remove();
                    });
                }, 10000);
            }

            // Validate image dimensions after loading
            function validateImageDimensions(imageData, fileName, callback) {
                const img = new Image();
                img.onload = function() {
                    const width = this.width;
                    const height = this.height;

                    // Check minimum dimensions (50x50)
                    if (width < 50 || height < 50) {
                        showImageError(
                            `Image dimensions too small: ${fileName}. Minimum size is 50x50 pixels. Current size: ${width}x${height}`
                            );
                        callback(false);
                        return;
                    }

                    // Check maximum dimensions (4000x4000)
                    if (width > 4000 || height > 4000) {
                        showImageError(
                            `Image dimensions too large: ${fileName}. Maximum size is 4000x4000 pixels. Current size: ${width}x${height}`
                            );
                        callback(false);
                        return;
                    }

                    callback(true);
                };
                img.onerror = function() {
                    showImageError(`Unable to read image dimensions: ${fileName}. The file may be corrupted.`);
                    callback(false);
                };
                img.src = imageData;
            }

            // Process and display image - Modified for file upload approach
            function processImage(file, index) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageData = e.target.result;

                    // Validate image dimensions before processing
                    validateImageDimensions(imageData, file.name, function(isValid) {
                        if (!isValid) {
                            // Remove file from tracking if invalid
                            uploadedFiles = uploadedFiles.filter(f => f !== file);
                            return; // Stop processing if dimensions are invalid
                        }

                        const imageCard = `
                    <div class="col-md-3 mb-3 image-item" data-index="${Date.now() + index}" data-filename="${file.name}">
                        <div class="card">
                            <img src="${imageData}" class="card-img-top" style="height: 150px; object-fit: cover;">
                            <div class="card-body p-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">${file.name}</small>
                                    <button type="button" class="btn btn-danger btn-sm remove-image">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                        $('#sortable').append(imageCard);
                        updateImageDisplay();
                    });
                };
                reader.onerror = function() {
                    showImageError(`Failed to read file: ${file.name}. The file may be corrupted.`);
                    // Remove file from tracking if error
                    uploadedFiles = uploadedFiles.filter(f => f !== file);
                };
                reader.readAsDataURL(file);
            }

            // Remove image - Fixed for file upload approach
            $(document).on('click', '.remove-image', function() {
                const imageItem = $(this).closest('.image-item');
                const filename = imageItem.data('filename');

                // Remove from uploaded files tracking
                uploadedFiles = uploadedFiles.filter(file => file.name !== filename);

                // Clear the file input and rebuild it to reflect current files
                $('#image-input').val('');

                imageItem.remove();
                updateImageDisplay();
                updateImageOrder();
            });

            // Update image display state
            function updateImageDisplay() {
                const totalImages = $('#sortable .image-item').length;
                if (totalImages > 0) {
                    $('#no-images-message').hide();
                    $('#sortable').show();
                } else {
                    $('#no-images-message').show();
                    $('#sortable').hide();
                }
            }

            // Update image order after sorting - Simplified for file upload
            function updateImageOrder() {
                $('#sortable .image-item').each(function(index) {
                    // For file uploads, order is maintained by the file input array
                    // No need to update hidden order fields since we're using real file uploads
                });
            }

            // Initial update for image display state
            updateImageDisplay();
        });
    </script>
@endpush
