<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->



    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="{{ url('admin/dashboard') }}"
                    class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard

                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/index') }}"
                    class="nav-link {{ request()->is('admin/index*') || request()->is('admin/admin/*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Admin
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/customer') }}"
                    class="nav-link {{ request()->is('admin/customer*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-friends"></i>
                    <p>
                        Customers
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/category') }}"
                    class="nav-link {{ request()->is('admin/category*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tags"></i>
                    <p>
                        Category
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/subcategory') }}"
                    class="nav-link {{ request()->is('admin/subcategory*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tags"></i>
                    <p>
                        SubCategory
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/brand') }}"
                    class="nav-link {{ request()->is('admin/brand*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-briefcase"></i>
                    <p>
                        Brand
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/color') }}"
                    class="nav-link {{ request()->is('admin/color*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-palette"></i>
                    <p>
                        Color
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/discount') }}"
                    class="nav-link {{ request()->is('admin/discount*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-percent"></i>
                    <p>
                        Discount Code
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/shipping') }}"
                    class="nav-link {{ request()->is('admin/shipping*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-truck"></i>
                    <p>
                        Shipping Methods
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/products') }}"
                    class="nav-link {{ request()->is('admin/products*') || request()->is('admin/product*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-box"></i>
                    <p>
                        Products
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/order') }}"
                    class="nav-link {{ request()->is('admin/order*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <p>
                        Orders
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/refunds') }}"
                    class="nav-link {{ request()->is('admin/refund*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-undo"></i>
                    <p>
                        Refunds
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/contact') }}"
                    class="nav-link {{ request()->is('admin/contact*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-envelope"></i>
                    <p>
                        Contact Messages
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('admin/settings') }}"
                    class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cog"></i>
                    <p>
                        Settings
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
