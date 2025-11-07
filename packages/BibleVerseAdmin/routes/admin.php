<?php

use Illuminate\Support\Facades\Route;
use Starprog\BibleVerseAdmin\Http\Controllers\DashboardController;
use Starprog\BibleVerseAdmin\Http\Controllers\VerseController;
use Starprog\BibleVerseAdmin\Http\Controllers\VerseCategoryController;

Route::middleware(config('bible-verse-admin.middleware'))
    ->prefix(config('bible-verse-admin.route_prefix'))
    ->name('admin.')
    ->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Verses Management
        Route::get('/verses', [VerseController::class, 'index'])->name('verses.index');
        Route::get('/verses/create', [VerseController::class, 'create'])->name('verses.create');
        Route::post('/verses', [VerseController::class, 'store'])->name('verses.store');
        Route::get('/verses/{verse}/edit', [VerseController::class, 'edit'])->name('verses.edit');
        Route::put('/verses/{verse}', [VerseController::class, 'update'])->name('verses.update');
        Route::delete('/verses/{verse}', [VerseController::class, 'destroy'])->name('verses.destroy');
        Route::patch('/verses/{verse}/toggle-featured', [VerseController::class, 'toggleFeatured'])->name('verses.toggle-featured');
        
        // Bulk Import
        Route::get('/verses/import', [VerseController::class, 'importForm'])->name('verses.import');
        Route::post('/verses/import', [VerseController::class, 'import'])->name('verses.import.process');

        // Categories Management
        Route::get('/categories', [VerseCategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [VerseCategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [VerseCategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [VerseCategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [VerseCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [VerseCategoryController::class, 'destroy'])->name('categories.destroy');
    });
