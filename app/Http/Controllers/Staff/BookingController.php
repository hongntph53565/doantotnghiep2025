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
// use Milon\Barcode\Facades\DNS1D;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;
use Milon\Barcode\DNS2D;





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



public function printView($id)
{
    $booking = Booking::with([
        'user',
        'showtime.movie',
        'showtime.room.cinema',
        'foods',
        'bookingSeats.showtimeSeat.seat'
    ])->findOrFail($id);

    $cinema = $booking->showtime->room->cinema ?? null;

    $dns2d = new DNS2D();
    $dns2d->setStorPath(public_path('cache/'));

    $barcode = base64_encode(
        $dns2d->getBarcodePNG($booking->booking_code, 'QRCODE', 8, 8)
    );

    return view('pdf.ticket', compact('booking', 'barcode', 'cinema'));
}


    public function step2(Request $request)
    {
        // Logic xử lý tiếp theo
        return view('staff.booking2');
    }
}