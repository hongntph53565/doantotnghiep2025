<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Showtime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowtimeController extends Controller
{
    public function index(Request $request)
    {
        $query = Showtime::with(['movie', 'room', 'room.cinema']);

        if ($request->cinema_id) {
            $query->whereHas('room', function ($q) use ($request) {
                $q->where('cinema_id', $request->cinema_id);
            });
        }

        if ($request->district) {
            $query->whereHas('room.cinema', function ($q) use ($request) {
                $q->where('city', $request->district);
            });
        }

        if ($request->from_date) {
            $query->whereDate('date', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        if ($request->status) {
            $now = now();
            $query->where(function ($q) use ($request, $now) {
                if ($request->status === 'Đang chiếu') {
                    $q->whereDate('date', $now->toDateString())
                        ->whereTime('start_time', '<=', $now->toTimeString())
                        ->whereTime('end_time', '>=', $now->toTimeString());
                } elseif ($request->status === 'Sắp chiếu') {
                    $q->where(function ($sub) use ($now) {
                        $sub->where('date', '>', $now->toDateString())
                            ->orWhere(function ($sub2) use ($now) {
                                $sub2->whereDate('date', $now->toDateString())
                                    ->whereTime('start_time', '>', $now->toTimeString());
                            });
                    });
                } elseif ($request->status === 'Đã chiếu') {
                    $q->where('status', 'sold_out');
                }
            });
        }


        $showtimes = $query->orderBy('start_time')->paginate(10);
        $districts = Cinema::select('city')->distinct()->get();
        $cinemas = Cinema::all();
        $selectedCinema = $request->cinema_id ? Cinema::find($request->cinema_id) : null;
        $now = now();

        return view('manager.list.showtime', compact(
            'showtimes',
            'districts',
            'cinemas',
            'now',
            'selectedCinema'
        ));
    }


    public function create()
    {
        $managerId = Auth::user()->user_id;

        $cinema_id = DB::table('manager_cinema')
            ->where('user_id', $managerId)
            ->value('cinema_id');
        $rooms = Room::all();
        $movies = Movie::all();
        $showtimes = Showtime::with('room')
            ->orderBy('start_time', 'asc')
            ->paginate(5);
        return view('manager.create.showtime', compact('cinema_id', 'rooms', 'movies', 'showtimes'));
    }
}
