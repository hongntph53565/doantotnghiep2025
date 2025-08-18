<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExtraPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ExtraPriceController extends Controller
{
    public function index()
    {
        $extraPrices = ExtraPrice::orderByDesc('date')->paginate(10);

        // Thêm label hiển thị cho loại ngày (weekday, weekend, holiday)
        $extraPrices->getCollection()->transform(function ($item) {
            $item->day_type_label = match ($item->day_type) {
                'weekday' => 'Ngày thường',
                'weekend' => 'Cuối tuần',
                'holiday' => 'Ngày lễ',
                default => ucfirst($item->day_type),
            };
            return $item;
        });

        return view('admin.list.extraprice', compact('extraPrices'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'day_type'   => 'required|in:weekday,weekend,holiday',
            'date'       => 'nullable|date',
            'percentage' => 'required|integer|min:0|max:100',
            'description'=> 'nullable|string|max:255',
        ]);

        ExtraPrice::create($data);
        return redirect()->route('extraprices.index')->with('success', 'Thêm phụ thu thành công!');
    }

    public function update(Request $request, $id)
    {
        $extraPrice = ExtraPrice::findOrFail($id);

        $data = $request->validate([
            'day_type'   => 'required|in:weekday,weekend,holiday',
            'date'       => 'nullable|date',
            'percentage' => 'required|integer|min:0|max:100',
            'description'=> 'nullable|string|max:255',
        ]);

        $extraPrice->update($data);
        return redirect()->route('extraprices.index')->with('success', 'Cập nhật phụ thu thành công!');
    }

    public function destroy($id)
    {
        $extraPrice = ExtraPrice::findOrFail($id);
        $extraPrice->delete();
        return redirect()->route('extraprices.index')->with('success', 'Xóa phụ thu thành công!');
    }
}
