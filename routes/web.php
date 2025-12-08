<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\GrowthRecordController;
use App\Http\Controllers\DevelopmentLogController;
use App\Http\Controllers\CaregiverController;
use App\Http\Controllers\ActivityController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/checkout', [StripeController::class, 'show'])->name('checkout.show');
Route::post('/checkout/session', [StripeController::class, 'createCheckoutSession'])->name('checkout.session');
Route::get('/checkout/success', [StripeController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [StripeController::class, 'cancel'])->name('checkout.cancel');

// Public route for hello module demo
Route::get('/hello', function () {
    return view('hello::index');
})->name('hello');

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

    // Child Development Tracker Routes
    Route::resource('children', ChildController::class);
    
    // Activity routes
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/activities/by-age', [ActivityController::class, 'byAge'])->name('activities.by-age');
    Route::get('/activities/category/{category}', [ActivityController::class, 'byCategory'])->name('activities.by-category');
    Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');
    Route::get('/children/{child}/activities', [ActivityController::class, 'forChild'])->name('activities.for-child');
    
    // Milestone routes - nested under children
    Route::get('/children/{child}/milestones', [MilestoneController::class, 'index'])->name('milestones.index');
    Route::get('/children/{child}/milestones/create', [MilestoneController::class, 'create'])->name('milestones.create');
    Route::post('/children/{child}/milestones', [MilestoneController::class, 'store'])->name('milestones.store');
    Route::get('/children/{child}/milestones/{childMilestone}', [MilestoneController::class, 'show'])->name('milestones.show');
    Route::get('/children/{child}/milestones/{childMilestone}/edit', [MilestoneController::class, 'edit'])->name('milestones.edit');
    Route::put('/children/{child}/milestones/{childMilestone}', [MilestoneController::class, 'update'])->name('milestones.update');
    Route::delete('/children/{child}/milestones/{childMilestone}', [MilestoneController::class, 'destroy'])->name('milestones.destroy');
    Route::post('/children/{child}/milestones/toggle', [MilestoneController::class, 'toggle'])->name('milestones.toggle');
    
    // Growth record routes - nested under children
    Route::get('/children/{child}/growth', [GrowthRecordController::class, 'index'])->name('growth.index');
    Route::get('/children/{child}/growth/create', [GrowthRecordController::class, 'create'])->name('growth.create');
    Route::post('/children/{child}/growth', [GrowthRecordController::class, 'store'])->name('growth.store');
    Route::get('/children/{child}/growth/{growthRecord}', [GrowthRecordController::class, 'show'])->name('growth.show');
    Route::get('/children/{child}/growth/{growthRecord}/edit', [GrowthRecordController::class, 'edit'])->name('growth.edit');
    Route::put('/children/{child}/growth/{growthRecord}', [GrowthRecordController::class, 'update'])->name('growth.update');
    Route::delete('/children/{child}/growth/{growthRecord}', [GrowthRecordController::class, 'destroy'])->name('growth.destroy');
    
    // Development log routes - nested under children
    Route::get('/children/{child}/logs', [DevelopmentLogController::class, 'index'])->name('logs.index');
    Route::get('/children/{child}/logs/create', [DevelopmentLogController::class, 'create'])->name('logs.create');
    Route::post('/children/{child}/logs', [DevelopmentLogController::class, 'store'])->name('logs.store');
    Route::get('/children/{child}/logs/{log}', [DevelopmentLogController::class, 'show'])->name('logs.show');
    Route::get('/children/{child}/logs/{log}/edit', [DevelopmentLogController::class, 'edit'])->name('logs.edit');
    Route::put('/children/{child}/logs/{log}', [DevelopmentLogController::class, 'update'])->name('logs.update');
    Route::delete('/children/{child}/logs/{log}', [DevelopmentLogController::class, 'destroy'])->name('logs.destroy');
    Route::get('/children/{child}/logs/category/{category}', [DevelopmentLogController::class, 'filterByCategory'])->name('logs.category');
    
    // Caregiver routes - nested under children
    Route::get('/children/{child}/caregivers', [CaregiverController::class, 'index'])->name('caregivers.index');
    Route::get('/children/{child}/caregivers/create', [CaregiverController::class, 'create'])->name('caregivers.create');
    Route::post('/children/{child}/caregivers', [CaregiverController::class, 'store'])->name('caregivers.store');
    Route::get('/children/{child}/caregivers/{caregiver}', [CaregiverController::class, 'show'])->name('caregivers.show');
    Route::get('/children/{child}/caregivers/{caregiver}/edit', [CaregiverController::class, 'edit'])->name('caregivers.edit');
    Route::put('/children/{child}/caregivers/{caregiver}', [CaregiverController::class, 'update'])->name('caregivers.update');
    Route::delete('/children/{child}/caregivers/{caregiver}', [CaregiverController::class, 'destroy'])->name('caregivers.destroy');
    Route::post('/children/{child}/caregivers/search', [CaregiverController::class, 'search'])->name('caregivers.search');
});