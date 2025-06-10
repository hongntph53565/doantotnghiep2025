<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Seat;
use App\Models\Showtime;
use App\Models\ShowtimeSeat;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShowtimeController extends Controller
{
    public function index()
    {
        $showTime = Showtime::with(['movie', 'room'])->get();
        return view('Showtime.list', compact('showTime'));
    }

    public function create()
    {
        $cinemas = Cinema::all();
        $rooms = Room::all();
        $movies = Movie::all();
        return view('Showtime.create', compact('cinemas', 'rooms', 'movies'));
    }



    public function store(Request $request)
    {
        $data = $request->validate([
            'movie_id'   => 'required|exists:movies,movie_id',
            'room_id'    => 'required|exists:rooms,room_id',
            'start_time' => 'required|date|after_or_equal:now',
            'end_time'   => 'nullable|date|after:start_time',
            'price'      => 'required|integer|min:1000',
            'status'     => 'required|in:active,cancelled,sold_out',
        ]);

        try {
            $seats = Seat::where('room_id', $data['room_id'])->get();

            $showtime = Showtime::create($data);

            foreach ($seats as $seat) {
                ShowtimeSeat::create([
                    'showtime_id' => $showtime->showtime_id,
                    'seat_id'     => $seat->seat_id,
                    'status'      => 'available',
                ]);
            }
            return redirect("/showtime")->with('success', 'Tạo suất chiếu thành công');
        } catch (Exception $e) {
            Log::error('[Showtime Store] ' . $e->getMessage());
            return back()->withErrors(['error' => 'Lỗi khi tạo suất chiếu']);
        }
    }

public function edit($id)
{
    $movies = Movie::select('movie_id', 'title')->get();
    $rooms = Room::select('room_id', 'room_name', 'cinema_id')->get(); // Thêm cinema_id để dùng trong view
    $cinemas = Cinema::select('cinema_id', 'name')->get(); // BỔ SUNG DÒNG NÀY
    $showtime = Showtime::with('room.cinema')->findOrFail($id); // Load cinema từ room

    return view('Showtime.edit', compact('movies', 'rooms', 'cinemas', 'showtime'));
}


public function update(Request $request, string $id)
{
    $data = $request->validate([
        'movie_id'   => 'required|exists:movies,movie_id',
        'room_id'    => 'required|exists:rooms,room_id',
        'start_time' => 'required|date|after_or_equal:now',
        'end_time'   => 'nullable|date|after:start_time',
        'price'      => 'required|integer|min:1000',
        'status'     => 'required|in:active,cancelled,sold_out',
    ]);

    try {
        $showtime = Showtime::findOrFail($id);
        $oldRoomID = $showtime->room_id;

        $showtime->update($data);

        if ($oldRoomID != $data['room_id']) {

            ShowtimeSeat::where('showtime_id', $showtime->showtime_id)->delete();

            $seats = Seat::where('room_id', $data['room_id'])->get();
            foreach ($seats as $seat) {
                ShowtimeSeat::create([
                    'showtime_id' => $showtime->showtime_id,
                    'seat_id'     => $seat->seat_id,
                    'status'      => 'available',
                ]);
            }
        }

        return redirect("/Showtime")->with('success', 'Cập nhật suất chiếu thành công');
    } catch (Exception $e) {
        Log::error('[Showtime Update] ' . $e->getMessage());
        return back()->withErrors(['error' => 'Lỗi khi cập nhật suất chiếu']);
    }
}


    public function delete(string $id)
    {
        try {
            $showtime = Showtime::findOrFail($id);
            $showtime->delete();
            return redirect("/Showtime")->with('success', 'Xóa suất chiếu thành công');
        } catch (Exception $e) {
            Log::error('[Showtime Delete] ' . $e->getMessage());
            return back()->withErrors(['error' => 'Lỗi khi xóa suất chiếu']);
        }
    }

    public function dele()
    {
        return view('Showtime.delete');
    }
}
