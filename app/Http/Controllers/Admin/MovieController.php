<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Genre;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Showtime;
use BaconQrCode\Renderer\Path\Move;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MovieController extends Controller
{


    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Movie::withTrashed()->with('genre');

        if ($keyword) {
            $query->where('title', 'like', "%$keyword%");
        }

        $movies = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        $index = ($movies->currentPage() - 1) * $movies->perPage() + 1;

        return view('admin.list.movie', compact('movies', 'index'));
    }


    public function create()
    {
        $genres = Genre::where('status', 'active')->get();
        return view('admin.create.movie', compact('genres'));
    }

    public function store(Request $request)
    {
        $messages = [
            'title.required' => 'Vui lòng nhập tiêu đề phim.',
            'title.string' => 'Tiêu đề phải là chuỗi ký tự.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',

            'genre_id.required' => 'Vui lòng chọn thể loại phim.',
            'genre_id.exists' => 'Thể loại phim không tồn tại.',

            'duration.required' => 'Vui lòng nhập thời lượng phim.',
            'duration.integer' => 'Thời lượng phải là số nguyên.',
            'duration.between' => 'Thời lượng phim phải từ 1 đến 500 phút.',

            'director.string' => 'Đạo diễn phải là chuỗi ký tự.',
            'director.max' => 'Đạo diễn không được vượt quá 255 ký tự.',

            'cast.string' => 'Diễn viên phải là chuỗi ký tự.',

            'release_date.required' => 'Vui lòng chọn ngày khởi chiếu.',
            'release_date.date' => 'Ngày khởi chiếu không hợp lệ.',

            'end_date.required' => 'Vui lòng chọn ngày kết thúc.',
            'end_date.date' => 'Ngày kết thúc không hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải bằng hoặc sau ngày khởi chiếu.',

            'poster.required' => 'Vui lòng chọn poster cho phim.',
            'poster.image' => 'File poster phải là hình ảnh.',
            'poster.mimes' => 'File poster phải có định dạng: jpeg, png, jpg.',
            'poster.max' => 'File poster không được lớn hơn 2MB.',

            'trailer.url' => 'Trailer phải là một URL hợp lệ.',

            'age_rating.required' => 'Vui lòng chọn độ tuổi phù hợp.',
            'age_rating.in' => 'Độ tuổi không hợp lệ.',

            'format.required' => 'Vui lòng chọn định dạng phim.',
            'format.string' => 'Định dạng phim phải là chuỗi ký tự.',
            'format.max' => 'Định dạng phim không được vượt quá 50 ký tự.',

            'language.required' => 'Vui lòng chọn ngôn ngữ.',
            'language.string' => 'Ngôn ngữ phải là chuỗi ký tự.',
            'language.max' => 'Ngôn ngữ không được vượt quá 50 ký tự.',

            'description.string' => 'Mô tả phải là chuỗi ký tự.',

        ];

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,genre_id',
            'duration' => 'required|integer|between:1,500',
            'director' => 'nullable|string|max:255',
            'cast' => 'nullable|string',
            'release_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:release_date',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'trailer' => 'nullable|url',
            'age_rating' => 'required|in:P,T13,T18',
            'format' => 'required|string|max:50',
            'language' => 'required|string|max:50',
            'description' => 'nullable|string',
        ], $messages);

          $existing = Movie::where('title', $data['title'])
        ->where('release_date', $data['release_date'])
        ->first();

    if ($existing) {
        return redirect()->back()->withInput()->with('error', 'Phim này đã tồn tại!');
    }

        $data['status'] = $request->has('status') && $request->input('status') == '1' ? 'active' : 'inactive';

        // Xử lý poster
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');

            if (!$file->isValid()) {
                return redirect()->back()->withInput()->with('error', 'File poster không hợp lệ.');
            }

            $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), '-')
                . '_' . time()
                . '.' . $file->getClientOriginalExtension();

            $destination = public_path('storage/posters');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $fileName);
            $data['poster'] = 'posters/' . $fileName;
        }

        Movie::create($data);

        return redirect()->route('movies.index')->with('success', 'Thêm phim mới thành công!');
    }


    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        $genres = Genre::where('status', 'active')->get();

        return view('admin.edit.movie', compact('movie', 'genres'));
    }


    // public function update(Request $request, $id)
    // {
    //     $movie = Movie::findOrFail($id);

    //     $data = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'genre_id' => 'required|exists:genres,genre_id',
    //         'duration' => 'required|integer',
    //         'director' => 'nullable|string|max:255',
    //         'cast' => 'nullable|string',
    //         'release_date' => 'required|date',
    //         'end_date' => 'required|date|after_or_equal:release_date',
    //         'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //         'trailer' => 'nullable|url',
    //         'age_rating' => 'nullable|string|max:10',
    //         'format' => 'nullable|string|max:50',
    //         'language' => 'nullable|string|max:50',
    //         'description' => 'nullable|string',
    //     ]);


    //     $data['status'] = $request->has('status') && $request->input('status') == '1' ? 'active' : 'inactive';


    //     if ($request->hasFile('poster')) {
    //         $file = $request->file('poster');

    //         if (!$file->isValid()) {
    //             throw new \Exception('File upload không hợp lệ.');
    //         }


    //         if ($movie->poster && file_exists(public_path('storage/' . $movie->poster))) {
    //             unlink(public_path('storage/' . $movie->poster));
    //         }

    //         $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), '-')
    //             . '_' . time()
    //             . '.' . $file->getClientOriginalExtension();

    //         $destination = public_path('storage/posters');
    //         if (!file_exists($destination)) {
    //             mkdir($destination, 0755, true);
    //         }

    //         $file->move($destination, $fileName);
    //         $posterPath = 'posters/' . $fileName;

    //         $data['poster'] = $posterPath;
    //     }

    //     $movie->update($data);

    //     return redirect()->route('movies.index')->with('success', 'Cập nhật phim thành công!');
    // }

    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $messages = [
            'title.required' => 'Vui lòng nhập tiêu đề phim.',
            'title.string' => 'Tiêu đề phải là chuỗi ký tự.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',

            'genre_id.required' => 'Vui lòng chọn thể loại phim.',
            'genre_id.exists' => 'Thể loại phim không tồn tại.',

            'duration.required' => 'Vui lòng nhập thời lượng phim.',
            'duration.integer' => 'Thời lượng phải là số nguyên.',

            'director.string' => 'Đạo diễn phải là chuỗi ký tự.',
            'director.max' => 'Đạo diễn không được vượt quá 255 ký tự.',

            'cast.string' => 'Diễn viên phải là chuỗi ký tự.',

            'release_date.required' => 'Vui lòng chọn ngày khởi chiếu.',
            'release_date.date' => 'Ngày khởi chiếu không hợp lệ.',

            'end_date.required' => 'Vui lòng chọn ngày kết thúc.',
            'end_date.date' => 'Ngày kết thúc không hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải bằng hoặc sau ngày khởi chiếu.',

            'poster.image' => 'File poster phải là hình ảnh.',
            'poster.mimes' => 'File poster phải có định dạng: jpeg, png, jpg.',
            'poster.max' => 'File poster không được lớn hơn 2MB.',

            'duration.min' => 'Thời lượng phim phải lớn hơn 0 phút.',
            'duration.max' => 'Thời lượng phim không được vượt quá 500 phút.',

            'trailer.url' => 'Trailer phải là một URL hợp lệ.',

            'age_rating.max' => 'Độ tuổi giới hạn không được vượt quá 10 ký tự.',
            'format.max' => 'Định dạng phim không được vượt quá 50 ký tự.',
            'language.max' => 'Ngôn ngữ không được vượt quá 50 ký tự.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.',
        ];

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,genre_id',
            'duration' => 'required|integer|min:1|max:500',
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
        ], $messages);

        $data['status'] = $request->has('status') && $request->input('status') == '1' ? 'active' : 'inactive';

        try {
            if ($request->hasFile('poster')) {
                $file = $request->file('poster');

                if (!$file->isValid()) {
                    return redirect()->back()->withInput()->with('error', 'File upload không hợp lệ.');
                }

                // Xóa poster cũ nếu có
                if ($movie->poster && file_exists(public_path('storage/' . $movie->poster))) {
                    @unlink(public_path('storage/' . $movie->poster));
                }

                $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), '-')
                    . '_' . time()
                    . '.' . $file->getClientOriginalExtension();

                $destination = public_path('storage/posters');
                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }

                $file->move($destination, $fileName);
                $data['poster'] = 'posters/' . $fileName;
            }

            $movie->update($data);

            return redirect()->route('movies.index')->with('success', 'Cập nhật phim thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Cập nhật thất bại: ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        $movie = Movie::with('genre')->findOrFail($id);


        $showtimeIds = Showtime::where('movie_id', $movie->movie_id)->pluck('showtime_id')->toArray();


        $showtimes = Showtime::with(['room.cinema', 'bookings'])
            ->whereIn('showtime_id', $showtimeIds)
            ->orderBy('start_time', 'desc')
            ->paginate(10);


        $totalRevenue = Booking::whereIn('showtime_id', $showtimeIds)->sum('total_price');


        $totalTickets = Booking::whereIn('showtime_id', $showtimeIds)->count();

        $totalSeats = Showtime::with('room')
            ->whereIn('showtime_id', $showtimeIds)
            ->get()
            ->sum(fn($showtime) => $showtime->room->total_seats);

        $occupancyRate = $totalSeats > 0 ? round(($totalTickets / $totalSeats) * 100, 2) : 0;


        $revenueByMonth = Booking::selectRaw("DATE_FORMAT(created_at, '%m/%Y') as month, SUM(total_price) as revenue")
            ->whereIn('showtime_id', $showtimeIds)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        $revenueChart = [
            'labels' => array_keys($revenueByMonth),
            'data' => array_values($revenueByMonth),
        ];
        if (!empty($movie->trailer) && Str::contains($movie->trailer, 'watch?v=')) {
            $videoId = explode('watch?v=', $movie->trailer)[1];
            $movie->trailer = 'https://www.youtube.com/embed/' . $videoId;
        }

        return view('admin.show.movie', compact(
            'movie',
            'showtimes',
            'totalRevenue',
            'totalTickets',
            'occupancyRate',
            'revenueChart'
        ));
    }


    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return redirect()->route('movies.index')->with('success', 'Xóa phim thành công!');
    }

    public function restore($id)
{
    $movie = Movie::withTrashed()->find($id);

    if ($movie && $movie->trashed()) {
        $movie->restore();
        return redirect()->route('movies.index')->with('success', 'Khôi phục phim thành công!');
    }

    return redirect()->route('movies.index')->with('error', 'Phim không tồn tại hoặc chưa bị xóa.');
}
}