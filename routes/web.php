<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\ProductController;
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

// Redirect root to login
Route::get('/', function () {
    return redirect('/admin/login');
});


