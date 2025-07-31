<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

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
    return view('manager.list.genre', compact('genres', 'index'));
}

        public function create()
    {
        return view('manager.create.genre');
    }
}
