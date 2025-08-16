<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cinema;
use App\Models\Payment;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Review;
use App\Models\Showtime;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Payment::where('status', 'paid')
            ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->sum('price_amount');

        $currentMonthRevenue = Payment::where('status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('price_amount');

        $lastMonthRevenue = Payment::where('status', 'paid')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('price_amount');

        $change = 0;
        if ($lastMonthRevenue > 0) {
            $change = (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        }

        $totalCinemas = Cinema::count();
        $activeCinemas = Cinema::where('status', 'active')->count();
        $activePercent = $totalCinemas > 0 ? ($activeCinemas / $totalCinemas) * 100 : 0;

        $currentMonthInvoices = Payment::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonthInvoices = Payment::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $invoiceChange = 0;
        if ($lastMonthInvoices > 0) {
            $invoiceChange = (($currentMonthInvoices - $lastMonthInvoices) / $lastMonthInvoices) * 100;
        }

        $revenues = Payment::where('paid_at', '>=', Carbon::now()->subDays(7))
            ->where('status', 'paid')
            ->selectRaw("DATE_FORMAT(paid_at, '%d/%m') as date, SUM(price_amount) as total")
            ->groupBy('date')
            ->orderByRaw("STR_TO_DATE(date, '%d/%m')")
            ->get();

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
            'totalRevenue' => $totalRevenue,
            'revenueChange' => $change,
            'totalCinemas' => $totalCinemas,
            'activeCinemas' => $activeCinemas,
            'activePercent' => $activePercent,
            'currentMonthInvoices' => $currentMonthInvoices,
            'invoiceChange' => $invoiceChange,
            'revenues' => $revenues,
            'genresstart' => $genresstart,
            'showtime' => $showtime,
            'movie' => $movies,
            'moviesByGenre' => $moviesByGenre,
            'averageRatings' => $averageRatings
        ]);
    }
}
