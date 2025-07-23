<?php

namespace App\Http\Controllers\Staff;


use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class StaffFoodController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Food::query();

        if ($keyword) {
            $query->where('name', 'like', "%$keyword%")
                ->orWhere('phone', 'like', "%$keyword%")
                ->orWhere('email', 'like', "%$keyword%");
        }

        $foods = $query->latest()->paginate(10);
        $index = 1;
        return view('staff.list_foods', compact('foods', 'index'));
    }



    public function show($id)
    {
        $food = Food::findOrFail($id);
        return view('staff.food_detail', compact('food'));
    }


}
