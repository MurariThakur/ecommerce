<!DOCTYPE html>
<html lang="en">


<!-- molla/index-2.html  22 Nov 2019 09:55:32 GMT -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo e($meta_title ?? 'Ecommerce'); ?></title>
    <meta name="keywords" content="<?php echo e($meta_keyword ?? ''); ?>">
    <meta name="description" content="<?php echo e($meta_description ?? ''); ?>">
    <meta name="author" content="">
    <!-- Favicon -->

    <link rel="shortcut icon" href="<?php echo e(asset('frontend/assets/images/icons/favicon.ico')); ?>">

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/assets/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('frontend/assets/css/plugins/owl-carousel/owl.carousel.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('frontend/assets/css/plugins/magnific-popup/magnific-popup.css')); ?>">
    <link rel="mask-icon" href="<?php echo e(asset('frontend/assets/images/icons/safari-pinned-tab.svg')); ?>" color="#666666">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/assets/css/style.css')); ?>">

    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body>
    <div class="page-wrapper">

        <?php echo $__env->make('frontend.layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo $__env->make('frontend.layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <?php echo $__env->make('frontend.layouts.mobile_menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- Sign in / Register Modal -->
    <?php echo $__env->make('frontend.layouts.signup', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


    

    <!-- Plugins JS File -->
    <script src="<?php echo e(asset('frontend/assets/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/assets/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/assets/js/jquery.hoverIntent.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/assets/js/jquery.waypoints.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/assets/js/superfish.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/assets/js/owl.carousel.min.js')); ?>"></script>
    <script src="<?php echo e(asset('frontend/assets/js/jquery.magnific-popup.min.js')); ?>"></script>
    <!-- Main JS File -->
    <script src="<?php echo e(asset('frontend/assets/js/main.js')); ?>"></script>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\ecommerce\resources\views/frontend/layouts/app.blade.php ENDPATH**/ ?>