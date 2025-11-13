<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AllCollectionController;
use App\Http\Controllers\AboutController;
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/home', function () {
//     return view('home');
// })->name('home');

Route::get('/', [HomeController::class, 'index'])->name('home');

// Public product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Contact & Inquiry
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/states/{countryId}', [ChatController::class, 'getStates'])->name('states.get');
Route::get('/cities/{stateId}', [ChatController::class, 'getCities'])->name('cities.get');
Route::post('/inquiries/store', [InquiryController::class, 'store'])->name('inquiries.store');

Route::get('/inquiry/user-check', [InquiryController::class, 'checkUser'])->name('inquiry.userCheck');

Route::post('/chat/send', [ChatController::class, 'sendChat'])->name('send.chat');

Route::get('/allcollection', [AllCollectionController::class, 'index'])->name('allcollection');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/allcollection/{category?}', [AllCollectionController::class, 'index'])->name('allcollection');

Route::post('/subscribe', [HomeController::class, 'subscribe'])->name('subscribe');
