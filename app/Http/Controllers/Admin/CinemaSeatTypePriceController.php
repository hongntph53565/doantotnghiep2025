<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cinema;
use App\Models\SeatType;
use App\Models\CinemaSeatTypePrice;

class CinemaSeatTypePriceController extends Controller
{
    public function index()
    {
        $prices = CinemaSeatTypePrice::with(['cinema', 'seatType'])->get();
        $cinemas = Cinema::all();
        $seatTypes = SeatType::all();
        $districts = Cinema::select('city')->distinct()->get();

        return view('admin.list.cinemaseatprice', compact('prices', 'cinemas', 'seatTypes', 'districts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cinema_id'     => 'required|exists:cinemas,cinema_id',
            'seat_type_id'  => 'required|exists:seat_types,seat_type_id',
            'price'         => 'required|numeric|min:0',
        ]);

        // Nếu đã tồn tại thì cập nhật luôn
        $existing = CinemaSeatTypePrice::where('cinema_id', $data['cinema_id'])
            ->where('seat_type_id', $data['seat_type_id'])
            ->first();

        if ($existing) {
            $existing->update(['price' => $data['price']]);
        } else {
            CinemaSeatTypePrice::create($data);
        }

        return redirect()->back()->with('success', 'Thêm/Cập nhật giá vé thành công');
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

    public function destroy($id)
    {
        $price = CinemaSeatTypePrice::findOrFail($id);
        $price->delete();

        return redirect()->back()->with('success', 'Xóa giá vé thành công');
    }
}
