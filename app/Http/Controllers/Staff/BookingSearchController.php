<?php

namespace App\Http\Controllers\Staff;


use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class BookingSearchController extends Controller
{



public function search(Request $request)
{
    $query = $request->input('query');
    $user = Auth::user();
    $cinema_id = $user->cinema_id;
    $bookings = Booking::with(['user', 'showtime.movie'])
    ->when($query, function ($q) use ($query) {
        $q->where(function ($q2) use ($query) {
            $q2->where('booking_code', 'LIKE', "%$query%")
               ->orWhereHas('user', function ($q3) use ($query) {
                   $q3->where('full_name', 'LIKE', "%$query%");
               })
               ->orWhereHas('showtime', function ($q4) use ($query) {
                   $q4->where('date', 'LIKE', "%$query%");
               })
               ->orWhereHas('showtime.movie', function ($q5) use ($query) {
                   $q5->where('title', 'LIKE', "%$query%");
               });
        });
    })
    ->whereHas('showtime.room.cinema', function ($q) use ($cinema_id) {
        $q->where('cinema_id', $cinema_id);
    })
    ->where('booking_status', 'confirmed')
    ->latest()
    ->paginate(10);
 // hoặc ->get() nếu không cần phân trang

    return view('staff.search_ticket_online', compact('bookings', 'query'));
}







}