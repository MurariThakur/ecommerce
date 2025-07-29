<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout-all-devices', [AuthController::class, 'logoutFromAllDevices'])->name('logout.all.devices');
Route::get('/check-auth', [AuthController::class, 'checkAuth'])->name('auth.check');
Route::get('/session-timeout', [AuthController::class, 'sessionTimeout'])->name('session.timeout');

// Protected Routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    // Add other protected routes here
});

// Redirect root to login
Route::get('/', function () {
    return redirect('/admin/login');
});
