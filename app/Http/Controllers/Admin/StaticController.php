<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaticController extends Controller
{
    public function index(Request $request)
    {
        // --- Lấy dữ liệu bộ lọc ---
        $startDate = $request->input('Sdate')
            ? Carbon::parse($request->input('Sdate'))->startOfDay()
            : Carbon::now()->startOfMonth();

        $endDate = $request->input('Edate')
            ? Carbon::parse($request->input('Edate'))->endOfDay()
            : Carbon::now()->endOfDay();

        $cinemaId = $request->input('cinema_id');
        $movieId  = $request->input('movie_id');
        $city     = $request->input('city');

        // --- Query gốc áp dụng bộ lọc ---
        $paymentQuery = Payment::query()
            ->leftJoin('bookings', 'bookings.booking_id', '=', 'payments.booking_id')
            ->leftJoin('showtimes', 'showtimes.showtime_id', '=', 'bookings.showtime_id')
            ->leftJoin('rooms', 'rooms.room_id', '=', 'showtimes.room_id')
            ->leftJoin('cinemas', 'cinemas.cinema_id', '=', 'rooms.cinema_id')
            ->leftJoin('movies', 'movies.movie_id', '=', 'showtimes.movie_id')
            ->where('payments.status', 'paid')
            ->whereBetween('payments.created_at', [$startDate, $endDate]);

        if ($cinemaId) {
            $paymentQuery->where('cinemas.cinema_id', $cinemaId);
        }
        if ($movieId) {
            $paymentQuery->where('movies.movie_id', $movieId);
        }
        if ($city) {
            $paymentQuery->where('cinemas.city', $city);
        }

        // --- Tổng doanh thu ---
        $totalRevenue = (clone $paymentQuery)->sum('payments.price_amount');

        // --- Rạp doanh thu cao nhất ---
        $highestCinemaRevenue = (clone $paymentQuery)
            ->select('cinemas.name as cinema_name', DB::raw('SUM(payments.price_amount) as total_revenue'))
            ->groupBy('cinemas.cinema_id', 'cinemas.name')
            ->orderByDesc('total_revenue')
            ->first();

        // --- Phim doanh thu cao nhất ---
        $topMovie = (clone $paymentQuery)
            ->select('movies.title','movies.poster', DB::raw('SUM(payments.price_amount) as total_revenue'))
            ->groupBy('movies.movie_id', 'movies.title')
            ->orderByDesc('total_revenue')
            ->first();

        // --- Phương thức thanh toán phổ biến ---
        $topPaymentMethod = (clone $paymentQuery)
            ->select('payments.payment_method', DB::raw('COUNT(*) as count'))
            ->groupBy('payments.payment_method')
            ->orderByDesc('count')
            ->first();

        $totalPayments = (clone $paymentQuery)->count();
        $percentage = $topPaymentMethod && $totalPayments > 0
            ? round(($topPaymentMethod->count / $totalPayments) * 100, 1)
: 0;

        // --- Doanh thu theo rạp ---
        $cinemaRevenue = (clone $paymentQuery)
            ->select('cinemas.name as cinema_name', DB::raw('SUM(payments.price_amount) as total_revenue'))
            ->groupBy('cinemas.cinema_id', 'cinemas.name')
            ->orderByDesc('total_revenue')
            ->get();

        // --- Doanh thu theo phim ---
        $movieRevenue = (clone $paymentQuery)
            ->select('movies.title', DB::raw('SUM(payments.price_amount) as total_revenue'))
            ->groupBy('movies.movie_id', 'movies.title')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();
        
        $topFoodQuery = DB::table('booking_food')
    ->join('foods', 'foods.food_id', '=', 'booking_food.food_id')
    ->join('bookings', 'bookings.booking_id', '=', 'booking_food.booking_id')
    ->leftJoin('showtimes', 'showtimes.showtime_id', '=', 'bookings.showtime_id') // <= đổi thành leftJoin
    ->leftJoin('rooms', 'rooms.room_id', '=', 'showtimes.room_id')
    ->leftJoin('cinemas', 'cinemas.cinema_id', '=', 'rooms.cinema_id')
    ->whereBetween('bookings.created_at', [$startDate, $endDate]);

if ($cinemaId) {
    $topFoodQuery->where('cinemas.cinema_id', $cinemaId);
}
if ($city) {
    $topFoodQuery->where('cinemas.city', $city);
}
if ($movieId) {
    $topFoodQuery->where('showtimes.movie_id', $movieId);
}

$topFood = $topFoodQuery
    ->select(
        'foods.name',
        'foods.image',
        DB::raw('SUM(booking_food.quantity) as total_quantity'),
        DB::raw('SUM(booking_food.price * booking_food.quantity) as total_revenue')
    )
    ->groupBy('foods.food_id', 'foods.name', 'foods.image')
    ->orderByDesc('total_quantity')
    ->first();

        // --- Doanh thu theo tháng ---
        $monthlyRevenue = (clone $paymentQuery)
            ->select(DB::raw("DATE_FORMAT(payments.created_at, '%Y-%m') as month"), DB::raw('SUM(payments.price_amount) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        $labels = $monthlyRevenue->pluck('month');
        $data   = $monthlyRevenue->pluck('total');

        // --- Doanh thu theo phương thức thanh toán ---
        $paymentByMethod = (clone $paymentQuery)
            ->select('payments.payment_method', DB::raw('SUM(payments.price_amount) as revenue'))
            ->groupBy('payments.payment_method')
            ->orderByDesc('revenue')
            ->get();
        $plabels = $paymentByMethod->pluck('payment_method');
        $pdata   = $paymentByMethod->pluck('revenue');

        $payosRevenue = (clone $paymentQuery)
    ->where('payments.payment_method', 'payos')
    ->sum('payments.price_amount');

    $vnpayRevenue = (clone $paymentQuery)
    ->where('payments.payment_method', 'vnpay')
    ->sum('payments.price_amount');

$zalopayRevenue = (clone $paymentQuery)
    ->where('payments.payment_method', 'zalopay')
    ->sum('payments.price_amount');

$cashRevenue = (clone $paymentQuery)
    ->where('payments.payment_method', 'cash')
    ->sum('payments.price_amount');

        // --- Danh sách cho bộ lọc ---
        $cities  = Cinema::distinct()->pluck('city');
        $cinemas = Cinema::all();
        $movies  = Movie::all();

        // --- Trả dữ liệu ra view ---
        return view('admin.static', compact(
            'startDate',
            'endDate',
            'totalRevenue',
            'highestCinemaRevenue',
            'topMovie',
            'topPaymentMethod',
            'percentage',
            'cinemaRevenue',
            'movieRevenue',
            'labels',
            'data',
            'plabels',
            'pdata',
            'cities',
            'cinemas',
            'movies',
             'topFood',
             'payosRevenue',
             'vnpayRevenue',
             'zalopayRevenue',
             'cashRevenue'
        ));
    }
}
