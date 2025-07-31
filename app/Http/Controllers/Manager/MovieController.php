<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Genre;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Showtime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    // Hiển thị danh sách phim

    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Movie::with('genre');

        if ($keyword) {
            $query->where('title', 'like', "%$keyword%");
        }

        $movies = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        $index = ($movies->currentPage() - 1) * $movies->perPage() + 1;

        return view('manager.list.movie', compact('movies', 'index'));
    }

    // Hiển thị form tạo phim
    public function create()
    {
        $genres = Genre::where('status', 'active')->get(); // Lọc theo trạng thái nếu có
        return view('manager.create.movie', compact('genres'));
    }
}
