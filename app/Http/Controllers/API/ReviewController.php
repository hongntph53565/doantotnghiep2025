<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Danh sách đánh giá',
            'data' => Review::with(['user', 'movie'])->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'movie_id' => 'required|exists:movies,movie_id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::create($request->only([
            'user_id', 'movie_id', 'rating', 'comment'
        ]));

        return response()->json([
            'message' => 'Thêm đánh giá thành công',
            'data' => $review
        ], 201);
    }

    public function show($id)
    {
        $review = Review::with(['user', 'movie'])->find($id);

        if (!$review) {
            return response()->json(['message' => 'Không tìm thấy đánh giá'], 404);
        }

        return response()->json([
            'message' => 'Chi tiết đánh giá',
            'data' => $review
        ]);
    }

    public function update(Request $request, $id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Không tìm thấy đánh giá'], 404);
        }

        $request->validate([
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review->update($request->only(['rating', 'comment']));

        return response()->json([
            'message' => 'Cập nhật đánh giá thành công',
            'data' => $review
        ]);
    }

    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Không tìm thấy đánh giá'], 404);
        }

        $review->delete();

        return response()->json(['message' => 'Xoá đánh giá thành công']);
    }
}
