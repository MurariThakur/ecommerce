<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' : '' }}Ecommerce Admin</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('assets/dist/css/adminlte.min.css') }}">
    
    <!-- Custom Styles -->
    @stack('styles')
    
    <!-- Custom Pagination Styles -->
    <style>
        .pagination {
            margin: 0;
        }
        .pagination .page-link {
            color: #007bff;
            background-color: #fff;
            border: 1px solid #dee2e6;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
            transition: all 0.15s ease-in-out;
        }
        .pagination .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
            box-shadow: 0 2px 4px rgba(0, 123, 255, 0.25);
        }
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            cursor: auto;
            background-color: #fff;
            border-color: #dee2e6;
            opacity: 0.6;
        }
        .pagination .page-link:hover {
            z-index: 2;
            color: #0056b3;
            text-decoration: none;
            background-color: #e9ecef;
            border-color: #adb5bd;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .pagination .page-link:focus {
            z-index: 3;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .pagination-sm .page-link {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
        }
        .card-footer.clearfix {
            background-color: rgba(0,0,0,.03);
            border-top: 1px solid rgba(0,0,0,.125);
            padding: 0.75rem 1.25rem;
        }
        .card-footer .pagination {
            margin-bottom: 0;
        }
        .card-footer .text-muted {
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 0;
        }
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .card-footer.clearfix .float-left,
            .card-footer.clearfix .float-right {
                float: none !important;
                text-align: center;
            }
            .card-footer.clearfix .float-left {
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('admin.layouts.header')
        @yield('content')
        <!-- Control Sidebar -->
        @include('admin.layouts.control_sidebar')
        @include('admin.layouts.footer')

    </div>
    <!-- ./wrapper -->

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 60%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); margin: 0;">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="logoutModalLabel">
                        <i class="fas fa-sign-out-alt mr-2"></i>Confirm Logout
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-exclamation-triangle text-warning mb-3" style="font-size: 4rem;"></i>
                    <h5 class="mb-3">Are you sure you want to logout?</h5>
                    <p class="text-muted">You will be logged out from this session and redirected to the login page.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary mr-3" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                    <form method="POST" action="{{ route('admin.logout') }}" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt mr-2"></i>Yes, Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
    #logoutModal .modal-dialog {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
    }
    
    #logoutModal .modal-content {
        width: 100%;
        max-width: none;
    }
    
    @media (max-width: 768px) {
        #logoutModal .modal-dialog {
            max-width: 90%;
            padding: 15px;
        }
    }
    </style>

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ url('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ url('assets/dist/js/adminlte.js') }}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ url('assets/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ url('assets/dist/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ url('assets/dist/js/pages/dashboard3.js') }}"></script>
    
    <!-- Notification Scripts -->
    <script>
    $(document).ready(function() {
        loadNotifications();
        
        // Load notifications every 30 seconds
        setInterval(loadNotifications, 30000);
        
        // Mark all as read
        $('#mark-all-read').click(function() {
            $.post('{{ route('admin.notifications.mark-all-read') }}', {
                _token: '{{ csrf_token() }}'
            }).done(function() {
                loadNotifications();
            });
        });
    });
    
    function loadNotifications() {
        $.get('{{ route('admin.notifications.unread-count') }}').done(function(data) {
            $('#notification-count').text(data.count);
            if(data.count > 0) {
                $('#notification-count').show();
            } else {
                $('#notification-count').hide();
            }
        });
        
        $.get('{{ route('admin.notifications.recent') }}').done(function(notifications) {
            let html = '';
            if(notifications.length > 0) {
                notifications.forEach(function(notification) {
                    let readClass = notification.is_read ? 'bg-light' : 'bg-white';
                    let newBadge = notification.is_read ? '' : '<span class="badge badge-danger badge-sm">New</span>';
                    let url = notification.url ? `onclick="markAsRead(${notification.id}, '${notification.url}')"` : '';
                    let textClass = notification.is_read ? 'text-muted' : 'text-dark';
                    
                    html += `
                        <a href="#" class="dropdown-item ${readClass} ${textClass} border-bottom" ${url} style="padding: 12px 20px;">
                            <div class="d-flex align-items-start">
                                <div class="mr-3">
                                    <i class="${notification.icon} text-${notification.color}" style="font-size: 16px;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h6 class="mb-1 font-weight-bold" style="font-size: 13px;">${notification.title}</h6>
                                        ${newBadge}
                                    </div>
                                    <p class="mb-1 text-muted" style="font-size: 12px; line-height: 1.3;">${notification.message}</p>
                                    <small class="text-muted">
                                        <i class="far fa-clock mr-1"></i>${timeAgo(notification.created_at)}
                                    </small>
                                </div>
                            </div>
                        </a>
                    `;
                });
            } else {
                html = `
                    <div class="text-center p-4">
                        <i class="fas fa-bell-slash fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">No notifications</p>
                    </div>
                `;
            }
            
            $('#notification-list').html(html);
            $('#notification-header').html(`<i class="fas fa-bell mr-2"></i>${notifications.length} Notifications`);
        });
    }
    
    function markAsRead(id, url) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/notifications/${id}/read`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
    
    function timeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);
        
        if (diffInSeconds < 60) return 'now';
        if (diffInSeconds < 3600) return Math.floor(diffInSeconds / 60) + 'm';
        if (diffInSeconds < 86400) return Math.floor(diffInSeconds / 3600) + 'h';
        return Math.floor(diffInSeconds / 86400) + 'd';
    }
    </script>
    
    <!-- Custom Scripts -->
    @stack('scripts')
</body>

</html>
