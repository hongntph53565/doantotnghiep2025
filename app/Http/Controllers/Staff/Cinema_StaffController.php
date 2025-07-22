<?php

namespace App\Http\Controllers\Staff;

use App\Models\Showtime;
use App\Models\Movie;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Cinema;
use Illuminate\Http\Request;

class Cinema_StaffController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Cinema::query();

        if ($keyword) {
            $query->where('name', 'like', "%$keyword%")
                ->orWhere('phone', 'like', "%$keyword%")
                ->orWhere('email', 'like', "%$keyword%");
        }

        $cinemas = $query->latest()->paginate(10);
        $index = 1;
        return view('staff.list_cinema', compact('cinemas', 'index'));
    }
public function nowShowing(Request $request)
{
    $today = Carbon::today();
    $keyword = $request->input('keyword');

    $query = Movie::where('release_date', '<=', $today)
        ->where('end_date', '>=', $today)
        ->where('status', 'active')
        ->when($keyword, function ($query) use ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%$keyword%")
                  ->orWhere('format', 'like', "%$keyword%");
            });
        });

    $nowShowing = $query->paginate(8)->appends(['keyword' => $keyword]);

    return view('staff.nowShowing', compact('nowShowing', 'keyword'));
}


    public function comingSoon(Request $request)
{
    $today = Carbon::today();
    $keyword = $request->input('keyword');

    $query = Movie::where('release_date', '>', $today)
        ->where('status', 'active')
        ->when($keyword, function ($query) use ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%$keyword%")
                  ->orWhere('format', 'like', "%$keyword%");
            });
        });


    $comingSoon = $query->orderBy('release_date', 'asc')->paginate(8);

    return view('staff.comingSoon', compact('comingSoon', 'keyword'));
}


}
