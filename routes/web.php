<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimeEntryController;
use App\Models\Category;

// Routes that require authentication
Route::middleware(['auth'])->group(function () {
    // Task routes
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
    Route::post('/tasks/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');
    Route::post('/tasks/move', [TaskController::class, 'move'])->name('tasks.move');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
    Route::post('/toggle-theme', [ProfileController::class, 'toggleTheme'])->name('toggle-theme');

    // Time Tracker routes
    Route::get('/time-tracker', [TimeEntryController::class, 'index'])->name('time-tracker.index');
    Route::post('/time-tracker/clock-in', [TimeEntryController::class, 'clockIn'])->name('time-tracker.clock-in');
    Route::post('/time-tracker/clock-out', [TimeEntryController::class, 'clockOut'])->name('time-tracker.clock-out');

    // Sprint Manager page route
    Route::get('/sprints', function () {
        $user = auth()->user();

        // Check if user has any categories; if not, create defaults
        if ($user->categories()->count() === 0) {
            $defaults = ['To Do', 'In Progress', 'Done'];
            foreach ($defaults as $i => $name) {
                Category::create([
                    'user_id' => $user->id,
                    'name' => $name,
                    'order' => $i,
                ]);
            }
        }

        // Fetch all categories for the user, ordered by 'order'
        $categories = $user->categories()->orderBy('order')->get();

        // Fetch incomplete tasks for "To Do" column
        $todoTasks = $user->tasks()->where('completed', false)->get();

        return view('sprints.index', compact('categories', 'todoTasks'));
    })->name('sprints.index');
});

// Public home page route
Route::get('/', function () {
    return view('home');
})->name('home');

// Dashboard route, requires authentication and verification
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
