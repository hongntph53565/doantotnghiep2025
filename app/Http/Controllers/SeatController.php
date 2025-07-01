<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{

    public function index()
    {
        // Lấy tất cả phòng kèm theo thông tin rạp (cinema)
        $rooms = Room::with('cinema')->get();

        // Trả về view, truyền dữ liệu rooms
        return view('Seat.index', compact('rooms'));
    }

    public function edit($roomId)
    {
        $room = Room::with('cinema')->findOrFail($roomId);
        $seats = Seat::where('room_id', $roomId)->orderBy('seat_code')->get();

        return view('seat.edit', compact('room', 'seats'));
    }


    public function update(Request $request, $roomId)
    {
        $room = Room::findOrFail($roomId);
        $data = $request->validate([
            'seats' => 'required|array',
            'seats.*.id' => 'required|exists:seats,seat_id',
            'seats.*.seat_type' => 'required|in:standard,vip,couple',
        ]);

        foreach ($data['seats'] as $seatData) {
            $seat = Seat::find($seatData['id']);
            $seat->seat_type = $seatData['seat_type'];
            $seat->save();
        }

        return redirect()->route('seat.index', $roomId)->with('success', 'Cập nhật loại ghế thành công');
    }
}
