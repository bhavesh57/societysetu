<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SocietyApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Mobile authentication
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        // Society data
        Route::get('/newsletters', [SocietyApiController::class, 'newsletters']);
        Route::get('/complaints', [SocietyApiController::class, 'complaints']);
        Route::post('/complaints', [SocietyApiController::class, 'storeComplaint']);
        Route::post('/complaints/{id}/comment', [SocietyApiController::class, 'addComment']);
        Route::get('/properties', [SocietyApiController::class, 'properties']);
    });
});
