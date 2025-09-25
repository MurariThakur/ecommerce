<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

       
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" id="notification-bell">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge" id="notification-count" style="display: none;">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notification-dropdown" style="width: 350px; max-height: 400px; overflow-y: auto;">
                <span class="dropdown-item dropdown-header bg-light" id="notification-header">
                    <i class="fas fa-bell mr-2"></i>0 Notifications
                </span>
                <div id="notification-list">
                    <div class="text-center p-4">
                        <i class="fas fa-bell-slash fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">No notifications</p>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="dropdown-footer bg-light p-2">
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('admin.notifications.index') }}" class="btn btn-sm btn-primary btn-block">
                                <i class="fas fa-eye mr-1"></i>View All
                            </a>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-sm btn-secondary btn-block" id="mark-all-read">
                                <i class="fas fa-check mr-1"></i>Mark Read
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </li>

    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ url('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Ecommerce</span>
    </a>
@include('admin.layouts.sidebar')
</aside>
