<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Room;
use App\Models\Seat;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RoomController extends Controller
{
public function index(Request $request)
{
    $keyword = $request->input('keyword');

    $query = Room::with('cinema');

    if ($keyword) {
        $query->whereHas('cinema', function ($q) use ($keyword) {
            $q->where('name', 'like', '%' . $keyword . '%');
        });
    }

    $rooms = $query->latest()->paginate(10);
    $index = ($rooms->currentPage() - 1) * $rooms->perPage() + 1;

    return view('admin.list.room', compact('rooms', 'index'));
}


public function create()
{
    $districts = Cinema::select('city')->distinct()->get();
    $cinemas = Cinema::select('cinema_id', 'name', 'city')->get();
    return view('admin.create.room', compact('cinemas','districts'));
}

    public function store(Request $request)
    {
        $data = $request->validate([
            'cinema_id' => 'required|exists:cinemas,cinema_id',
            'room_name' => 'required|string|max:255',
            'total_seats' => 'required|integer|min:1',
        ]);

            Room::create($data);
            $room_id = Room::select('room_id')->where('cinema_id', $request->cinema_id)->where('room_name', $request->room_name)->value('room_id');
            $this->generateSeats($room_id, $request->total_seats);

            return redirect()->route('rooms.index')->with('success', 'Đã cập nhật template');
    }

public function edit($id)
{
    $room = Room::with('cinema')->where('room_id', $id)->firstOrFail();

    $cinemas = Cinema::select('cinema_id', 'name', 'city')->get();

    $districts = Cinema::select('city')->distinct()->get();

    return view('admin.edit.room', compact('room', 'cinemas', 'districts'));
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
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Xoá mẫu email thành công!');
    }

public function show($id)
{
    $room = Room::findOrFail($id);

    $seats = Seat::with('seatType')
        ->where('room_id', $room->room_id)
        ->orderBy('seat_code')
        ->get();

    foreach ($seats as $seat) {
        switch ($seat->seat_type_id) {
            case 1:
                $filename = "seat-normal-available.svg";
                break;
            case 2:
                $filename = "seat-vip-available.svg";
                break;
            case 3:
                $filename = "seat-double-available.svg";
                break;
            default:
                $filename = "seat-normal-available.svg";
        }

        $seat->img_url = asset('admin/pictures/' . $filename);
    }

    return view('admin.show.room', compact('room', 'seats'));
}


protected function generateSeats($roomID, int $quantity)
{
    $rows = 0;
    $colsPerRow = 0;
    $coupleRow = '';
    $vipRows = [];
    $vipCols = [];

    if ($quantity == 50) {
        $rows = 5;
        $colsPerRow = 10;
        $coupleRow = 'E';
        $vipRows = ['C', 'D'];
        $vipCols = [3, 8];
    } elseif ($quantity == 80) {
        $rows = 7;
        $colsPerRow = 12;
        $coupleRow = 'G';
        $vipRows = ['D', 'E', 'F'];
        $vipCols = [3, 10];
    } elseif ($quantity == 120) {
        $rows = 10;
        $colsPerRow = 12;
        $coupleRow = 'J';
        $vipRows = ['E', 'F', 'G', 'H', 'I'];
        $vipCols = [3, 10];
    } else {
        $rows = ceil($quantity / 10);
        $colsPerRow = 10;
        $coupleRow = chr(64 + $rows);
        $vipRows = [chr(64 + $rows - 2), chr(64 + $rows - 1)];
        $vipCols = [floor($colsPerRow * 0.3), floor($colsPerRow * 0.7)];
    }

    $letters = $this->getSeatLetters($rows);
    $seatIndex = 0;

    for ($rowIndex = 0; $rowIndex < $rows; $rowIndex++) {
        $currentRowLetter = $letters[$rowIndex];
        $currentCols = $colsPerRow;
        
        if ($currentRowLetter == $coupleRow && $quantity % $colsPerRow != 0) {
            $currentCols = $quantity % $colsPerRow;
        }

        for ($colIndex = 1; $colIndex <= $currentCols; $colIndex++) {
            if ($seatIndex >= $quantity) break;

            $seatCode = $currentRowLetter . $colIndex;
            $seatTypeId = 1;

            $existingSeat = Seat::where('room_id', $roomID)
                              ->where('seat_code', $seatCode)
                              ->first();

            if ($existingSeat) {
                continue;
            }

            if ($currentRowLetter == $coupleRow) {
                if ($colIndex % 2 == 1) {
                    $seatTypeId = 3;
                    
                    Seat::create([
                        'room_id' => $roomID,
                        'seat_code' => $seatCode,
                        'seat_type_id' => $seatTypeId,
                    ]);
                    
                    if ($colIndex + 1 <= $currentCols) {
                        $nextSeatCode = $currentRowLetter . ($colIndex + 1);
                        Seat::create([
                            'room_id' => $roomID,
                            'seat_code' => $nextSeatCode,
                            'seat_type_id' => $seatTypeId,
                        ]);
                        $colIndex++;
                    }
                    
                    $seatIndex += 2;
                    continue;
                }
            } elseif (in_array($currentRowLetter, $vipRows) && 
                     $colIndex >= $vipCols[0] && $colIndex <= $vipCols[1]) {
                $seatTypeId = 2;
            }

            Seat::create([
                'room_id' => $roomID,
                'seat_code' => $seatCode,
                'seat_type_id' => $seatTypeId,
            ]);

            $seatIndex++;
        }
    }
}

protected function getSeatLetters($rowCount)
{
    $letters = [];
    for ($i = 0; $i < $rowCount; $i++) {
        $letter = '';
        $n = $i;
        while ($n >= 0) {
            $letter = chr($n % 26 + 65) . $letter;
            $n = floor($n / 26) - 1;
        }
        $letters[] = $letter;
    }
    return $letters;
}
}
