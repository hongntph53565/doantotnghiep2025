<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\EmailTemplateApiController;
use App\Http\Controllers\Api\SendMailApiController;
use App\Http\Controllers\Api\ShowtimeApiController;
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\RoomApiController;
use App\Http\Controllers\Api\SeatApiController;
use App\Http\Controllers\Api\MenuItemController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\CinemaController;
use App\Http\Controllers\API\PromotionController;

use App\Http\Controllers\PayosController;
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('users')->group(function () {
        Route::get('/',              [UserController::class, 'index']);
        Route::get('/{id}',          [UserController::class, 'show']);
        Route::post('/',             [UserController::class, 'store']);
        Route::put('/{id}',          [UserController::class, 'update']);
        Route::delete('/{id}',       [UserController::class, 'delete']);
        Route::post('/restore/{id}', [UserController::class, 'restore']);
        Route::delete('/force/{id}', [UserController::class, 'forceDelete']);
    });

    Route::prefix('cinemas')->group(function () {
        Route::get('/',        [CinemaController::class, 'index']);
        Route::post('/',       [CinemaController::class, 'store']);
        Route::get('/{id}',    [CinemaController::class, 'show']);
        Route::patch('/{id}',  [CinemaController::class, 'update']);
        Route::delete('/{id}', [CinemaController::class, 'destroy']);
    });

    Route::prefix('rooms')->group(function () {
        Route::get('/',        [RoomApiController::class, 'index']);
        Route::post('/',       [RoomApiController::class, 'store']);
        Route::get('/{id}',    [RoomApiController::class, 'show']);
        Route::put('/{id}',    [RoomApiController::class, 'update']);
        Route::delete('/{id}', [RoomApiController::class, 'destroy']);
    });

    Route::prefix('seats')->group(function () {
        Route::get('/',          [SeatApiController::class, 'index']);
        Route::get('/{room_id}', [SeatApiController::class, 'show']);
        Route::put('/{room_id}', [SeatApiController::class, 'update']);
    });

    Route::prefix('booking')->group(function () {
        Route::get('/',        [BookingApiController::class, 'index']);
        Route::post('/',       [BookingApiController::class, 'store']);
        Route::get('/{id}',    [BookingApiController::class, 'show']);
        Route::put('/{id}',    [BookingApiController::class, 'update']);
        Route::delete('/{id}', [BookingApiController::class, 'destroy']);
    });

    Route::prefix('showtime')->group(function () {
        Route::get('/',        [ShowtimeApiController::class, 'index']);
        Route::post('/',       [ShowtimeApiController::class, 'store']);
        Route::get('/{id}',    [ShowtimeApiController::class, 'show']);
        Route::put('/{id}',    [ShowtimeApiController::class, 'update']);
        Route::delete('/{id}', [ShowtimeApiController::class, 'destroy']);
    });

    Route::prefix('template')->name('template.')->group(function () {
        Route::get('/',        [EmailTemplateApiController::class, 'index']);
        Route::get('/{id}',    [EmailTemplateApiController::class, 'show']);
        Route::post('/',       [EmailTemplateApiController::class, 'store']);
        Route::put('/{id}',    [EmailTemplateApiController::class, 'update']);
        Route::delete('/{id}', [EmailTemplateApiController::class, 'destroy']);
    });

    Route::prefix('mail')->group(function () {
        Route::post('/send', [SendMailApiController::class, 'send']);
    });

    Route::prefix('genres')->group(function () {
        Route::get('/',              [GenreController::class, 'index']);
        Route::get('/trashed',       [GenreController::class, 'trashed']);
        Route::post('/',             [GenreController::class, 'store']);
        Route::get('/{id}',          [GenreController::class, 'show']);
        Route::put('/{id}',          [GenreController::class, 'update']);
        Route::delete('/{id}',       [GenreController::class, 'destroy']);
        Route::post('/{id}/restore', [GenreController::class, 'restore']);
        Route::delete('/{id}/force', [GenreController::class, 'forceDelete']);
    });

    Route::prefix('movies')->group(function () {
        Route::get('/',              [MovieController::class, 'index']);
        Route::get('/{id}',          [MovieController::class, 'show']);
        Route::post('/',             [MovieController::class, 'store']);
        Route::put('/{id}',          [MovieController::class, 'update']);
        Route::delete('/{id}',       [MovieController::class, 'destroy']);
        Route::post('/restore/{id}', [MovieController::class, 'restore']);
        Route::delete('/force/{id}', [MovieController::class, 'forceDelete']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::prefix('promotions')->group(function () {
    Route::get('/', [PromotionController::class, 'index']);
    Route::get('/{id}', [PromotionController::class, 'show']);
    Route::post('/', [PromotionController::class, 'store']);
    Route::put('/{id}', [PromotionController::class, 'update']);
    Route::delete('/{id}', [PromotionController::class, 'destroy']); // xóa mềm
    Route::post('/restore/{id}', [PromotionController::class, 'restore']);
    Route::delete('/force/{id}', [PromotionController::class, 'forceDelete']);
});

Route::prefix('menu-items')->group(function () {
    Route::get('/', [MenuItemController::class, 'index']);
    Route::get('/{id}', [MenuItemController::class, 'show']);
    Route::post('/', [MenuItemController::class, 'store']);
    Route::put('/{id}', [MenuItemController::class, 'update']);
    Route::delete('/{id}', [MenuItemController::class, 'delete']);
});
Route::prefix('payos')->name('payosapi.')->group(function () {
    Route::get('/{amount}/{description}',    [PayosController::class, 'createLink']);
    Route::get('/return-link/{description}', [PayosController::class, 'returnPage']);

});
