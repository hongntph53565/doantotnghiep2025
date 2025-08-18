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
        ]);
        $data = $request->validate([
    'discount_code' => 'required|string|unique:promotions',
    'type_discount' => 'required|in:percent,amount',
    'discount_value' => 'required|numeric|min:0',
    'max_uses' => 'nullable|integer|min:1',
    'max_discount' => 'nullable|numeric|min:0',
    'min_order_value' => 'nullable|numeric|min:0',
    'start_date' => 'required|date',
    'end_date' => 'required|date|after_or_equal:start_date',
    'status' => 'in:active,inactive',
], [
    'discount_code.required' => 'Mã giảm giá là bắt buộc.',
    'discount_code.unique' => 'Mã giảm giá này đã tồn tại.',
    'type_discount.required' => 'Bạn phải chọn loại giảm giá.',
    'discount_value.required' => 'Giá trị giảm giá không được để trống.',
    'discount_value.numeric' => 'Giá trị giảm giá phải là số.',
    'max_uses.integer' => 'Số lượt sử dụng tối đa phải là số nguyên.',
    'max_discount.numeric' => 'Giá trị giảm tối đa phải là số.',
    'min_order_value.numeric' => 'Giá trị đơn hàng tối thiểu phải là số.',
    'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
    'end_date.required' => 'Ngày kết thúc là bắt buộc.',
    'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
]);

        $data['status'] = $request->boolean('status') ? 'active' : 'inactive';
        Promotion::create($data);
        return redirect()->route('promotions.index')->with('success', 'Thêm mã giảm giá thành công!');
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

         $data = $request->validate([
        'discount_code' => [
            'required',
            'string',
            Rule::unique('promotions', 'discount_code')->ignore($id, 'promo_id'),
        ],
        'type_discount' => 'required|in:percent,amount',
        'discount_value' => 'required|numeric|min:0',
        'max_uses' => 'nullable|integer|min:1',
        'max_discount' => 'nullable|numeric|min:0',
        'min_order_value' => 'nullable|numeric|min:0',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'status' => 'in:active,inactive',
    ], [
        'discount_code.required' => 'Mã giảm giá là bắt buộc.',
        'discount_code.unique' => 'Mã giảm giá này đã tồn tại.',
        'type_discount.required' => 'Bạn phải chọn loại giảm giá.',
        'discount_value.required' => 'Giá trị giảm giá không được để trống.',
        'discount_value.numeric' => 'Giá trị giảm giá phải là số.',
        'max_uses.integer' => 'Số lượt sử dụng tối đa phải là số nguyên.',
        'max_discount.numeric' => 'Giá trị giảm tối đa phải là số.',
        'min_order_value.numeric' => 'Giá trị đơn hàng tối thiểu phải là số.',
        'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
        'end_date.required' => 'Ngày kết thúc là bắt buộc.',
        'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
    ]);

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
