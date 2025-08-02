<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use Carbon\Carbon;

class StaffMovieController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $search = $request->input('search');

        // === Phim đang chiếu ===
        $nowShowingQuery = Movie::where('release_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->where('status', 'active');

        // === Phim sắp chiếu ===
        $comingSoonQuery = Movie::where('release_date', '>', $today)
            ->where('status', 'active')
            ->orderBy('release_date', 'asc');

        // Nếu có từ khóa tìm kiếm
        if ($search) {
            $nowShowingQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('age_rating', 'like', "%$search%")
                    ->orWhere('language', 'like', "%$search%")
                    ->orWhereHas('genre', function ($query) use ($search) {
                        $query->where('genre_name', 'like', "%$search%");
                    });
            });

            $comingSoonQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('age_rating', 'like', "%$search%")
                    ->orWhere('language', 'like', "%$search%")
                    ->orWhereHas('genre', function ($query) use ($search) {
                        $query->where('genre_name', 'like', "%$search%");
                    });
            });
        }


        // Lấy dữ liệu
        $nowShowing = $nowShowingQuery->paginate(8, ['*'], 'now_page');
        $comingSoon = $comingSoonQuery->paginate(8, ['*'], 'soon_page');
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