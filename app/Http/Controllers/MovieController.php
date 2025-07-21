<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Showtime;
use Carbon\Carbon;
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

        return view('admin.list.movie', compact('movies', 'index'));
    }

    // Hiển thị form tạo phim
    public function create()
    {
        $genres = Genre::where('status', 'active')->get(); // Lọc theo trạng thái nếu có
        return view('admin.create.movie', compact('genres'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,genre_id',
            'duration' => 'required|integer',
            'director' => 'nullable|string|max:255',
            'cast' => 'nullable|string',
            'release_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:release_date',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'trailer' => 'nullable|url',
            'age_rating' => 'nullable|string|max:10',
            'format' => 'nullable|string|max:50',
            'language' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);
        $data['status'] = $request->has('status') && $request->input('status') == '1' ? 'active' : 'inactive';
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');

            if (!$file->isValid()) {
                throw new \Exception('File upload không hợp lệ.');
            }

            $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), '-')
                . '_' . time()
                . '.' . $file->getClientOriginalExtension();

            $destination = public_path('storage/posters');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $fileName);
            $posterPath = 'posters/' . $fileName;
        }

        if (!empty($posterPath)) {
            $data['poster'] = $posterPath;
        }

        Movie::create($data);

        return redirect()->route('movies.index')->with('success', 'Thêm phim thành công!');
    }

    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        $genres = Genre::where('status', 'active')->get();

        return view('admin.edit.movie', compact('movie', 'genres'));
    }


    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,genre_id',
            'duration' => 'required|integer',
            'director' => 'nullable|string|max:255',
            'cast' => 'nullable|string',
            'release_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:release_date',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'trailer' => 'nullable|url',
            'age_rating' => 'nullable|string|max:10',
            'format' => 'nullable|string|max:50',
            'language' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        // Xử lý trạng thái checkbox
        $data['status'] = $request->has('status') && $request->input('status') == '1' ? 'active' : 'inactive';

        // Nếu có ảnh mới, xử lý thay thế ảnh cũ
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');

            if (!$file->isValid()) {
                throw new \Exception('File upload không hợp lệ.');
            }

            // Xoá ảnh cũ nếu tồn tại
            if ($movie->poster && file_exists(public_path('storage/' . $movie->poster))) {
                unlink(public_path('storage/' . $movie->poster));
            }

            $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), '-')
                . '_' . time()
                . '.' . $file->getClientOriginalExtension();

            $destination = public_path('storage/posters');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $fileName);
            $posterPath = 'posters/' . $fileName;

            $data['poster'] = $posterPath;
        }

        $movie->update($data);

        return redirect()->route('movies.index')->with('success', 'Cập nhật phim thành công!');
    }
public function show($id)
{
    // Tạo dữ liệu phim giả
    $movie = Movie::with('genre')->where('movie_id',$id)->firstOrFail();

$showtimes = Showtime::with(['room.cinema'])->where('movie_id', $id)->get();


    // Tạo thống kê giả
    $totalTickets = 482;
    $totalRevenue = 125600000; // 125.600.000 VND
    $occupancyRate = 68; // 68%

    // Tạo dữ liệu biểu đồ giả (7 ngày gần nhất)
    $revenueChart = [
        'labels' => ['20/3', '21/3', '22/3', '23/3', '24/3', '25/3', '26/3'],
        'data' => [12000000, 18500000, 22400000, 18000000, 21000000, 19700000, 14000000]
    ];

    return view('admin.show.movie', compact(
        'movie',
        'showtimes',
        'totalTickets',
        'totalRevenue',
        'occupancyRate',
        'revenueChart'
    ));
}
}
