<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Seat;
use Illuminate\Http\Request;

class SeatApiController extends Controller
{
    public function index()
    {
        $rooms = Room::with('cinema')->get();
        return response()->json($rooms);
    }

    public function show($room_id)
    {
        $room = Room::with('cinema')->findOrFail($room_id);
        $seats = Seat::where('room_id', $room_id)->orderBy('seat_code')->get();

        return response()->json([
            'room' => $room,
            'seats' => $seats
        ]);
    }

    public function update(Request $request, $room_id)
    {
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

        return response()->json(['message' => 'Cập nhật thành công']);
    }
}
