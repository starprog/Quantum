<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return redirect('/bpm');
})->name('home');

Route::get('/checkout', [StripeController::class, 'show'])->name('checkout.show');
Route::post('/checkout/session', [StripeController::class, 'createCheckoutSession'])->name('checkout.session');
Route::get('/checkout/success', [StripeController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [StripeController::class, 'cancel'])->name('checkout.cancel');

// Public route for hello module demo
Route::get('/hello', function () {
    return view('hello::index');
})->name('hello');

// BPM player demo
Route::get('/bpm', function () {
    return view('bpm');
})->name('bpm');

// Audio proxy for direct audio file URLs (used to bypass CORS for analysis)
use App\Http\Controllers\AudioProxyController;
Route::get('/proxy/audio', [AudioProxyController::class, 'stream'])->name('proxy.audio');
use App\Http\Controllers\CoverController;
Route::post('/cover/upload', [CoverController::class, 'upload'])->name('cover.upload');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/services', [HomeController::class, 'services'])->name('services');
    Route::get('/settings', [HomeController::class, 'settings'])->name('settings');

    // Module management routes (Admin)
    Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
    Route::patch('/modules/{module}/toggle', [ModuleController::class, 'toggle'])->name('modules.toggle');
    Route::post('/modules/scan', [ModuleController::class, 'scan'])->name('modules.scan');
    Route::post('/modules/upload', [ModuleController::class, 'upload'])->name('modules.upload');
});
