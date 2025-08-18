<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Requests\GenreRequest;
use Illuminate\Support\Facades\Auth;

class GenreController extends Controller
{
public function index(Request $request)
{
    $keyword = $request->input('keyword');

    $query = Genre::query();

    if ($keyword) {
        $query->where('genre_name', 'like', "%$keyword%")   ;
    }

    $genres = $query->latest()->paginate(10);
    $index = 1;
    return view('admin.list.genre', compact('genres', 'index'));
}

    public function trashed()
    {
        return Genre::onlyTrashed()->get();
    }

        public function create()
    {
        return view('admin.create.genre');
    }

public function store(GenreRequest $request)
{

      $request->validate([
        'genre_name' => 'required|string|max:100|min:3',
        'description' => 'nullable|string|max:255',
    ], [
        // genre_name
        'genre_name.required' => 'Vui lòng nhập tên thể loại.',
        'genre_name.string'   => 'Tên thể loại phải là chuỗi ký tự.',
        'genre_name.max'      => 'Tên thể loại không được vượt quá 100 ký tự.',
        'genre_name.min'      => 'Tên thể loại phải có ít nhất 3 ký tự.',

        // description
        'description.string' => 'Mô tả phải là chuỗi ký tự.',
        'description.max'    => 'Mô tả không được vượt quá 255 ký tự.',
    ]);
    
    $data = $request->only(['genre_name', 'description']);
    $data['status'] = $request->has('status') ? 'active' : 'inactive';

    Genre::create($data);

    if(Auth::user()->role_id == 1) {
        return redirect()->route('genres.index')->with('success', 'Thể loại đã được thêm thành công.');
    } else {
        return redirect()->route('manager.genres.index')->with('success', 'Thể loại đã được thêm thành công.');
    }
}

public function edit($id)
{
    $genre = Genre::findOrFail($id);
    return view('admin.edit.genre', compact('genre'));
}

public function update(Request $request, $id)
{
      $request->validate([
        'genre_name' => 'required|string|max:50|min:3',
        'description' => 'nullable|string|max:255',
    ], [
        // genre_name
        'genre_name.required' => 'Vui lòng nhập tên thể loại.',
        'genre_name.string'   => 'Tên thể loại phải là chuỗi ký tự.',
        'genre_name.max'      => 'Tên thể loại không được vượt quá 50 ký tự.',
        'genre_name.min'      => 'Tên thể loại phải có ít nhất 3 ký tự.',

        // description
        'description.string' => 'Mô tả phải là chuỗi ký tự.',
        'description.max'    => 'Mô tả không được vượt quá 255 ký tự.',
    ]);

    $genre = Genre::findOrFail($id);
    $genre->update([
        'genre_name' => $request->genre_name,
        'description' => $request->description,
        'status' => $request->has('status') ? 'active' : 'inactive',
    ]);

    return redirect()->route('genres.index')->with('success', 'Cập nhật thể loại thành công.');
}

    public function show($id)
    {
        return Genre::findOrFail($id);
    }


    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();

        return redirect()->route('genres.index')->with('success', 'Thể loại đã được xóa thành công.');

    }

    public function restore($id)
    {
        $genre = Genre::onlyTrashed()->findOrFail($id);
        $genre->restore();

        return response()->json(['message' => 'Genre đã được khôi phục.']);
    }

    public function forceDelete($id)
    {
        $genre = Genre::onlyTrashed()->find($id);
        $genre = Genre::findOrFail($id);

        if (!$genre) {
            return response()->json(['message' => 'Không tìm thấy thể loại đã bị xóa.'], 404);
        }

        $genre->forceDelete();

        return response()->json(['message' => 'Genre đã bị xóa vĩnh viễn.']);
    }
}