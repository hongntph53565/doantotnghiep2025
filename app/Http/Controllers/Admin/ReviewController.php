<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index($movie_id)
    {
        $reviews = Review::where('movie_id', $movie_id)
            ->where('status', 'active')
            ->with('user')
            ->latest()
            ->get();

        return view('admin.show.review', compact('reviews', 'movie_id'));
    }

    public function create($movie_id)
    {
        return view('reviews.create', compact('movie_id'));
    }

    // Lưu review mới
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'movie_id' => 'required|exists:movies,movie_id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'user_id' => $data['user_id'],
            'movie_id' => $data['movie_id'],
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Đánh giá đã được gửi.');
    }

    // Cập nhật review
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update($data);

        return redirect()->back()->with('success', 'Cập nhật đánh giá thành công.');
    }

    // Xoá review
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Xoá đánh giá thành công.');
    }

    // Ẩn review
    public function deactivate($id)
    {
        $review = Review::findOrFail($id);
        $review->status = 'inactive';
        $review->save();

        return redirect()->back()->with('success', 'Review đã bị ẩn.');
    }
}
