<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Room;
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

    public function delete($id){
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

    public function dele(){
               return view('Room    .delete');

    }
}
