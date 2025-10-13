<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BibleVerseController;

// Public Bible verse routes
Route::get('/verses', [BibleVerseController::class, 'index'])->name('verses.index');
Route::get('/verses/random', [BibleVerseController::class, 'random'])->name('verses.random');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

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
