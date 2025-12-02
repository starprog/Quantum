<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BattleController;
use App\Models\Hero;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Get all heroes
Route::get('/heroes', function () {
    return Hero::all();
});

// Battle endpoint
Route::post('/battles/toptrumps', [BattleController::class, 'topTrumps']);