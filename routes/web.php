<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BibleVerseController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Bible verse routes
Route::get('/bible-verse', function () {
    return view('vendor.bible-verse.verse');
})->name('bible-verse');

Route::get('/verse-of-the-day', [BibleVerseController::class, 'verseOfTheDay'])->name('verse-of-the-day');

Route::get('/daily-verse', [BibleVerseController::class, 'verseOfTheDay'])->name('daily-verse');

// Modules routes
Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
Route::get('/modules/{module}', [ModuleController::class, 'show'])->name('modules.show');

// Stripe routes
Route::get('/checkout/{module}', [StripeController::class, 'checkout'])->name('checkout');
Route::get('/checkout/success', [StripeController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [StripeController::class, 'cancel'])->name('checkout.cancel');