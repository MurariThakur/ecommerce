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
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\PaymentController;

// Authentication Routes
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout-all-devices', [AuthController::class, 'logoutFromAllDevices'])->name('logout.all.devices');
Route::get('/check-auth', [AuthController::class, 'checkAuth'])->name('auth.check');
Route::get('/session-timeout', [AuthController::class, 'sessionTimeout'])->name('session.timeout');

// Protected Routes (require authentication)
Route::middleware(['auth', 'admin'])->group(function () {
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
    Route::put('/admin/settings', [SettingController::class, 'update'])->name('admin.settings.update');

    // Brand management routes
    Route::resource('admin/brand', BrandController::class)->names([
        'index' => 'admin.brand.index',
        'create' => 'admin.brand.create',
        'store' => 'admin.brand.store',
        'show' => 'admin.brand.show',
        'edit' => 'admin.brand.edit',
        'update' => 'admin.brand.update',
        'destroy' => 'admin.brand.destroy',
    ]);
    Route::post('admin/brand/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])->name('admin.brand.toggle.status');

    // Color management routes
    Route::resource('admin/color', ColorController::class)->names([
        'index' => 'admin.color.index',
        'create' => 'admin.color.create',
        'store' => 'admin.color.store',
        'show' => 'admin.color.show',
        'edit' => 'admin.color.edit',
        'update' => 'admin.color.update',
        'destroy' => 'admin.color.destroy',
    ]);
    Route::post('admin/color/{color}/toggle-status', [ColorController::class, 'toggleStatus'])->name('admin.color.toggle.status');

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
Route::post('/register', [\App\Http\Controllers\Frontend\AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [\App\Http\Controllers\Frontend\AuthController::class, 'login'])->name(name: 'auth.login');
Route::post('/frontendlogout', [\App\Http\Controllers\Frontend\AuthController::class, 'frontendlogout'])->name('frontend.auth.logout');
Route::get('/forgot-password', [\App\Http\Controllers\Frontend\AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [\App\Http\Controllers\Frontend\AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{email}/{token}', [\App\Http\Controllers\Frontend\AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [\App\Http\Controllers\Frontend\AuthController::class, 'resetPassword'])->name('password.update');
Route::get('/email/verify/{id}/{hash}', [\App\Http\Controllers\Frontend\AuthController::class, 'verify'])->name('verification.verify');


// Frontend Routes (no authentication required)
Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::get('/search', [FrontendProductController::class, 'search'])->name('frontend.search');
Route::get('{slug?}/{subslug?}', [FrontendProductController::class, 'getCategory']);
Route::get('{category_slug}/{subcategory_slug}/{product_slug}', [FrontendProductController::class, 'getProductDetails'])->name('product.details');


