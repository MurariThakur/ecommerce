<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">View Product</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.product.index')); ?>">Product Management</a></li>
                        <li class="breadcrumb-item active">View Product</li>
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
                            <h3 class="card-title">
                                <i class="fas fa-eye"></i> Product Details
                            </h3>
                            <div class="card-tools">
                                <a href="<?php echo e(route('admin.product.edit', $product)); ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit Product
                                </a>
                                <a href="<?php echo e(route('admin.product.index')); ?>" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <!--  Basic Information -->
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-info-circle"></i> Basic Information
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td width="150"><strong>Title</strong></td>
                                                    <td><?php echo e($product->title); ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="150"><strong>Sku</strong></td>
                                                    <td><?php echo e($product->slug); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Category</strong></td>
                                                    <td><?php echo e($product->category ? $product->category->name : 'N/A'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Subcategory</strong></td>
                                                    <td><?php echo e($product->subcategory ? $product->subcategory->name : 'N/A'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Brand</strong></td>
                                                    <td><?php echo e($product->brand ? $product->brand->name : 'N/A'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Price</strong></td>
                                                    <td>$<?php echo e(number_format($product->price, 2)); ?></td>
                                                </tr>
                                                <?php if($product->old_price && $product->old_price > $product->price): ?>
                                                <tr>
                                                    <td><strong>Old Price</strong></td>
                                                    <td>$<?php echo e(number_format($product->old_price, 2)); ?></td>
                                                </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td><strong>Status</strong></td>
                                                    <td>
                                                        <?php if($product->status): ?>
                                                            <span class="badge badge-success">
                                                                <i class="fas fa-check-circle"></i> Active
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="badge badge-danger">
                                                                <i class="fas fa-times-circle"></i> Inactive
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Created At</strong></td>
                                                    <td><?php echo e($product->created_at); ?></td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>

                                    <!-- Product Images -->
                                    <div class="card card-outline card-success">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-images"></i> Product Images
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <?php if($product->productImages->count() > 0): ?>
                                                <div class="row">
                                                    <?php $__currentLoopData = $product->productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="col-md-4 col-sm-6 mb-3">
                                                            <div class="card">
                                                                <img src="<?php echo e($image->image_src); ?>"
                                                                     class="card-img-top"
                                                                     alt="<?php echo e($image->original_name); ?>"
                                                                     style="height: 150px; object-fit: cover; cursor: pointer;"
                                                                     data-toggle="modal"
                                                                     data-target="#imageModal<?php echo e($image->id); ?>">
                                                                <div class="card-body p-2">
                                                                    <small class="text-muted"><?php echo e($image->original_name); ?></small>
                                                                    <br>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-center text-muted py-4">
                                                    <i class="fas fa-image fa-3x mb-3"></i>
                                                    <p>No images available for this product</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Product Colors -->
                                    <div class="card card-outline card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-palette"></i> Available Colors
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <?php if($product->colors->count() > 0): ?>
                                                <div class="row">
                                                    <?php $__currentLoopData = $product->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="col-md-6 col-sm-12 mb-2">
                                                            <div class="d-flex align-items-center p-2 border rounded">
                                                                <div class="color-swatch rounded-circle mr-3"
                                                                     style="width: 30px; height: 30px; background-color: <?php echo e($color->color_code); ?>; border: 2px solid #ddd;"></div>
                                                                <div>
                                                                    <strong><?php echo e($color->name); ?></strong>
                                                                    <br>
                                                                    <small class="text-muted"><?php echo e($color->color_code); ?></small>
                                                                    <?php if($color->status): ?>
                                                                        <span class="badge badge-success badge-sm ml-2">Active</span>
                                                                    <?php else: ?>
                                                                        <span class="badge badge-secondary badge-sm ml-2">Inactive</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-center text-muted py-4">
                                                    <i class="fas fa-palette fa-3x mb-3"></i>
                                                    <p>No colors assigned to this product</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Product Sizes -->
                                    <div class="card card-outline card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-ruler"></i> Available Sizes
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <?php if($product->productSizes->count() > 0): ?>
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-hover">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Size Name</th>
                                                                <th>Size Value</th>
                                                                <th>Additional Price</th>
                                                                <th>Quantity</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $__currentLoopData = $product->productSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <td><strong><?php echo e($size->size_name); ?></strong></td>
                                                                    <td><?php echo e($size->size_value); ?></td>
                                                                    <td>
                                                                        <?php if($size->additional_price > 0): ?>
                                                                            <span class="text-success">+$<?php echo e(number_format($size->additional_price, 2)); ?></span>
                                                                        <?php elseif($size->additional_price < 0): ?>
                                                                            <span class="text-danger">$<?php echo e(number_format($size->additional_price, 2)); ?></span>
                                                                        <?php else: ?>
                                                                            <span class="text-muted">$0.00</span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if($size->quantity > 0): ?>
                                                                            <span class="badge badge-success"><?php echo e($size->quantity); ?> in stock</span>
                                                                        <?php else: ?>
                                                                            <span class="badge badge-danger">Out of stock</span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php if($size->quantity > 0): ?>
                                                                            <i class="fas fa-check-circle text-success"></i>
                                                                        <?php else: ?>
                                                                            <i class="fas fa-times-circle text-danger"></i>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-center text-muted py-4">
                                                    <i class="fas fa-ruler fa-3x mb-3"></i>
                                                    <p>No sizes defined for this product</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Detailed Information -->
                                    <div class="card card-outline card-secondary">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-edit"></i> Detailed Information
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td width="150"><strong>Short Description</strong></td>
                                                    <td><?php echo e($product->short_description ?? '-'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Additional Information</strong></td>
                                                    <td><?php echo e($product->additional_information ?? '-'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Shipping & Returns</strong></td>
                                                    <td><?php echo e($product->shipping_return ?? '-'); ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <!--  Quick Actions -->
                                    <div class="card card-outline card-success">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-cogs"></i> Quick Actions
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-grid gap-2">
                                                <!-- Edit Button -->
                                                <a href="<?php echo e(route('admin.product.edit', $product)); ?>" class="btn btn-warning btn-block">
                                                    <i class="fas fa-edit"></i> Edit Product
                                                </a>

                                                <!-- Toggle Status Button -->
                                                <button type="button" class="btn btn-block <?php echo e($product->status ? 'btn-secondary' : 'btn-success'); ?>"
                                                    data-toggle="modal" data-target="#statusModal">
                                                    <i class="fas fa-<?php echo e($product->status ? 'ban' : 'check'); ?>"></i>
                                                    <?php echo e($product->status ? 'Deactivate' : 'Activate'); ?> Product
                                                </button>

                                                <!-- Delete Button -->
                                                <button type="button" class="btn btn-danger btn-block"
                                                    data-toggle="modal" data-target="#deleteModal">
                                                    <i class="fas fa-trash"></i> Delete Product
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Product Statistics -->
                                    <div class="card card-outline card-warning">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-chart-bar"></i> Statistics
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-info">
                                                    <i class="fas fa-calendar"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Days Since Created</span>
                                                    <span class="info-box-number"><?php echo e($product->created_at->diffInDays(now())); ?></span>
                                                </div>
                                            </div>
                                            <div class="info-box">
                                                <span class="info-box-icon bg-success">
                                                    <i class="fas fa-clock"></i>
                                                </span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Last Updated</span>
                                                    <span class="info-box-number text-sm"><?php echo e($product->updated_at->diffForHumans()); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Product Overview -->
                                    <div class="card card-outline card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-clipboard-list"></i> Overview
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="description-block border-right">
                                                        <span class="description-percentage text-success">
                                                            <i class="fas fa-images"></i>
                                                        </span>
                                                        <h5 class="description-header"><?php echo e($product->productImages->count()); ?></h5>
                                                        <span class="description-text">IMAGES</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="description-block">
                                                        <span class="description-percentage text-warning">
                                                            <i class="fas fa-palette"></i>
                                                        </span>
                                                        <h5 class="description-header"><?php echo e($product->colors->count()); ?></h5>
                                                        <span class="description-text">COLORS</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-6">
                                                    <div class="description-block border-right">
                                                        <span class="description-percentage text-info">
                                                            <i class="fas fa-ruler"></i>
                                                        </span>
                                                        <h5 class="description-header"><?php echo e($product->productSizes->count()); ?></h5>
                                                        <span class="description-text">SIZES</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="description-block">
                                                        <span class="description-percentage text-<?php echo e($product->productSizes->sum('quantity') > 0 ? 'success' : 'danger'); ?>">
                                                            <i class="fas fa-boxes"></i>
                                                        </span>
                                                        <h5 class="description-header"><?php echo e($product->productSizes->sum('quantity')); ?></h5>
                                                        <span class="description-text">TOTAL STOCK</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($product->hasDiscount()): ?>
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <div class="description-block text-center">
                                                        <span class="description-percentage text-success">
                                                            <i class="fas fa-percentage"></i>
                                                        </span>
                                                        <h5 class="description-header text-success"><?php echo e($product->discount_percentage); ?>%</h5>
                                                        <span class="description-text">DISCOUNT</span>
                                                        <br>
                                                        <small class="text-muted">
                                                            Save $<?php echo e(number_format($product->old_price - $product->price, 2)); ?>

                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
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

<!-- Status Toggle Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">
                    <i class="fas fa-<?php echo e($product->status ? 'ban text-warning' : 'check text-success'); ?>"></i>
                    <?php echo e($product->status ? 'Deactivate' : 'Activate'); ?> Product
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to <?php echo e($product->status ? 'deactivate' : 'activate'); ?> this product?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <form action="<?php echo e(route('admin.product.toggle.status', $product)); ?>" method="POST" style="display: inline-block;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn <?php echo e($product->status ? 'btn-warning' : 'btn-success'); ?>">
                        <i class="fas fa-<?php echo e($product->status ? 'ban' : 'check'); ?>"></i>
                        <?php echo e($product->status ? 'Deactivate' : 'Activate'); ?> Product
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Deletion
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Are you sure you want to delete this product?</p>
                <div class="alert alert-danger">
                    <strong>Warning:</strong> This action cannot be undone!<br>
                    <strong>Product:</strong> <?php echo e($product->title); ?>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <form action="<?php echo e(route('admin.product.destroy', $product)); ?>" method="POST" style="display: inline-block;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete Product
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Image Modals -->
<?php $__currentLoopData = $product->productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="imageModal<?php echo e($image->id); ?>" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel<?php echo e($image->id); ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel<?php echo e($image->id); ?>">
                    <i class="fas fa-image"></i> <?php echo e($image->original_name); ?>

                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="<?php echo e($image->image_src); ?>"
                     class="img-fluid"
                     alt="<?php echo e($image->original_name); ?>"
                     style="max-height: 70vh; object-fit: contain;">
                <div class="mt-3">
                    <small class="text-muted">
                        <strong>File:</strong> <?php echo e($image->original_name); ?><br>
                        <strong>Type:</strong> <?php echo e($image->mime_type); ?><br>
                        <strong>Order:</strong> <?php echo e($image->order); ?>

                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>











































































































































































































<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ecommerce\resources\views/admin/product/show.blade.php ENDPATH**/ ?>