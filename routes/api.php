<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\CinemaController;
use App\Http\Controllers\Api\EmailTemplateApiController;
use App\Http\Controllers\Api\PayosApiController;
use App\Http\Controllers\Api\RoomApiController;
use App\Http\Controllers\Api\SeatApiController;
use App\Http\Controllers\Api\SendMailApiController;
use App\Http\Controllers\Api\ShowtimeApiController;
use App\Http\Controllers\PayosController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'delete']); // xóa mềm
    });

    Route::prefix('cinemas')->group(function () {
        Route::get('/', [CinemaController::class, 'index']);
        Route::post('/', [CinemaController::class, 'store']);
        Route::get('/{id}', [CinemaController::class, 'show']);
        Route::patch('/{id}', [CinemaController::class, 'update']);
        Route::delete('/{id}', [CinemaController::class, 'destroy']);
    });

    Route::prefix('rooms')->group(function () {
        Route::get('/', [RoomApiController::class, 'index']);
        Route::post('/', [RoomApiController::class, 'store']);
        Route::get('/{id}', [RoomApiController::class, 'show']);
        Route::put('/{id}', [RoomApiController::class, 'update']);
        Route::delete('/{id}', [RoomApiController::class, 'destroy']);
    });

    Route::prefix('seats')->group(function () {
        Route::get('/', [SeatApiController::class, 'index']); // Lấy danh sách phòng
        Route::get('/{room_id}', [SeatApiController::class, 'show']); // Lấy danh sách ghế trong phòng
        Route::put('/{room_id}', [SeatApiController::class, 'update']); // Cập nhật loại ghế
    });

    Route::prefix('booking')->group(function () {
        Route::get('/',        [BookingApiController::class, 'index']);
        Route::post('/',       [BookingApiController::class, 'store']);
        Route::get('/{id}',    [BookingApiController::class, 'show']);
        Route::put('/{id}',    [BookingApiController::class, 'update']);
        Route::delete('/{id}', [BookingApiController::class, 'destroy']);
    });

    Route::prefix('showtime')->group(function () {
        Route::get('/', [ShowtimeApiController::class, 'index']);
        Route::post('/', [ShowtimeApiController::class, 'store']);
        Route::get('/{id}', [ShowtimeApiController::class, 'show']);
        Route::put('/{id}', [ShowtimeApiController::class, 'update']);
        Route::delete('/{id}', [ShowtimeApiController::class, 'destroy']);
    });

    Route::prefix('template')->name('template.')->group(function () {
        Route::get('/', [EmailTemplateApiController::class, 'index']);
        Route::get('/{id}', [EmailTemplateApiController::class, 'show']);
        Route::post('/', [EmailTemplateApiController::class, 'store']);
        Route::put('/{id}', [EmailTemplateApiController::class, 'update']);
        Route::delete('/{id}', [EmailTemplateApiController::class, 'destroy']); // dùng destroy thay vì delete
    });

    Route::prefix('mail')->group(function () {
        Route::post('/send', [SendMailApiController::class, 'send']);
    });

    Route::prefix('payos')->name('payosapi.')->group(function () {
        Route::get('/{amount}/{description}', [PayosController::class, 'createLink']);
        Route::get('/return-link/{description}',          [PayosController::class, 'returnPage']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});