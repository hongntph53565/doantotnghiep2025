<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Room;
use App\Models\Seat;
use Exception;
use Illuminate\Http\Request;

class RoomApiController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return response()->json($rooms);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cinema_id' => 'required|exists:cinemas,cinema_id',
            'room_name' => 'required|string|max:255',
            'total_seats' => 'required|integer|min:1',
        ]);

        try {
            $room = Room::create($data);
            $this->generateSeats($room->room_id, $data['total_seats']);

            return response()->json([
                'message' => 'Room created successfully',
                'room' => $room,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create room',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }
        return response()->json($room);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'cinema_id' => 'required|exists:cinemas,cinema_id',
            'room_name' => 'required|string|max:255',
            'total_seats' => 'required|integer|min:1',
        ]);

        $room = Room::find($id);
        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        try {
            $room->update($data);

            return response()->json([
                'message' => 'Room updated successfully',
                'room' => $room,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update room',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        try {
            $room->delete();
            return response()->json(['message' => 'Room deleted successfully']);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete room',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    protected function generateSeats($roomID, $quantity)
    {
        $letters = range('A', 'Z');
        $rows = ceil($quantity / 10);
        if ($rows > count($letters)) return;

        for ($i = 0; $i < $quantity; $i++) {
            $row = floor($i / 10);
            $number = ($i % 10) + 1;
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
