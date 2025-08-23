<!DOCTYPE html>
<html lang="en">


<!-- molla/index-2.html  22 Nov 2019 09:55:32 GMT -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $meta_title ?? 'Ecommerce' }}</title>
    <meta name="keywords" content="{{ $meta_keyword ?? '' }}">
    <meta name="description" content="{{ $meta_description ?? '' }}">
    <meta name="author" content="">
    <!-- Favicon -->

    <link rel="shortcut icon" href="{{ asset('frontend/assets/images/icons/favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/magnific-popup/magnific-popup.css') }}">
    <link rel="mask-icon" href="{{ asset('frontend/assets/images/icons/safari-pinned-tab.svg') }}" color="#666666">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">

    @yield('styles')
    <style>
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 2000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast-custom {
            min-width: 280px;
            padding: 14px 18px;
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.4s ease;
        }

        .toast-custom.show {
            opacity: 1;
            transform: translateX(0);
        }

        .toast-custom .toast-message {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }

        .toast-custom .close-btn {
            background: transparent;
            border: none;
            color: inherit;
            font-size: 18px;
            cursor: pointer;
        }

        /* Colors */
        .toast-success {
            background: linear-gradient(135deg, #28a745, #218838);
        }

        .toast-error {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        .toast-warning {
            background: linear-gradient(135deg, #ffc107, #e0a800);
            color: #333;
        }

        .toast-info {
            background: linear-gradient(135deg, #17a2b8, #117a8b);
        }

        .cart-update-animation {
            animation: cartPulse 0.5s ease;
        }

        @keyframes cartPulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Prevent dropdown from closing when clicking inside */
        #cart-dropdown-menu {
            pointer-events: auto;
        }

        #cart-dropdown-menu * {
            pointer-events: auto;
        }
    </style>

</head>

<body>
    <div class="page-wrapper">

        @include('frontend.layouts.header')
        @yield('content')
        @include('frontend.layouts.footer')
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    @include('frontend.layouts.mobile_menu')
    <!-- Sign in / Register Modal -->
    @include('frontend.layouts.signup')


    {{-- <div class="container newsletter-popup-container mfp-hide" id="newsletter-popup-form">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="row no-gutters bg-white newsletter-popup-content">
                    <div class="col-xl-3-5col col-lg-7 banner-content-wrap">
                        <div class="banner-content text-center">
                            <img src="{{ asset('frontend/assets/images/popup/newsletter/logo.png') }}" class="logo" alt="logo"
                                width="60" height="15">
                            <h2 class="banner-title">get <span>25<light>%</light></span> off</h2>
                            <p>Subscribe to the Molla eCommerce newsletter to receive timely updates from your favorite
                                products.</p>
                            <form action="#">
                                <div class="input-group input-group-round">
                                    <input type="email" class="form-control form-control-white"
                                        placeholder="Your Email Address" aria-label="Email Adress" required>
                                    <div class="input-group-append">
                                        <button class="btn" type="submit"><span>go</span></button>
                                    </div><!-- .End .input-group-append -->
                                </div><!-- .End .input-group -->
                            </form>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="register-policy-2" required>
                                <label class="custom-control-label" for="register-policy-2">Do not show this popup
                                    again</label>
                            </div><!-- End .custom-checkbox -->
                        </div>
                    </div>
                    <div class="col-xl-2-5col col-lg-5 ">
                        <img src="{{ asset('frontend/assets/images/popup/newsletter/img-1.jpg') }}" class="newsletter-img"
                            alt="newsletter">
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Plugins JS File -->
    <script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.hoverIntent.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/superfish.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Main JS File -->
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>

    @yield('scripts')
    <div id="toast-container" class="toast-container"></div>
    <script>
        // Global CartManager Object
        window.CartManager = {
            // Properties
            routes: {},
            csrfToken: '',

            // Initialize the cart system
            init: function() {
                this.setupRoutes();
                this.initializeDropdownEvents();
                this.setupGlobalEventListeners();

                // Initialize cart page if we're on the cart page
                if (document.querySelector('.cart')) {
                    this.initializeCartPage();
                }

                console.log('CartManager initialized');
            },

            // Setup route URLs
            setupRoutes: function() {
                this.routes = {
                    update: '{{ route('cart.update') }}',
                    remove: '{{ route('cart.remove') }}',
                    clear: '{{ route('cart.clear') }}',
                    dropdown: '{{ route('cart.dropdown') }}'
                };
                this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            },

            // Initialize dropdown events using event delegation
            initializeDropdownEvents: function() {
                document.addEventListener('click', (e) => {
                    if (e.target.closest('.remove-item-dropdown')) {
                        e.preventDefault();
                        const rowId = e.target.closest('.remove-item-dropdown').dataset.rowid;
                        this.removeItem(rowId, true);
                    }
                });
            },

            // Setup global event listeners
            setupGlobalEventListeners: function() {
                // Listen for custom cart update events
                document.addEventListener('cartUpdated', (e) => {
                    this.updateHeaderCart(e.detail);
                });
            },

            // Initialize cart page functionality
            initializeCartPage: function() {
                // Update quantity with debounce
                let updateTimeout;
                const debounceTime = 500;

                document.querySelectorAll('.quantity-input').forEach(input => {
                    input.addEventListener('change', (e) => {
                        const rowId = e.target.dataset.rowid;
                        const newQuantity = e.target.value;

                        clearTimeout(updateTimeout);
                        updateTimeout = setTimeout(() => {
                            this.updateQuantity(rowId, newQuantity);
                        }, debounceTime);
                    });
                });

                // Remove item from cart page
                document.querySelectorAll('.remove-item').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const rowId = e.target.closest('.remove-item').dataset.rowid;
                        this.removeItem(rowId);
                    });
                });

                // Clear entire cart
                document.querySelectorAll('.clear-cart').forEach(button => {
                    button.addEventListener('click', (e) => {
                        e.preventDefault();
                        this.clearCart();
                    });
                });

                // Update shipping cost when selection changes
                document.querySelectorAll('input[name="shipping"]').forEach(input => {
                    input.addEventListener('change', () => {
                        this.updateTotals();
                    });
                });
            },

            // Update item quantity
            updateQuantity: function(rowId, quantity) {
                fetch(this.routes.update, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken
                        },
                        body: JSON.stringify({
                            rowId: rowId,
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(response => {
                        if (response.success) {
                            // Update individual item total
                            const itemTotalElement = document.querySelector(`#cart-item-${rowId} .item-total`);
                            if (itemTotalElement) {
                                itemTotalElement.textContent = response.itemTotal;
                            }

                            // Update cart totals
                            this.updateCartTotals(response.subTotal, response.total);

                            // Trigger custom event to update header
                            this.triggerCartUpdated(response);

                            this.showToast('Quantity updated successfully', 'success');
                        } else {
                            this.showToast(response.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.showToast('Error updating quantity', 'error');
                    });
            },

            // Remove item from cart
            removeItem: function(rowId, fromDropdown = false) {

                fetch(this.routes.remove, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken
                        },
                        body: JSON.stringify({
                            rowId: rowId
                        })
                    })
                    .then(response => response.json())
                    .then(response => {
                        if (response.success) {
                            if (!fromDropdown) {
                                // Remove item from DOM on cart page
                                const itemElement = document.querySelector(`#cart-item-${rowId}`);
                                if (itemElement) {
                                    itemElement.remove();
                                }

                                // Update cart totals
                                this.updateCartTotals(response.subTotal, response.total);

                                // Check if cart is empty
                                if (response.itemsCount === 0) {
                                    location.reload();
                                }
                            }

                            // Trigger custom event to update header
                            this.triggerCartUpdated(response);

                            this.showToast('Item removed from cart', 'success');
                        } else {
                            this.showToast('Error removing item', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.showToast('Error removing item', 'error');
                    });
            },

            // Clear entire cart
            clearCart: function() {
                if (!confirm('Are you sure you want to clear your entire cart?')) {
                    return;
                }

                fetch(this.routes.clear, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(response => {
                        if (response.success) {
                            // Trigger custom event to update header
                            this.triggerCartUpdated(response);

                            location.reload();
                        } else {
                            this.showToast('Error clearing cart', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.showToast('Error clearing cart', 'error');
                    });
            },

            // Update cart totals display
            updateCartTotals: function(subTotal, total) {
                const subtotalElement = document.querySelector('#cart-subtotal');
                const totalElement = document.querySelector('#cart-total');

                if (subtotalElement) subtotalElement.textContent = '$' + subTotal;
                if (totalElement) totalElement.textContent = '$' + total;
            },

            // Update shipping totals
            updateTotals: function() {
                const selectedShipping = document.querySelector('input[name="shipping"]:checked');
                if (!selectedShipping) return;

                const shippingCost = parseFloat(selectedShipping.parentElement.nextElementSibling.textContent
                    .replace('$', ''));
                const subTotal = parseFloat(document.querySelector('#cart-subtotal').textContent.replace('$', ''));
                const total = subTotal + shippingCost;

                document.querySelector('#cart-total').textContent = '$' + total.toFixed(2);
            },

            // Update header cart
            updateHeaderCart: function(response) {
                // Update cart count with animation
                const cartCount = document.querySelector('#header-cart-count');
                if (cartCount) {
                    cartCount.textContent = response.itemsCount;
                    cartCount.classList.add('cart-update-animation');
                    setTimeout(() => cartCount.classList.remove('cart-update-animation'), 500);
                }

                // Update cart dropdown content
                if (response.itemsCount === 0) {
                    const dropdownMenu = document.querySelector('#cart-dropdown-menu');
                    if (dropdownMenu) {
                        dropdownMenu.innerHTML = '<p class="text-center p-3">Your cart is empty</p>';
                    }
                    return;
                }

                // Refresh dropdown via AJAX
                this.refreshCartDropdown();
            },

            // Refresh cart dropdown via AJAX
            refreshCartDropdown: function() {
                fetch(this.routes.dropdown)
                    .then(response => response.text())
                    .then(data => {
                        const dropdownMenu = document.querySelector('#cart-dropdown-menu');
                        if (dropdownMenu) {
                            dropdownMenu.innerHTML = data;

                            // Re-attach event listeners to new remove buttons
                            this.initializeDropdownEvents();
                        }
                    })
                    .catch(error => {
                        console.error('Failed to refresh cart dropdown:', error);
                    });
            },

            // Trigger cart updated event
            triggerCartUpdated: function(response) {
                const event = new CustomEvent('cartUpdated', {
                    detail: response
                });
                document.dispatchEvent(event);
            },

            // Show toast notification (using your existing toast system)
            showToast: function(message, type = "success") {
                // Create toast element
                const container = document.getElementById("toast-container");
                const toast = document.createElement("div");
                toast.className = `toast-custom toast-${type}`;

                toast.innerHTML = `
                <div class="toast-message">
                    ${this.getToastIcon(type)}
                    <span>${message}</span>
                </div>
                <button class="close-btn" onclick="this.parentElement.remove()">×</button>
            `;

                container.appendChild(toast);

                // Show toast with animation
                setTimeout(() => toast.classList.add("show"), 50);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    toast.classList.remove("show");
                    setTimeout(() => {
                        if (toast.parentNode) {
                            toast.parentNode.removeChild(toast);
                        }
                    }, 400);
                }, 3000);
            },

            // Get icon for toast based on type
            getToastIcon: function(type) {
                switch (type) {
                    case "success":
                        return `<i class="icon-check-circle"></i>`;
                    case "error":
                        return `<i class="icon-times-circle"></i>`;
                    case "warning":
                        return `<i class="icon-exclamation-circle"></i>`;
                    default:
                        return `<i class="icon-info-circle"></i>`;
                }
            }
        };

        // Initialize CartManager when document is loaded
        document.addEventListener('DOMContentLoaded', function() {
            CartManager.init();

            // Flash message handler for server-side messages with navigation detection
            const showFlashMessages = () => {
                const navigationKey = 'flash_message_shown_' + Date.now();
                const lastShownKey = sessionStorage.getItem('last_flash_message_key');

                // Check if we're coming from browser navigation
                const isNavigationReload = performance.navigation.type === 2 || // Back/Forward
                                         (performance.navigation.type === 1 && document.referrer === window.location.href); // Refresh

                @if (session('success'))
                    const successMessage = "{{ session('success') }}";
                    const successKey = 'success_' + btoa(successMessage).slice(0, 10);

                    // Only show if not from navigation and not already shown
                    if (!isNavigationReload && lastShownKey !== successKey) {
                        CartManager.showToast(successMessage, "success");
                        sessionStorage.setItem('last_flash_message_key', successKey);
                    }
                @endif

                @if (session('error'))
                    const errorMessage = "{{ session('error') }}";
                    const errorKey = 'error_' + btoa(errorMessage).slice(0, 10);

                    // Only show if not from navigation and not already shown
                    if (!isNavigationReload && lastShownKey !== errorKey) {
                        CartManager.showToast(errorMessage, "error");
                        sessionStorage.setItem('last_flash_message_key', errorKey);
                    }
                @endif
            };

            // Show flash messages after a short delay to ensure proper detection
            setTimeout(showFlashMessages, 100);
        });

        // Add CSS for cart animations if not already present
        const style = document.createElement('style');
        style.textContent = `
        .cart-update-animation {
            animation: cartPulse 0.5s ease;
        }

        @keyframes cartPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        /* Prevent dropdown from closing when clicking inside */
        #cart-dropdown-menu {
            pointer-events: auto;
        }

        #cart-dropdown-menu * {
            pointer-events: auto;
        }
    `;
        document.head.appendChild(style);
    </script>


    </div>

</body>

</html>
