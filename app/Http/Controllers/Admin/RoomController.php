<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Room;
use App\Models\Seat;
use App\Models\SeatType;
use Exception;
use Illuminate\Http\Request;

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
        return view('admin.create.room', compact('cinemas', 'districts'));
    }

    public function store(Request $request)
    {
         $messages = [
        'cinema_id.required'   => 'Vui lòng chọn rạp.',
        'cinema_id.exists'     => 'Rạp đã chọn không tồn tại.',
        'room_name.required'   => 'Vui lòng nhập tên phòng.',
        'room_name.string'     => 'Tên phòng phải là chuỗi ký tự.',
        'room_name.max'        => 'Tên phòng không được vượt quá 255 ký tự.',
        'room_name.min'        => 'Tên phòng ít nhất 3 ký tự.',
        'total_seats.required' => 'Vui lòng nhập số ghế.',
        'total_seats.integer'  => 'Số ghế phải là một số nguyên.',
        'total_seats.min'      => 'Số ghế phải lớn hơn 0.',
    ];

    $data = $request->validate([
        'cinema_id'   => 'required|exists:cinemas,cinema_id',
           'room_name' => [
            'required',
            'string',
            'max:255',
            'min:3',
            function ($attribute, $value, $fail) use ($request) {
                $exists = Room::where('cinema_id', $request->cinema_id)
                              ->where('room_name', $value)
                              ->exists();
                if ($exists) {
                    $fail('Tên phòng đã tồn tại trong rạp này.');
                }
            },
        ],
        'total_seats' => 'required|integer|min:1',
    ], $messages);

        Room::create($data);

        $room_id = Room::select('room_id')
            ->where('cinema_id', $request->input('cinema_id'))
            ->where('room_name', $request->input('room_name'))
            ->value('room_id');

        $this->generateSeats($room_id, $request->input('total_seats'));


        return redirect()->route('rooms.index')->with('success', 'Đã thêm mới phòng chiếu thành công');
    }

    public function update(Request $request, $id)
    {
        $messages = [
        'cinema_id.required'   => 'Vui lòng chọn rạp.',
        'cinema_id.exists'     => 'Rạp đã chọn không tồn tại.',
        'room_name.required'   => 'Vui lòng nhập tên phòng.',
        'room_name.string'     => 'Tên phòng phải là chuỗi ký tự.',
        'room_name.max'        => 'Tên phòng không được vượt quá 255 ký tự.',
        'total_seats.required' => 'Vui lòng nhập số ghế.',
        'total_seats.integer'  => 'Số ghế phải là một số nguyên.',
        'total_seats.min'      => 'Số ghế phải lớn hơn 0.',
    ];

    $data = $request->validate([
        'cinema_id'   => 'required|exists:cinemas,cinema_id',
        'room_name'   => 'required|string|max:255',
        'total_seats' => 'required|integer|min:1',
    ], $messages);
        try {

            $room = Room::find($id);

            if (!$room) {
                return redirect()->back()->withErrors(['error' => 'Phòng không tồn tại']);
            }

            $room->update($data);

            return redirect()->route('rooms.show', $room->room_id)->with('success', 'Cập nhật phòng thành công');

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

        return redirect()->route('rooms.index')->with('success', 'Xoá phòng chiếu thành công!');
    }

    public function show($id)
    {
        $seatTypes = SeatType::all();
        $rooms = Room::all();
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

        return view('admin.show.room', compact('room', 'seats', 'seatTypes', 'rooms'));
    }


    protected function generateSeats($roomID, int $quantity)
    {
        Seat::where('room_id', $roomID)->delete();

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
            $colsPerRow = min(20, ceil($quantity / 5));
            $rows = ceil($quantity / $colsPerRow);

            $coupleRow = chr(64 + $rows);

            $vipRowCount = max(2, round($rows * 0.25));
            $vipRowStart = floor(($rows - $vipRowCount) / 2);
            $vipRows = [];
            for ($i = $vipRowStart; $i < $vipRowStart + $vipRowCount; $i++) {
                $vipRows[] = chr(65 + $i);
            }

            $vipCols = [
                floor($colsPerRow * 0.3),
                ceil($colsPerRow * 0.7),
            ];
        }

        $letters = $this->getSeatLetters($rows);
        $createdSeats = 0;

        foreach ($letters as $rowIndex => $currentRowLetter) {
            $isCoupleRow = ($currentRowLetter === $coupleRow);
            $isVipRow = in_array($currentRowLetter, $vipRows);

            $seatsInRow = $colsPerRow;
            if ($isCoupleRow) {
                if ($seatsInRow % 2 !== 0) $seatsInRow--;
            }

            for ($colIndex = 1; $colIndex <= $seatsInRow; $colIndex++) {
                if ($createdSeats >= $quantity) break;

                $seatCode = $currentRowLetter . $colIndex;

                if ($isCoupleRow) {
                    if ($colIndex % 2 === 1 && $colIndex + 1 <= $seatsInRow) {
                        Seat::create([
                            'room_id' => $roomID,
                            'seat_code' => $seatCode,
                            'seat_type_id' => 3,
                        ]);
                        Seat::create([
                            'room_id' => $roomID,
                            'seat_code' => $currentRowLetter . ($colIndex + 1),
                            'seat_type_id' => 3,
                        ]);
                        $createdSeats += 2;
                    }
                    continue;
                }

                $seatTypeId = 1;
                if ($isVipRow && $colIndex >= $vipCols[0] && $colIndex <= $vipCols[1]) {
                    $seatTypeId = 2;
                }

                Seat::create([
                    'room_id' => $roomID,
                    'seat_code' => $seatCode,
                    'seat_type_id' => $seatTypeId,
                ]);
                $createdSeats++;
            }
        }

        if ($createdSeats != $quantity) {
            throw new \RuntimeException("Tạo ghế không thành công. Yêu cầu: {$quantity}, Đã tạo: {$createdSeats}");
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
public function edit($id)
{
    $room = Room::findOrFail($id);
    $cinemas = Cinema::select('cinema_id', 'name', 'city')->get();
    $districts = Cinema::select('city')->distinct()->get(); // ✅ thêm dòng này

    return view('admin.edit.room', compact('room', 'cinemas', 'districts'));
}

}