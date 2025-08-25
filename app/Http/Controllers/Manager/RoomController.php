<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Seat;
use Exception;
use App\Models\SeatType;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    public function index(Request $request)
{
    $userId   = Auth::user()->user_id; // hoặc Auth::id()
    $cinemaId = DB::table('manager_cinema')
        ->where('user_id', $userId)
        ->value('cinema_id');

    if (!$cinemaId) {
        // Trả về view với thông báo
        return view('manager.list.room', ['errorMessage' => 'Bạn không phải Quản lý của rạp này']);
    }

    $q = trim((string)$request->input('q'));

    $rooms = Room::query()
        ->when($q, fn($qq) => $qq->where('room_name', 'like', "%{$q}%"))
        ->where('cinema_id', $cinemaId)
        ->orderBy('room_name')
        ->paginate(15);

    $index = ($rooms->currentPage() - 1) * $rooms->perPage() + 1;

    return view('manager.list.room', compact('rooms', 'index'));
}



    public function create()
    {
        $managerId = Auth::user()->user_id;

        $cinema_id = DB::table('manager_cinema')
            ->where('user_id', $managerId)
            ->value('cinema_id');
        return view('manager.create.room', compact('cinema_id'));
    }
    


public function update(Request $request, $id)
{
    try {
        // Lấy room + kiểm tra tồn tại
        $room = Room::find($id);
        if (!$room) {
            return back()->withErrors(['error' => 'Phòng không tồn tại.']);
        }

        // Lấy cinema_id mà manager được gán
        $managerCinemaId = DB::table('manager_cinema')
            ->where('user_id', Auth::user()->user_id)
            ->value('cinema_id');

        if (!$managerCinemaId) {
            return back()->withErrors(['error' => 'Bạn chưa được gán rạp.']);
        }

        // Chặn sửa phòng không thuộc rạp của manager
        if ((int)$room->cinema_id !== (int)$managerCinemaId) {
            return back()->withErrors(['error' => 'Bạn không có quyền sửa phòng của rạp khác.']);
        }

        // Validate: buộc cinema_id phải đúng rạp của manager, thêm format
        $data = $request->validate([
            'cinema_id'   => ['required', 'integer', Rule::in([$managerCinemaId])],
            'room_name'   => [
                'required','string','max:255',
                Rule::unique('rooms', 'room_name')
                    ->where(fn($q) => $q->where('cinema_id', $managerCinemaId))
                    ->ignore($room->room_id, 'room_id'),
            ],
            'total_seats' => ['required','integer','min:1'],
            'format'      => ['required', 'string', Rule::in(['2D','3D','IMAX','VIP'])],
        ], [
            'cinema_id.in' => 'Bạn chỉ được gán phòng cho rạp của mình.',
        ]);

        // Cập nhật
        $room->fill($data)->save();

        // Nếu số lượng ghế thay đổi, tạo lại ghế
        if ($room->total_seats != $data['total_seats']) {
            $this->generateSeats($room->room_id, $data['total_seats']);
        }

        return redirect()
            ->route('manager.rooms.index')
            ->with('success', 'Cập nhật phòng thành công.');
    }
    catch (Exception $e) {
        // Ghi log đúng folder + file
        $dir  = storage_path('logs/RoomsLogs');
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        $file = $dir . DIRECTORY_SEPARATOR . date('Y-m-d') . '_logs.txt';
        @file_put_contents($file, '['.now().'] '.$e->getMessage()."\n", FILE_APPEND);

        // Đồng thời log chuẩn của Laravel
        Log::error('Room update failed', [
            'room_id' => $id,
            'user_id' => Auth::user()->user_id ?? null,
            'error'   => $e->getMessage(),
        ]);

        return back()->withErrors(['error' => 'Có lỗi xảy ra khi cập nhật phòng.']);
    }
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

        return view('manager.show.room', compact('room', 'seats', 'seatTypes', 'rooms'));
    }
   public function store(Request $request)
{
    $data = $request->validate([
        'cinema_id'     => 'required|exists:cinemas,cinema_id',
        'room_name'     => 'required|string|max:255',
        'total_seats'   => 'required|integer|min:1',
        'format'        => ['required','string', Rule::in(['2D','3D','IMAX','VIP'])],
        'seat_template' => ['required','string'],
        'active'        => 'sometimes|boolean',
    ]);

    // Checkbox active
    $data['active'] = $request->has('active') ? 1 : 0;

    $room = Room::create($data);

    $this->generateSeats($room->room_id, $data['total_seats']);

    return redirect()->route('manager.rooms.index')
        ->with('success', 'Đã thêm phòng chiếu thành công.');
}

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $cinemas = Cinema::select('cinema_id', 'name', 'city')->get();
        $districts = Cinema::select('city')->distinct()->get(); // ✅ thêm dòng này

        return view('manager.edit.room', compact('room', 'cinemas', 'districts'));
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
}
