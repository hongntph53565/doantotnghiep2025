<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Requests\GenreRequest;

class GenreController extends Controller
{
    public function index()
    {
        return Genre::all();
    }

    public function trashed()
    {
        return Genre::onlyTrashed()->get();
    }

    public function store(GenreRequest $request)
    {
        $request->validate([
            'genre_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        return Genre::create($request->all());
    }

    public function show($id)
    {
        return Genre::findOrFail($id);
    }

    public function update(GenreRequest $request, $id)
    {
        $request->validate([
            'genre_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $genre = Genre::findOrFail($id);
        $genre->update([
            'genre_name' => $request->genre_name,
            'description' => $request->description,
        ]);

        return response()->json($genre);
    }


    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();

        return response()->json(['message' => 'Genre đã được xóa mềm.']);
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
