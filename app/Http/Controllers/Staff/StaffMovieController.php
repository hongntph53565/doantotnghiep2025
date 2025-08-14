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
   public function index(Request $request)
{
    $user    = Auth::user();
    $search  = trim((string)$request->input('search'));
    $today   = Carbon::today();

    $isStaff = (int)($user->role_id ?? 0) === 3;

    if (!$isStaff) abort(403);
    if ($isStaff && empty($user->cinema_id)) abort(403, 'Nhân viên chưa được gán rạp.');

    $cinemaId = $isStaff ? (int)$user->cinema_id : null;

    // Lấy movie_id có suất HÔM NAY tại đúng rạp
    $todayMovieIds = Showtime::query()
        ->join('rooms','rooms.room_id','=','showtimes.room_id')
        ->when($cinemaId, fn($q) => $q->where('rooms.cinema_id', $cinemaId))
        ->whereBetween('showtimes.start_time', [$today->copy()->startOfDay(), $today->copy()->endOfDay()])
        ->distinct()->pluck('showtimes.movie_id');

    // Lấy movie_id có suất TƯƠNG LAI tại đúng rạp
    $futureMovieIds = Showtime::query()
        ->join('rooms','rooms.room_id','=','showtimes.room_id')
        ->when($cinemaId, fn($q) => $q->where('rooms.cinema_id', $cinemaId))
        ->where('showtimes.start_time', '>', $today->copy()->endOfDay())
        ->distinct()->pluck('showtimes.movie_id');

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

    // Phim đang chiếu hôm nay (đúng rạp)
    $nowShowingQuery = Movie::query()
        ->where('status', 'active')
        ->whereIn('movie_id', $todayMovieIds);
    $applySearch($nowShowingQuery);

    // Phim sắp chiếu (đúng rạp, có suất sau hôm nay)
    $comingSoonQuery = Movie::query()
        ->where('status', 'active')
        ->whereIn('movie_id', $futureMovieIds)
        ->orderBy('release_date', 'asc');
    $applySearch($comingSoonQuery);

    $nowShowing = $nowShowingQuery->with('genre')
        ->paginate(8, ['*'], 'now_page')->appends($request->except('now_page'));

    $comingSoon = $comingSoonQuery->with('genre')
        ->paginate(8, ['*'], 'soon_page')->appends($request->except('soon_page'));

    return view('staff.staff', compact('nowShowing', 'comingSoon', 'search'));
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