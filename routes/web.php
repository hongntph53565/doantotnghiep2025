<?php

use App\Http\Controllers\CinemaController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CinemaSeatTypePriceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailLogController;
use App\Http\Controllers\ExtraPriceController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PayosController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\VnpayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ZalopayController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/static', [StaticController::class, 'index'])->name('admin.static');

Route::get('/home', [HomeController::class, 'home']);
Route::get('/cart', [HomeController::class, 'index']);
Route::get('/booking2', [HomeController::class, 'booking2']);
Route::get('/booking3', [HomeController::class, 'booking3']);
Route::get('/booking4', [HomeController::class, 'booking4']);
Route::get('/', function () {
    // return response()->json(['message' => 'Backend OK']);
});
Route::get('/lich-chieu-phim', function () {
    return view('Client.lichchieuphim');
});

Route::get('/lich-chieu-theo-rap', function () {
    return view('Client.lichchieurap');
});
Route::get('/he-thong-rap', function () {
    return view('Client.hethongrap');
});
Route::get('/profile', function () {
    return view('Client.profile');
});
Route::get('/thong-tin-rap', function () {
    return view('Client.thongtinrap');
});


Route::prefix('cinema')->name('cinemas.')->group(function () {
    Route::get('/',              [CinemaController::class, 'index'])->name('index');
    Route::get('/create',        [CinemaController::class, 'create'])->name('create');
    Route::post('/store',        [CinemaController::class, 'store'])->name('store');
    Route::get('/edit/{id}',     [CinemaController::class, 'edit'])->name('edit');
    Route::post('/update/{id}',  [CinemaController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [CinemaController::class, 'delete'])->name('delete');
});

Route::prefix('room')->name('rooms.')->group(function () {
    Route::get('/',               [RoomController::class, 'index'])->name('index');
    Route::get('/create',         [RoomController::class, 'create'])->name('create');
    Route::post('/store',         [RoomController::class, 'store'])->name('store');
    Route::get('/edit/{id}',      [RoomController::class, 'edit'])->name('edit');
    Route::post('/update/{id}',   [RoomController::class, 'update'])->name('update');
    Route::get('/show/{id}',      [RoomController::class, 'show'])->name('show');
    Route::delete('/delete/{id}', [RoomController::class, 'delete'])->name('delete');
});

Route::prefix('genre')->name('genres.')->group(function () {
    Route::get('/',               [GenreController::class, 'index'])->name('index');
    Route::get('/create',         [GenreController::class, 'create'])->name('create');
    Route::post('/store',         [GenreController::class, 'store'])->name('store');
    Route::get('/edit/{id}',      [GenreController::class, 'edit'])->name('edit');
    Route::post('/update/{id}',   [GenreController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [GenreController::class, 'delete'])->name('delete');
});


Route::prefix('movie')->name('movies.')->group(function () {
    Route::get('/',               [MovieController::class, 'index'])->name('index');
    Route::get('/create',         [MovieController::class, 'create'])->name('create');
    Route::post('/store',         [MovieController::class, 'store'])->name('store');
    Route::get('/edit/{id}',      [MovieController::class, 'edit'])->name('edit');
    Route::post('/update/{id}',   [MovieController::class, 'update'])->name('update');
    Route::get('/show/{id}',      [MovieController::class, 'show'])->name('show');
    Route::delete('/delete/{id}', [MovieController::class, 'destroy'])->name('destroy');
});

Route::prefix('review')->name('reviews.')->group(function () {
    Route::get('/{id}',           [ReviewController::class, 'index'])->name('index');
    Route::post('/store',         [ReviewController::class, 'store'])->name('store');
    Route::post('/update/{id}',   [ReviewController::class, 'update'])->name('update');
    Route::get('/show/{id}',      [ReviewController::class, 'show'])->name('show');
    Route::delete('/delete/{id}', [ReviewController::class, 'destroy'])->name('destroy');
});

Route::prefix('food')->name('foods.')->group(function () {
    Route::get('/',               [FoodController::class, 'index'])->name('index');
    Route::post('/store',         [FoodController::class, 'store'])->name('store');
    Route::get('/edit/{id}',      [FoodController::class, 'edit'])->name('edit');
    Route::post('/update/{id}',   [FoodController::class, 'update'])->name('update');
    Route::get('/show/{id}',      [FoodController::class, 'show'])->name('show');
    Route::delete('/delete/{id}', [FoodController::class, 'destroy'])->name('destroy');
});

Route::prefix('showtime')->name('showtimes.')->group(function () {
    Route::get('/',               [ShowtimeController::class, 'index'])->name("index");
    Route::get('/create',         [ShowtimeController::class, 'create'])->name('create');
    Route::post('/store',         [ShowtimeController::class, 'store'])->name('store');
    Route::get('/edit/{id}',      [ShowtimeController::class, 'edit'])->name('edit');
    Route::post('/update/{id}',   [ShowtimeController::class, 'update'])->name('update');
    Route::post('/search',        [ShowtimeController::class, 'search'])->name('search');
    Route::delete('/delete/{id}', [ShowtimeController::class, 'delete'])->name('delete');
});

Route::prefix('template')->name('template.')->group(function () {
    Route::get('/',               [EmailTemplateController::class, 'index'])->name('index');
    Route::get('show/{id}',       [EmailTemplateController::class, 'show'])->name('show');

    Route::get('/create',         [EmailTemplateController::class, 'create'])->name('create');
    Route::post('/store',         [EmailTemplateController::class, 'store'])->name('store');
    Route::get('/edit/{id}',      [EmailTemplateController::class, 'edit'])->name('edit');
    Route::post('/update/{id}',   [EmailTemplateController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [EmailTemplateController::class, 'delete'])->name('delete');
});

Route::prefix('emaillog')->name('emaillog.')->group(function () {
    Route::get('/',               [EmailLogController::class, 'index'])->name('index');
});

Route::prefix('promotion')->name('promotions.')->group(function () {
    Route::get('/',               [PromotionController::class, 'index'])->name('index');
    Route::post('/store',         [PromotionController::class, 'store'])->name('store');
    Route::post('/update/{id}',   [PromotionController::class, 'update'])->name('update');
    Route::get('/show/{id}',      [PromotionController::class, 'show'])->name('show');
    Route::delete('/delete/{id}', [PromotionController::class, 'destroy'])->name('destroy');
});

Route::prefix('extraprice')->name('extraprices.')->group(function () {
    Route::get('/',               [ExtraPriceController::class, 'index'])->name('index');
    Route::post('/store',         [ExtraPriceController::class, 'store'])->name('store');
    Route::post('/update/{id}',   [ExtraPriceController::class, 'update'])->name('update');
    Route::get('/show/{id}',      [ExtraPriceController::class, 'show'])->name('show');
    Route::delete('/delete/{id}', [ExtraPriceController::class, 'destroy'])->name('destroy');
});

Route::prefix('cinemaseatprice')->name('cinemaseatprices.')->group(function () {
    Route::get('/',               [CinemaSeatTypePriceController::class, 'index'])->name('index');
    Route::post('/store',         [CinemaSeatTypePriceController::class, 'store'])->name('store');
    Route::post('/update/{id}',   [CinemaSeatTypePriceController::class, 'update'])->name('update');
    Route::get('/show/{id}',      [CinemaSeatTypePriceController::class, 'show'])->name('show');
    Route::delete('/delete/{id}', [CinemaSeatTypePriceController::class, 'destroy'])->name('destroy');
});

Route::prefix('booking')->name('booking.')->group(function () {
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

Route::prefix('zalopay')->name('zalopay.')->group(function () {
    Route::get('/create-link/{amount}/{description}', [ZalopayController::class, 'createLink'])->name('create');
    Route::get('/return-link/{description}',          [ZalopayController::class, 'returnPage'])->name('return');
});

Route::prefix('vnpay')->name('vnpay.')->group(function () {
    Route::get('/create-link/{amount}/{description}', [VnpayController::class, 'createLink'])->name('create');
    Route::get('/return-link/{description}',          [VnpayController::class, 'returnPage'])->name('return');
});

Route::get('/seats/{showtime_id}', [BookingController::class, 'getSeatsByShowtime']);

