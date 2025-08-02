<?php
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Cinema;
use Illuminate\Http\Request;

class CinemaController extends Controller
{
public function index(Request $request)
{
    $keyword = $request->input('keyword');

    $query = Cinema::query();

    if ($keyword) {
        $query->where('name', 'like', "%$keyword%")
              ->orWhere('phone', 'like', "%$keyword%")
              ->orWhere('email', 'like', "%$keyword%");
    }

    $cinemas = $query->latest()->paginate(10);
    $index = 1;
    return view('admin.list.cinema', compact('cinemas', 'index'));
}

    public function create()
    {
        return view('admin.create.cinema');
    }

public function store(Request $request)
{
    // Validate đầu vào
    $validated = $request->validate([
        'name'            => 'required|string|max:255',
        'address_detail'  => 'required|string',
        'ward'            => 'required|string|max:100',
        'district'        => 'required|string|max:100',
        'city'            => 'required|string|max:100',
        'phone'           => 'nullable|string|max:20',
        'email'           => 'nullable|email|max:255',
    ]);

    // Xử lý checkbox status: nếu checkbox được bật, lưu là 'active', ngược lại 'inactive'
    $validated['status'] = $request->boolean('status') ? 'active' : 'inactive';
    // Tạo mới rạp
    Cinema::create($validated);

    return redirect()->route('cinemas.index')->with('success', 'Thêm rạp chiếu thành công!');
}


    public function edit($id)
    {
        $cinema = Cinema::findOrFail($id);
         return view('admin.edit.cinema', compact('cinema'));
    }

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'address_detail' => 'required|string',
        'ward' => 'required|string|max:100',
        'district' => 'required|string|max:100',
        'city' => 'required|string|max:100',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
    ]);

    $validated['status'] = $request->boolean('status') ? 'active' : 'inactive';

    $cinema = Cinema::findOrFail($id);
    $cinema->update($validated);

    return redirect()->route('cinemas.index')->with('success', 'Cập nhật rạp thành công!');
}


    public function delete($id)
    {
        $cinema = Cinema::findOrFail($id);
        $cinema->delete();

        return redirect()->route('cinemas.index')->with('success', 'Xoá mẫu email thành công!');
    }

 public function listCinemas()
{
    $selectedCity = session('selected_city'); // Lấy khu vực đã chọn từ session

    if ($selectedCity) {
        // Nếu người dùng đã chọn khu vực, chỉ lấy rạp ở khu vực đó
        $cinemas = Cinema::where('city', $selectedCity)->latest()->get();
    } else {
        // Nếu chưa chọn khu vực, lấy tất cả rạp
        $cinemas = Cinema::latest()->get();
    }

    return view('Client.cinemaShowtime', compact('cinemas'));
}
public function CinemaSystem()
{
    $cinemas = Cinema::all(); // Lấy toàn bộ rạp (không lọc gì hết)
    return view('Client.CinemaSystem', compact('cinemas'));
}
public function infoCinema($cinema_id)
{
    $cinema = Cinema::with('rooms')->findOrFail($cinema_id); // lấy kèm số phòng
    $otherCinemas = Cinema::where('cinema_id', '!=', $cinema_id)->get(); // rạp còn lại

    return view('Client.infoCinema', compact('cinema', 'otherCinemas'));
}

public function show($id)
{
    $cinema = Cinema::findOrFail($id);
    return view('Client.MovieShowtimesByCinema', compact('cinema'));
}
}
