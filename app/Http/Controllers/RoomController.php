<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Room;
use App\Models\Seat;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('Room.list', compact('rooms'));
    }

    public function create()
    {
        $cinemas = Cinema::select('cinema_id', 'name')->get();
        return view('Room.create', compact('cinemas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cinema_id' => 'required|exists:cinemas,cinema_id',
            'room_name' => 'required|string|max:255',
            'total_seats' => 'required|integer|min:1',
        ]);
        try {
            Room::create($data);
            $room_id = Room::select('room_id')->where('cinema_id', $request->cinema_id)->where('room_name', $request->room_name)->value('room_id');
            $this->generateSeats($room_id, $request->total_seats);
        } catch (Exception $e) {
            $logPath = storage_path('logs/RoomsLogs');
            if (!file_exists($logPath)) {
                mkdir($logPath, 0755, true);
            }
            $dateName = date("d-m-Y");
            file_put_contents($dateName . '_logs.txt', $e->getMessage() . "\n", FILE_APPEND);
        }
    }

    public function edit($id)
    {
        $oldValue = Room::where('room_id', $id)->first();
        $cinemas = Cinema::select('cinema_id', 'name')->get();
        return view('Room.edit', compact('oldValue', 'cinemas'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'cinema_id' => 'required|exists:cinemas,cinema_id',
            'room_name' => 'required|string|max:255',
            'total_seats' => 'required|integer|min:1',
        ]);
        try {

            $room = Room::find($id);

            if (!$room) {
                return redirect()->back()->withErrors(['error' => 'Phòng không tồn tại']);
            }

            $room->update($data);

            return redirect()->route('show')->with('success', 'Cập nhật phòng thành công');
        } catch (Exception $e) {
            $logPath = storage_path('logs/RoomsLogs');
            if (!file_exists($logPath)) {
                mkdir($logPath, 0755, true);
            }
            $dateName = date("d-m-Y");
            file_put_contents($dateName . '_logs.txt', $e->getMessage() . "\n", FILE_APPEND);
        }
    }

    public function delete($id)
    {
        try {
            $room = Room::findOrFail($id);

            if (!$room) {
                return redirect()->back()->withErrors(['error' => 'Phòng không tồn tại']);
            }

            $room->delete();
        } catch (Exception $e) {
            $logPath = storage_path('logs/RoomsLogs');
            if (!file_exists($logPath)) {
                mkdir($logPath, 0755, true);
            }
            $dateName = date("d-m-Y");
            file_put_contents($dateName . '_logs.txt', $e->getMessage() . "\n", FILE_APPEND);
        }
    }

    public function dele()
    {
        return view('Room    .delete');
    }

    protected function generateSeats($roomID, $quantity)
    {
        $letters = range('A', 'Z');
        $rows = ceil($quantity / 16);
        if ($rows > count($letters)) return;

        for ($i = 0; $i < $quantity; $i++) {
            $row = floor($i / 16);
            $number = ($i % 16) + 1;
            $seat_code = $letters[$row] . $number;
            if (in_array($letters[$row], ['A', 'B'])) {
                $seat_type = 'standard';
            } elseif ($row == $rows - 1) {
                $seat_type = 'couple';
            } else {
                $seat_type = 'vip';
            }

            Seat::create([
                'room_id' => $roomID,
                'seat_code' => $seat_code,
                'seat_type' => $seat_type,
            ]);
        }
    }
}
