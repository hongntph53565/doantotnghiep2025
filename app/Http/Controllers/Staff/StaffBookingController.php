<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\Seat;
use App\Models\Food;
use Carbon\Carbon;

class StaffBookingController extends Controller
{
    public function show($id)
    {
        $today = Carbon::today()->toDateString();

        $movie = Movie::with([
            'showtimes' => function ($query) use ($today) {
                $query->whereDate('date', $today)
                    ->where('status', 'active')
                    ->with('room.cinema');
            },
            'genre'
        ])->findOrFail($id);

        return view('staff.booking1', [
            'movie' => $movie,
            'selectedDate' => $today
        ]);
    }

    public function showtimesByDate(Request $request, $movieId)
    {
        $date = $request->input('date'); // dạng yyyy-mm-dd

        $movie = Movie::with([
            'showtimes' => function ($query) use ($date) {
                $query->whereDate('date', $date)->where('status', 'active')->with('room.cinema');
            },
            'genre'
        ])->findOrFail($movieId);

        $cinema = null;
        $firstShowtime = $movie->showtimes->first();
        if ($firstShowtime && $firstShowtime->room && $firstShowtime->room->cinema) {
            $cinema = $firstShowtime->room->cinema;
        }


        return view('staff.booking.showtimes', compact('movie', 'cinema'))->render();
    }

    public function showSeatsByRoom(Request $request, $movie_id)
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

        $selectedShowtimeId = $request->input('showtime');
        $selectedShowtime = null;
        $seats = collect();
        $foods = collect();
        $step = 0;

        if ($selectedShowtimeId) {
            $selectedShowtime = Showtime::with([
                'room.cinema',
                'room.seats.seatType',
                'movie'
            ])->find($selectedShowtimeId);

            if ($selectedShowtime && $selectedShowtime->room) {
                $seats = $selectedShowtime->room->seats;

                if ($seats->isEmpty()) {
                    abort(404, 'Không tìm thấy ghế nào trong phòng chiếu này.');
                }

                $step = 1;

                $cinemaId = $selectedShowtime->room->cinema_id;
                $foods = Food::where('cinema_id', $cinemaId)
                    ->where('status', 'active')
                    ->get()
                    ->groupBy('type');
            }
        }
        return view('staff.booking2', compact(
            'movie',
            'showtimes',
            'selectedShowtimeId',
            'selectedShowtime',
            'seats',
            'step',
            'foods'
        ));
    }
}
