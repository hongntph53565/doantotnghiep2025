<?php

// namespace App\Http\Controllers\Manager;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use App\Models\Cinema;
// use App\Models\Payment;
// use App\Models\Movie;
// use App\Models\Genre;
// use App\Models\Review;
// use App\Models\Showtime;
// use Carbon\Carbon;
// use Carbon\CarbonPeriod;
// use Illuminate\Support\Arr;
// use Illuminate\Support\Facades\DB;

// class DashboardController extends Controller
// {
// public function index(Request $request)
// {
//     $manager = auth()->user(); // assuming user is authenticated manager
//     $cinemas = $manager->cinemas; // Quan hệ: 1 manager có nhiều rạp

//     if ($cinemas->isEmpty()) {
//         abort(403, 'Bạn không có quyền xem thống kê vì chưa được phân rạp.');
//     }

//     // Ngày bắt đầu và kết thúc
//     $startDate = $request->filled('start_date')
//         ? Carbon::parse($request->start_date)->startOfDay()
//         : now()->startOfMonth();

//     $endDate = $request->filled('end_date')
//         ? Carbon::parse($request->end_date)->endOfDay()
//         : now();

//     $cinemaIds = $cinemas->pluck('id');

//     // Tổng doanh thu
//     $totalRevenue = DB::table('tickets')
//         ->whereBetween('created_at', [$startDate, $endDate])
//         ->whereIn('cinema_id', $cinemaIds)
//         ->sum('price');

//     // Top cinema theo doanh thu
//     $topCinema = DB::table('tickets')
//         ->select('cinema_id', DB::raw('SUM(price) as total_revenue'))
//         ->whereBetween('created_at', [$startDate, $endDate])
//         ->whereIn('cinema_id', $cinemaIds)
//         ->groupBy('cinema_id')
//         ->orderByDesc('total_revenue')
//         ->first();

//     $topCinemaModel = $topCinema ? Cinema::find($topCinema->cinema_id) : null;

//     // Phim bán chạy
//     $topMovie = DB::table('tickets')
//         ->select('movie_id', DB::raw('COUNT(*) as ticket_count'))
//         ->whereBetween('created_at', [$startDate, $endDate])
//         ->whereIn('cinema_id', $cinemaIds)
//         ->groupBy('movie_id')
//         ->orderByDesc('ticket_count')
//         ->first();

//     $topMovieModel = $topMovie ? Movie::find($topMovie->movie_id) : null;

//     // Phương thức thanh toán phổ biến
//     $topPayment = DB::table('payments')
//         ->select('method', DB::raw('COUNT(*) as total'))
//         ->whereBetween('created_at', [$startDate, $endDate])
//         ->groupBy('method')
//         ->orderByDesc('total')
//         ->first();

//     $totalPayments = DB::table('payments')
//         ->whereBetween('created_at', [$startDate, $endDate])
//         ->count();

//     if ($topPayment) {
//         $topPayment->percentage = $totalPayments > 0
//             ? round($topPayment->total / $totalPayments * 100, 1)
//             : 0;
//     }

//     // Xu hướng doanh thu theo ngày
//     $trendLabels = [];
//     $trendData = [];

//     $period = CarbonPeriod::create($startDate, $endDate);
//     foreach ($period as $date) {
//         $trendLabels[] = $date->format('d/m');
//         $revenue = DB::table('tickets')
//             ->whereDate('created_at', $date)
//             ->whereIn('cinema_id', $cinemaIds)
//             ->sum('price');
//         $trendData[] = $revenue;
//     }

//     // Phân bổ doanh thu theo rạp
//     $distributionLabels = [];
//     $distributionData = [];

//     foreach ($cinemas as $cinema) {
//         $revenue = DB::table('tickets')
//             ->where('cinema_id', $cinema->id)
//             ->whereBetween('created_at', [$startDate, $endDate])
//             ->sum('price');

//         if ($revenue > 0) {
//             $distributionLabels[] = $cinema->name;
//             $distributionData[] = $revenue;
//         }
//     }

//     // Top 10 phim
//     $topMovies = DB::table('tickets')
//         ->select('movie_id', DB::raw('SUM(price) as revenue'), DB::raw('COUNT(*) as ticket_count'))
//         ->whereBetween('created_at', [$startDate, $endDate])
//         ->whereIn('cinema_id', $cinemaIds)
//         ->groupBy('movie_id')
//         ->orderByDesc('revenue')
//         ->limit(10)
//         ->get()
//         ->map(function ($item) {
//             $movie = Movie::find($item->movie_id);
//             $item->title = $movie->title ?? 'N/A';
//             return $item;
//         });

//     return view('manager.dashboard.index', [
//         'startDate' => $startDate,
//         'endDate' => $endDate,
//         'cinemas' => $cinemas,
//         'totalRevenue' => $totalRevenue,
//         'topCinema' => $topCinemaModel,
//         'topMovie' => $topMovieModel,
//         'topPaymentMethod' => $topPayment,
//         'trendLabels' => $trendLabels,
//         'trendData' => $trendData,
//         'distributionLabels' => $distributionLabels,
//         'distributionData' => $distributionData,
//         'topMovies' => $topMovies,
//     ]);
// }
// }
