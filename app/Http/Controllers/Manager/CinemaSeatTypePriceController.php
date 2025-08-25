<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\SeatType;
use App\Models\CinemaSeatTypePrice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CinemaSeatTypePriceController extends Controller
{
    public function index()
{
    $managerId = Auth::user()->user_id;

    $cinema_id = DB::table('manager_cinema')
        ->where('user_id', $managerId)
        ->value('cinema_id');

    $cinemaName = Cinema::where('cinema_id', $cinema_id)->value('name');

    // Chỉ lấy giá ghế của rạp đang quản lý
    $prices = CinemaSeatTypePrice::with(['cinema', 'seatType'])
        ->where('cinema_id', $cinema_id)
        ->get();

    $seatTypes = SeatType::all();

    return view('manager.list.cinemaseatprice', compact('prices',  'seatTypes', 'cinema_id', 'cinemaName'));
}


    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'cinema_id'     => 'required|exists:cinemas,cinema_id',
            'seat_type_id'  => 'required|exists:seat_types,seat_type_id',
            'price'         => 'required|numeric|min:0',
        ]);

        $price = CinemaSeatTypePrice::findOrFail($id);
        $price->update($data);

        return redirect()->back()->with('success', 'Cập nhật giá vé thành công');
    }
}
