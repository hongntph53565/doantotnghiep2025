<?php

namespace App\Http\Controllers\Staff;


use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingSearchController extends Controller
{


public function search(Request $request)
{
    $query = Booking::with(['user', 'showtime.movie']);

    // Tìm theo số ghế
    if ($request->filled('booking_id')) {
        $query->where('booking_id', 'like' . $request->booking_id);
    }



    // Tìm theo tên người đặt
    if ($request->filled('last_name')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('last_name', 'like', '%' . $request->last_name . '%');
        });
    }

    // Tìm theo tên phim
    if ($request->filled('movie_title')) {
        $query->whereHas('showtime.movie', function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->title . '%');
        });
    }

    // Tìm theo ngày chiếu
    if ($request->filled('show_date')) {
        $query->whereHas('showtime', function ($q) use ($request) {
            $q->whereDate('date', $request->show_date);
        });
    }

    $bookings = $query->paginate(10);

    return view('bookings.index', compact('bookings'));
}




}
