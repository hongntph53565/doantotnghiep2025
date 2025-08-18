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

class ShowtimeController extends Controller
{
    public function index(Request $request)
    {
        $query = Showtime::with(['movie', 'room', 'room.cinema']);

        // Lọc theo rạp
        if ($request->cinema_id) {
            $query->whereHas('room', function ($q) use ($request) {
                $q->where('cinema_id', $request->cinema_id);
            });
        }

        // Lọc theo ngày
        if ($request->from_date) {
            $query->whereDate('start_time', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('end_time', '<=', $request->to_date);
        }

        // Lọc theo trạng thái
        if ($request->status) {
            $now = now();
            $query->where(function ($q) use ($request, $now) {
                if ($request->status === 'Đang chiếu') {
                    $q->where('start_time', '<=', $now)->where('end_time', '>=', $now);
                } elseif ($request->status === 'Sắp chiếu') {
                    $q->where('start_time', '>', $now);
                } elseif ($request->status === 'Đã chiếu') {
                    $q->where('status', 'cancelled');
                }
            });
        }

        $showtimes = $query->orderBy('start_time')->paginate(10);
        $districts = Cinema::select('city')->distinct()->get();
        $cinemas = Cinema::all();
        $now = now();

        return view('admin.list.showtime', compact('showtimes', 'districts', 'cinemas', 'now'));
    }



    public function create()
    {
        $districts = Cinema::select('city')->distinct()->get();
        $cinemas = Cinema::all();
        $rooms = Room::all();
        $movies = Movie::all();
        $showtimes = Showtime::with('room')
            ->orderBy('start_time', 'asc')
            ->paginate(5);
        return view('admin.create.showtime', compact('cinemas', 'rooms', 'movies', 'districts', 'showtimes'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'status' => $request->boolean('status') ? 'active' : 'inactive',
        ]);
        $data = $request->validate([
            'movie_id' => 'required|exists:movies,movie_id',
            'room_id' => 'required|exists:rooms,room_id',
            'date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'status' => 'in:active,inactive'
        ]);

        $movie = Movie::findOrFail($data['movie_id']);
        $duration = $movie->duration;
        $date = $data['date'];

        if ($request->has('auto_create')) {
            $firstStart = $request->input('start_time') ?? '09:00';
            $start = Carbon::createFromFormat('Y-m-d H:i', "$date $firstStart");
            $end = $start->copy()->setTime(22, 0);

            while ($start->lt($end)) {
                $newStart = $start->copy();
                $newEnd = $newStart->copy()->addMinutes($duration);

                $showtime = Showtime::create([
                    'movie_id' => $movie->movie_id,
                    'room_id' => $data['room_id'],
                    'date' => $data['date'],
                    'start_time' => $newStart,
                    'end_time' => $newEnd,
                    'status' => $data['status']
                ]);

                $seats = Seat::where('room_id', $data['room_id'])->get();
                foreach ($seats as $seat) {
                    ShowtimeSeat::create([
                        'showtime_id' => $showtime->showtime_id,
                        'seat_id' => $seat->seat_id,
                        'status' => 'available',
                    ]);
                }

                // Cộng 30 phút dọn dẹp
                $start = $newEnd->copy()->addMinutes(30);

                // --- Làm tròn lên giờ đẹp ---
                $minute = $start->minute;
                $roundedMinute = ceil($minute / 5) * 5; // làm tròn lên bội số 5 phút
                if ($roundedMinute >= 60) {
                    $start->addHour()->minute(0);
                } else {
                    $start->minute($roundedMinute);
                }
            }
        } else {
            $startTime = Carbon::createFromFormat('Y-m-d H:i', "$date " . $data['start_time']);
            $endTime = $startTime->copy()->addMinutes($duration);

            $showtime = Showtime::create([
                'movie_id' => $data['movie_id'],
                'room_id' => $data['room_id'],
                'date' => $data['date'],
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => $data['status'] ?? 'inactive',
            ]);

            $seats = Seat::where('room_id', $data['room_id'])->get();
            foreach ($seats as $seat) {
                ShowtimeSeat::create([
                    'showtime_id' => $showtime->showtime_id,
                    'seat_id' => $seat->seat_id,
                    'status' => 'available',
                ]);
            }
        }

        return redirect()->route('showtimes.index')->with('success', 'Đã tạo suất chiếu thành công');
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

        return redirect()->route('showtimes.index')
            ->with('success', 'Cập nhật suất chiếu thành công!');
    }


    public function delete(string $id)
    {
        try {
            $showtime = Showtime::findOrFail($id);
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
