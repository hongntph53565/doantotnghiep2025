<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Movie;
use App\Models\Cinema;
use App\Models\Room;

class BillController extends Controller
{
  public function index(Request $request)
  {
    // Query cơ bản
    $query = Booking::with(['user', 'showtime.movie', 'showtime.room.cinema', 'seats'])
      ->where('payment_status', 'paid');

    // Filter theo city
    if ($request->city) {
      $query->whereHas('showtime.room.cinema', function ($q) use ($request) {
        $q->where('cinemas.city', $request->city);
      });
    }

    // Filter theo cinema
    if ($request->cinema) {
      $query->whereHas('showtime.room.cinema', function ($q) use ($request) {
        $q->where('cinemas.cinema_id', $request->cinema);
      });
    }
    if ($request->room) {
      $query->whereHas('showtime', function ($q) use ($request) {
        $q->where('room_id', $request->room);
      });
    }
    // Filter theo movie
    if ($request->movie) {
      $query->whereHas('showtime.movie', function ($q) use ($request) {
        $q->where('movies.movie_id', $request->movie);
      });
    }

    // Filter theo date
    if ($request->date) {
      $query->whereHas('showtime', function ($q) use ($request) {
        $q->whereDate('date', $request->date);
      });
    }

    // Filter theo trạng thái vé
    if ($request->status) {
      if ($request->status === 'printed') {
        $query->where('printed_count', '>', 0);
      } elseif ($request->status === 'not_printed') {
        $query->where('printed_count', 0);
      }
    }

    // Search theo booking code, user, movie
    $search = $request->input('search');
    if (!empty($search)) {
      $query->where(function ($q) use ($search) {
        $q->where('booking_code', 'like', "%$search%")
          ->orWhereHas('user', function ($q2) use ($search) {
            $q2->where('full_name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%");
          })
          ->orWhereHas('showtime.movie', function ($q3) use ($search) {
            $q3->where('title', 'like', "%$search%");
          })
          ->orWhereHas('showtime.room', function ($q4) use ($search) {
            $q4->where('room_name', 'like', "%$search%");
          });
      });
    }


    $bookings = $query->latest()->paginate(10);

    // Danh sách city
    $cities = Cinema::select('city')->distinct()->get();

    // Danh sách rạp theo city đã chọn hoặc tất cả
    $selectedCinemas = $request->city
      ? Cinema::where('city', $request->city)->get()
      : Cinema::all();
    // Danh sách phòng theo cinema đã chọn hoặc tất cả
    $selectedRooms = $request->cinema
      ? Room::where('cinema_id', $request->cinema)->get()
      : Room::all();

        // Danh sách phim theo cinema đã chọn hoặc tất cả
       $selectedMovies = $request->cinema
    ? Movie::withTrashed()->whereHas('showtimes.room', function($q) use ($request) {
        $q->where('cinema_id', $request->cinema);
    })->get()
    : Movie::withTrashed()->get();

        return view('admin.list.bill', compact(
            'bookings', 'cities', 'selectedCinemas', 'selectedMovies', 'search','selectedRooms'
        ));
    }

    public function show($id)
{
    $booking = Booking::with([
    'bookingSeats.showtimeSeat.seat.seatType',
    'showtime.movie',
    'showtime.room.cinema',
    'payment',
    'foods',
    'bookingPromotions'
])->where('payment_status', 'paid')->findOrFail($id);

$totalCombo = $booking->foods->sum(fn($food) => $food->pivot->quantity * $food->price);
$totalSeatPrice = ($booking->payment?->price_amount ?? 0) - $totalCombo + ($booking->total_discount ?? 0);


    // Danh sách city
    $cities = Cinema::select('city')->distinct()->get();

    // Rạp theo city của booking
    $selectedCinemas = $booking->showtime->room->cinema
        ? Cinema::where('city', $booking->showtime->room->cinema->city)->get()
        : Cinema::all();

    // Phim theo cinema của booking
    $selectedMovies = $booking->showtime->movie
        ? Movie::whereHas('showtimes.room', function($q) use ($booking) {
            $q->where('cinema_id', $booking->showtime->room->cinema->cinema_id);
        })->get()
        : Movie::all();

    $search = ''; // Search trống

    return view('admin.show.bill', compact(
    'booking', 'cities', 'selectedCinemas', 'selectedMovies', 'search', 'totalSeatPrice'
));
}


    public function ajaxList(Request $request)
    {
        $query = Booking::with([
            'user',
            'showtime.movie',
            'showtime.room.cinema',
            'seats'
        ])->where('payment_status', 'paid');

        if ($request->city) {
            $query->whereHas('showtime.room.cinema', fn($q) => $q->where('city', $request->city));
        }
        if ($request->cinema) {
            $query->whereHas('showtime.room', fn($q) => $q->where('cinema_id', $request->cinema));
        }
        if ($request->movie) {
            $query->whereHas('showtime', fn($q) => $q->where('movie_id', $request->movie));
        }
        if ($request->date) {
            $query->whereHas('showtime', fn($q) => $q->whereDate('date', $request->date));
        }
        if ($request->status) {
            if ($request->status === 'printed') {
                $query->where('printed_count', '>', 0);
            } else {
                $query->where('printed_count', 0);
            }
        }

        $bookings = $query->latest()->get();

        return view('admin.list.booking_rows', compact('bookings'))->render();
    }
}


