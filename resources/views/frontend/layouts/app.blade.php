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
        window.addEventListener('pageshow', event => {
            if (event.persisted) {
                window.location.reload();
            }
        });

        window.CartManager = {
            routes: {},
            csrfToken: '',

            init: function() {
                this.setupRoutes();
                this.initializeDropdownEvents();
                this.setupGlobalEventListeners();

                if (document.querySelector('.cart')) {
                    this.initializeCartPage();
                }

                if (document.querySelector('.checkout')) {
                    this.initializeCheckoutPage();
                }
            },

            setupRoutes: function() {
                this.routes = {
                    update: '{{ route('cart.update') }}',
                    remove: '{{ route('cart.remove') }}',
                    clear: '{{ route('cart.clear') }}',
                    dropdown: '{{ route('cart.dropdown') }}',
                    check: '{{ url('cart/check') }}' // Make sure this backend route exists
                };
                this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            },

            initializeDropdownEvents: function() {
                document.addEventListener('click', (e) => {
                    const btn = e.target.closest('.remove-item-dropdown');
                    if (btn) {
                        e.preventDefault();
                        const rowId = btn.dataset.rowid;
                        this.removeItem(rowId, true);
                    }
                });
            },

            setupGlobalEventListeners: function() {
                document.addEventListener('cartUpdated', (e) => {
                    this.updateHeaderCart(e.detail);

                    // If on details page, re-check product status
                    const addBtn = document.querySelector('#add-to-cart-btn');
                    if (addBtn && addBtn.dataset.productId) {
                        this.checkProductStatus(addBtn.dataset.productId);
                    }
                });
            },

            initializeCartPage: function() {
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

                document.querySelectorAll('.remove-item').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const rowId = e.target.closest('.remove-item').dataset.rowid;
                        this.removeItem(rowId);
                    });
                });

                document.querySelectorAll('.clear-cart').forEach(button => {
                    button.addEventListener('click', (e) => {
                        e.preventDefault();
                        this.clearCart();
                    });
                });

                document.querySelectorAll('input[name="shipping"]').forEach(input => {
                    input.addEventListener('change', () => {
                        this.updateTotals();
                    });
                });
            },

            initializeCheckoutPage: function() {
                this.initializeDiscountForm();
            },

            initializeDiscountForm: function() {
                const applyDiscountBtn = document.getElementById('apply-discount-btn');
                if (applyDiscountBtn) {
                    applyDiscountBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        this.applyDiscount();
                    });
                }

                const discountInput = document.getElementById('discount_code');
                if (discountInput) {
                    discountInput.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            this.applyDiscount();
                        }
                    });
                }

                const removeDiscountBtn = document.getElementById('remove-discount');
                if (removeDiscountBtn) {
                    removeDiscountBtn.addEventListener('click', () => {
                        this.removeDiscount();
                    });
                }
            },

            applyDiscount: function() {
                const discountCode = document.getElementById('discount_code').value.trim();
                if (!discountCode) {
                    this.showDiscountError('Please enter a discount code');
                    return;
                }

                fetch('{{ route('checkout.apply.discount') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken
                        },
                        body: JSON.stringify({
                            discount_code: discountCode
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.showDiscountSuccess(data.message);
                            this.displayAppliedDiscount(data.discount_name, data.discount_amount, data
                                .new_total);
                        } else {
                            this.showDiscountError(data.message);
                        }
                    })
                    .catch(() => {
                        this.showDiscountError('Error applying discount code');
                    });
            },

            removeDiscount: function() {
                fetch('{{ route('checkout.remove.discount') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.clearAppliedDiscount();
                            this.updateCheckoutTotal(data.new_total);
                            this.showToast('Discount removed', 'info');
                        }
                    })
                    .catch(() => {
                        this.showToast('Error removing discount', 'error');
                    });
            },

            displayAppliedDiscount: function(discountName, discountAmount, newTotal) {
                document.getElementById('applied-discount-name').textContent = discountName;
                document.getElementById('discount-amount').textContent = discountAmount;
                document.getElementById('discount-row').style.display = 'table-row';
                document.getElementById('discount_code').value = '';
                this.updateCheckoutTotal(newTotal);
            },

            clearAppliedDiscount: function() {
                document.getElementById('discount-row').style.display = 'none';
                document.getElementById('discount_code').value = '';
                this.hideDiscountMessages();

                fetch('{{ route('checkout.remove.discount') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken
                    }
                }).catch(() => {});
            },

            updateCheckoutTotal: function(newTotal) {
                const totalCell = document.querySelector('.summary-total td:last-child');
                if (totalCell) {
                    totalCell.textContent = '$' + newTotal;
                }
            },

            showDiscountError: function(message) {
                const errorDiv = document.getElementById('discount-error');
                const successDiv = document.getElementById('discount-success');
                errorDiv.textContent = message;
                errorDiv.style.display = 'flex';
                successDiv.style.display = 'none';
            },

            showDiscountSuccess: function(message) {
                const errorDiv = document.getElementById('discount-error');
                const successDiv = document.getElementById('discount-success');
                successDiv.textContent = message;
                successDiv.style.display = 'flex';
                errorDiv.style.display = 'none';
            },

            hideDiscountMessages: function() {
                document.getElementById('discount-error').style.display = 'none';
                document.getElementById('discount-success').style.display = 'none';
            },

            updateQuantity: function(rowId, quantity) {
                fetch(this.routes.update, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken
                        },
                        body: JSON.stringify({
                            rowId,
                            quantity
                        })
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            const itemTotal = document.querySelector(`#cart-item-${rowId} .item-total`);
                            if (itemTotal) itemTotal.textContent = res.itemTotal;
                            this.updateCartTotals(res.subTotal, res.total);
                            this.triggerCartUpdated(res);
                            this.showToast('Quantity updated successfully', 'success');
                        } else {
                            this.showToast(res.message, 'error');
                        }
                    })
                    .catch(() => this.showToast('Error updating quantity', 'error'));
            },

            removeItem: function(rowId, fromDropdown = false) {
                fetch(this.routes.remove, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken
                        },
                        body: JSON.stringify({
                            rowId
                        })
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            this.triggerCartUpdated(res);

                            const cartItem = document.querySelector(`#cart-item-${rowId}`);
                            if (cartItem) {
                                cartItem.remove();
                                this.updateCartTotals(res.subTotal, res.total);

                                if (res.itemsCount === 0) {
                                    document.querySelector('.cart').innerHTML = `
                                <div class="text-center py-5">
                                    <h4>Your cart is empty</h4>
                                    <a href="/" class="btn btn-primary mt-3">Continue Shopping</a>
                                </div>`;
                                }
                            }

                            // Update checkout page if we're on it
                            if (fromDropdown && document.querySelector('.checkout')) {
                                this.updateCheckoutOrderSummary(res);
                            }

                            // **NEW**: If on product details page, re-check button state
                            const addBtn = document.querySelector('#add-to-cart-btn');
                            if (fromDropdown && addBtn && addBtn.dataset.productId) {
                                this.checkProductStatus(addBtn.dataset.productId);
                            }

                            this.showToast('Item removed from cart', 'success');
                        } else {
                            this.showToast('Error removing item', 'error');
                        }
                    })
                    .catch(() => this.showToast('Error removing item', 'error'));
            },

            clearCart: function() {
                if (!confirm('Are you sure you want to clear your entire cart?')) return;

                fetch(this.routes.clear, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken
                        }
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            this.triggerCartUpdated(res);
                            location.reload();
                        } else {
                            this.showToast('Error clearing cart', 'error');
                        }
                    })
                    .catch(() => this.showToast('Error clearing cart', 'error'));
            },

            updateCartTotals: function(subTotal, total) {
                const sub = document.querySelector('#cart-subtotal');
                const tot = document.querySelector('#cart-total');
                if (sub) sub.textContent = '$' + subTotal;
                if (tot) tot.textContent = '$' + total;
            },

            updateTotals: function() {
                const selected = document.querySelector('input[name="shipping"]:checked');
                if (!selected) return;
                const shipCost = parseFloat(selected.parentElement.nextElementSibling.textContent.replace('$', ''));
                const sub = parseFloat(document.querySelector('#cart-subtotal').textContent.replace('$', ''));
                document.querySelector('#cart-total').textContent = '$' + (sub + shipCost).toFixed(2);
            },

            updateHeaderCart: function(res) {
                const cartCount = document.querySelector('#header-cart-count');
                if (cartCount) {
                    cartCount.textContent = res.itemsCount;
                    cartCount.classList.add('cart-update-animation');
                    setTimeout(() => cartCount.classList.remove('cart-update-animation'), 500);
                }
                const dropdown = document.querySelector('#cart-dropdown-menu');
                if (res.itemsCount === 0 && dropdown) {
                    dropdown.innerHTML = '<p class="text-center p-3">Your cart is empty</p>';
                } else {
                    this.refreshCartDropdown();
                }
            },

            refreshCartDropdown: function() {
                fetch(this.routes.dropdown)
                    .then(res => res.text())
                    .then(html => {
                        const dropdown = document.querySelector('#cart-dropdown-menu');
                        if (dropdown) dropdown.innerHTML = html;
                    })
                    .catch(err => console.error('Failed to refresh cart dropdown:', err));
            },

            updateCheckoutOrderSummary: function(res) {
                // If cart is empty, redirect to cart page
                if (res.itemsCount === 0) {
                    window.location.href = '/cart';
                    return;
                }

                // Clear discount when cart changes
                this.clearAppliedDiscount();
                // Update checkout order summary dynamically without page reload
                this.refreshCheckoutOrderSummary();
            },

            refreshCheckoutOrderSummary: function() {
                // Use the checkout summary route
                const checkoutSummaryRoute = '{{ route('checkout.summary') }}';

                fetch(checkoutSummaryRoute)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.updateCheckoutOrderTable(data.cartItems, data.subTotal, data.total);
                        }
                    })
                    .catch(err => {
                        console.error('Failed to refresh checkout order summary:', err);
                        // Fallback: show a toast message
                        this.showToast('Cart updated. Please refresh to see changes.', 'info');
                    });
            },

            updateCheckoutOrderTable: function(cartItems, subTotal, total) {
                const orderTableBody = document.querySelector('.table-summary tbody');
                if (!orderTableBody) return;

                // Clear existing product rows (keep subtotal, discount, shipping, total rows)
                const productRows = orderTableBody.querySelectorAll(
                    'tr:not(.summary-subtotal):not(.summary-total)');
                productRows.forEach(row => {
                    if (row.cells.length === 2 && !row.querySelector('.cart-discount') &&
                        !row.textContent.includes('Discount:') &&
                        !row.textContent.includes('Shipping:')) {
                        row.remove();
                    }
                });

                const subtotalRow = orderTableBody.querySelector('.summary-subtotal');

                // Add updated product rows with color & size
                cartItems.forEach(item => {
                    const productRow = document.createElement('tr');
                    let variantHtml = '';

                    if (item.color) {
                        variantHtml +=
                            `<span class="d-inline-block rounded-circle me-2 border" style="width:15px; height:15px; background:${item.color}"></span>`;
                        variantHtml +=
                            `<span style="font-size: 1.5rem;padding-left:0.5rem">${item.color}</span>`;
                    }

                    if (item.size) {
                        variantHtml +=
                            `<span style="padding-left: 1.5rem;font-size: 1.3rem">Size: <strong>${item.size}</strong></span>`;
                    }

                    productRow.innerHTML = `
            <td>
                <a href="#">${item.name}</a>
                <div class="d-flex align-items-center flex-wrap small text-muted mt-1">
                    ${variantHtml}
                </div>
                <div class="mb-1 mt-1">
                    <span class="fw-semibold">${item.quantity}</span> x
                    <span class="fw-semibold">$${parseFloat(item.price).toFixed(2)}</span>
                </div>
            </td>
            <td>$${parseFloat(item.price * item.quantity).toFixed(2)}</td>
        `;
                    orderTableBody.insertBefore(productRow, subtotalRow);
                });

                // Update subtotal
                const subtotalCell = subtotalRow.querySelector('td:last-child');
                if (subtotalCell) {
                    subtotalCell.textContent = `$${parseFloat(subTotal).toFixed(2)}`;
                }

                // Update total
                const totalRow = orderTableBody.querySelector('.summary-total td:last-child');
                if (totalRow) {
                    totalRow.textContent = `$${parseFloat(total).toFixed(2)}`;
                }
            },

            triggerCartUpdated: function(res) {
                document.dispatchEvent(new CustomEvent('cartUpdated', {
                    detail: res
                }));
            },

            checkProductStatus: function(productId) {
                fetch(`${this.routes.check}/${productId}`)
                    .then(res => res.json())
                    .then(data => {
                        const btn = document.querySelector('#add-to-cart-btn');
                        if (!btn) return;
                        if (data.in_cart) {
                            btn.disabled = true;
                            btn.textContent = 'Added';
                        } else {
                            btn.disabled = false;
                            btn.textContent = 'Add to Cart';
                        }
                    })
                    .catch(err => console.error('Check status failed', err));
            },

            showToast: function(message, type = "success") {
                const container = document.getElementById("toast-container");
                const toast = document.createElement("div");
                toast.className = `toast-custom toast-${type}`;
                toast.innerHTML = `
                <div class="toast-message">
                    ${this.getToastIcon(type)}
                    <span>${message}</span>
                </div>
                <button class="close-btn" onclick="this.parentElement.remove()">×</button>`;
                container.appendChild(toast);
                setTimeout(() => toast.classList.add("show"), 50);
                setTimeout(() => {
                    toast.classList.remove("show");
                    setTimeout(() => toast.remove(), 400);
                }, 3000);
            },

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

        document.addEventListener('DOMContentLoaded', () => CartManager.init());
    </script>





    </div>

</body>

</html>
