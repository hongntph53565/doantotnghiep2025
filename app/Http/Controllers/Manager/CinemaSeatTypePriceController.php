<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\SeatType;
use App\Models\CinemaSeatTypePrice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CinemaSeatTypePriceController extends Controller
{
    public function index()
    {
        $managerId = Auth::user()->user_id;

        $cinema_id = DB::table('manager_cinema')
            ->where('user_id', $managerId)
            ->value('cinema_id');
        $cinemaName = Cinema::where('cinema_id', $cinema_id)->value('name');
        $prices = CinemaSeatTypePrice::with(['cinema', 'seatType'])->get();
        $seatTypes = SeatType::all();

        return view('manager.list.cinemaseatprice', compact('prices',  'seatTypes', 'cinema_id', 'cinemaName'));
    }
}
