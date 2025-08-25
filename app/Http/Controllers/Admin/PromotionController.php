<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PromotionController extends Controller
{
    // Hiển thị danh sách khuyến mãi
    public function index(Request $request)
    {
        $id = $request->input('id');
        $promos = Promotion::whereNull('deleted_at')->get()->groupBy('type_discount');
        return view('admin.list.promotion', compact('promos'));
    }

    // Lưu khuyến mãi mới
public function store(Request $request)
{
    $request->merge([
        'discount_value' => $request->type_discount === 'percent'
            ? $request->discount_percent
            : $request->discount_amount,
        'status' => $request->boolean('status') ? 'active' : 'inactive',
        'used_count' => 0,
    ]);

    $messages = [
        'discount_code.required' => '⚠️ Mã giảm giá không được để trống.',
        'discount_code.unique'   => '⚠️ Mã giảm giá đã tồn tại.',
        'type_discount.required' => '⚠️ Vui lòng chọn loại giảm giá.',
        'discount_value.required' => '⚠️ Giá trị giảm không được để trống.',
        'discount_value.numeric'  => '⚠️ Giá trị giảm phải là số.',
        'discount_percent.max'    => '⚠️ Phần trăm giảm không được lớn hơn 100.',
        'end_date.after_or_equal' => '⚠️ Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        'start_date.required'      => '⚠️ Ngày bắt đầu không được để trống.',
    'end_date.required'        => '⚠️ Ngày kết thúc không được để trống.',
    'max_uses.max' => '⚠️ Số lần sử dụng tối đa không được vượt quá 2000.',
     'min_order_value.max'     => '⚠️ Giá trị đơn hàng tối thiểu không được vượt quá 200.000 VNĐ.',
    
    ];

    $data = $request->validate([
        'discount_code'   => 'required|string|unique:promotions',
        'type_discount'   => 'required|in:percent,amount',
        'discount_value'  => 'required|numeric|min:0',
        'discount_percent'=> 'nullable|numeric|min:1|max:100',
        'max_uses'        => 'nullable|integer|min:1|max:2000',
        'used_count'      => 'nullable|integer|min:0',
        'max_discount'    => 'nullable|numeric|min:0',
        'min_order_value' => 'nullable|numeric|min:0|max:200000',
        'start_date'      => 'required|date',
        'end_date'        => 'required|date|after_or_equal:start_date',
        'status'          => 'in:active,inactive',
        'card_type'       => 'required|in:normal,silver,gold,platinum',
    ], $messages);

    Promotion::create($data);

    return redirect()->route('promotions.index')->with('success', '🎉 Thêm mã giảm giá thành công!');
}



public function update(Request $request, $id)
{
    $promotion = Promotion::findOrFail($id);

    $request->merge([
        'discount_value' => $request->type_discount === 'percent'
            ? $request->discount_percent
            : $request->discount_amount,
        'status' => $request->boolean('status') ? 'active' : 'inactive',
    ]);

   
    $messages = [
        'discount_code.required' => '⚠️ Mã giảm giá không được để trống.',
        'discount_code.unique'   => '⚠️ Mã giảm giá đã tồn tại.',
        'type_discount.required' => '⚠️ Vui lòng chọn loại giảm giá.',
        'discount_value.required' => '⚠️ Giá trị giảm không được để trống.',
        'discount_value.numeric'  => '⚠️ Giá trị giảm phải là số.',
        'discount_percent.max'    => '⚠️ Phần trăm giảm không được lớn hơn 100.',
        'end_date.after_or_equal' => '⚠️ Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        'start_date.required'     => '⚠️ Ngày bắt đầu không được để trống.',
        'end_date.required'       => '⚠️ Ngày kết thúc không được để trống.',
        'max_uses.max'            => '⚠️ Số lần sử dụng tối đa không được vượt quá 2000.',
         'min_order_value.max'     => '⚠️ Giá trị đơn hàng tối thiểu không được vượt quá 200.000 VNĐ.',
    ];

    try {
        $data = $request->validate([
            'discount_code'   => [
                'required',
                'string',
                Rule::unique('promotions', 'discount_code')->ignore($id, 'promo_id'),
            ],
            'type_discount'   => 'required|in:percent,amount',
            'discount_value'  => 'required|numeric|min:0',
            'discount_percent'=> 'nullable|numeric|min:1|max:100',
            'max_uses'        => 'nullable|integer|min:1|max:2000',
            'used_count'      => 'nullable|integer|min:0',
            'max_discount'    => 'nullable|numeric|min:0',
            'min_order_value' => 'nullable|numeric|min:0|max:200000',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'status'          => 'in:active,inactive',
            'card_type'       => 'required|in:normal,silver,gold,platinum',
        ], $messages);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()
            ->back()
            ->withErrors($e->validator)
            ->withInput()
            ->with('edit_mode', true)
            ->with('edit_id', $id);
    }

    $promotion->update($data);

    return redirect()->route('promotions.index')->with('success', 'Cập nhật mã giảm giá thành công!');
}


    public function destroy($id)
    {
        $promo = Promotion::findOrFail($id);
        // $promo->update(['deleted_at' => now()]);
        $promo->delete();
        return redirect()->route('promotions.index')->with('success', 'Đã xoá mã giảm giá.');

    }
    
}
