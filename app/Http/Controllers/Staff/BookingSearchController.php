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
        ->where('booking_status', 'confirmed')
        ->latest()
        ->paginate(10); // hoặc ->get() nếu không cần phân trang

    return view('staff.search_ticket_online', compact('bookings', 'query'));
}








}