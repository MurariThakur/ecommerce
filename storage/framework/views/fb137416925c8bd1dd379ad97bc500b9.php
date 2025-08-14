
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->



        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?php echo e(url('admin/dashboard')); ?>"
                        class="nav-link <?php echo e(request()->is('admin/dashboard') ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard

                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(url('admin/index')); ?>"
                        class="nav-link <?php echo e(request()->is('admin/index*') || request()->is('admin/admin/*') ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Admin 
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(url('admin/category')); ?>"
                        class="nav-link <?php echo e(request()->is('admin/category*') ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            Category
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(url('admin/subcategory')); ?>"
                        class="nav-link <?php echo e(request()->is('admin/subcategory*') ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            SubCategory
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(url('admin/brand')); ?>"
                        class="nav-link <?php echo e(request()->is('admin/brand*') ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>
                            Brand
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(url('admin/color')); ?>"
                        class="nav-link <?php echo e(request()->is('admin/color*') ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-palette"></i>
                        <p>
                            Color
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(url('admin/products')); ?>" class="nav-link <?php echo e(request()->is('admin/products*') || request()->is('admin/product*') ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Products
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" data-toggle="modal" data-target="#logoutModal">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
<?php /**PATH C:\xampp\htdocs\ecommerce\resources\views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>