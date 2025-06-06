<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CinemaController;

Route::prefix('cinemas')->group(function () {
    Route::get('/', [CinemaController::class, 'index']);
    Route::post('/', [CinemaController::class, 'store']);
    Route::get('/{id}', [CinemaController::class, 'show']);
    Route::patch('/{id}', [CinemaController::class, 'update']);
    Route::delete('/{id}', [CinemaController::class, 'destroy']);
});