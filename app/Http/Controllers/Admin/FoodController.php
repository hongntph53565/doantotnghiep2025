<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Cinema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FoodController extends Controller
{
    // Danh sách tất cả món ăn
    public function index()
    {
        $districts = Cinema::select('city')->distinct()->get();
        $cinemas = Cinema::select('cinema_id', 'name', 'city')->get();
        $foods = Food::with('cinema')->get()->groupBy('type');
        $foods = Food::with('cinema')->withTrashed()->get()->groupBy('cinema_id');

        return view('admin.list.food', compact('foods', 'districts', 'cinemas'));
    }

    public function restore($id)
{
    $food = Food::withTrashed()->findOrFail($id);
    $food->restore();

    return redirect()->back()->with('success', 'Đã khôi phục món ăn');
}


    public function store(Request $request)
{
    $data = $request->validate([
        'cinema_id' => 'required|exists:cinemas,cinema_id',
        'name'      => 'required|string|max:255',
        'type'      => 'required|in:combo,food,drink',
        'description' => 'nullable|string',
        'price'     => 'required|numeric|min:0',
        'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'cinema_id.required' => 'Vui lòng chọn rạp chiếu.',
        'cinema_id.exists'   => 'Rạp chiếu không hợp lệ.',
        'name.required'      => 'Tên món ăn không được để trống.',
        'name.max'           => 'Tên món ăn tối đa 255 ký tự.',
        'type.required'      => 'Vui lòng chọn loại món.',
        'type.in'            => 'Loại món không hợp lệ.',
        'price.required'     => 'Giá món ăn không được để trống.',
        'price.numeric'      => 'Giá phải là số.',
        'price.min'          => 'Giá phải lớn hơn hoặc bằng 0.',
        'image.image'        => 'Tệp tải lên phải là ảnh.',
        'image.mimes'        => 'Ảnh chỉ được có định dạng jpg, jpeg, png.',
        'image.max'          => 'Kích thước ảnh tối đa 2MB.',
    ]);

    $data['status'] = $request->boolean('status') ? 'active' : 'inactive';

    if ($request->hasFile('image')) {
        $file = $request->file('image');

        if (!$file->isValid()) {
            throw new \Exception('File ảnh không hợp lệ.');
        }

        $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), '-')
            . '_' . time() . '.' . $file->getClientOriginalExtension();

        $destination = public_path('storage/foods');
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $fileName);
        $data['image'] = 'foods/' . $fileName;
    }

    Food::create($data);

    return redirect()->route('foods.index')->with('success', 'Đã thêm món ăn thành công');
}


    // Hiển thị form sửa (dùng modal hoặc route riêng)
    public function edit($id)
    {
        $food = Food::findOrFail($id);
$districts = Cinema::select('city')->distinct()->get();
        $cinemas = Cinema::select('cinema_id', 'name', 'city')->get();
        return view('admin.edit.food', compact('food', 'cinemas','districts'));
    }

    // Cập nhật món ăn
public function update(Request $request, $id)
{
    $food = Food::where('food_id', $id)->firstOrFail();
   $data = $request->validate([
        'cinema_id' => 'required|exists:cinemas,cinema_id',
        'name'      => 'required|string|max:255',
        'type'      => 'required|in:combo,food,drink',
        'description' => 'nullable|string',
        'price'     => 'required|numeric|min:0',
        'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ], [
        'cinema_id.required' => 'Vui lòng chọn rạp chiếu.',
        'cinema_id.exists'   => 'Rạp chiếu không hợp lệ.',

        'name.required' => 'Tên món ăn không được để trống.',
        'name.max'      => 'Tên món ăn tối đa 255 ký tự.',

        'type.required' => 'Vui lòng chọn loại món.',
        'type.in'       => 'Loại món không hợp lệ.',

        'price.required' => 'Giá món ăn không được để trống.',
        'price.numeric'  => 'Giá phải là số.',
        'price.min'      => 'Giá phải lớn hơn hoặc bằng 0.',

        'image.image' => 'Tệp tải lên phải là ảnh.',
        'image.mimes' => 'Ảnh chỉ được có định dạng jpg, jpeg, png.',
        'image.max'   => 'Kích thước ảnh tối đa 2MB.',
    ]);
    $data['status'] = $request->boolean('status') ? 'active' : 'inactive';

    // Xử lý ảnh nếu có upload mới
    if ($request->hasFile('image')) {
        $file = $request->file('image');

        if (!$file->isValid()) {
            throw new \Exception('File ảnh không hợp lệ.');
        }

        // Tên file
        $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), '-')
            . '_' . time() . '.' . $file->getClientOriginalExtension();

        // Tạo thư mục nếu chưa có
        $destination = public_path('storage/foods');
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        // Di chuyển file
        $file->move($destination, $fileName);

        // Cập nhật đường dẫn ảnh mới
        $data['image'] = 'foods/' . $fileName;

        // Xoá ảnh cũ nếu có
        if ($food->image && file_exists(public_path('storage/' . $food->image))) {
            unlink(public_path('storage/' . $food->image));
        }
    }

    $food->update($data);

    return redirect()->route('foods.index')->with('success', 'Đã cập nhật món ăn thành công');
}


    // Xoá món ăn
    public function destroy($id)
{
    $food = Food::findOrFail($id);

    // ❌ Không xóa ảnh ở đây nếu chỉ xóa mềm
    $food->delete(); // chỉ set deleted_at

    return redirect()->back()->with('success', 'Đã xoá món ăn thành công ');
}


public function forceDestroy($id)
{
    $food = Food::withTrashed()->findOrFail($id);

    // ✅ Khi xóa vĩnh viễn mới xóa ảnh
    if ($food->image && file_exists(public_path('storage/' . $food->image))) {
        unlink(public_path('storage/' . $food->image));
    }

    $food->forceDelete(); // xóa hẳn khỏi DB

    return redirect()->back()->with('success', 'Đã xoá món ăn vĩnh viễn');
}
}