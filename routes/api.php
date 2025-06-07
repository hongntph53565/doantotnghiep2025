<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Api\CinemaController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\GenreController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'delete']);
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

    Route::prefix('genres')->group(function () {
        Route::get('/', [GenreController::class, 'index']);
        Route::get('/trashed', [GenreController::class, 'trashed']);
        Route::post('/', [GenreController::class, 'store']);
        Route::get('/{id}', [GenreController::class, 'show']);
        Route::put('/{id}', [GenreController::class, 'update']);
        Route::delete('/{id}', [GenreController::class, 'destroy']);
        Route::post('/{id}/restore', [GenreController::class, 'restore']);
        Route::delete('/{id}/force', [GenreController::class, 'forceDelete']);
    });

    Route::prefix('movies')->group(function () {
        Route::get('/', [MovieController::class, 'index']);
        Route::get('/{id}', [MovieController::class, 'show']);
        Route::post('/', [MovieController::class, 'store']);
        Route::put('/{id}', [MovieController::class, 'update']);
        Route::delete('/{id}', [MovieController::class, 'destroy']);
        Route::post('/restore/{id}', [MovieController::class, 'restore']);
        Route::delete('/force/{id}', [MovieController::class, 'forceDelete']);
    });
    
    Route::post('/logout', [AuthController::class, 'logout']);
});
