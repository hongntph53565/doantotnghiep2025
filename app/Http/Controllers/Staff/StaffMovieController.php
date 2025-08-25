<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Showtime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StaffMovieController extends Controller
{
//    public function index(Request $request)
// {
//     $user    = Auth::user();
//     $search  = trim((string)$request->input('search'));
//     $today   = Carbon::today();

//     $isStaff = (int)($user->role_id ?? 0) === 3;

// if (!$isStaff) {
//     return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập vào trang nàyyy.');
// }

// if ($isStaff && empty($user->cinema_id)) {
//     return redirect()->route('home')->with('error', 'Nhân viên chưa được gán rạp. Vui lòng liên hệ quản trị viên.');
// }

//     $cinemaId = $isStaff ? (int)$user->cinema_id : null;

//      // Lấy tất cả movie_id có suất chiếu tại rạp (hôm nay hoặc sau này)
//     // $movieIdsWithShowtimes = Showtime::query()
//     //     ->join('rooms','rooms.room_id','=','showtimes.room_id')
//     //     ->when($cinemaId, fn($q) => $q->where('rooms.cinema_id', $cinemaId))
//     //     ->where('showtimes.start_time', '>=', $today->copy()->startOfDay())
//     //     ->distinct()
//     //     ->pluck('showtimes.movie_id');

//     // Helper áp tìm kiếm
//     $applySearch = function ($q) use ($search) {
//         if ($search === '') return;
//         $q->where(function ($w) use ($search) {
//             $w->where('title', 'like', "%{$search}%")
//               ->orWhere('age_rating', 'like', "%{$search}%")
//               ->orWhere('language', 'like', "%{$search}%")
//               ->orWhereHas('genre', fn($g) => $g->where('genre_name', 'like', "%{$search}%"));
//         });
//     };

//    // Lấy tất cả movie_id có suất chiếu tại rạp (không giới hạn ngày)
// $movieIdsWithShowtimes = Showtime::query()
//     ->join('rooms','rooms.room_id','=','showtimes.room_id')
//     ->when($cinemaId, fn($q) => $q->where('rooms.cinema_id', $cinemaId))
//     ->distinct()
//     ->pluck('showtimes.movie_id');

// // Phim đang chiếu (đã phát hành tính tới hôm nay)
// $nowShowingQuery = Movie::query()
//     ->where('status', 'active')
//     ->whereDate('release_date', '<=', $today)
//     ->whereIn('movie_id', $movieIdsWithShowtimes);
// $applySearch($nowShowingQuery);

// // Phim sắp chiếu (chưa phát hành)
// $comingSoonQuery = Movie::query()
//     ->where('status', 'active')
//     ->whereDate('release_date', '>', $today)
//     ->whereIn('movie_id', $movieIdsWithShowtimes)
//     ->orderBy('release_date', 'asc');
// $applySearch($comingSoonQuery);

// $nowShowing = $nowShowingQuery->with([
//         'genre',
//         'showtimes' => function($q) use ($cinemaId) {
//             $q->join('rooms','rooms.room_id','=','showtimes.room_id')
//               ->when($cinemaId, fn($q2) => $q2->where('rooms.cinema_id', $cinemaId))
//               ->select('showtimes.*');
//         }
//     ])
//     ->paginate(8, ['*'], 'now_page')->appends($request->except('now_page'));

// $comingSoon = $comingSoonQuery->with([
//         'genre',
//         'showtimes' => function($q) use ($cinemaId) {
//             $q->join('rooms','rooms.room_id','=','showtimes.room_id')
//               ->when($cinemaId, fn($q2) => $q2->where('rooms.cinema_id', $cinemaId))
//               ->select('showtimes.*');
//         }
//     ])
//     ->paginate(8, ['*'], 'soon_page')->appends($request->except('soon_page'));


//     return view('staff.staff', compact('nowShowing', 'comingSoon', 'search'));
// }

public function index(Request $request)
{
    $user    = Auth::user();
    $search  = trim((string)$request->input('search'));
    $today   = Carbon::today();

    $isStaff = (int)($user->role_id ?? 0) === 3;

    if (!$isStaff) {
        return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập vào trang này.');
    }

    if ($isStaff && empty($user->cinema_id)) {
        return redirect()->route('home')->with('error', 'Nhân viên chưa được gán rạp. Vui lòng liên hệ quản trị viên.');
    }

    $cinemaId = (int)$user->cinema_id;

    // Helper áp tìm kiếm
    $applySearch = function ($q) use ($search) {
        if ($search === '') return;
        $q->where(function ($w) use ($search) {
            $w->where('title', 'like', "%{$search}%")
              ->orWhere('age_rating', 'like', "%{$search}%")
              ->orWhere('language', 'like', "%{$search}%")
              ->orWhereHas('genre', fn($g) => $g->where('genre_name', 'like', "%{$search}%"));
        });
    };

    // 1. Phim đang chiếu (toàn bộ, không theo rạp)
    $nowShowingQuery = Movie::query()
        ->where('status', 'active')
        ->whereDate('release_date', '<=', $today);
    $applySearch($nowShowingQuery);

    // 2. Phim sắp chiếu (toàn bộ, không theo rạp)
    $comingSoonQuery = Movie::query()
        ->where('status', 'active')
        ->whereDate('release_date', '>', $today)
        ->orderBy('release_date', 'asc');
    $applySearch($comingSoonQuery);

    $nowShowing = $nowShowingQuery->with('genre')->paginate(25, ['*'], 'now_page')
        ->appends($request->except('now_page'));

    $comingSoon = $comingSoonQuery->with('genre')->paginate(25, ['*'], 'soon_page')
        ->appends($request->except('soon_page'));

    // 3. Suất chiếu theo rạp
    $showtimes = Showtime::query()
        ->join('rooms','rooms.room_id','=','showtimes.room_id')
        ->where('rooms.cinema_id', $cinemaId)
        ->with(['movie','room'])
        ->orderBy('date','asc')
        ->orderBy('start_time','asc')
        ->get();

    return view('staff.staff', compact('nowShowing', 'comingSoon', 'showtimes', 'search'));
}




    // public function index(Request $request)
    // {
    //     $today = Carbon::today();
    //     $search = $request->input('search');

    //     // === Phim đang chiếu ===
    //     $nowShowingQuery = Movie::where('release_date', '<=', $today)
    //         ->where('end_date', '>=', $today)
    //         ->where('status', 'active')
    //         ->whereHas('showtimes.room', function ($q) use ($search) {
    //             if ($search) {
    //                 $q->where('format', 'like', "%$search%");
    //             }
    //         });

    //     // === Phim sắp chiếu ===
    //     $comingSoonQuery = Movie::where('release_date', '>', $today)
    //         ->where('status', 'active')
    //         ->orderBy('release_date', 'asc')
    //         ->whereHas('showtimes.room', function ($q) use ($search) {
    //             if ($search) {
    //                 $q->where('format', 'like', "%$search%");
    //             }
    //         });

    //     // Nếu có từ khóa tìm kiếm theo tiêu đề
    //     if ($search) {
    //         $nowShowingQuery->where('title', 'like', "%$search%");
    //         $comingSoonQuery->where('title', 'like', "%$search%");
    //     }

    //     // Lấy dữ liệu
    //     $nowShowing = $nowShowingQuery->paginate(8, ['*'], 'now_page');
    //     $comingSoon = $comingSoonQuery->paginate(8, ['*'], 'soon_page');

    //     return view('staff.staff', compact('nowShowing', 'comingSoon', 'search'));
    // }
    // return view('staff.booking');
}