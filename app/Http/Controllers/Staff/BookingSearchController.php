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

    $bookings = Booking::with(['user', 'showtime.movie', 'bookingFoods.food'])
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
                    })
                    ->orWhereHas('bookingFoods.food', function ($q6) use ($query) {
                        $q6->where('name', 'LIKE', "%$query%");
                    });
            });
        })
        ->where(function ($q) use ($cinema_id) {
            $q->whereHas('showtime.room.cinema', function ($q2) use ($cinema_id) {
                $q2->where('cinema_id', $cinema_id);
            })
            ->orWhereHas('bookingFoods.food', function ($q3) use ($cinema_id) {
                $q3->where('cinema_id', $cinema_id);
            });
        })
        ->where('booking_status', 'confirmed')
        ->latest()
        ->paginate(10);

    return view('staff.search_ticket_online', compact('bookings', 'query'));
}







}