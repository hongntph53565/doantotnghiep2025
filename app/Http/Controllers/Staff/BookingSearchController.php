<?php

namespace App\Http\Controllers\Staff;


use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingSearchController extends Controller
{


// public function search(Request $request)
// {
//     $query = Booking::with(['user', 'showtime.movie']);

//     // Tìm theo số ghế
//     if ($request->filled('booking_code')) {
//         $query->where('booking_code', 'like' . $request->booking_code);
//     }



//     // Tìm theo tên người đặt
//     if ($request->filled('last_name')) {
//         $query->whereHas('user', function ($q) use ($request) {
//             $q->where('last_name', 'like', '%' . $request->last_name . '%');
//         });
//     }

//     // Tìm theo tên phim
//     if ($request->filled('movie_title')) {
//         $query->whereHas('showtime.movie', function ($q) use ($request) {
//             $q->where('title', 'like', '%' . $request->title . '%');
//         });
//     }

//     // Tìm theo ngày chiếu
//     if ($request->filled('show_date')) {
//         $query->whereHas('showtime', function ($q) use ($request) {
//             $q->whereDate('date', $request->show_date);
//         });
//     }

//     $bookings = $query->paginate(10);

//     return view('staff.search_ticket_online', compact('bookings'));
// }

public function search(Request $request)
{
    $query = $request->input('query');

    $bookings = Booking::with(['user', 'showtime.movie'])
        ->where(function ($q) use ($query) {
            $q->where('booking_code', 'LIKE', "%$query%")
              ->orWhereHas('user', function ($q2) use ($query) {
                  $q2->where('last_name', 'LIKE', "%$query%");
              })
              ->orWhereHas('showtime', function ($q3) use ($query) {
                  $q3->where('show_date', 'LIKE', "%$query%");
              })
              ->orWhereHas('showtime.movie', function ($q4) use ($query) {
                  $q4->where('title', 'LIKE', "%$query%");
              });
        })
        ->get();

    return view('staff.search_ticket_online', compact('bookings'));
}





}
