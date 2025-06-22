<?php

use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PayosController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SeatController;
use App\Models\EmailTemplate;
use App\Models\Showtime;
use App\Models\Room;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('room')->name('rooms.')->group(function () {
    Route::get('/',               [RoomController::class, 'index'])->name('index');
    Route::get('/create',         [RoomController::class, 'create'])->name('create');
    Route::post('/store',         [RoomController::class, 'store'])->name('store');
    Route::get('/edit/{id}',      [RoomController::class, 'edit'])->name('edit');
    Route::post('/update/{id}',   [RoomController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [RoomController::class, 'delete'])->name('delete');
});

Route::prefix('showtime')->name('showtime.')->group(function () {
    Route::get('/',               [ShowtimeController::class, 'index'])->name("index");
    Route::get('/create',         [ShowtimeController::class, 'create'])->name('create');
    Route::post('/store',         [ShowtimeController::class, 'store'])->name('store');
    Route::get('/edit/{id}',      [ShowtimeController::class, 'edit'])->name('edit');
    Route::post('/update/{id}',   [ShowtimeController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [ShowtimeController::class, 'delete'])->name('delete');
});

Route::prefix('template')->name('template.')->group(function (){
    Route::get('/',               [EmailTemplateController::class, 'index'])->name('index');
    Route::get('/create',         [EmailTemplateController::class, 'create'])->name('create');
    Route::post('/store',         [EmailTemplateController::class, 'store'])->name('store');
    Route::get('/edit/{id}',      [EmailTemplateController::class, 'edit'])->name('edit');
    Route::post('/update/{id}',   [EmailTemplateController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [EmailTemplateController::class, 'delete'])->name('delete');
});

Route::prefix('booking')->name('booking.')->group(function (){
    Route::get('/',               [BookingController::class, 'index'])->name('index');
    Route::get('/create',         [BookingController::class, 'create'])->name('create');
    Route::post('/store',         [BookingController::class, 'store'])->name('store');
    Route::get('/edit/{id}',      [BookingController::class, 'edit'])->name('edit');
    Route::post('/update/{id}',   [BookingController::class, 'update'])->name('update');
    Route::get('/show/{id}',      [BookingController::class, 'show'])->name('show');
    Route::delete('/delete/{id}', [BookingController::class, 'delete'])->name('delete');
});

Route::prefix('mail')->name('mail.')->group(function () {
    Route::get('/send-form',  [SendMailController::class, 'create'])->name('create');
    Route::post('/send-mail', [SendMailController::class, 'send'])->name('send');
});

Route::prefix('seat')->name('seat.')->group(function () {
    Route::get('/', [SeatController::class, 'index'])->name('index');
    Route::get('rooms/{room}/seats/edit',    [SeatController::class, 'edit'])->name('edit');
    Route::post('rooms/{room}/seats/update', [SeatController::class, 'update'])->name('update');
});

Route::prefix('payos')->name('payos.')->group(function () {
    Route::get('/create-link/{amount}/{description}', [PayosController::class, 'createLink'])->name('create');
    Route::get('/return-link/{description}',          [PayosController::class, 'returnPage'])->name('return');
});

