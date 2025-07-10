<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Payment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaticController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'Sdate' => 'nullable|date',
            'Edate' => 'nullable|date|after_or_equal:Sdate',
            'cinema' => 'nullable|string',
        ]);

        // Set default date range (current month)
        $startDate = $validated['Sdate'] ?? Carbon::now()->startOfMonth()->toDateString();
        $endDate = $validated['Edate'] ?? Carbon::now()->endOfDay()->toDateString();

        // Get filter data
        $districts = Cinema::distinct('city')->pluck('city');
        $cinemas = Cinema::all();

        // Main statistics
        $stats = $this->getMainStatistics($startDate, $endDate);
        
        // Chart data
        $chartData = $this->getChartData($startDate, $endDate);

        return view('admin.static', array_merge(
            compact('cinemas', 'districts', 'startDate', 'endDate'),
            $stats,
            $chartData
        ));
    }

    protected function getMainStatistics($startDate, $endDate)
    {
        // Total revenue
        $totalRevenue = Payment::where('status', 'paid')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->sum('price_amount');

        // Highest revenue cinema
        $highestCinemaRevenue = $this->getCinemaRevenueQuery($startDate, $endDate)
            ->orderByDesc('total_revenue')
            ->first();

        // Top payment method
        $paymentStats = $this->getPaymentMethodStats($startDate, $endDate);
        $topPaymentMethod = $paymentStats->sortByDesc('count')->first();
        $percentagePayment = $paymentStats->sum('count') > 0 
            ? round(($topPaymentMethod->count / $paymentStats->sum('count')) * 100, 2)
            : 0;

        // Top movie
        $topMovie = $this->getMovieRevenueQuery($startDate, $endDate)
            ->orderByDesc('total_revenue')
            ->first();

        return [
            'totalRevenue' => $totalRevenue,
            'highestCinemaRevenue' => $highestCinemaRevenue,
            'topPaymentMethod' => $topPaymentMethod,
            'percentagePayment' => $percentagePayment,
            'topMovie' => $topMovie,
        ];
    }

    protected function getChartData($startDate, $endDate)
    {
        // Cinema revenue data
        $cinemaRevenue = $this->getCinemaRevenueQuery($startDate, $endDate)->get();

        // Movie revenue data (top 7)
        $movieRevenue = $this->getMovieRevenueQuery($startDate, $endDate)
            ->limit(7)
            ->get();

        // Payment methods data
        $paymentMethods = $this->getPaymentMethodStats($startDate, $endDate);
        $paymentLabels = $paymentMethods->pluck('payment_method');
        $paymentData = $paymentMethods->pluck('count');

        // Monthly revenue trend
        $monthlyRevenue = $this->getMonthlyRevenueTrend($startDate, $endDate);
        $monthlyLabels = $monthlyRevenue->pluck('month');
        $monthlyData = $monthlyRevenue->pluck('total');

        return [
            'cinemaRevenue' => $cinemaRevenue,
            'movieRevenue' => $movieRevenue,
            'paymentMethods' => $paymentMethods,
            'labels' => $paymentLabels,
            'data' => $paymentData,
            'labels2' => $monthlyLabels,
            'data2' => $monthlyData,
        ];
    }

    protected function getCinemaRevenueQuery($startDate, $endDate)
    {
        return Payment::join('bookings', 'payments.booking_id', '=', 'bookings.booking_id')
            ->join('booking_seats', 'bookings.booking_id', '=', 'booking_seats.booking_id')
            ->join('showtime_seats', 'booking_seats.showtime_seat_id', '=', 'showtime_seats.id')
            ->join('seats', 'showtime_seats.seat_id', '=', 'seats.seat_id')
            ->join('rooms', 'seats.room_id', '=', 'rooms.room_id')
            ->join('cinemas', 'rooms.cinema_id', '=', 'cinemas.cinema_id')
            ->where('payments.status', 'paid')
            ->whereBetween('payments.paid_at', [$startDate, $endDate])
            ->select(
                'cinemas.name as cinema_name', 
                DB::raw('SUM(payments.price_amount) as total_revenue')
            )
            ->groupBy('cinemas.name');
    }

    protected function getMovieRevenueQuery($startDate, $endDate)
    {
        return Payment::join('bookings', 'payments.booking_id', '=', 'bookings.booking_id')
            ->join('showtimes', 'bookings.showtime_id', '=', 'showtimes.showtime_id')
            ->join('movies', 'showtimes.movie_id', '=', 'movies.movie_id')
            ->where('payments.status', 'paid')
            ->whereBetween('payments.paid_at', [$startDate, $endDate])
            ->select(
                'movies.title', 
                DB::raw('SUM(payments.price_amount) as total_revenue')
            )
            ->groupBy('movies.title');
    }

    protected function getPaymentMethodStats($startDate, $endDate)
    {
        return Payment::where('status', 'paid')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->select(
                'payment_method', 
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('payment_method')
            ->get();
    }

    protected function getMonthlyRevenueTrend($startDate, $endDate)
    {
        // Create date period for all months in range
        $period = CarbonPeriod::create(
            Carbon::parse($startDate)->startOfMonth(),
            '1 month',
            Carbon::parse($endDate)->endOfMonth()
        );

        // Get actual revenue data
        $monthlyRevenue = Payment::selectRaw("
                DATE_FORMAT(paid_at, '%Y-%m') as month_key,
                DATE_FORMAT(paid_at, '%b') as month, 
                SUM(price_amount) as total
            ")
            ->where('status', 'paid')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->groupBy('month_key', 'month')
            ->orderBy('month_key')
            ->get()
            ->keyBy('month_key');

        // Fill in missing months with 0 values
        $results = collect();
        foreach ($period as $date) {
            $monthKey = $date->format('Y-m');
            $monthName = $date->format('M');
            
            $results->push([
                'month_key' => $monthKey,
                'month' => $monthName,
                'total' => $monthlyRevenue->has($monthKey) 
                    ? $monthlyRevenue->get($monthKey)->total 
                    : 0
            ]);
        }

        return $results;
    }
}   