<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

// Guest routes (only when not logged in as admin)
Route::middleware('admin.guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
});

// Authenticated admin routes
Route::middleware('admin.auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Route::get('/dashboard1', [DashboardController::class, 'index'])->name('admin.main');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class, ['as' => 'admin']);
    Route::resource('inquiries', \App\Http\Controllers\Admin\InquiryController::class, ['as' => 'admin']);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class, ['as' => 'admin']);

    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});
