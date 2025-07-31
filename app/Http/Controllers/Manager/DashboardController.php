<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('Sdate') ? Carbon::parse($request->input('Sdate')) : now()->startOfMonth();
        $endDate = $request->input('Edate') ? Carbon::parse($request->input('Edate')) : now();

        $managerId = Auth::user()->user_id;

        $cinemaId = DB::table('manager_cinema')
            ->where('user_id', $managerId)
            ->value('cinema_id');

        $cinemaName = null;
        if ($cinemaId) {
            $cinemaName = DB::table('cinemas')->where('cinema_id', $cinemaId)->value('name');
        }

        $paymentQuery = DB::table('payments')
            ->join('bookings', 'bookings.booking_id', '=', 'payments.booking_id')
            ->join('showtimes', 'showtimes.showtime_id', '=', 'bookings.showtime_id')
            ->join('movies', 'movies.movie_id', '=', 'showtimes.movie_id')
            ->join('rooms', 'rooms.room_id', '=', 'showtimes.room_id')
            ->join('cinemas', 'cinemas.cinema_id', '=', 'rooms.cinema_id')
            ->whereBetween('payments.created_at', [$startDate, $endDate]);

        if ($cinemaId) {
            $paymentQuery->where('cinemas.cinema_id', $cinemaId);
        }

        $totalRevenue = (clone $paymentQuery)->sum('payments.price_amount');

        $topMovie = DB::table('payments')
            ->join('bookings', 'bookings.booking_id', '=', 'payments.booking_id')
            ->join('showtimes', 'showtimes.showtime_id', '=', 'bookings.showtime_id')
            ->join('movies', 'movies.movie_id', '=', 'showtimes.movie_id')
            ->whereBetween('payments.created_at', [$startDate, $endDate])
            ->select('movies.title', DB::raw('COUNT(*) as ticket_count'))
            ->groupBy('movies.movie_id', 'movies.title')
            ->orderByDesc('ticket_count')
            ->first();

        $methodStats = (clone $paymentQuery)
            ->select('payments.payment_method', DB::raw('COUNT(*) as count'))
            ->groupBy('payments.payment_method')
            ->orderByDesc('count')
            ->get();

        $totalCount = $methodStats->sum('count');

        $topPaymentMethod = $methodStats->map(function ($item) use ($totalCount) {
            $item->percentage = round($item->count / max($totalCount, 1) * 100, 1);
            return $item;
        })->first();

        $trend = (clone $paymentQuery)
            ->select(DB::raw('DATE(payments.created_at) as date'), DB::raw('SUM(payments.price_amount) as total'))
            ->groupBy(DB::raw('DATE(payments.created_at)'))
            ->orderBy('date')
            ->get();

        $trendLabels = $trend->pluck('date');
        $trendData = $trend->pluck('total');

        $genrebution = (clone $paymentQuery)
            ->join('genres', 'genres.genre_id', '=', 'movies.genre_id')
            ->select('genres.genre_name as genre', DB::raw('SUM(payments.price_amount) as revenue'))
            ->groupBy('genres.genre_id', 'genres.genre_name')
            ->orderByDesc('revenue')
            ->get();

        $genrebutionLabels = $genrebution->pluck('genre');
        $genrebutionData = $genrebution->pluck('revenue');

        $topMovies = DB::table('payments')
            ->join('bookings', 'bookings.booking_id', '=', 'payments.booking_id')
            ->join('showtimes', 'showtimes.showtime_id', '=', 'bookings.showtime_id')
            ->join('movies', 'movies.movie_id', '=', 'showtimes.movie_id')
            ->whereBetween('payments.created_at', [$startDate, $endDate])
            ->select(
                'movies.title',
                DB::raw('SUM(payments.price_amount) as revenue'),
                DB::raw('COUNT(*) as ticket_count')
            )
            ->groupBy('movies.movie_id', 'movies.title')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        return view('manager.dashboard', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalRevenue' => $totalRevenue,
            'topMovie' => $topMovie,
            'topPaymentMethod' => $topPaymentMethod,
            'trendLabels' => $trendLabels,
            'trendData' => $trendData,
            'genrebutionLabels' => $genrebutionLabels,
            'genrebutionData' => $genrebutionData,
            'topMovies' => $topMovies,
            'cinemaName' => $cinemaName,
        ]);
    }
}
