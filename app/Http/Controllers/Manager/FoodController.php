<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Admin\Cinema;
use App\Models\Food;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    // Danh sách tất cả món ăn
    public function index()
    {
        $managerId = Auth::user()->user_id;

        $cinema_id = DB::table('manager_cinema')
            ->where('user_id', $managerId)
            ->value('cinema_id');
        $cinemaName = Cinema::where('cinema_id', $cinema_id)->value('name');
        $foods = Food::with('cinema')->get()->groupBy('type');

        return view('manager.list.food', compact('foods','cinema_id', 'cinemaName'));
    }
}
