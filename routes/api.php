<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CinemaController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'delete']); // xóa mềm
        Route::post('/restore/{id}', [UserController::class, 'restore']);
        Route::delete('/force/{id}', [UserController::class, 'forceDelete']);
    });

    Route::prefix('cinemas')->group(function () {
    Route::get('/', [CinemaController::class, 'index']);
    Route::post('/', [CinemaController::class, 'store']);
    Route::get('/{id}', [CinemaController::class, 'show']);
    Route::patch('/{id}', [CinemaController::class, 'update']);
    Route::delete('/{id}', [CinemaController::class, 'destroy']);
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});

