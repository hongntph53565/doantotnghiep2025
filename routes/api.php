<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\API\CenimaController;
use App\Http\Controllers\API\PromotionController;
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'delete']);//Xóa mềm
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});

    // Route::prefix('combos')->group(function () {
    //     Route::get('/', [AdminComboController::class, 'index']);
    //     Route::get('/{id}', [AdminComboController::class, 'show']);
    //     Route::post('/', [AdminComboController::class, 'store']);
    //     Route::put('/{id}', [AdminComboController::class, 'update']);
    //     Route::delete('/{id}', [AdminComboController::class, 'delete']);//Xóa mềm
    // });

Route::prefix('promotions')->group(function () {
        Route::get('/', [PromotionController::class, 'index']);
        Route::get('/{id}', [PromotionController::class, 'show']);
        Route::get('/create', [PromotionController::class, 'create']);
        Route::post('/', [PromotionController::class, 'store']);
        Route::put('/{id}', [PromotionController::class, 'update']);
        Route::delete('/promotions/{id}', [PromotionController::class, 'destroy']);
        Route::patch('/promotions/{id}/restore', [PromotionController::class, 'restore']);

    });
