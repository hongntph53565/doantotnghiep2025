<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Cinema;
use Illuminate\Support\Facades\Auth;
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

        return view('admin.list.food', compact('foods', 'districts', 'cinemas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cinema_id' => 'required|exists:cinemas,cinema_id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:combo,food,drink',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Trạng thái
        $data['status'] = $request->boolean('status') ? 'active' : 'inactive';

        // Xử lý ảnh nếu có
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

        if(Auth::user()->role_id == 1) {
            return redirect()->route('foods.index')->with('success', 'Đã thêm món ăn thành công');
        }else {
            return redirect()->route('manager.foods.index')->with('success', 'Đã thêm món ăn thành công');
        }
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
        'name' => 'required|string|max:255',
        'type' => 'required|in:combo,food,drink',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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
        if ($food->image) {
            Storage::disk('public')->delete($food->image);
        }
        $food->delete();
        return redirect()->back()->with('success', 'Đã xoá món ăn');
    }
}
