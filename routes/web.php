<?php

use App\Http\Controllers\Admin\CinemaController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\SendMailController;
use App\Http\Controllers\Admin\ShowtimeController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CinemaSeatTypePriceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailLogController;
use App\Http\Controllers\Admin\ExtraPriceController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\PayosController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\SeatController;
use App\Http\Controllers\Admin\StaticController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VnpayController;
use App\Http\Controllers\Admin\ZalopayController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\ComboController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\StaffMovieController;
use App\Http\Controllers\Staff\StaffBookingController;
use App\Http\Controllers\Staff\BookingSearchController;
use App\Http\Controllers\Staff\BookingController as StaffBooking;

Route::prefix('payos')->name('payos.')->group(function () {
    Route::get('/create-link/{amount}/{description}', [PayosController::class, 'createLink'])->name('create');
    Route::get('/return-link/{description}', [PayosController::class, 'returnPage'])->name('return');
});

Route::prefix('zalopay')->name('zalopay.')->group(function () {
    Route::get('/create-link/{amount}/{description}', [ZalopayController::class, 'createLink'])->name('create');
    Route::get('/return-link/{description}', [ZalopayController::class, 'returnPage'])->name('return');
});

Route::prefix('vnpay')->name('vnpay.')->group(function () {
    Route::get('/create-link/{amount}/{description}', [VnpayController::class, 'createLink'])->name('create');
    Route::get('/return-link/{description}', [VnpayController::class, 'returnPage'])->name('return');
});

Route::prefix('booking')->name('booking.')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('index');
    Route::post('/store', [BookingController::class, 'store'])->name('store');
    Route::delete('/delete/{id}', [BookingController::class, 'delete'])->name('delete');
});

Route::prefix('admin')->middleware(['auth', 'role:admin,employee'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/static', [StaticController::class, 'index'])->name('admin.static');

    Route::prefix('user')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('cinema')->name('cinemas.')->group(function () {
        Route::get('/', [CinemaController::class, 'index'])->name('index');
        Route::get('/create', [CinemaController::class, 'create'])->name('create');
        Route::post('/store', [CinemaController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CinemaController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CinemaController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CinemaController::class, 'delete'])->name('delete');
    });

    Route::prefix('room')->name('rooms.')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('index');
        Route::get('/create', [RoomController::class, 'create'])->name('create');
        Route::post('/store', [RoomController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [RoomController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [RoomController::class, 'update'])->name('update');



        Route::get('/show/{id}', [RoomController::class, 'show'])->name('show');
        Route::delete('/delete/{id}', [RoomController::class, 'delete'])->name('delete');
    });

    Route::prefix('genre')->name('genres.')->group(function () {
        Route::get('/', [GenreController::class, 'index'])->name('index');
        Route::get('/create', [GenreController::class, 'create'])->name('create');
        Route::post('/store', [GenreController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [GenreController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [GenreController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [GenreController::class, 'destroy'])->name('delete');
    });


    Route::prefix('movie')->name('movies.')->group(function () {
        Route::get('/', [MovieController::class, 'index'])->name('index');
        Route::get('/create', [MovieController::class, 'create'])->name('create');
        Route::post('/store', [MovieController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [MovieController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [MovieController::class, 'update'])->name('update');
        Route::get('/show/{id}', [MovieController::class, 'show'])->name('show');
        Route::delete('/delete/{id}', [MovieController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('review')->name('reviews.')->group(function () {
        Route::get('/{id}', [ReviewController::class, 'index'])->name('index');
        Route::post('/store', [ReviewController::class, 'store'])->name('store');
        Route::post('/update/{id}', [ReviewController::class, 'update'])->name('update');
        Route::get('/show/{id}', [ReviewController::class, 'show'])->name('show');
        Route::delete('/delete/{id}', [ReviewController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('food')->name('foods.')->group(function () {
        Route::get('/', [FoodController::class, 'index'])->name('index');
        Route::post('/store', [FoodController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [FoodController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [FoodController::class, 'update'])->name('update');
        Route::get('/show/{id}', [FoodController::class, 'show'])->name('show');
        Route::delete('/delete/{id}', [FoodController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('showtime')->name('showtimes.')->group(function () {
        Route::get('/', [ShowtimeController::class, 'index'])->name("index");
        Route::get('/create', [ShowtimeController::class, 'create'])->name('create');
        Route::post('/store', [ShowtimeController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ShowtimeController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ShowtimeController::class, 'update'])->name('update');
        Route::post('/search', [ShowtimeController::class, 'search'])->name('search');
        Route::delete('/delete/{id}', [ShowtimeController::class, 'delete'])->name('delete');
    });

    Route::prefix('template')->name('template.')->group(function () {
        Route::get('/', [EmailTemplateController::class, 'index'])->name('index');
        Route::get('show/{id}', [EmailTemplateController::class, 'show'])->name('show');
        Route::get('/create', [EmailTemplateController::class, 'create'])->name('create');
        Route::post('/store', [EmailTemplateController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [EmailTemplateController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [EmailTemplateController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [EmailTemplateController::class, 'delete'])->name('delete');
    });

    Route::prefix('post')->name('posts.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PostController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [PostController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [PostController::class, 'delete'])->name('delete');
    });

    Route::prefix('emaillog')->name('emaillog.')->group(function () {
        Route::get('/', [EmailLogController::class, 'index'])->name('index');
    });

    Route::prefix('promotion')->name('promotions.')->group(function () {
        Route::get('/', [PromotionController::class, 'index'])->name('index');
        Route::post('/store', [PromotionController::class, 'store'])->name('store');
        Route::post('/update/{id}', [PromotionController::class, 'update'])->name('update');
        Route::get('/show/{id}', [PromotionController::class, 'show'])->name('show');
        Route::delete('/delete/{id}', [PromotionController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('extraprice')->name('extraprices.')->group(function () {
        Route::get('/', [ExtraPriceController::class, 'index'])->name('index');
        Route::post('/store', [ExtraPriceController::class, 'store'])->name('store');
        Route::post('/update/{id}', [ExtraPriceController::class, 'update'])->name('update');
        Route::get('/show/{id}', [ExtraPriceController::class, 'show'])->name('show');
        Route::delete('/delete/{id}', [ExtraPriceController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('cinemaseatprice')->name('cinemaseatprices.')->group(function () {
        Route::get('/', [CinemaSeatTypePriceController::class, 'index'])->name('index');
        Route::post('/store', [CinemaSeatTypePriceController::class, 'store'])->name('store');
        Route::post('/update/{id}', [CinemaSeatTypePriceController::class, 'update'])->name('update');
        Route::get('/show/{id}', [CinemaSeatTypePriceController::class, 'show'])->name('show');
        Route::delete('/delete/{id}', [CinemaSeatTypePriceController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('mail')->name('mail.')->group(function () {
        Route::get('/send-form', [SendMailController::class, 'create'])->name('create');
        Route::post('/send-mail', [SendMailController::class, 'send'])->name('send');
    });

    Route::prefix('seat')->name('seat.')->group(function () {
        Route::get('/', [SeatController::class, 'index'])->name('index');
        Route::get('rooms/{room}/seats/edit', [SeatController::class, 'edit'])->name('edit');
        Route::post('rooms/{room}/seats/update', [SeatController::class, 'update'])->name('update');
    });

    Route::get('/seats/{showtime_id}', [BookingController::class, 'getSeatsByShowtime']);

    // Route::prefix('manager')->name('manager.')->group(callback: function () {
    //     Route::get('/', [ManagerDashboardController::class, 'index'])->name('index');
    // });
});
Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('/', [StaffMovieController::class, 'index'])->name('list');
    Route::get('/bookings/{movie}', [StaffBookingController::class, 'booking'])->name('booking1');
    Route::get('/bookings/{movie}/showtimes-by-date', [StaffBookingController::class, 'showtimesByDate'])->name('booking.showtimes_by_date');
    Route::get('/booking/seats/{room_id}', [StaffBookingController::class, 'showSeatsByRoom'])->name('booking.seats');
    Route::get('/search-ticket-online', [BookingSearchController::class, 'search'])->name('search_ticket_online');
    Route::get('/staff/bookings/{booking}/print', [StaffBooking::class, 'print'])->name('booking.print');
    Route::get('/dat-do-an', [StaffBookingController::class, 'getCombos'])->name('combo');
    Route::get('/combo/{id}', [StaffBookingController::class, 'showCombo'])->name('combo.show');
    Route::get('/cart', [StaffBookingController::class, 'showCart'])->name('cart');
    Route::post('/cart/add', [StaffBookingController::class, 'addToCart'])->name('cart.addCart');
    Route::get('/clear-cart-and-search', function () {
        session()->forget('cart');
        return redirect()->route('staff.search_ticket_online');
    })->name('cart.clearAndRedirect');
});




Route::get('/', function () {
    // return response()->json(['message' => 'Backend OK']);
});
Route::get('/lich-chieu-phim', [HomeController::class, 'MovieShowtimes'])->name('Client.MovieShowtimes');
Route::get('/set-city/{city}', [HomeController::class, 'setCity'])->name('set.city');




Route::get('/mua-do-an', [CartController::class, 'showCart'])->name('cart');

Route::get('/cua-hang', [ComboController::class, 'getCombos'])->name('combo');
Route::get('/combo/{id}', [ComboController::class, 'show'])->name('combo.show');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart');

Route::post('/booking/food-only', [BookingController::class, 'storeFoodOnly'])->name('booking.foodOnly');




Route::post('/add-cart', [CartController::class, 'addToCart'])->name('cart.addCart');
// Route::post('/update-cart', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');


Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

// web.php
Route::get('/thong-tin-rap/{cinema_id}', [CinemaController::class, 'infoCinema'])->name('Client.infoCinema');

Route::get('/dat-ve', function () {
    return view('Client.booking.home');
});
Route::get('/he-thong-rap', [CinemaController::class, 'CinemaSystem'])->name('Client.cinemaSystem');
Route::get('/lich-chieu-rap', [CinemaController::class, 'listCinemas'])->name('Client.cinemaShowtime');
Route::get('/lich-chieu-rap/{cinema_id}', [HomeController::class, 'ShowtimesByCinema'])->name('Client.MovieShowtimesByCinema');


Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/', [HomeController::class, 'home'])->name('home');


Route::get('/dat-ve/{movie_id}', [HomeController::class, 'booking'])->name('Client.booking.home');
Route::get('/ajax/showtimes', [HomeController::class, 'ajaxShowtimes']);
Route::get('/ajax-showtimes-by-cinema', [HomeController::class, 'ajaxShowtimesByCinema'])->name('Client.ajaxShowtimesByCinema');
// web.php
Route::get('/ajax/showtime/{id}/seats-status', [HomeController::class, 'fetchSeatStatuses']);






Route::post('/login', [AuthController::class, 'login']);

Route::prefix('room')->name('rooms.')->group(function () {
    Route::get('/', [RoomController::class, 'index'])->name('index');
    Route::get('/create', [RoomController::class, 'create'])->name('create');
    Route::post('/store', [RoomController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [RoomController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [RoomController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [RoomController::class, 'delete'])->name('delete');
});
Route::prefix('showtime')->name('showtime.')->group(function () {
    Route::get('/', [ShowtimeController::class, 'index'])->name("index");
    Route::get('/create', [ShowtimeController::class, 'create'])->name('create');
    Route::post('/store', [ShowtimeController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [ShowtimeController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [ShowtimeController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [ShowtimeController::class, 'delete'])->name('delete');
});

Route::prefix('template')->name('template.')->group(function () {
    Route::get('/', [EmailTemplateController::class, 'index'])->name('index');
    Route::get('/create', [EmailTemplateController::class, 'create'])->name('create');
    Route::post('/store', [EmailTemplateController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [EmailTemplateController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [EmailTemplateController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [EmailTemplateController::class, 'delete'])->name('delete');
});

Route::prefix('booking')->name('booking.')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('index');
    Route::get('/create', [BookingController::class, 'create'])->name('create');
    Route::post('/store', [BookingController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [BookingController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [BookingController::class, 'update'])->name('update');
    Route::get('/show/{id}', [BookingController::class, 'show'])->name('show');
    Route::delete('/delete/{id}', [BookingController::class, 'delete'])->name('delete');
});

Route::prefix('mail')->name('mail.')->group(function () {
    Route::get('/send-form', [SendMailController::class, 'create'])->name('create');
    Route::post('/send-mail', [SendMailController::class, 'send'])->name('send');
});

Route::prefix('seat')->name('seat.')->group(function () {
    Route::get('/', [SeatController::class, 'index'])->name('index');
    Route::get('rooms/{room}/seats/edit', [SeatController::class, 'edit'])->name('edit');
    Route::post('rooms/{room}/seats/update', [SeatController::class, 'update'])->name('update');
});

Route::prefix('payos')->name('payos.')->group(function () {
    Route::get('/create-link/{amount}/{description}', [PayosController::class, 'createLink'])->name('create');
    Route::get('/return-link/{description}', [PayosController::class, 'returnPage'])->name('return');
});

Route::middleware('web')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/register/form', function () {
    return view('Client.auth');
})->name('register.form');
