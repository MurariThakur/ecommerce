<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;

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
    Route::get('/admin/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/admin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::post('/admin/admin/toggle-status/{id}', [AdminController::class, 'toggleStatus'])->name('admin.toggle.status');
});

// Redirect root to login
Route::get('/', function () {
    return redirect('/admin/login');
});


