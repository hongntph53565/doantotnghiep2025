<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Cinema;
use Exception;
use Illuminate\Http\Request;

class ShowtimeApiController extends Controller
{
    public function index()
    {
        $showtimes = Showtime::with(['room.cinema', 'movie'])->get();
        return response()->json($showtimes);
    }

    public function create()
    {
        // API không cần view, nhưng nếu muốn trả dữ liệu dùng cho form thì trả json
        $movies = Movie::select('movie_id', 'title')->get();
        $rooms = Room::select('room_id', 'room_name', 'cinema_id')->get();
        $cinemas = Cinema::all();

        return response()->json(compact('movies', 'rooms', 'cinemas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'movie_id'   => 'required|exists:movies,movie_id',
            'cinema_id'  => 'required|exists:cinemas,cinema_id',
            'room_id'    => 'required|exists:rooms,room_id',
            'show_date'  => 'required|date|after_or_equal:today',
            'price'      => 'required|integer|min:1000',
            'status'     => 'required|in:active,inactive',
        ]);

        try {
            $showtime = Showtime::create($data);
            return response()->json([
                'message' => 'Tạo suất chiếu thành công',
                'showtime' => $showtime,
            ], 201);
        } catch (Exception $e) {
            $this->logError($e);
            return response()->json(['error' => 'Lỗi hệ thống, vui lòng thử lại'], 500);
        }
    }

    public function edit($id)
    {
        // API không cần view, trả dữ liệu sửa
        $movies = Movie::select('movie_id', 'title')->get();
        $rooms = Room::select('room_id', 'room_name', 'cinema_id')->get();
        $cinemas = Cinema::all();
        $showtime = Showtime::with(['room.cinema'])->find($id);

        if (!$showtime) {
            return response()->json(['error' => 'Suất chiếu không tồn tại'], 404);
        }

        return response()->json(compact('movies', 'rooms', 'cinemas', 'showtime'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'movie_id'   => 'required|exists:movies,movie_id',
            'cinema_id'  => 'required|exists:cinemas,cinema_id',
            'room_id'    => 'required|exists:rooms,room_id',
            'show_date'  => 'required|date|after_or_equal:today',
            'price'      => 'required|integer|min:1000',
            'status'     => 'required|in:active,inactive',
        ]);

        try {
            $showtime = Showtime::find($id);

            if (!$showtime) {
                return response()->json(['error' => 'Suất chiếu không tồn tại'], 404);
            }

            $showtime->update($data);

            return response()->json([
                'message' => 'Cập nhật suất chiếu thành công',
                'showtime' => $showtime,
            ]);
        } catch (Exception $e) {
            $this->logError($e);
            return response()->json(['error' => 'Lỗi hệ thống, vui lòng thử lại'], 500);
        }
    }

    public function delete($id)
    {
        try {
            $showtime = Showtime::find($id);

            if (!$showtime) {
                return response()->json(['error' => 'Suất chiếu không tồn tại'], 404);
            }

            $showtime->delete();

            return response()->json(['message' => 'Xóa suất chiếu thành công']);
        } catch (Exception $e) {
            $this->logError($e);
            return response()->json(['error' => 'Lỗi hệ thống, vui lòng thử lại'], 500);
        }
    }

    protected function logError(Exception $e)
    {
        $logPath = storage_path('logs/RoomsLogs');
        if (!file_exists($logPath)) {
            mkdir($logPath, 0755, true);
        }
        $dateName = date("d-m-Y");
        file_put_contents($logPath . '/' . $dateName . '_logs.txt', $e->getMessage() . "\n", FILE_APPEND);
    }
}
