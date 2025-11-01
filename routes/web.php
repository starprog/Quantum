<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BibleVerseController;
use App\Http\Controllers\FavoriteVerseController;
use App\Http\Controllers\ChurchFinderController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// Bible verse routes
Route::get('/bible-verse', function () {
    return view('bible-verse.verse');
})->name('bible-verse');

// Embeddable widget version (minimal UI, no auth)
Route::get('/bible-verse/embed', function () {
    return view('bible-verse.embed');
})->name('bible-verse.embed');

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