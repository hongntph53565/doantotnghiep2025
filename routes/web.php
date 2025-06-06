<?php

use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\ShowtimeController;
use App\Models\EmailTemplate;
use App\Models\Room;
use App\Models\Showtime;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('Room')->name('rooms.')->group(function () {
    Route::get('/',               [RoomController::class, 'index'])->name('index');
    Route::get('/create',         [RoomController::class, 'create'])->name('create');
    Route::post('/store',         [RoomController::class, 'store'])->name('store');
    Route::get('/edit/{id}',      [RoomController::class, 'edit'])->name('edit');
    Route::post('/update/{id}',   [RoomController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [RoomController::class, 'delete'])->name('delete');
});

Route::prefix('Showtime')->name('showtime.')->group(function () {
    Route::get('/',               [ShowtimeController::class, 'index'])->name("index");
    Route::get('/create',         [ShowtimeController::class, 'create'])->name('create');
    Route::post('/store',         [ShowtimeController::class, 'store'])->name('store');
    Route::get('/edit/{id}',      [ShowtimeController::class, 'edit'])->name('edit');
    Route::post('/update/{id}',   [ShowtimeController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [ShowtimeController::class, 'delete'])->name('delete');
});

Route::prefix('Mail')->name('mail.')->group(function () {
    Route::get('/send-form', [SendMailController::class, 'create'])->name('create');
    Route::post('/send-mail', [SendMailController::class, 'send'])->name('send');
});

Route::prefix('Template')->name('template.')->group(function (){
    Route::get('/',               [EmailTemplateController::class, 'index'])->name('index');
    Route::get('/create',         [EmailTemplateController::class, 'create'])->name('create');
    Route::post('/store',         [EmailTemplateController::class, 'store'])->name('store');
    Route::get('/edit/{id}',      [EmailTemplateController::class, 'edit'])->name('edit');
    Route::post('/update/{id}',   [EmailTemplateController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [EmailTemplateController::class, 'delete'])->name('delete');
});