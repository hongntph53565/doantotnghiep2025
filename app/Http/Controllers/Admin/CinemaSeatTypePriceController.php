<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cinema;
use App\Models\SeatType;
use App\Models\CinemaSeatTypePrice;
use Illuminate\Database\Eloquent\SoftDeletes;

class CinemaSeatTypePriceController extends Controller
{
    public function index()
    {
        $cinemas = Cinema::all();

        if ($cinemas->isEmpty()) {
            return redirect()->back()->with('error', 'Chưa có rạp nào được tạo.');
        }

        $prices = CinemaSeatTypePrice::with(['cinema', 'seatType'])
    ->whereHas('cinema') // chỉ lấy bản ghi có cinema tồn tại
    ->get();
        $seatTypes = SeatType::all();
        $districts = Cinema::select('city')->distinct()->get();

        return view('admin.list.cinemaseatprice', compact('prices', 'cinemas', 'seatTypes', 'districts'));
    }

    public function store(Request $request)
    {
        $messages = [
            'cinema_id.required'    => 'Vui lòng chọn rạp chiếu.',
            'cinema_id.exists'      => 'Rạp chiếu không tồn tại.',

            'seat_type_id.required' => 'Vui lòng chọn loại ghế.',
            'seat_type_id.exists'   => 'Loại ghế không tồn tại.',

            'price.required'        => 'Vui lòng nhập giá vé.',
            'price.numeric'         => 'Giá vé phải là một số.',
            'price.min'             => 'Giá vé không được nhỏ hơn 0.',
        ];

        $data = $request->validate([
            'cinema_id'     => 'required|exists:cinemas,cinema_id',
            'seat_type_id'  => 'required|exists:seat_types,seat_type_id',
            'price'         => 'required|numeric|min:0',
        ], $messages);

        $existing = CinemaSeatTypePrice::withTrashed()
    ->where('cinema_id', $data['cinema_id'])
    ->where('seat_type_id', $data['seat_type_id'])
    ->first();

if ($existing) {
    if ($existing->trashed()) {
        // Khôi phục bản ghi đã soft delete và cập nhật giá
        $existing->restore();
        $existing->update(['price' => $data['price']]);
    } else {
        // Nếu bản ghi tồn tại, chỉ cập nhật giá
        $existing->update(['price' => $data['price']]);
    }
} else {
    CinemaSeatTypePrice::create($data);
}

        return redirect()->back()->with('success', 'Thêm/Cập nhật giá vé thành công');
    }

    public function update(Request $request, $id)
    {
       $messages = [
        'cinema_id.required'    => 'Vui lòng chọn rạp chiếu.',
        'cinema_id.exists'      => 'Rạp chiếu không tồn tại.',

        'seat_type_id.required' => 'Vui lòng chọn loại ghế.',
        'seat_type_id.exists'   => 'Loại ghế không tồn tại.',

        'price.required'        => 'Vui lòng nhập giá vé.',
        'price.numeric'         => 'Giá vé phải là một số.',
        'price.min'             => 'Giá vé không được nhỏ hơn 0.',
        'price.max'             => 'Giá vé không được lớn hơn 500.000.',
    ];

    $data = $request->validate([
        'cinema_id'     => 'required|exists:cinemas,cinema_id',
        'seat_type_id'  => 'required|exists:seat_types,seat_type_id',
        'price'         => 'required|numeric|min:0|max:500000', // 👈 thêm max ở đây
    ], $messages);
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