<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Seat;
use App\Models\Showtime;
use App\Models\ShowtimeSeat;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShowtimeApiController extends Controller
{
    public function index()
    {
        $showTimes = Showtime::with(['movie', 'room'])->get();
        return response()->json($showTimes);
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
            $showtime = Showtime::create($data);

            $seats = Seat::where('room_id', $data['room_id'])->get();
            foreach ($seats as $seat) {
                ShowtimeSeat::create([
                    'showtime_id' => $showtime->showtime_id,
                    'seat_id'     => $seat->seat_id,
                    'status'      => 'available',
                ]);
            }

            return response()->json(['message' => 'Tạo suất chiếu thành công', 'showtime' => $showtime], 201);
        } catch (Exception $e) {
            Log::error('[API Showtime Store] ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi khi tạo suất chiếu'], 500);
        }
    }

    public function show($id)
    {
        $showtime = Showtime::with(['movie', 'room'])->find($id);
        if (!$showtime) {
            return response()->json(['error' => 'Không tìm thấy suất chiếu'], 404);
        }
        return response()->json($showtime);
    }

    public function update(Request $request, $id)
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

            return response()->json(['message' => 'Cập nhật suất chiếu thành công', 'showtime' => $showtime]);
        } catch (Exception $e) {
            Log::error('[API Showtime Update] ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi khi cập nhật suất chiếu'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $showtime = Showtime::findOrFail($id);
            $showtime->delete();
            return response()->json(['message' => 'Xóa suất chiếu thành công']);
        } catch (Exception $e) {
            Log::error('[API Showtime Delete] ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi khi xóa suất chiếu'], 500);
        }
    }

    public function getFormData()
    {
        return response()->json([
            'movies'  => Movie::select('movie_id', 'title')->get(),
            'rooms'   => Room::select('room_id', 'room_name', 'cinema_id')->get(),
            'cinemas' => Cinema::select('cinema_id', 'name')->get(),
        ]);
    }
}
