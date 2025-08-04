<?php

namespace App\Http\Controllers\Staff;


use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingSearchController extends Controller
{



public function search(Request $request)
{
    $query = $request->input('query');

    $bookings = Booking::with(['user', 'showtime.movie'])
        ->where(function ($q) use ($query) {
            $q->where('booking_code', 'LIKE', "%$query%")
              ->orWhereHas('user', function ($q2) use ($query) {
                  $q2->where('full_name', 'LIKE', "%$query%");
              })
              ->orWhereHas('showtime', function ($q3) use ($query) {
                  $q3->where('date', 'LIKE', "%$query%");
              })
              ->orWhereHas('showtime.movie', function ($q4) use ($query) {
                  $q4->where('title', 'LIKE', "%$query%");
              });
        })
        ->get();

    return view('staff.search_ticket_online', compact('bookings'));
}





}
