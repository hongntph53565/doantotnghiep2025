<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['author', 'categories']);

        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lọc theo khoảng ngày
        if ($request->filled('from_date')) {
            $query->whereDate('published_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('published_at', '<=', $request->to_date);
        }

        // Tìm kiếm theo tiêu đề
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $posts = $query->orderBy('published_at', 'desc')->paginate(10);
        $categories = Category::all();

        return view('admin.list.post', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.create.post', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'required|unique:posts,slug',
            'content'      => 'required',
            'status'       => 'required|in:draft,published,pending',
            'thumbnail'    => 'nullable|image|max:2048',
            'category_ids' => 'array',
        ]);

        // Upload thumbnail nếu có
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        
        $validated['published_at'] = now();

        $post = Post::create($validated);
        $post->categories()->sync($request->input('category_ids', []));

        return redirect()->route('posts.index')->with('success', 'Đã thêm bài viết.');
    }

    public function edit($id)
    {
        $post = Post::with('categories')->findOrFail($id);
        $categories = Category::all();
        return view('admin.edit.post', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'required|unique:posts,slug,' . $post->id,
            'content'      => 'required',
            'status'       => 'required|in:draft,published,pending',
            'thumbnail'    => 'nullable|image|max:2048',
            'category_ids' => 'array',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $post->update($validated);
        $post->categories()->sync($request->input('category_ids', []));

        return redirect()->route('posts.index')->with('success', 'Đã cập nhật bài viết.');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Đã xóa bài viết.');
    }

    // PostController.php
// PostController.php
public function uploadImage(Request $request)
{
    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('uploads/posts', 'public');
        return response()->json(['location' => asset('storage/' . $path)]);
    }

    return response()->json(['error' => 'Không có file'], 400);
}
}

