<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Cinema;
use App\Models\Showtime;
use Carbon\Carbon;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;



class BookingController extends Controller
{
    public function step1(Request $request)
{
    $movie = Movie::with('genre')->findOrFail($request->movie_id);
    $movie_id = $movie->movie_id;

    $cinemas = Cinema::with(['rooms.showtimes' => function ($query) use ($movie_id) {
        $query->where('movie_id', $movie_id)
              ->where('date', '>=', Carbon::today())
              ->orderBy('date')
              ->orderBy('start_time');
    }])->whereHas('rooms.showtimes', function ($query) use ($movie_id) {
        $query->where('movie_id', $movie_id)
              ->where('date', '>=', Carbon::today());
    })->get();

    return view('staff.booking1', compact('movie', 'cinemas'));
}

public function print($id)
{
        $booking = Booking::with([
            'user',
            'showtime.movie',
            'showtime.room.cinema',
            'foods',
            'bookingSeats.showtimeSeat.seat'
        ])->findOrFail($id);


    $pdf = Pdf::loadView('pdf.ticket', compact('booking'));
    return $pdf->download('ve-xem-phim-' . $booking->booking_code . '.pdf');
}

    public function step2(Request $request)
    {
        // Logic xử lý tiếp theo
        return view('staff.booking2');
    }
}