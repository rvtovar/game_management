<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\PlayerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentication routes
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Publicly accessible routes
// -- Events
// Public routes
Route::apiResource('games', GameController::class)
    ->only(['index', 'show']);

// Protected routes
Route::apiResource('games', GameController::class)
    ->only(['store', 'update', 'destroy'])
    ->middleware(['auth:sanctum', 'throttle:api']);

// Protected routes
Route::apiResource('games.players', PlayerController::class)
    ->scoped()
    ->only(['store', 'destroy'])
    ->middleware(['auth:sanctum', 'throttle:api']);


// Public routes
Route::apiResource('games.players', PlayerController::class)
    ->scoped()
    ->only(['index', 'show']);

// Fallback route for undefined endpoints
Route::fallback(function () {
    return response()->json(['message' => 'This endpoint was not found!'], 404);
});
