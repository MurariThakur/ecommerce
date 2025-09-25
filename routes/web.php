<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\RefundController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Frontend\AuthController as FrontendAuthController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\ContactController as FrontendContactController;
use App\Http\Controllers\WebhookController;

// Admin Authentication Routes
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::post('/logout-all-devices', [AuthController::class, 'logoutFromAllDevices'])->name('logout.all.devices');
Route::get('/check-auth', [AuthController::class, 'checkAuth'])->name('auth.check');
Route::get('/session-timeout', [AuthController::class, 'sessionTimeout'])->name('session.timeout');

// Protected Routes (require authentication)
Route::middleware(['auth:admin', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

    // Admin management routes
    Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/admin/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/admin/view/{id}', [AdminController::class, 'show'])->name('admin.show');
    Route::get('/admin/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/admin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::post('/admin/admin/toggle-status/{id}', [AdminController::class, 'toggleStatus'])->name('admin.toggle.status');

    // Category management routes
    Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.category.index');
    Route::get('/admin/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/admin/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/admin/category/view/{category}', [CategoryController::class, 'show'])->name('admin.category.show');
    Route::get('/admin/category/edit/{category}', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('/admin/category/update/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('/admin/category/delete/{category}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    Route::post('/admin/category/toggle-status/{category}', [CategoryController::class, 'toggleStatus'])->name('admin.category.toggle.status');

    // Subcategory management routes
    Route::get('/admin/subcategory', [SubcategoryController::class, 'index'])->name('admin.subcategory.index');
    Route::get('/admin/subcategory/create', [SubcategoryController::class, 'create'])->name('admin.subcategory.create');
    Route::post('/admin/subcategory/store', [SubcategoryController::class, 'store'])->name('admin.subcategory.store');
    Route::get('/admin/subcategory/view/{subcategory}', [SubcategoryController::class, 'show'])->name('admin.subcategory.show');
    Route::get('/admin/subcategory/edit/{subcategory}', [SubcategoryController::class, 'edit'])->name('admin.subcategory.edit');
    Route::put('/admin/subcategory/update/{subcategory}', [SubcategoryController::class, 'update'])->name('admin.subcategory.update');
    Route::delete('/admin/subcategory/delete/{subcategory}', [SubcategoryController::class, 'destroy'])->name('admin.subcategory.destroy');
    Route::post('/admin/subcategory/toggle-status/{subcategory}', [SubcategoryController::class, 'toggleStatus'])->name('admin.subcategory.toggle.status');

    // Discount management routes
    Route::get('/admin/discount', [DiscountController::class, 'index'])->name('admin.discount.index');
    Route::get('/admin/discount/create', [DiscountController::class, 'create'])->name('admin.discount.create');
    Route::post('/admin/discount/store', [DiscountController::class, 'store'])->name('admin.discount.store');
    Route::get('/admin/discount/view/{discount}', [DiscountController::class, 'show'])->name('admin.discount.show');
    Route::get('/admin/discount/edit/{discount}', [DiscountController::class, 'edit'])->name('admin.discount.edit');
    Route::put('/admin/discount/update/{discount}', [DiscountController::class, 'update'])->name('admin.discount.update');
    Route::delete('/admin/discount/delete/{discount}', [DiscountController::class, 'destroy'])->name('admin.discount.destroy');
    Route::post('/admin/discount/toggle-status/{discount}', [DiscountController::class, 'toggleStatus'])->name('admin.discount.toggle.status');

    // Shipping management routes
    Route::get('/admin/shipping', [ShippingController::class, 'index'])->name('admin.shipping.index');
    Route::get('/admin/shipping/create', [ShippingController::class, 'create'])->name('admin.shipping.create');
    Route::post('/admin/shipping/store', [ShippingController::class, 'store'])->name('admin.shipping.store');
    Route::get('/admin/shipping/view/{shipping}', [ShippingController::class, 'show'])->name('admin.shipping.show');
    Route::get('/admin/shipping/edit/{shipping}', [ShippingController::class, 'edit'])->name('admin.shipping.edit');
    Route::put('/admin/shipping/update/{shipping}', [ShippingController::class, 'update'])->name('admin.shipping.update');
    Route::delete('/admin/shipping/delete/{shipping}', [ShippingController::class, 'destroy'])->name('admin.shipping.destroy');
    Route::post('/admin/shipping/toggle-status/{shipping}', [ShippingController::class, 'toggleStatus'])->name('admin.shipping.toggle.status');

    // Settings management routes
    Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/admin/settings', [SettingController::class, 'update'])->name('admin.settings.update');

    // Contact management routes
    Route::get('/admin/contact', [ContactController::class, 'index'])->name('admin.contact.index');
    Route::get('/admin/contact/{contact}', [ContactController::class, 'show'])->name('admin.contact.show');
    Route::delete('/admin/contact/{contact}', [ContactController::class, 'destroy'])->name('admin.contact.destroy');
    Route::post('/admin/contact/{contact}/toggle-status', [ContactController::class, 'toggleStatus'])->name('admin.contact.toggle.status');

    // Order management routes
    Route::get('/admin/order', [OrderController::class, 'index'])->name('admin.order.index');
    Route::get('/admin/order/view/{order}', [OrderController::class, 'show'])->name('admin.order.show');
    Route::put('/admin/order/update/{order}', [OrderController::class, 'update'])->name('admin.order.update');
    Route::delete('/admin/order/delete/{order}', [OrderController::class, 'destroy'])->name('admin.order.destroy');
    Route::post('/admin/order/toggle-payment/{order}', [OrderController::class, 'togglePaymentStatus'])->name('admin.order.toggle.payment');

    // Customer management routes
    Route::get('/admin/customer', [CustomerController::class, 'index'])->name('admin.customer.index');
    Route::get('/admin/customer/view/{customer}', [CustomerController::class, 'show'])->name('admin.customer.show');
    Route::delete('/admin/customer/delete/{customer}', [CustomerController::class, 'destroy'])->name('admin.customer.destroy');
    Route::post('/admin/customer/toggle-status/{customer}', [CustomerController::class, 'toggleStatus'])->name('admin.customer.toggle.status');

    // Refund management routes
    Route::get('/admin/refunds', [RefundController::class, 'index'])->name('admin.refunds.index');
    Route::get('/admin/refund/view/{refund}', [RefundController::class, 'show'])->name('admin.refunds.show');
    Route::post('/admin/refund/approve/{refund}', [RefundController::class, 'approve'])->name('admin.refunds.approve');
    Route::post('/admin/refund/process/{refund}', [RefundController::class, 'process'])->name('admin.refunds.process');
    Route::post('/admin/refund/reject/{refund}', [RefundController::class, 'reject'])->name('admin.refunds.reject');

    // Slider management routes
    Route::get('/admin/sliders', [SliderController::class, 'index'])->name('admin.sliders.index');
    Route::get('/admin/sliders/create', [SliderController::class, 'create'])->name('admin.sliders.create');
    Route::post('/admin/sliders/store', [SliderController::class, 'store'])->name('admin.sliders.store');
    Route::get('/admin/sliders/view/{slider}', [SliderController::class, 'show'])->name('admin.sliders.show');
    Route::get('/admin/sliders/edit/{slider}', [SliderController::class, 'edit'])->name('admin.sliders.edit');
    Route::put('/admin/sliders/update/{slider}', [SliderController::class, 'update'])->name('admin.sliders.update');
    Route::delete('/admin/sliders/delete/{slider}', [SliderController::class, 'destroy'])->name('admin.sliders.destroy');
    Route::post('/admin/sliders/toggle-status/{slider}', [SliderController::class, 'toggleStatus'])->name('admin.sliders.toggle.status');

    // Partner management routes
    Route::get('/admin/partners', [PartnerController::class, 'index'])->name('admin.partners.index');
    Route::get('/admin/partners/create', [PartnerController::class, 'create'])->name('admin.partners.create');
    Route::post('/admin/partners/store', [PartnerController::class, 'store'])->name('admin.partners.store');
    Route::get('/admin/partners/view/{partner}', [PartnerController::class, 'show'])->name('admin.partners.show');
    Route::get('/admin/partners/edit/{partner}', [PartnerController::class, 'edit'])->name('admin.partners.edit');
    Route::put('/admin/partners/update/{partner}', [PartnerController::class, 'update'])->name('admin.partners.update');
    Route::delete('/admin/partners/delete/{partner}', [PartnerController::class, 'destroy'])->name('admin.partners.destroy');
    Route::post('/admin/partners/toggle-status/{partner}', [PartnerController::class, 'toggleStatus'])->name('admin.partners.toggle.status');

    // Brand management routes
    Route::get('/admin/brand', [BrandController::class, 'index'])->name('admin.brand.index');
    Route::get('/admin/brand/create', [BrandController::class, 'create'])->name('admin.brand.create');
    Route::post('/admin/brand/store', [BrandController::class, 'store'])->name('admin.brand.store');
    Route::get('/admin/brand/view/{brand}', [BrandController::class, 'show'])->name('admin.brand.show');
    Route::get('/admin/brand/edit/{brand}', [BrandController::class, 'edit'])->name('admin.brand.edit');
    Route::put('/admin/brand/update/{brand}', [BrandController::class, 'update'])->name('admin.brand.update');
    Route::delete('/admin/brand/delete/{brand}', [BrandController::class, 'destroy'])->name('admin.brand.destroy');
    Route::post('/admin/brand/toggle-status/{brand}', [BrandController::class, 'toggleStatus'])->name('admin.brand.toggle.status');

    // Color management routes
    Route::get('/admin/color', [ColorController::class, 'index'])->name('admin.color.index');
    Route::get('/admin/color/create', [ColorController::class, 'create'])->name('admin.color.create');
    Route::post('/admin/color/store', [ColorController::class, 'store'])->name('admin.color.store');
    Route::get('/admin/color/view/{color}', [ColorController::class, 'show'])->name('admin.color.show');
    Route::get('/admin/color/edit/{color}', [ColorController::class, 'edit'])->name('admin.color.edit');
    Route::put('/admin/color/update/{color}', [ColorController::class, 'update'])->name('admin.color.update');
    Route::delete('/admin/color/delete/{color}', [ColorController::class, 'destroy'])->name('admin.color.destroy');
    Route::post('/admin/color/toggle-status/{color}', [ColorController::class, 'toggleStatus'])->name('admin.color.toggle.status');

    // Product management routes
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.product.index');
    Route::get('/admin/product/create', [ProductController::class, 'create'])->name('admin.product.create');
    Route::post('/admin/product/store', [ProductController::class, 'store'])->name('admin.product.store');
    Route::get('/admin/product/view/{product}', [ProductController::class, 'show'])->name('admin.product.show');
    Route::get('/admin/product/edit/{product}', [ProductController::class, 'edit'])->name('admin.product.edit');
    Route::put('/admin/product/update/{product}', [ProductController::class, 'update'])->name('admin.product.update');
    Route::delete('/admin/product/delete/{product}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
    Route::post('/admin/product/toggle-status/{product}', [ProductController::class, 'toggleStatus'])->name('admin.product.toggle.status');
    Route::get('/admin/product/subcategories', [ProductController::class, 'getSubcategories'])->name('admin.product.subcategories');

    // Blog Category management routes
    Route::get('/admin/blog-category', [BlogCategoryController::class, 'index'])->name('admin.blog-category.index');
    Route::get('/admin/blog-category/create', [BlogCategoryController::class, 'create'])->name('admin.blog-category.create');
    Route::post('/admin/blog-category/store', [BlogCategoryController::class, 'store'])->name('admin.blog-category.store');
    Route::get('/admin/blog-category/view/{blog_category}', [BlogCategoryController::class, 'show'])->name('admin.blog-category.show');
    Route::get('/admin/blog-category/edit/{blog_category}', [BlogCategoryController::class, 'edit'])->name('admin.blog-category.edit');
    Route::put('/admin/blog-category/update/{blog_category}', [BlogCategoryController::class, 'update'])->name('admin.blog-category.update');
    Route::delete('/admin/blog-category/delete/{blog_category}', [BlogCategoryController::class, 'destroy'])->name('admin.blog-category.destroy');
    Route::post('/admin/blog-category/toggle-status/{blog_category}', [BlogCategoryController::class, 'toggleStatus'])->name('admin.blog-category.toggle.status');

    // Blog management routes
    Route::get('/admin/blog', [BlogController::class, 'index'])->name('admin.blog.index');
    Route::get('/admin/blog/create', [BlogController::class, 'create'])->name('admin.blog.create');
    Route::post('/admin/blog/store', [BlogController::class, 'store'])->name('admin.blog.store');
    Route::get('/admin/blog/view/{blog}', [BlogController::class, 'show'])->name('admin.blog.show');
    Route::get('/admin/blog/edit/{blog}', [BlogController::class, 'edit'])->name('admin.blog.edit');
    Route::put('/admin/blog/update/{blog}', [BlogController::class, 'update'])->name('admin.blog.update');
    Route::delete('/admin/blog/delete/{blog}', [BlogController::class, 'destroy'])->name('admin.blog.destroy');
    Route::post('/admin/blog/toggle-status/{blog}', [BlogController::class, 'toggleStatus'])->name('admin.blog.toggle.status');

    // Notification routes
    Route::get('admin/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::post('admin/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.read');
    Route::post('admin/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('admin.notifications.mark-all-read');
    Route::get('admin/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('admin.notifications.unread-count');
    Route::get('admin/notifications/recent', [NotificationController::class, 'getRecent'])->name('admin.notifications.recent');

});

Route::post('/cart/add', [PaymentController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [PaymentController::class, 'cart'])->name('cart.index');
Route::post('/cart/update', [PaymentController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [PaymentController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [PaymentController::class, 'clearCart'])->name('cart.clear');
Route::post('/cart/check', [PaymentController::class, 'checkCart'])->name('cart.check');
Route::get('/cart/dropdown', [PaymentController::class, 'getCartDropdown'])->name('cart.dropdown');

// Checkout Routes
Route::get('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
Route::get('/checkout/summary', [PaymentController::class, 'getCheckoutSummary'])->name('checkout.summary');
Route::post('/checkout/apply-discount', [PaymentController::class, 'applyDiscount'])->name('checkout.apply.discount');
Route::post('/checkout/remove-discount', [PaymentController::class, 'removeDiscount'])->name('checkout.remove.discount');
Route::post('/checkout/process', [PaymentController::class, 'processCheckout'])->name('checkout.process');
Route::post('/order/place', [PaymentController::class, 'placeOrder'])->name('order.place');
Route::get('/paypal/success/{order}', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
Route::get('/paypal/cancel/{order}', [PaymentController::class, 'paypalCancel'])->name('paypal.cancel');
Route::get('/stripe/success/{order}', [PaymentController::class, 'stripeSuccess'])->name('stripe.success');
Route::get('/stripe/cancel/{order}', [PaymentController::class, 'stripeCancel'])->name('stripe.cancel');

// Auth Routes
Route::post('/register', [FrontendAuthController::class, 'register'])->name('auth.register');
Route::post('/login', [FrontendAuthController::class, 'login'])->name('auth.login');
Route::post('/frontendlogout', [FrontendAuthController::class, 'frontendlogout'])->name('frontend.auth.logout');
Route::get('/forgot-password', [FrontendAuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [FrontendAuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{email}/{token}', [FrontendAuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [FrontendAuthController::class, 'resetPassword'])->name('password.update');
Route::get('/email/verify/{id}/{hash}', [FrontendAuthController::class, 'verify'])->name('verification.verify');

// Wishlist Routes (AJAX)
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::get('/wishlist/count', [WishlistController::class, 'getCount'])->name('wishlist.count');

// Review Routes
Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');

Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/blog', [HomeController::class, 'blog'])->name('frontend.blog');
Route::get('/blog/{slug}', [HomeController::class, 'blogDetail'])->name('frontend.blog.detail');
Route::post('/blog/{slug}/comment', [HomeController::class, 'storeComment'])->name('frontend.blog.comment')->middleware('user');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [FrontendContactController::class, 'store'])->name('contact.store');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/payment-methods', [HomeController::class, 'paymentMethods'])->name('payment.methods');
Route::get('/returns', [HomeController::class, 'returns'])->name('returns');
Route::get('/shipping', [HomeController::class, 'shipping'])->name('shipping');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');

// User Dashboard Routes (require authentication)
Route::middleware(['user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [UserDashboardController::class, 'orders'])->name('orders');
    Route::get('/order/{id}', [UserDashboardController::class, 'orderDetails'])->name('order.details');
    Route::get('/profile', [UserDashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [UserDashboardController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password', [UserDashboardController::class, 'updatePassword'])->name('change-password.update');
    Route::post('/order/{id}/cancel', [UserDashboardController::class, 'cancelOrder'])->name('order.cancel');
    Route::post('/order/{id}/return', [UserDashboardController::class, 'returnOrder'])->name('order.return');
});

// Frontend Routes (no authentication required)
Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::get('/search', [FrontendProductController::class, 'search'])->name('frontend.search');
Route::get('{slug?}/{subslug?}', [FrontendProductController::class, 'getCategory']);
Route::get('{category_slug}/{subcategory_slug}/{product_slug}', [FrontendProductController::class, 'getProductDetails'])->name('product.details');


Route::post('/stripe/webhook', [WebhookController::class, 'stripeWebhook'])->name('stripe.webhook');
Route::post('/paypal/webhook', [WebhookController::class, 'paypalWebhook'])->name('paypal.webhook');