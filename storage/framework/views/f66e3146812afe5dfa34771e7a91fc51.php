<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(url('assets/plugins/summernote/summernote-lite.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
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
                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.product.index')); ?>">Product Management</a>
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
                <?php echo $__env->make('admin.layouts.message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Edit Product</h3>
                            </div>
                            <!-- /.card-header -->
                            <form action="<?php echo e(route('admin.product.update', $product)); ?>" method="POST"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="title" name="title" value="<?php echo e(old('title', $product->title)); ?>"
                                            required>
                                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="slug">Slug <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="slug" name="slug" value="<?php echo e(old('slug', $product->slug)); ?>"
                                            required>
                                        <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category">Category <span class="text-danger">*</span></label>
                                                <select name="category_id"
                                                    class="form-control <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    id="category" required>
                                                    <option value="">-- Select Category --</option>
                                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($key); ?>"
                                                            <?php echo e(old('category_id', $product->category_id) == $key ? 'selected' : ''); ?>>
                                                            <?php echo e($value); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="subcategory">Subcategory <span
                                                        class="text-danger">*</span></label>
                                                <select name="subcategory_id"
                                                    class="form-control <?php $__errorArgs = ['subcategory_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    id="subcategory" required>
                                                    <option value="">-- Select Subcategory --</option>
                                                    <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($key); ?>"
                                                            <?php echo e(old('subcategory_id', $product->subcategory_id) == $key ? 'selected' : ''); ?>>
                                                            <?php echo e($value); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php $__errorArgs = ['subcategory_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Colors</label>
                                                <div class="<?php $__errorArgs = ['colors'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <div class="row">
                                                        <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="col-md-6 col-lg-4">
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="colors[]" value="<?php echo e($key); ?>"
                                                                        id="color_<?php echo e($key); ?>"
                                                                        <?php echo e(in_array($key, old('colors', $product->colors->pluck('id')->toArray() ?? [])) ? 'checked' : ''); ?>>
                                                                    <label class="form-check-label"
                                                                        for="color_<?php echo e($key); ?>">
                                                                        <?php echo e($value); ?>

                                                                    </label>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                                <?php $__errorArgs = ['colors'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="brand_id">Brand</label>
                                        <select name="brand_id" class="form-control <?php $__errorArgs = ['brand_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="brand_id">
                                            <option value="">-- Select Brand --</option>
                                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>"
                                                    <?php echo e(old('brand_id', $product->brand_id) == $key ? 'selected' : ''); ?>>
                                                    <?php echo e($value); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['brand_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="old_price">Old Price</label>
                                        <input type="number" class="form-control <?php $__errorArgs = ['old_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="old_price" name="old_price"
                                            value="<?php echo e(old('old_price', $product->old_price)); ?>" step="0.01">
                                        <?php $__errorArgs = ['old_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="price">Price <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="price" name="price" value="<?php echo e(old('price', $product->price)); ?>"
                                            step="0.01" required>
                                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                        <textarea class="form-control <?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="short_description"
                                            name="short_description" rows="3"><?php echo e(old('short_description', $product->short_description)); ?></textarea>
                                        <?php $__errorArgs = ['short_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control summernote <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description"
                                            name="description" rows="5"><?php echo e(old('description', $product->description)); ?></textarea>
                                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="additional_information">Additional Information</label>
                                        <textarea class="form-control summernote <?php $__errorArgs = ['additional_information'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="additional_information" name="additional_information" rows="3"><?php echo e(old('additional_information', $product->additional_information)); ?></textarea>
                                        <?php $__errorArgs = ['additional_information'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="shipping_return">Shipping & Return</label>
                                        <textarea class="form-control summernote <?php $__errorArgs = ['shipping_return'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="shipping_return"
                                            name="shipping_return" rows="3"><?php echo e(old('shipping_return', $product->shipping_return)); ?></textarea>
                                        <?php $__errorArgs = ['shipping_return'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <div class="custom-control custom-switch">
                                            <input type="hidden" name="status" value="0">
                                            <input type="checkbox" class="custom-control-input" id="status"
                                                name="status" value="1"
                                                <?php echo e(old('status', $product->status) ? 'checked' : ''); ?>>
                                            <label class="custom-control-label" for="status">
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update Product</button>
                                    <a href="<?php echo e(route('admin.product.index')); ?>" class="btn btn-secondary">Cancel</a>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(url('assets/plugins/summernote/summernote-lite.min.js')); ?>"></script>
    <script src="<?php echo e(url('assets/sortable/jquery-ui.js')); ?>"></script>
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
                console.log('Category changed in edit form!');
                var categoryId = $(this).val();
                var subcategorySelect = $('#subcategory');
                var currentSubcategoryId = '<?php echo e(old('subcategory_id', $product->subcategory_id)); ?>';

                console.log('Selected category ID:', categoryId);
                console.log('Current subcategory ID:', currentSubcategoryId);

                subcategorySelect.html('<option value="">-- Select Subcategory --</option>');

                if (categoryId) {
                    subcategorySelect.html('<option value="">Loading...</option>');

                    $.ajax({
                        url: '<?php echo e(route('admin.product.subcategories')); ?>',
                        type: 'GET',
                        data: {
                            category_id: categoryId
                        },
                        beforeSend: function() {
                            console.log('Sending AJAX request in edit form...');
                        },
                        success: function(data) {
                            console.log('AJAX success in edit form:', data);
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
                            console.log('AJAX error in edit form:', xhr, status, error);
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
            let existingSizes = <?php echo json_encode($selectedSizes, 15, 512) ?>;
            existingSizes.forEach(function(size) {
                let sizeRow = `
            <div class="size-row border p-3 mb-3 rounded" data-index="${sizeIndex}">
                <div class="row">
                    <div class="col-md-3">
                        <label>Size Name <span class="text-danger">*</span></label>
                        <input type="text" name="sizes[${sizeIndex}][size_name]" class="form-control" placeholder="e.g., Small, Medium, Large" value="${size.size_name}" required>
                    </div>
                    <div class="col-md-3">
                        <label>Size Value</label>
                        <input type="text" name="sizes[${sizeIndex}][size_value]" class="form-control" placeholder="e.g., 28 inches" value="${size.size_value || ''}">
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

            // Image Upload Management (Modified for URL storage)
            let imageIndex = 1000;
            let uploadedImages = [];

            // Initialize sortable for images
            $("#sortable").sortable({
                update: function(event, ui) {
                    updateImageOrder();
                }
            });

            // Load existing images on page load - Using URL path instead of base64
            let existingImages = <?php echo json_encode($product->productImages ?? [], 15, 512) ?>;
            if (existingImages.length > 0) {
                existingImages.forEach(function(image, index) {
                    const imageCard = `
                <div class="col-md-3 mb-3 image-item existing-image" data-index="existing_${image.id}" data-image-id="${image.id}">
                    <div class="card">
                        <img src="/storage/product_images/${image.image_path}" class="card-img-top" style="height: 150px; object-fit: cover;">
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

            // Handle file selection - Keep functionality but use preview for display
            $('#image-input').on('change', function() {
                const files = this.files;
                if (files.length > 0) {
                    for (let i = 0; i < files.length; i++) {
                        processImage(files[i], imageIndex);
                        imageIndex++;
                    }
                }
                // Don't reset input value to maintain files for form submission
            });

            // Process and display image - Modified to show preview but submit as file
            function processImage(file, index) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageData = e.target.result; // This is for preview only
                    const imageCard = `
                <div class="col-md-3 mb-3 image-item" data-index="${index}">
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

                    // Store file reference for tracking, but let the file input handle actual submission
                    uploadedImages.push({
                        index: index,
                        name: file.name,
                        size: file.size,
                        type: file.type
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ecommerce\resources\views/admin/product/edit.blade.php ENDPATH**/ ?>