<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

// Guest routes (only when not logged in as admin)
Route::middleware('admin.guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
});

// Authenticated admin routes
Route::middleware('admin.auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Route::get('/dashboard1', [DashboardController::class, 'index'])->name('admin.main');
    Route::post('/products/toggle-status', [\App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])->name('admin.products.toggle-status');
    Route::post('/products/bulk-status', [\App\Http\Controllers\Admin\ProductController::class, 'bulkUpdateStatus'])->name('admin.products.bulk-status');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class, ['as' => 'admin']);

    // Product Import Routes
    Route::post('/products/import', [\App\Http\Controllers\Admin\ProductController::class, 'import'])->name('admin.products.import');
    Route::get('/products/import-progress', [\App\Http\Controllers\Admin\ProductController::class, 'importProgress'])->name('admin.products.import.progress');
    Route::post('/products/cancel-import', [\App\Http\Controllers\Admin\ProductController::class, 'cancelImport'])->name('admin.products.cancel.import');

    Route::get('/admin/products/import-format', [\App\Http\Controllers\Admin\ProductController::class, 'downloadImportFormat'])->name('admin.products.import.format');

    Route::resource('inquiries', \App\Http\Controllers\Admin\InquiryController::class, ['as' => 'admin']);

    Route::get('/inquiries-export', [\App\Http\Controllers\Admin\InquiryController::class, 'export'])->name('admin.inquiries.export');

    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class, ['as' => 'admin']);
    Route::resource('subcategories', \App\Http\Controllers\Admin\SubCategoryController::class, ['as' => 'admin']);
    Route::get('/get-subcategories/{categoryId}', [\App\Http\Controllers\Admin\ProductController::class, 'getSubcategories']);

    Route::get('/newsletters', [NewsletterController::class, 'index'])->name('admin.newsletters.index');
    Route::get('/newsletters/{id}', [NewsletterController::class, 'show'])->name('admin.newsletters.show');
    Route::delete('/newsletters/{id}', [NewsletterController::class, 'destroy'])->name('admin.newsletters.destroy');
    Route::get('newsletters-export', [NewsletterController::class, 'export'])->name('admin.newsletters.export');

    Route::get('/settings', [SettingController::class, 'manage'])->name('admin.settings.manage');
    Route::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');

    // Admin About manage routes
    Route::get('/about', [\App\Http\Controllers\Admin\AboutController::class, 'manage'])->name('admin.about.manage');
    Route::post('/about', [\App\Http\Controllers\Admin\AboutController::class, 'update'])->name('admin.about.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});
