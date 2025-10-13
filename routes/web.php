<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BibleVerseController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// Bible verse routes
Route::get('/bible-verse', function () {
    return view('vendor.bible-verse.verse');
})->name('bible-verse');

// Other routes
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/settings', [HomeController::class, 'settings'])->name('settings');

// Modules routes
Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
Route::get('/modules/{module}', [ModuleController::class, 'show'])->name('modules.show');

// Stripe routes
Route::get('/checkout/{module}', [StripeController::class, 'checkout'])->name('checkout');
Route::get('/checkout/success', [StripeController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [StripeController::class, 'cancel'])->name('checkout.cancel');