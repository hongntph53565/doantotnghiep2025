<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Showtime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\ShowtimeSeat;
use App\Models\Seat;
use Exception;
class ShowtimeController extends Controller
{
   public function index(Request $request)
{
    // Lấy cinema_id theo manager hiện tại
    $userId   = Auth::user()->user_id; // hoặc Auth::id() nếu PK là id
    $cinemaId = DB::table('manager_cinema')
        ->where('user_id', $userId)
        ->value('cinema_id');

     if (!$cinemaId) {
        // Trả về view với thông báo
        return view('manager.list.showtime', ['errorMessage' => 'Bạn không phải Quản lý của rạp này']);
    }

    $now = now();

    // Chỉ lấy suất chiếu thuộc rạp của manager
    $query = Showtime::query()
        ->with(['movie', 'room', 'room.cinema'])
        ->whereHas('room', fn($q) => $q->where('cinema_id', $cinemaId));

    // --- FILTERS ---

    // (Tuỳ chọn) Lọc theo city (trước đây bạn dùng $request->district nhưng lại where city)
    if ($request->filled('city')) {
        $query->whereHas('room.cinema', fn($q) => $q->where('city', $request->city));
    }

    // Khoảng ngày
    if ($request->filled('from_date')) {
        $from = Carbon::parse($request->from_date)->toDateString();
        $query->whereDate('date', '>=', $from);
    }
    if ($request->filled('to_date')) {
        $to = Carbon::parse($request->to_date)->toDateString();
        $query->whereDate('date', '<=', $to);
    }

    // Trạng thái chiếu
    if ($request->filled('status')) {
        $query->where(function ($q) use ($request, $now) {
            switch ($request->status) {
                case 'Đang chiếu':
                    $q->whereDate('date', $now->toDateString())
                      ->whereTime('start_time', '<=', $now->toTimeString())
                      ->whereTime('end_time',   '>=', $now->toTimeString());
                    break;

                case 'Sắp chiếu':
                    $q->where(function ($sub) use ($now) {
                        $sub->whereDate('date', '>', $now->toDateString())
                            ->orWhere(function ($sub2) use ($now) {
                                $sub2->whereDate('date', $now->toDateString())
                                     ->whereTime('start_time', '>', $now->toTimeString());
                            });
                    });
                    break;

                case 'Đã chiếu':
                    // Sửa lại đúng nghĩa "đã kết thúc"
                    $q->where(function ($sub) use ($now) {
                        $sub->whereDate('date', '<', $now->toDateString())
                            ->orWhere(function ($sub2) use ($now) {
                                $sub2->whereDate('date', $now->toDateString())
                                     ->whereTime('end_time', '<', $now->toTimeString());
                            });
                    });
                    break;
            }
        });
    }

    $showtimes = $query
        ->orderBy('date', 'desc')
        ->orderBy('start_time')
        ->paginate(10);


    $selectedCinema = Cinema::find($cinemaId);
    $cinemas   = $selectedCinema ? collect([$selectedCinema]) : collect();
    $districts = Cinema::where('cinema_id', $cinemaId)->select('city')->distinct()->get();

    return view('manager.list.showtime', compact(
        'showtimes',
        'districts',
        'cinemas',
        'now',
        'selectedCinema'
    ));
}


    // public function create()
    // {
    //     $managerId = Auth::user()->user_id;

    //     $cinema_id = DB::table('manager_cinema')
    //         ->where('user_id', $managerId)
    //         ->value('cinema_id');
    //     $rooms = Room::where('cinema_id', $cinema_id)->get();
    //     $movies = Movie::all();
    //     $showtimes = Showtime::with('room')
    //         ->orderBy('start_time', 'asc')
    //         ->paginate(5);
    //     return view('manager.create.showtime', compact('cinema_id', 'rooms', 'movies', 'showtimes'));
    // }


public function create(Request $request)
{
    $managerId = Auth::user()->user_id;

    // Rạp mà manager quản lý
    $cinema_id = DB::table('manager_cinema')
        ->where('user_id', $managerId)
        ->value('cinema_id');

    // Lấy rooms thuộc rạp
    $rooms = Room::where('cinema_id', $cinema_id)->get();

    // Lấy tất cả phim (dùng cho filter)
    $movies = Movie::all();

    // Filter
    $filterDate   = $request->date ?? now()->toDateString();
    $filterCinema = $request->cinema_id ?? $cinema_id;
    $filterMovie  = $request->movie_id ?? null;

    // Query suất chiếu trong ngày
    $query = Showtime::with(['room.cinema', 'movie'])
        ->whereDate('date', $filterDate)
        ->whereHas('room', function ($q) use ($cinema_id) {
            $q->where('cinema_id', $cinema_id);
        })
        ->orderBy('start_time', 'asc');

    if ($filterCinema) {
        $query->whereHas('room', function ($q) use ($filterCinema) {
            $q->where('cinema_id', $filterCinema);
        });
    }

    if ($filterMovie) {
        $query->where('movie_id', $filterMovie);
    }

    $showtimes = $query->paginate(10);

    // Nếu người dùng đã chọn giờ bắt đầu và phim => tính giờ kết thúc
    $usedRooms = [];
    if ($request->start_time && $request->movie_id) {
        $movie = Movie::find($request->movie_id);
        if ($movie) {
            $startTime = Carbon::parse($request->start_time);
            $endTime   = (clone $startTime)->addMinutes($movie->duration);

            $usedRooms = Showtime::whereDate('date', $filterDate)
                ->whereHas('room', function ($q) use ($cinema_id) {
                    $q->where('cinema_id', $cinema_id);
                })
                ->where(function ($q) use ($startTime, $endTime) {
                    $q->whereBetween('start_time', [$startTime, $endTime])
                      ->orWhereBetween('end_time', [$startTime, $endTime])
                      ->orWhere(function ($query) use ($startTime, $endTime) {
                          $query->where('start_time', '<=', $startTime)
                                ->where('end_time', '>=', $endTime);
                      });
                })
                ->pluck('room_id')
                ->toArray();
        }
    }

    $cinemas = Cinema::where('cinema_id', $cinema_id)->get();

    return view('manager.create.showtime', compact(
        'cinemas',
        'rooms',
        'movies',
        'showtimes',
        'usedRooms',
        'filterDate',
        'filterCinema',
        'filterMovie',
        'cinema_id'
    ));
}


    //  public function store(Request $request)
    // {
    //     $request->merge([
    //         'status' => $request->boolean('status') ? 'active' : 'inactive',
    //     ]);
    //     $data = $request->validate([
    //         'movie_id' => 'required|exists:movies,movie_id',
    //         'room_id' => 'required|exists:rooms,room_id',
    //         'date' => 'required|date',
    //         'start_time' => 'nullable|date_format:H:i',
    //         'status' => 'in:active,inactive'
    //     ]);

    //     $movie = Movie::findOrFail($data['movie_id']);
    //     $duration = $movie->duration;
    //     $date = $data['date'];

    //     if ($request->has('auto_create')) {
    //         $firstStart = $request->input('start_time') ?? '09:00';
    //         $start = Carbon::createFromFormat('Y-m-d H:i', "$date $firstStart");
    //         $end = $start->copy()->setTime(22, 0);

    //         while ($start->lt($end)) {
    //             $newStart = $start->copy();
    //             $newEnd = $newStart->copy()->addMinutes($duration);

    //             $showtime = Showtime::create([
    //                 'movie_id' => $movie->movie_id,
    //                 'room_id' => $data['room_id'],
    //                 'date' => $data['date'],
    //                 'start_time' => $newStart,
    //                 'end_time' => $newEnd,
    //                 'status' => $data['status']
    //             ]);

    //             $seats = Seat::where('room_id', $data['room_id'])->get();
    //             foreach ($seats as $seat) {
    //                 ShowtimeSeat::create([
    //                     'showtime_id' => $showtime->showtime_id,
    //                     'seat_id' => $seat->seat_id,
    //                     'status' => 'available',
    //                 ]);
    //             }

    //             // Cộng 30 phút dọn dẹp
    //             $start = $newEnd->copy()->addMinutes(30);

    //             // --- Làm tròn lên giờ đẹp ---
    //             $minute = $start->minute;
    //             $roundedMinute = ceil($minute / 5) * 5; // làm tròn lên bội số 5 phút
    //             if ($roundedMinute >= 60) {
    //                 $start->addHour()->minute(0);
    //             } else {
    //                 $start->minute($roundedMinute);
    //             }
    //         }
    //     } else {
    //         $startTime = Carbon::createFromFormat('Y-m-d H:i', "$date " . $data['start_time']);
    //         $endTime = $startTime->copy()->addMinutes($duration);

    //         $showtime = Showtime::create([
    //             'movie_id' => $data['movie_id'],
    //             'room_id' => $data['room_id'],
    //             'date' => $data['date'],
    //             'start_time' => $startTime,
    //             'end_time' => $endTime,
    //             'status' => $data['status'] ?? 'inactive',
    //         ]);

    //         $seats = Seat::where('room_id', $data['room_id'])->get();
    //         foreach ($seats as $seat) {
    //             ShowtimeSeat::create([
    //                 'showtime_id' => $showtime->showtime_id,
    //                 'seat_id' => $seat->seat_id,
    //                 'status' => 'available',
    //             ]);
    //         }
    //     }

    //     return redirect()->route('manager.showtimes.index')->with('success', 'Đã tạo suất chiếu thành công');
    // }

    public function store(Request $request)
{
    $managerId = Auth::user()->user_id;
    $cinema_id = DB::table('manager_cinema')
        ->where('user_id', $managerId)
        ->value('cinema_id');

    if (!$cinema_id) {
        return back()->withErrors(['cinema' => 'Bạn chưa được phân công quản lý rạp nào.']);
    }

    $request->merge([
        'status' => $request->boolean('status') ? 'active' : 'inactive',
    ]);

    $data = $request->validate([
        'movie_id'   => 'required|exists:movies,movie_id',
        'room_id'    => 'required|exists:rooms,room_id',
        'date'       => 'required|date|after_or_equal:today|before_or_equal:' . now()->addMonth()->toDateString(),
        'start_time' => 'nullable|date_format:H:i',
        'status'     => 'in:active,inactive'
    ], [
        'movie_id.required'    => 'Vui lòng chọn phim.',
        'movie_id.exists'      => 'Phim không hợp lệ.',
        'room_id.required'     => 'Vui lòng chọn phòng chiếu.',
        'room_id.exists'       => 'Phòng chiếu không hợp lệ.',
        'date.required'        => 'Vui lòng chọn ngày chiếu.',
        'date.after_or_equal'  => 'Ngày chiếu không được trước hôm nay.',
        'date.before_or_equal' => 'Ngày chiếu không vượt quá 1 tháng tới.',
        'start_time.date_format' => 'Giờ bắt đầu không hợp lệ.',
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

            // 🔎 Kiểm tra overlap
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

                // Tạo ghế
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

            // Làm tròn phút lên bội số 5
            $minute        = $start->minute;
            $roundedMinute = ceil($minute / 5) * 5;
            if ($roundedMinute >= 60) {
                $start->addHour()->minute(0);
            } else {
                $start->minute($roundedMinute);
            }
        }

        return redirect()->route('manager.showtimes.index')
            ->with('success', 'Đã tự động tạo suất chiếu trong ngày');
    }

    // --- TẠO 1 SUẤT ---
    $startTime = Carbon::createFromFormat('Y-m-d H:i', "$date " . $data['start_time']);
    $endTime   = $startTime->copy()->addMinutes($duration);

    // 🔎 Check duplicate
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

    // 🔎 Check overlap
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
            ->withInput();
    }

    $showtime = Showtime::create([
        'movie_id'   => $data['movie_id'],
        'room_id'    => $data['room_id'],
        'date'       => $data['date'],
        'start_time' => $startTime->format('H:i:s'),
        'end_time'   => $endTime->format('H:i:s'),
        'status'     => $data['status'] ?? 'inactive',
    ]);

    // Tạo ghế
    $seats = Seat::where('room_id', $data['room_id'])->get();
    foreach ($seats as $seat) {
        ShowtimeSeat::create([
            'showtime_id' => $showtime->showtime_id,
            'seat_id'     => $seat->seat_id,
            'status'      => 'available',
        ]);
    }

    return redirect()->route('manager.showtimes.index')
        ->with('success', 'Đã tạo suất chiếu thành công');
}



    public function edit($id)
    {
        $showtime = Showtime::with(['movie', 'room.cinema'])->findOrFail($id);

        $movies = Movie::all();
        $rooms = Room::with('cinema')->get();
        $cinemas = Cinema::all();
        $districts = Cinema::select('city')->distinct()->get();

        return view('manager.edit.showtime', compact(
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

        $showtime->update([
            'movie_id' => $request->movie_id,
            'room_id' => $request->room_id,
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

        return redirect()->route('manager.showtimes.index')
            ->with('success', 'Cập nhật suất chiếu thành công!');
    }


    public function delete(string $id)
    {
        try {
            $showtime = Showtime::findOrFail($id);
            $showtime->delete();
            return redirect()->route('manager.showtimes.index')->with('success', 'Xóa suất chiếu thành công');
        } catch (Exception $e) {
            Log::error('[Showtime Delete] ' . $e->getMessage());
            return back()->withErrors(['error' => 'Lỗi khi xóa suất chiếu']);
        }
    }
}
