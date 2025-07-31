<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaticController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('Sdate')
            ? Carbon::parse($request->input('Sdate'))->startOfDay()
            : Carbon::now()->startOfMonth();

        $endDate = $request->input('Edate')
            ? Carbon::parse($request->input('Edate'))->endOfDay()
            : Carbon::now()->endOfDay();

        $paymentQuery = Payment::query()
            ->join('bookings', 'bookings.booking_id', '=', 'payments.booking_id')
            ->join('showtimes', 'showtimes.showtime_id', '=', 'bookings.showtime_id')
            ->join('rooms', 'rooms.room_id', '=', 'showtimes.room_id')
            ->join('cinemas', 'cinemas.cinema_id', '=', 'rooms.cinema_id')
            ->join('movies', 'movies.movie_id', '=', 'showtimes.movie_id')
            ->whereBetween('payments.created_at', [$startDate, $endDate]);

        $totalRevenue = (clone $paymentQuery)->sum('payments.price_amount');

        $highestCinemaRevenue = (clone $paymentQuery)
            ->select('cinemas.name as cinema_name', DB::raw('SUM(payments.price_amount) as total_revenue'))
            ->groupBy('cinemas.cinema_id', 'cinemas.name')
            ->orderByDesc('total_revenue')
            ->first();

        $topMovie = (clone $paymentQuery)
            ->select('movies.title', DB::raw('SUM(payments.price_amount) as total_revenue'))
            ->groupBy('movies.movie_id', 'movies.title')
            ->orderByDesc('total_revenue')
            ->first();

        $topPaymentMethod = (clone $paymentQuery)
            ->select('payments.payment_method', DB::raw('COUNT(*) as count'))
            ->groupBy('payments.payment_method')
            ->orderByDesc('count')
            ->first();

        $totalPayments = (clone $paymentQuery)->count();
        $percentage = $topPaymentMethod && $totalPayments > 0
            ? round(($topPaymentMethod->count / $totalPayments) * 100, 1)
            : 0;

        $cinemaRevenue = (clone $paymentQuery)
            ->select('cinemas.name as cinema_name', DB::raw('SUM(payments.price_amount) as total_revenue'))
            ->groupBy('cinemas.cinema_id', 'cinemas.name')
            ->orderByDesc('total_revenue')
            ->get();

        $movieRevenue = (clone $paymentQuery)
            ->select('movies.title', DB::raw('SUM(payments.price_amount) as total_revenue'))
            ->groupBy('movies.movie_id', 'movies.title')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();

        $monthlyRevenue = (clone $paymentQuery)
            ->select(DB::raw("DATE_FORMAT(payments.created_at, '%Y-%m') as month"), DB::raw('SUM(payments.price_amount) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = $monthlyRevenue->pluck('month');
        $data = $monthlyRevenue->pluck('total');

        $paymentByMethod = (clone $paymentQuery)
            ->select('payments.payment_method', DB::raw('SUM(payments.price_amount) as revenue'))
            ->groupBy('payments.payment_method')
            ->orderByDesc('revenue')
            ->get();

        $plabels = $paymentByMethod->pluck('payment_method');
        $pdata = $paymentByMethod->pluck('revenue');

        $cinemas = Cinema::select('name', 'district')->get();
        $districts = $cinemas->pluck('district')->unique()->values();

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
            'cinemas',
            'districts'
        ));
    }
}
