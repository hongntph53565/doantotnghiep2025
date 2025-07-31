<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Room::with('cinema');

        if ($keyword) {
            $query->whereHas('cinema', function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%');
            });
        }

        $rooms = $query->latest()->paginate(10);
        $index = ($rooms->currentPage() - 1) * $rooms->perPage() + 1;

        return view('manager.list.room', compact('rooms', 'index'));
    }


    public function create()
    {
        $managerId = Auth::user()->user_id;

        $cinema_id = DB::table('manager_cinema')
            ->where('user_id', $managerId)
            ->value('cinema_id');
        return view('manager.create.room', compact('cinema_id'));
    }
}
