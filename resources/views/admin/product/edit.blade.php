@extends('admin.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ url('assets/plugins/summernote/summernote-lite.min.css') }}">
@endpush

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Product</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Product Management</a>
                            </li>
                            <li class="breadcrumb-item active">Edit Product</li>
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
                                <h3 class="card-title">Edit Product</h3>
                            </div>
                            <!-- /.card-header -->
                            <form action="{{ route('admin.product.update', $product) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title', $product->title) }}"
                                            required>
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="slug">Slug <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                            id="slug" name="slug" value="{{ old('slug', $product->slug) }}"
                                            required>
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
                                                            {{ old('category_id', $product->category_id) == $key ? 'selected' : '' }}>
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
                                                    @foreach ($subcategories as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ old('subcategory_id', $product->subcategory_id) == $key ? 'selected' : '' }}>
                                                            {{ $value }}</option>
                                                    @endforeach
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
                                                                        {{ in_array($key, old('colors', $product->colors->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
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
                                                    {{ old('brand_id', $product->brand_id) == $key ? 'selected' : '' }}>
                                                    {{ $value }}</option>
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
                                            id="old_price" name="old_price"
                                            value="{{ old('old_price', $product->old_price) }}" step="0.01">
                                        @error('old_price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="price">Price <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror"
                                            id="price" name="price" value="{{ old('price', $product->price) }}"
                                            step="0.01" required>
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
                                                <input type="file" id="image-input" accept="image/*" multiple
                                                    style="display: none;">
                                                <div id="images-container">
                                                    <div class="text-center p-4" id="no-images-message"
                                                        style="display: none;">
                                                        <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                                        <p class="text-muted">No images uploaded yet. Click "Add Images" to
                                                            start.</p>
                                                    </div>
                                                </div>
                                                <div id="sortable" class="row">
                                                    <!-- Sortable images will be displayed here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="short_description">Short Description</label>
                                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                                            name="short_description" rows="3">{{ old('short_description', $product->short_description) }}</textarea>
                                        @error('short_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control summernote @error('description') is-invalid @enderror" id="description"
                                            name="description" rows="5">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="additional_information">Additional Information</label>
                                        <textarea class="form-control summernote @error('additional_information') is-invalid @enderror"
                                            id="additional_information" name="additional_information" rows="3">{{ old('additional_information', $product->additional_information) }}</textarea>
                                        @error('additional_information')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="shipping_return">Shipping & Return</label>
                                        <textarea class="form-control summernote @error('shipping_return') is-invalid @enderror" id="shipping_return"
                                            name="shipping_return" rows="3">{{ old('shipping_return', $product->shipping_return) }}</textarea>
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
                                                name="status" value="1"
                                                {{ old('status', $product->status) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="status">
                                                Active
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="is_trendy">Trendy Product</label>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" name="is_trendy" value="0">
                                            <input type="checkbox" class="custom-control-input" id="is_trendy"
                                                name="is_trendy" value="1"
                                                {{ old('is_trendy', $product->is_trendy) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_trendy">
                                                Mark as Trendy
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update Product</button>
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
        });
        $(document).ready(function() {
            // Setup CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Auto-generate slug from title
            $('#title').on('input', function() {
                var title = $(this).val();
                var slug = title.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
                $('#slug').val(slug);
            });

            // Load subcategories when category changes
            $('#category').on('change', function() {
                console.log('Category changed in edit form!'); // Debug log
                var categoryId = $(this).val();
                var subcategorySelect = $('#subcategory');
                var currentSubcategoryId = '{{ old('subcategory_id', $product->subcategory_id) }}';

                console.log('Selected category ID:', categoryId); // Debug log
                console.log('Current subcategory ID:', currentSubcategoryId); // Debug log

                // Reset subcategory dropdown
                subcategorySelect.html('<option value="">-- Select Subcategory --</option>');

                if (categoryId) {
                    // Show loading state
                    subcategorySelect.html('<option value="">Loading...</option>');

                    $.ajax({
                        url: '{{ route('admin.product.subcategories') }}',
                        type: 'GET',
                        data: {
                            category_id: categoryId
                        },
                        beforeSend: function() {
                            console.log('Sending AJAX request in edit form...'); // Debug log
                        },
                        success: function(data) {
                            console.log('AJAX success in edit form:', data); // Debug log
                            subcategorySelect.html(
                                '<option value="">-- Select Subcategory --</option>');
                            if (Object.keys(data).length === 0) {
                                subcategorySelect.html(
                                    '<option value="">No subcategories available</option>');
                            } else {
                                $.each(data, function(key, value) {
                                    var selected = (key == currentSubcategoryId) ?
                                        'selected' : '';
                                    subcategorySelect.append('<option value="' + key +
                                        '" ' + selected + '>' + value + '</option>');
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('AJAX error in edit form:', xhr, status,
                            error); // Debug log
                            subcategorySelect.html(
                                '<option value="">Error loading subcategories</option>');
                        }
                    });
                } else {
                    subcategorySelect.html('<option value="">-- Select Category First --</option>');
                }
            });

            // Trigger category change on page load to populate subcategories
            var initialCategoryId = $('#category').val();
            if (initialCategoryId) {
                $('#category').trigger('change');
            }

            // Size management
            let sizeIndex = 0;

            // Load existing sizes on page load
            let existingSizes = @json($selectedSizes);
            existingSizes.forEach(function(size) {
                let sizeRow = `
                <div class="size-row border p-3 mb-3 rounded" data-index="${sizeIndex}">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Size Name <span class="text-danger">*</span></label>
                            <input type="text" name="sizes[${sizeIndex}][size_name]" class="form-control" placeholder="e.g., Small, Medium, Large" value="${size.size_name}" required>
                        </div>
                        <div class="col-md-2">
                            <label>Additional Price</label>
                            <input type="number" name="sizes[${sizeIndex}][additional_price]" class="form-control" step="0.01" value="${size.additional_price || 0}">
                        </div>
                        <div class="col-md-2">
                            <label>Stock Quantity</label>
                            <input type="number" name="sizes[${sizeIndex}][stock_quantity]" class="form-control" value="${size.quantity || 0}" min="0">
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

            // Add size variation
            $('#add-size').on('click', function() {
                let sizeRow = `
                <div class="size-row border p-3 mb-3 rounded" data-index="${sizeIndex}">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Size Name <span class="text-danger">*</span></label>
                            <input type="text" name="sizes[${sizeIndex}][size_name]" class="form-control" placeholder="e.g., Small, Medium, Large" required>
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

            // Image Upload Management
            let imageIndex = 1000; // Start with high number to avoid conflicts with existing images
            let uploadedImages = [];

            // Initialize sortable for images
            $("#sortable").sortable({
                update: function(event, ui) {
                    updateImageOrder();
                }
            });

            // Load existing images on page load
            let existingImages = @json($product->productImages ?? []);
            if (existingImages.length > 0) {
                existingImages.forEach(function(image, index) {
                    const imageCard = `
                    <div class="col-md-3 mb-3 image-item existing-image" data-index="existing_${image.id}" data-image-id="${image.id}">
                        <div class="card">
                            <img src="/storage/${image.image_path}" class="card-img-top" style="height: 150px; object-fit: cover;">
                            <div class="card-body p-2">
                                <input type="hidden" name="existing_images[${image.id}][id]" value="${image.id}">
                                <input type="hidden" name="existing_images[${image.id}][order]" value="${image.order}" class="image-order">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">${image.original_name}</small>
                                    <button type="button" class="btn btn-danger btn-sm remove-image">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                    $('#sortable').append(imageCard);
                });
                updateImageDisplay();
            } else {
                updateImageDisplay();
            }

            // Add image button click
            $('#add-image').on('click', function() {
                $('#image-input').click();
            });

            // Handle file selection
            $('#image-input').on('change', function() {
                const files = this.files;
                if (files.length > 0) {
                    for (let i = 0; i < files.length; i++) {
                        processImage(files[i], imageIndex);
                        imageIndex++;
                    }
                }
                this.value = ''; // Reset input
            });

            // Process and display image
            function processImage(file, index) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageData = e.target.result;
                    const imageCard = `
                    <div class="col-md-3 mb-3 image-item" data-index="${index}">
                        <div class="card">
                            <img src="${imageData}" class="card-img-top" style="height: 150px; object-fit: cover;">
                            <div class="card-body p-2">
                                <input type="hidden" name="images[${index}][image_data]" value="${imageData}">
                                <input type="hidden" name="images[${index}][mime_type]" value="${file.type}">
                                <input type="hidden" name="images[${index}][original_name]" value="${file.name}">
                                <input type="hidden" name="images[${index}][order]" value="${index}" class="image-order">
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

                    uploadedImages.push({
                        index: index,
                        data: imageData,
                        type: file.type,
                        name: file.name
                    });

                    $('#sortable').append(imageCard);
                    updateImageDisplay();
                };
                reader.readAsDataURL(file);
            }

            // Remove image
            $(document).on('click', '.remove-image', function() {
                const imageItem = $(this).closest('.image-item');
                const index = imageItem.data('index');

                // If it's an existing image, mark it for deletion
                if (typeof index === 'string' && index.startsWith('existing_')) {
                    const imageId = index.replace('existing_', '');
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'deleted_images[]',
                        value: imageId
                    }).appendTo('form');
                } else {
                    // Remove from uploadedImages array for new images
                    uploadedImages = uploadedImages.filter(img => img.index !== index);
                }

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

            // Update image order after sorting
            function updateImageOrder() {
                $('#sortable .image-item').each(function(index) {
                    $(this).find('.image-order').val(index);
                });
            }
        });
    </script>
@endpush
