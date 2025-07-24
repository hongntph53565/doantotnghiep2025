<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\Food;
use App\Models\Cinema;
use App\Models\BookingSeat;
use App\Models\Booking;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
public function home()
{
    $today = Carbon::now()->toDateString(); 

    
    $movies = Movie::with('genre')
        ->whereDate('release_date', '<=', $today)
        ->orderBy('release_date', 'desc')
        ->get();

   
    foreach ($movies as $movie) {
        if (!empty($movie->trailer) && Str::contains($movie->trailer, 'watch?v=')) {
            $videoId = explode('watch?v=', $movie->trailer)[1];
            $movie->trailer = 'https://www.youtube.com/embed/' . $videoId;
        }
    }

    return view('Client.home', compact('movies'));
}
// public function booking(Request $request, $movie_id)
// {
//     $movie = Movie::with('genre')->findOrFail($movie_id);
//     $date = $request->input('date', now()->toDateString());

//     $query = Showtime::with('room.cinema')
//         ->where('movie_id', $movie_id)
//         ->where('status', 'active')
//         ->whereDate('date', Carbon::parse($date)->toDateString());

//     $showtimes = $query
//         ->orderBy('start_time')
//         ->get()
//         ->groupBy(fn($item) => $item->room->cinema->cinema_id);

//     $selectedShowtimeId = $request->input('showtime_id');
//     $selectedShowtime = null;
//     $seats = collect();
//     $foods = collect();
//     $step = 0;
    

//     if ($selectedShowtimeId) {
//         // Chuyển hướng nếu chưa đăng nhập
//         if (!Auth::check()) {
//             return redirect()->route('register.form')->with('message', 'Vui lòng đăng ký hoặc đăng nhập để tiếp tục đặt vé.');
//         }

        

//         $selectedShowtime = Showtime::with(['room.cinema', 'room.seats.seatType', 'movie'])->find($selectedShowtimeId);

//         if ($selectedShowtime && $selectedShowtime->room) {
//             $seats = $selectedShowtime->room->seats;
//             $step = 1;

//             $cinemaId = $selectedShowtime->room->cinema_id;
//             $foods = Food::where('cinema_id', $cinemaId)
//                 ->where('status', 'active')
//                 ->get()
//                 ->groupBy('type');
//         }
//     }
    
    

//     return view('Client.booking.home', compact(
//         'movie',
//         'showtimes',
//         'selectedShowtimeId',
//         'selectedShowtime',
//         'seats',
//         'step',
//         'foods'
//     ));
// }




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
    $showtimeSeatStatuses = [];

    if ($selectedShowtimeId) {
        // Chuyển hướng nếu chưa đăng nhập
        if (!Auth::check()) {
            return redirect()->route('register.form')->with('message', 'Vui lòng đăng ký hoặc đăng nhập để tiếp tục đặt vé.');
        }

        $selectedShowtime = Showtime::with(['room.cinema', 'room.seats.seatType', 'movie'])->find($selectedShowtimeId);

        if ($selectedShowtime && $selectedShowtime->room) {
            $seats = $selectedShowtime->room->seats;
            $step = 1;

            // Lấy trạng thái của các ghế thuộc suất chiếu này
            $showtimeSeatStatuses = \App\Models\ShowtimeSeat::where('showtime_id', $selectedShowtime->showtime_id)
                ->pluck('status', 'seat_id')
                ->toArray();

            // Lấy food theo rạp
            $cinemaId = $selectedShowtime->room->cinema_id;
            $foods = Food::where('cinema_id', $cinemaId)
                ->where('status', 'active')
                ->get()
                ->groupBy('type');
        }
    }

    return view('Client.booking.home', compact(
        'movie',
        'showtimes',
        'selectedShowtimeId',
        'selectedShowtime',
        'seats',
        'step',
        'foods',
        'showtimeSeatStatuses'
    ));
}


    public function ShowtimesByCinema(Request $request, $cinema_id)
    {
        $date = $request->input('date', now()->toDateString());
        $nowVN = Carbon::now('Asia/Ho_Chi_Minh');

        $query = Showtime::with(['room.cinema', 'movie'])
            ->whereHas('room', function ($q) use ($cinema_id) {
                $q->where('cinema_id', $cinema_id);
            })
            ->where('status', 'active')
            ->whereDate('date', Carbon::parse($date)->toDateString());

        if ($date === $nowVN->toDateString()) {
            $query->whereTime('start_time', '>=', $nowVN->toTimeString());
        }

        $showtimes = $query
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn($item) => $item->movie->movie_id);

        $cinema = Cinema::findOrFail($cinema_id);
return view('Client.MovieShowtimesByCinema', compact('cinema', 'showtimes', 'date'));
    }




    public function Showtimes()
    {
        $nowShowing = Movie::with('genre')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        $comingSoon = Movie::with('genre')
            ->where('status', 'inactive')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Client.MovieShowtimes', compact('nowShowing', 'comingSoon'));
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
    public function ajaxShowtimesByCinema(Request $request)
    {
        $cinemaId = $request->input('cinema_id');
        $date = $request->input('date', now()->toDateString());

        $nowVN = Carbon::now('Asia/Ho_Chi_Minh');

        $query = Showtime::with(['room.cinema', 'movie'])
            ->whereHas('room', function ($q) use ($cinemaId) {
                $q->where('cinema_id', $cinemaId);
            })
            ->where('status', 'active')
            ->whereDate('date', Carbon::parse($date)->toDateString());

        if ($date === $nowVN->toDateString()) {
            $query->whereTime('start_time', '>=', $nowVN->toTimeString());
        }

        $showtimes = $query
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn($item) => $item->movie->movie_id);

        return view('ajax.showtimes-by-cinema', compact('showtimes'))->render();
    }


}