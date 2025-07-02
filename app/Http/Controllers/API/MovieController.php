<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MovieController extends Controller
{
    // Lấy danh sách phim
    public function index()
    {
        $movies = Movie::with('genre')->get();
        return response()->json($movies);
    }

    // Lấy chi tiết phim theo id
    public function show($id)
    {
        $movie = Movie::with('genre')->find($id);
        if (!$movie) {
            return response()->json(['message' => 'Phim không tồn tại'], 404);
        }
        return response()->json($movie);
    }

    // Tạo phim mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'genre_id' => 'required|exists:genres,genre_id',
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:0',
            'director' => 'nullable|string|max:100',
            'cast' => 'nullable|string',
            'release_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:release_date',
            'poster' => 'nullable|string|max:255',
            'trailer' => 'nullable|string|max:255',
            // 'age_rating' => 'nullable|numeric|min:0|max:10',
            'format' => ['nullable', Rule::in(['2D', '3D', 'IMAX'])],
            'language' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $movie = Movie::create($validated);

        return response()->json($movie, 201);
    }

    // Cập nhật phim
    public function update(Request $request, $id)
    {
        $movie = Movie::find($id);
        if (!$movie) {
            return response()->json(['message' => 'Phim không tồn tại'], 404);
        }

        $validated = $request->validate([
            'genre_id' => 'sometimes|required|exists:genres,genre_id',
            'title' => 'sometimes|required|string|max:255',
            'duration' => 'sometimes|required|integer|min:0',
            'director' => 'nullable|string|max:100',
            'cast' => 'nullable|string',
            'release_date' => 'sometimes|required|date',
            'end_date' => 'nullable|date|after_or_equal:release_date',
            'poster' => 'nullable|string|max:255',
            'trailer' => 'nullable|string|max:255',
            // 'age_rating' => 'nullable|numeric|min:0|max:10',
            'format' => ['nullable', Rule::in(['2D', '3D', 'IMAX'])],
            'language' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $movie->update($validated);

        return response()->json($movie);
    }

    // Xóa phim
    public function destroy($id)
    {
        $movie = Movie::find($id);
        if (!$movie) {
            return response()->json(['message' => 'Phim không tồn tại'], 404);
        }
        $movie->delete(); // Xóa mềm

        return response()->json(['message' => 'Xóa mềm phim thành công']);
    }
    // Khôi phục phim đã xóa mềm
    public function restore($id)
    {
        $movie = Movie::onlyTrashed()->find($id);
        if (!$movie) {
            return response()->json(['message' => 'Phim không tồn tại hoặc chưa bị xóa'], 404);
        }

        $movie->restore(); // Khôi phục phim

        return response()->json(['message' => 'Khôi phục phim thành công', 'movie' => $movie]);
    }

    // Xóa vĩnh viễn phim (force delete)
    public function forceDelete($id)
    {
        $movie = Movie::onlyTrashed()->find($id);
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Phim không tồn tại hoặc chưa bị xóa'], 404);
        }

        $movie->forceDelete();

        return response()->json(['message' => 'Xóa vĩnh viễn phim thành công']);
    }
}
