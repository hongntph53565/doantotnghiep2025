<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Showtime;
use App\Models\Food;

use Illuminate\Http\Request;
use Carbon\Carbon;


class HomeController extends Controller
{
    public function home()
    {
        $movies = Movie::with('genre')
            ->latest()
            ->get();

        return view('Client.home', compact('movies'));
    }
public function booking(Request $request, $movie_id)
{
    $movie = Movie::with('genre')->findOrFail($movie_id);
    $date = $request->input('date', now()->toDateString());

    $query = Showtime::with('room.cinema')
        ->where('movie_id', $movie_id)
        ->where('status', 'active')
        ->whereDate('date', Carbon::parse($date)->toDateString());

    $showtimes = $query
        ->orderBy('start_time')
        ->get()
        ->groupBy(fn($item) => $item->room->cinema->cinema_id);

    $selectedShowtimeId = $request->input('showtime_id');
    $selectedShowtime = null;
    $seats = collect();
    $foods = collect();
    $step = 0;

    if ($selectedShowtimeId) {
        $selectedShowtime = Showtime::with(['room.cinema', 'room.seats.seatType', 'movie'])->find($selectedShowtimeId);

        if ($selectedShowtime && $selectedShowtime->room) {
            $seats = $selectedShowtime->room->seats;
            $step = 1;

            // 👉 Lấy combo theo cinema_id
            $cinemaId = $selectedShowtime->room->cinema_id;
            $foods = Food::where('cinema_id', $cinemaId)
                         ->where('status', 'active')
                         ->get()
                         ->groupBy('type');
        }
    }

    return view('Client.booking.home', compact(
        'movie', 'showtimes', 'selectedShowtimeId', 'selectedShowtime', 'seats', 'step', 'foods'
    ));
}


public function lichChieu()
{
    $nowShowing = Movie::with('genre')
        ->where('status', 'active') // hoặc 'now_showing', tuỳ theo cách bạn lưu status
        ->orderBy('created_at', 'desc')
        ->get();

    $comingSoon = Movie::with('genre')
        ->where('status', 'inactive') // hoặc 'coming_soon'
        ->orderBy('created_at', 'desc')
        ->get();

    return view('Client.lichchieuphim', compact('nowShowing', 'comingSoon'));
}


public function loadShowtimes(Request $request)
{
    $movie_id = $request->input('movie_id');
    $date = $request->input('date');

    $movie = Movie::with('genre')->findOrFail($movie_id);

    $query = Showtime::with('room.cinema')
        ->where('movie_id', $movie_id)
        ->where('status', 'active');

    if ($date) {
        $query->whereDate('date', Carbon::parse($date)->toDateString());
    }

    $showtimes = $query
        ->orderBy('start_time')
        ->get()
        ->groupBy(fn($item) => $item->room->cinema->cinema_id);

    return view('Client.booking.steps.select_showtime', compact('movie', 'showtimes'))->render();
}
public function ajaxShowtimes(Request $request)
{
    $movieId = $request->input('movie_id');
    $date = $request->input('date'); 
    $nowVN = Carbon::now('Asia/Ho_Chi_Minh');

    $query = Showtime::with(['room.cinema', 'movie'])
        ->where('movie_id', $movieId)
        ->whereDate('date', $date);


    if ($date === $nowVN->toDateString()) {
        $query->whereTime('start_time', '>=', $nowVN->toTimeString());
    }

    $showtimes = $query
        ->orderBy('start_time')
        ->get()
        ->groupBy(function ($item) {
            return $item->room->cinema_id;
        });

    return view('ajax.showtimes', [
        'showtimes' => $showtimes,
        'movie' => Movie::find($movieId),
    ]);
}



// public function booking(Request $request, $movie_id)
// {
//     $movie = Movie::with('genre')->findOrFail($movie_id);

//     $date = $request->input('date', now()->toDateString());

//     $showtimes = Showtime::with('room.cinema')
//         ->where('movie_id', $movie_id)
//         ->where('status', 'active')
//         ->whereDate('date', Carbon::parse($date)->toDateString())
//         ->orderBy('start_time')
//         ->get()
//         ->groupBy(fn($item) => $item->room->cinema->cinema_id);

//     $selectedShowtimeId = $request->input('showtime_id');
//     $selectedShowtime = null;
//     $seats = collect();
//     $foods = collect();

//     if ($selectedShowtimeId) {
//         $selectedShowtime = Showtime::with(['room.cinema', 'room.seats.seatType', 'movie'])->find($selectedShowtimeId);

//         if ($selectedShowtime && $selectedShowtime->room) {
//             $seats = $selectedShowtime->room->seats;

//             $cinemaId = $selectedShowtime->room->cinema_id;
//             $foods = Food::where('cinema_id', $cinemaId)
//                 ->where('status', 'active')
//                 ->get()
//                 ->groupBy('type');
//         }
//     }

//     return view('Client.booking.home', compact(
//         'movie', 'showtimes', 'selectedShowtimeId', 'selectedShowtime', 'seats', 'foods'
//     ));
// }

}
