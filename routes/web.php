<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimeEntryController;

Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
    Route::post('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

    Route::get('/time-tracker', [TimeEntryController::class, 'index'])->name('time-tracker.index');
    Route::post('/time-tracker/clock-in', [TimeEntryController::class, 'clockIn'])->name('time-tracker.clock-in');
    Route::post('/time-tracker/clock-out', [TimeEntryController::class, 'clockOut'])->name('time-tracker.clock-out');
    Route::post('/toggle-theme', [ProfileController::class, 'toggleTheme'])->name('toggle-theme');
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
