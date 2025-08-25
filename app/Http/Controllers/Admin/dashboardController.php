<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cinema;
use App\Models\Payment;
use App\Models\BookingSeat;
use App\Models\Movie;
use App\Models\User;
use App\Models\Genre;
use App\Models\Review;
use App\Models\Showtime;
use App\Models\ShowtimeSeat;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Doanh thu
        $currentMonthRevenue = Payment::where('status', 'paid')
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->sum('price_amount');

        $lastMonthRevenue = Payment::where('status', 'paid')
            ->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])
            ->sum('price_amount');

        $revenueChange = $lastMonthRevenue > 0
            ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
            : 100;

        // Vé
        $currentMonthTickets = BookingSeat::whereHas('booking', function ($q) {
            $q->where('payment_status', 'paid')
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
        })->count();

        $lastMonthTickets = BookingSeat::whereHas('booking', function ($q) {
            $q->where('payment_status', 'paid')
                ->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()]);
        })->count();

        $ticketChange = $lastMonthTickets > 0
            ? (($currentMonthTickets - $lastMonthTickets) / $lastMonthTickets) * 100
            : 100;

        // Khách hàng
        $currentMonthCustomers = User::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
        $lastMonthCustomers    = User::whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->count();

        $customerChange = $lastMonthCustomers > 0
            ? (($currentMonthCustomers - $lastMonthCustomers) / $lastMonthCustomers) * 100
            : 100;

        // Suất chiếu
        $currentMonthShowtimes = Showtime::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
        $lastMonthShowtimes    = Showtime::whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->count();

        $showtimeChange = $lastMonthShowtimes > 0
            ? (($currentMonthShowtimes - $lastMonthShowtimes) / $lastMonthShowtimes) * 100
            : 100;


        $genresstart = Genre::select('genre_name')
            ->selectRaw('COUNT(movies.movie_id) as movie_count')
            ->leftJoin('movies', 'genres.genre_id', '=', 'movies.genre_id')
->groupBy('genres.genre_id', 'genres.genre_name')
            ->get();

        $showtime = Showtime::selectRaw('HOUR(start_time) as hour, COUNT(*) as total')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        $movies = Movie::with('genre')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
        $moviesByGenre = $movies->groupBy(fn($movie) => $movie->genre->genre_name);

        $averageRatings = Review::selectRaw('movie_id, AVG(rating) as average_rating')
            ->where('status', 'active')
            ->groupBy('movie_id')
            ->pluck('average_rating', 'movie_id');

        return view('admin.dashboard', [
            'currentMonthRevenue' => $currentMonthRevenue,
            'revenueChange' => $revenueChange,
            'currentMonthTickets' => $currentMonthTickets,
            'ticketChange' => $ticketChange,
            'currentMonthCustomers' => $currentMonthCustomers,
            'customerChange' => $customerChange,
            'currentMonthShowtimes' => $currentMonthShowtimes,
            'showtimeChange'        => $showtimeChange,
            'genresstart' => $genresstart,
            'showtime' => $showtime,
            'movie' => $movies,
            'moviesByGenre' => $moviesByGenre,
            'averageRatings' => $averageRatings
        ]);
    }
    public function getRevenueData(Request $request)
    {
        $year = $request->input('year', now()->year);

        // Lấy doanh thu theo từng tháng
        $revenues = Payment::selectRaw('MONTH(created_at) as month, SUM(price_amount) as total')
            ->where('status', 'paid')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Chuẩn hóa đủ 12 tháng
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthRevenue = $revenues->firstWhere('month', $i);
            $monthlyData[] = [
                'month' => $i,
                'total' => $monthRevenue ? $monthRevenue->total : 0,
            ];
        }

        // Tổng doanh thu cả năm
        $total = Payment::where('status', 'paid')
            ->whereYear('created_at', $year)
            ->sum('price_amount');

        return response()->json([
            'monthly' => $monthlyData,
            'total'   => $total
        ]);
    }
    public function getSeatTypeStats()
    {
        $stats = DB::table('showtime_seats as ss')
            ->join('seats as s', 'ss.seat_id', '=', 's.seat_id') // sửa lại seat_id
            ->join('seat_types as st', 's.seat_type_id', '=', 'st.seat_type_id')
            ->select('st.name as seat_type', DB::raw('COUNT(*) as total'))
            ->where('ss.status', 'booked')
            ->groupBy('st.name')
            ->get();
        return response()->json($stats);
    }
}