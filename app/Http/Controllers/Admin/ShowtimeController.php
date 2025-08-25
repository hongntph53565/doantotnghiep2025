<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Seat;
use App\Models\Showtime;
use App\Models\ShowtimeSeat;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ShowtimeController extends Controller
{

    
    public function index(Request $request)
{
    $query = Showtime::withTrashed()->with(['movie', 'room', 'room.cinema']);

    // Lọc theo rạp
    if ($request->cinema_id) {
        $query->whereHas('room', function ($q) use ($request) {
            $q->where('cinema_id', $request->cinema_id);
        });
    }

    // Lọc theo phim
    if ($request->movie_id) {
        $query->where('movie_id', $request->movie_id);
    }

   if ($request->from_date) {
    $query->where('date', '>=', $request->from_date);
}

if ($request->to_date) {
    $query->where('date', '<=', $request->to_date);
}

    if ($request->status) {
    $now = now();
    $query->where(function ($q) use ($request, $now) {
        if ($request->status === 'Đang chiếu') {
            $q->whereRaw("STR_TO_DATE(CONCAT(date,' ',start_time),'%Y-%m-%d %H:%i:%s') <= ?", [$now])
              ->whereRaw("STR_TO_DATE(CONCAT(date,' ',end_time),'%Y-%m-%d %H:%i:%s') >= ?", [$now]);
        } elseif ($request->status === 'Sắp chiếu') {
            $q->whereRaw("STR_TO_DATE(CONCAT(date,' ',start_time),'%Y-%m-%d %H:%i:%s') > ?", [$now]);
        } elseif ($request->status === 'Đã chiếu') {
            $q->whereRaw("STR_TO_DATE(CONCAT(date,' ',end_time),'%Y-%m-%d %H:%i:%s') < ?", [$now])
              ->where('status', '!=', 'cancelled');
        } elseif ($request->status === 'Đã hủy') {
            $q->where('status', 'cancelled');
        }elseif ($request->status === 'Đã xóa') {
            $q->whereNotNull('deleted_at'); // Lọc các bản ghi đã soft delete
        }
    });
}


    $showtimes = $query->orderBy('date', 'desc')
                   ->orderBy('start_time', 'asc') // hoặc desc tùy muốn
                   ->paginate(10);

    $districts = Cinema::select('city')->distinct()->get();
    $cinemas = Cinema::all();
    $movies = Movie::all(); // Lấy danh sách phim để filter

    return view('admin.list.showtime', compact('showtimes', 'districts', 'cinemas', 'movies'));
}


public function restore($id)
{
    $showtime = Showtime::withTrashed()->findOrFail($id);
    $showtime->restore();
    $showtime->update(['deleted_by' => null]); // Xóa thông tin người xóa

    return redirect()->route('showtimes.index')->with('success', 'Đã khôi phục suất chiếu thành công');
}






public function store(Request $request)
{
    $request->merge([
        'status' => $request->boolean('status') ? 'active' : 'inactive',
    ]);

    $startTimeRule = $request->has('auto_create') 
    ? 'nullable|date_format:H:i' // tick auto_create → giờ có thể bỏ trống
    : 'required|date_format:H:i'; // không tick → bắt buộc nhập giờ

    $data = $request->validate([
    'movie_id'   => 'required|exists:movies,movie_id',
    'district'   => 'required|string',
    'cinema_id'  => 'required|exists:cinemas,cinema_id',
    'room_id'    => 'required|exists:rooms,room_id',
    'date'       => 'required|date|after_or_equal:today|before_or_equal:' . now()->addMonth()->toDateString(),
    'start_time' => $startTimeRule,
    'status'     => 'in:active,inactive'
], [
    'movie_id.required' => 'Vui lòng chọn phim.',
    'movie_id.exists'   => 'Phim không hợp lệ.',
    'district.required' => 'Vui lòng chọn khu vực.',
    'cinema_id.required' => 'Vui lòng chọn rạp chiếu.',
    'cinema_id.exists'   => 'Rạp chiếu không hợp lệ.',
    'room_id.required'  => 'Vui lòng chọn phòng chiếu.',
    'room_id.exists'    => 'Phòng chiếu không hợp lệ.',
    'date.required'     => 'Vui lòng chọn ngày chiếu.',
    'date.date'         => 'Ngày chiếu không hợp lệ.',
    'date.after_or_equal' => 'Ngày chiếu không được trước hôm nay.',
    'date.before_or_equal' => 'Ngày chiếu không được vượt quá 1 tháng so với hiện tại.',
    'start_time.required' => 'Vui lòng nhập giờ bắt đầu khi không tạo tự động.',
    'start_time.date_format' => 'Giờ bắt đầu không hợp lệ.',
    'status.in'         => 'Trạng thái không hợp lệ.',
]);


    $movie    = Movie::findOrFail($data['movie_id']);
    $duration = $movie->duration;
    $date     = $data['date'];

    // --- AUTO CREATE NHIỀU SUẤT ---
    if ($request->has('auto_create')) {
        $firstStart = $request->input('start_time') ?? '09:00';
        $start      = Carbon::createFromFormat('Y-m-d H:i', "$date $firstStart");
        $endLimit   = $start->copy()->setTime(22, 0);

        while ($start->lt($endLimit)) {
            $newStart = $start->copy();
            $newEnd   = $newStart->copy()->addMinutes($duration);

            // 🔎 Kiểm tra trùng suất (full datetime)
            $conflict = Showtime::where('room_id', $data['room_id'])
                ->where('date', $data['date'])
                ->where(function ($q) use ($newStart, $newEnd) {
                    $q->whereRaw("CONCAT(date,' ',start_time) < ?", [$newEnd->format('Y-m-d H:i:s')])
                      ->whereRaw("CONCAT(date,' ',end_time) > ?", [$newStart->format('Y-m-d H:i:s')]);
                })
                ->exists();

            if (!$conflict) {
                $showtime = Showtime::create([
                    'movie_id'   => $movie->movie_id,
                    'room_id'    => $data['room_id'],
                    'date'       => $data['date'],
                    'start_time' => $newStart->format('H:i:s'),
                    'end_time'   => $newEnd->format('H:i:s'),
                    'status'     => $data['status'],
                ]);

                // Tạo ghế cho suất chiếu
                $seats = Seat::where('room_id', $data['room_id'])->get();
                foreach ($seats as $seat) {
                    ShowtimeSeat::create([
                        'showtime_id' => $showtime->showtime_id,
                        'seat_id'     => $seat->seat_id,
                        'status'      => 'available',
                    ]);
                }
            }

            // Cộng 30 phút dọn dẹp
            $start = $newEnd->copy()->addMinutes(30);

            // --- Làm tròn lên giờ đẹp ---
            $minute        = $start->minute;
            $roundedMinute = ceil($minute / 5) * 5; // làm tròn lên bội số 5
            if ($roundedMinute >= 60) {
                $start->addHour()->minute(0);
            } else {
                $start->minute($roundedMinute);
            }
        }

        return redirect()->route('showtimes.index')
            ->with('success', 'Đã tự động tạo suất chiếu trong ngày');

    } 
    // --- TẠO 1 SUẤT ---
    else {
        $startTime = Carbon::createFromFormat('Y-m-d H:i', "$date " . $data['start_time']);
        $endTime   = $startTime->copy()->addMinutes($duration);

        // 🔎 Kiểm tra duplicate (trùng hệt suất chiếu)
        $duplicate = Showtime::where('room_id', $data['room_id'])
            ->where('date', $data['date'])
            ->where('start_time', $startTime->format('H:i:s'))
            ->where('end_time', $endTime->format('H:i:s'))
            ->exists();

        if ($duplicate) {
            return back()
                ->withErrors(['start_time' => 'Suất chiếu này đã tồn tại.'])
                ->withInput();
        }

        // 🔎 Kiểm tra overlap (trùng giờ, không cần phải y hệt)
        $conflict = Showtime::where('room_id', $data['room_id'])
            ->where('date', $data['date'])
            ->where(function ($q) use ($startTime, $endTime) {
                $q->whereRaw("CONCAT(date,' ',start_time) < ?", [$endTime->format('Y-m-d H:i:s')])
                  ->whereRaw("CONCAT(date,' ',end_time) > ?", [$startTime->format('Y-m-d H:i:s')]);
            })
            ->exists();

        if ($conflict) {
            return back()
                ->withErrors(['start_time' => 'Khung giờ này đã có suất chiếu trong phòng.'])
                ->withInput($request->all());

        }

        $showtime = Showtime::create([
            'movie_id'   => $data['movie_id'],
            'room_id'    => $data['room_id'],
            'date'       => $data['date'],
            'start_time' => $startTime->format('H:i:s'),
            'end_time'   => $endTime->format('H:i:s'),
            'status'     => $data['status'] ?? 'inactive',
        ]);

        $seats = Seat::where('room_id', $data['room_id'])->get();
        foreach ($seats as $seat) {
            ShowtimeSeat::create([
                'showtime_id' => $showtime->showtime_id,
                'seat_id'     => $seat->seat_id,
                'status'      => 'available',
            ]);
        }

        return redirect()->route('showtimes.index')
            ->with('success', 'Đã tạo suất chiếu thành công');
    }
}




public function create(Request $request)
{
    $districts = Cinema::select('city')->distinct()->get();
    $cinemas   = Cinema::all();
    $rooms     = Room::with('cinema')->get();
    $movies    = Movie::all();

    // Lấy filter từ request (ngày)
    $filterDate = $request->date ?? now()->toDateString();
     $filterCinema = $request->cinema_id ?? null;

   $query = Showtime::with(['room.cinema', 'movie'])
    ->whereDate('date', $filterDate)
    ->orderBy('start_time', 'asc');

if ($filterCinema) {
    $query->whereHas('room', function ($q) use ($filterCinema) {
        $q->where('cinema_id', $filterCinema);
    });
}

$showtimes = $query->paginate(10);  

    

    // Room đã có suất chiếu trong ngày
    $usedRooms = Showtime::whereDate('date', $filterDate)
        ->pluck('room_id')
        ->toArray();

    return view('admin.create.showtime', compact(
        'cinemas',
        'rooms',
        'movies',
        'districts',
        'showtimes',
        'usedRooms',
        'filterDate',
        'filterCinema'
    ));
}





    public function edit($id)
    {
        $showtime = Showtime::with(['movie', 'room.cinema'])->findOrFail($id);

        $movies = Movie::all();
        $rooms = Room::with('cinema')->get();
        $cinemas = Cinema::all();
        $districts = Cinema::select('city')->distinct()->get();

        return view('admin.edit.showtime', compact(
            'showtime',
            'movies',
            'rooms',
            'cinemas',
            'districts'
        ));
    }
public function update(Request $request, $id)
    {
        $request->merge([
            'status' => $request->boolean('status') ? 'active' : 'inactive',
        ]);
        $request->validate([
            'movie_id' => 'required|exists:movies,movie_id',
            'room_id' => 'required|exists:rooms,room_id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'in:active,inactive                                                                                                                                                                                 '
        ]);

        $showtime = Showtime::findOrFail($id);

        // Kết hợp ngày và giờ
        $startDateTime = Carbon::parse($request->date . ' ' . $request->start_time);
        $endDateTime = Carbon::parse($request->date . ' ' . $request->end_time);

        // Xử lý trường hợp qua đêm
        if ($endDateTime <= $startDateTime) {
            $endDateTime->addDay();
        }

        $roomChanged = $showtime->room_id != $request->room_id;

        $duplicate = Showtime::where('room_id', $request->room_id)
    ->where('date', $request->date)
    ->where('start_time', $startDateTime->format('H:i:s'))
    ->where('end_time', $endDateTime->format('H:i:s'))
    ->where('showtime_id', '!=', $id) // loại trừ chính nó
    ->exists();

if ($duplicate) {
    return back()
        ->withErrors(['start_time' => 'Suất chiếu này đã tồn tại.'])
        ->withInput();
}

// 🔎 Check overlap (trùng khung giờ)
$conflict = Showtime::where('room_id', $request->room_id)
    ->where('date', $request->date)
    ->where('showtime_id', '!=', $id) // loại trừ chính nó
    ->where(function ($q) use ($startDateTime, $endDateTime) {
        $q->whereRaw("CONCAT(date,' ',start_time) < ?", [$endDateTime->format('Y-m-d H:i:s')])
          ->whereRaw("CONCAT(date,' ',end_time) > ?", [$startDateTime->format('Y-m-d H:i:s')]);
    })
    ->exists();

if ($conflict) {
    return back()
        ->withErrors(['start_time' => 'Khung giờ này đã có suất chiếu khác trong phòng.'])
        ->withInput();
}

        $showtime->update([
            'movie_id' => $request->movie_id,
            'room_id' => $request->room_id,
            'date'       => $request->date,
            'start_time' => $startDateTime,
            'end_time' => $endDateTime,
            'status' => $request->status ?? false
        ]);

        if ($roomChanged) {

            $showtime->seats()->delete();

            $seats = Seat::where('room_id', $request->room_id)->get();
            foreach ($seats as $seat) {
                ShowtimeSeat::create([
                    'showtime_id' => $showtime->showtime_id,
                    'seat_id' => $seat->seat_id,
                    'status' => 'available',
                ]);
            }
        }

        return redirect()->route('showtimes.index')
            ->with('success', 'Cập nhật suất chiếu thành công!');
    }


   public function delete(string $id)
{
    try {
        $showtime = Showtime::findOrFail($id);

        // Ghi user_id người xóa
        $showtime->deleted_by = Auth::id();
        $showtime->save();

        // Xóa mềm
        $showtime->delete();

        return redirect()->route('showtimes.index')->with('success', 'Xóa suất chiếu thành công');
    } catch (Exception $e) {
        Log::error('[Showtime Delete] ' . $e->getMessage());
        return back()->withErrors(['error' => 'Lỗi khi xóa suất chiếu']);
    }
}



    public function dele()
    {
        return view('Showtime.delete');
    }
}