<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\IpController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'ability:full,read'])->group(function() {
    Route::get('ip/index', [IpController::class, 'index']);
    Route::get('ip/show', [IpController::class, 'show']);
    Route::patch('ip/update/{id}', [IpController::class, 'update']);
    Route::get('ip/export', [IpController::class, 'export']);
    Route::post('/logout', [AuthController::class, 'logout'] );
});

Route::middleware(['auth:sanctum', 'abilities:full'])->group(function() {
    Route::post('/ip/store', [IpController::class, 'store']);
    Route::delete('ip/destroy/{ip}', [IpController::class, 'destroy']);
});

Route::fallback(function () {
    return response()->json(['message' => 'Route Not Found'], 404);
})->name('api.fallback.404');






