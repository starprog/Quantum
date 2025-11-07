<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BibleVerseController;
use App\Http\Controllers\FavoriteVerseController;
use App\Http\Controllers\ChurchFinderController;
use App\Http\Controllers\Admin\VerseController as AdminVerseController;
use App\Http\Controllers\Admin\VerseCategoryController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// Bible verse routes - Using minimal embeddable widget
Route::get('/bible-verse', function () {
    return view('bible-verse.embed');
})->name('bible-verse');

// Also available at /embed for iframe usage
Route::get('/bible-verse/embed', function () {
    return view('bible-verse.embed');
})->name('bible-verse.embed');

// Demo page with documentation
Route::get('/bible-verse/demo', function () {
    return view('bible-verse.demo');
})->name('bible-verse.demo');

Route::get('/daily-verse', function () {
    $bibleVerseService = app(\App\Services\BibleVerseService::class);
    $verseOfTheDay = $bibleVerseService->getVerseOfTheDay();
    return view('daily-verse', ['verseOfTheDay' => $verseOfTheDay]);
})->name('daily-verse');

// Favorite verses routes (protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/favorites', [FavoriteVerseController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle/{verse}', [FavoriteVerseController::class, 'toggle'])->name('favorites.toggle');
});

// Other routes
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/settings', [HomeController::class, 'settings'])->name('settings');

// Church Finder routes
Route::get('/church-finder', [ChurchFinderController::class, 'index'])->name('church-finder');
Route::post('/church-finder/search', [ChurchFinderController::class, 'search'])->name('church-finder.search');
Route::get('/church-finder/details/{placeId}', [ChurchFinderController::class, 'details'])->name('church-finder.details');
Route::middleware(['auth'])->group(function () {
    Route::post('/church-finder/favorite', [ChurchFinderController::class, 'toggleFavorite'])->name('church-finder.favorite');
    Route::get('/church-finder/favorites', [ChurchFinderController::class, 'favorites'])->name('church-finder.favorites');
});

// Admin routes (protected by admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $versesCount = \App\Models\Verse::count();
        $categoriesCount = \App\Models\VerseCategory::count();
        $featuredCount = \App\Models\Verse::where('is_featured', true)->count();
        
        return view('admin.dashboard', compact('versesCount', 'categoriesCount', 'featuredCount'));
    })->name('dashboard');

    // Verses Management
    Route::get('/verses', [AdminVerseController::class, 'index'])->name('verses.index');
    Route::get('/verses/create', [AdminVerseController::class, 'create'])->name('verses.create');
    Route::post('/verses', [AdminVerseController::class, 'store'])->name('verses.store');
    Route::get('/verses/{verse}/edit', [AdminVerseController::class, 'edit'])->name('verses.edit');
    Route::put('/verses/{verse}', [AdminVerseController::class, 'update'])->name('verses.update');
    Route::delete('/verses/{verse}', [AdminVerseController::class, 'destroy'])->name('verses.destroy');
    Route::patch('/verses/{verse}/toggle-featured', [AdminVerseController::class, 'toggleFeatured'])->name('verses.toggle-featured');
    
    // Bulk Import
    Route::get('/verses/import', [AdminVerseController::class, 'importForm'])->name('verses.import');
    Route::post('/verses/import', [AdminVerseController::class, 'import'])->name('verses.import.process');

    // Categories Management
    Route::get('/categories', [VerseCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [VerseCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [VerseCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [VerseCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [VerseCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [VerseCategoryController::class, 'destroy'])->name('categories.destroy');
});