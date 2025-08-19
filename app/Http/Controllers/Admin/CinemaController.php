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
            'name' => [
            'required',
            'string',
            'max:255',
            'min:3',
            function ($attribute, $value, $fail) use ($request) {
                $exists = \App\Models\Cinema::where('name', $value)
                    ->where('city', $request->city)
                    ->whereNull('deleted_at') // bỏ qua soft deleted
                    ->exists();

                if ($exists) {
                    $fail('Tên rạp đã tồn tại trong cùng thành phố.');
                }
            }
        ],
            'address_detail' => 'required|string',
            'ward'           => 'required|string|max:100',
            'district'       => 'required|string|max:100',
            'city'           => 'required|string|max:100',
            'phone'          => 'required|regex:/^0\d{9,10}$/',
            'email'          => 'required|email|max:255|min:3',
        ], [
            // Tên rạp
            'name.required'  => 'Vui lòng nhập tên rạp.',
            'name.min'       => 'Tên rạp phải có ít nhất 3 ký tự.',
            'name.max'       => 'Tên rạp không được vượt quá 255 ký tự.',

            // Địa chỉ
            'address_detail.required' => 'Vui lòng nhập địa chỉ chi tiết.',

            // Phường
            'ward.required' => 'Vui lòng nhập phường.',
            'ward.max'      => 'Tên phường không được vượt quá 100 ký tự.',

            // Quận
            'district.required' => 'Vui lòng nhập quận.',
            'district.max'      => 'Tên quận không được vượt quá 100 ký tự.',

            // Thành phố
            'city.required' => 'Vui lòng nhập thành phố.',
            'city.max'      => 'Tên thành phố không được vượt quá 100 ký tự.',

            // Số điện thoại
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex'    => 'Số điện thoại phải bắt đầu bằng số 0 và có độ dài 10–11 số.',

            // Email
            'email.required' => 'Vui lòng nhập email.',
            'email.email'    => 'Email phải đúng định dạng (ví dụ: ten@gmail.com).',
            'email.max'      => 'Email không được vượt quá 255 ký tự.',
            'email.min'      => 'Email phải có ít nhất 3 ký tự.',
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
            'name' => [
            'required',
            'string',
            'max:255',
            'min:3',
            function ($attribute, $value, $fail) use ($request) {
                $exists = \App\Models\Cinema::where('name', $value)
                    ->where('city', $request->city)
                    ->whereNull('deleted_at') // bỏ qua soft deleted
                    ->exists();

                if ($exists) {
                    $fail('Tên rạp đã tồn tại trong cùng thành phố.');
                }
            }
        ],
            'address_detail' => 'required|string',
            'ward'           => 'required|string|max:100',
            'district'       => 'required|string|max:100',
            'city'           => 'required|string|max:100',
            'phone'          => 'required|regex:/^0\d{9,10}$/',
            'email'          => 'required|email|max:255|min:3',
        ], [
            // Tên rạp
            'name.required'  => 'Vui lòng nhập tên rạp.',
            'name.min'       => 'Tên rạp phải có ít nhất 3 ký tự.',
            'name.max'       => 'Tên rạp không được vượt quá 255 ký tự.',

            // Địa chỉ
            'address_detail.required' => 'Vui lòng nhập địa chỉ chi tiết.',

            // Phường
            'ward.required' => 'Vui lòng nhập phường.',
            'ward.max'      => 'Tên phường không được vượt quá 100 ký tự.',

            // Quận
            'district.required' => 'Vui lòng nhập quận.',
            'district.max'      => 'Tên quận không được vượt quá 100 ký tự.',

            // Thành phố
            'city.required' => 'Vui lòng nhập thành phố.',
            'city.max'      => 'Tên thành phố không được vượt quá 100 ký tự.',

            // Số điện thoại
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex'    => 'Số điện thoại phải bắt đầu bằng số 0 và có độ dài 10–11 số.',

            // Email
            'email.required' => 'Vui lòng nhập email.',
            'email.email'    => 'Email phải đúng định dạng (ví dụ: ten@gmail.com).',
            'email.max'      => 'Email không được vượt quá 255 ký tự.',
            'email.min'      => 'Email phải có ít nhất 3 ký tự.',
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

        return redirect()->route('cinemas.index')->with('success', 'Xoá rạp thành công!');
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
