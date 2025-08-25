<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Cinema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->latest()->paginate(10);
        $roles = Role::all();
        
        return view('admin.list.user', compact('users', 'roles'));
    }

public function edit($id)
{
    $user = User::findOrFail($id);
    $roles = Role::all();
    $cinemas = Cinema::all();

    // Nếu là manager thì lấy từ bảng manager_cinema
    if ($user->role_id == 2) {
        $cinemaId = DB::table('manager_cinema')
            ->where('user_id', $id)
            ->value('cinema_id');
    } 
    // Nếu là employee thì lấy trực tiếp từ bảng users
    elseif ($user->role_id == 3) {
        $cinemaId = $user->cinema_id;
    } else {
        $cinemaId = null;
    }

    return view('admin.edit.user', compact('user', 'roles', 'cinemas', 'cinemaId'));
}


public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $data = $request->validate(
        [
            'username'   => 'required|string|max:255',
            'full_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
            'phone'      => 'nullable|regex:/^0\d{9,10}$/',
            'role_id'    => 'required|exists:roles,role_id',
            'cinema_id'  => 'nullable|exists:cinemas,cinema_id',
            'password'   => 'nullable|string|min:6|confirmed',
            'status'     => 'nullable|boolean',
        ],
        [
            'username.required' => 'Tên đăng nhập không được để trống.',
            'username.max'      => 'Tên đăng nhập không được vượt quá :max ký tự.',

            'full_name.required' => 'Họ và tên không được để trống.',
            'full_name.max'      => 'Họ và tên không được vượt quá :max ký tự.',

            'email.required' => 'Email không được để trống.',
            'email.email'    => 'Email không đúng định dạng.',
            'email.max'      => 'Email không được vượt quá :max ký tự.',
            'email.unique'   => 'Email này đã tồn tại trong hệ thống.',

            'phone.regex'    => 'Số điện thoại phải bắt đầu bằng số 0 và có độ dài 10–11 số.',

            'role_id.required' => 'Bạn phải chọn vai trò.',
            'role_id.exists'   => 'Vai trò không hợp lệ.',

            'cinema_id.exists' => 'Rạp chiếu không hợp lệ.',

            'password.min'      => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed'=> 'Xác nhận mật khẩu không khớp.',

            'status.boolean'    => 'Trạng thái không hợp lệ.',
        ]
    );

    // Mật khẩu
    if (!empty($data['password'])) {
        $data['password'] = bcrypt($data['password']);
    } else {
        unset($data['password']);
    }

    // Trạng thái
    $data['status'] = $request->has('status') ? 'active' : 'inactive';

    /**
     * Xử lý cinema_id theo role
     */
    if ($data['role_id'] == 3) {
        // Nhân viên: lưu cinema_id trong bảng users
        $data['cinema_id'] = $request->cinema_id;
        // Xóa quan hệ trong manager_cinema nếu tồn tại
        DB::table('manager_cinema')->where('user_id', $user->user_id)->delete();
    } elseif ($data['role_id'] == 2) {
        // Quản lý: lưu cinema_id trong bảng manager_cinema
        if ($request->cinema_id) {
            DB::table('manager_cinema')->updateOrInsert(
                ['user_id' => $user->user_id],
                [
                    'cinema_id' => $request->cinema_id,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
        $data['cinema_id'] = null; // không lưu trong users
    } else {
        // Các role khác: xóa cinema_id ở cả 2 chỗ
        $data['cinema_id'] = null;
        DB::table('manager_cinema')->where('user_id', $user->user_id)->delete();
    }

    // Cập nhật user
    $user->update($data);

    return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công!');
}



    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'username' => 'required|string|max:255|unique:users,username',
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'phone' => 'nullable|string|max:20',
                'role_id' => 'required|exists:roles,role_id',
                'cinema_id' => 'nullable|exists:cinemas,cinema_id',
                'password' => 'required|string|min:6|confirmed',
                'status' => 'nullable|boolean',
            ],
            [
                'username.required' => 'Tên đăng nhập không được để trống.',
                'username.max' => 'Tên đăng nhập không được vượt quá :max ký tự.',
                'username.unique' => 'Tên đăng nhập này đã tồn tại.',

                'full_name.required' => 'Họ và tên không được để trống.',
                'full_name.max' => 'Họ và tên không được vượt quá :max ký tự.',

                'email.required' => 'Email không được để trống.',
                'email.email' => 'Email không đúng định dạng.',
                'email.max' => 'Email không được vượt quá :max ký tự.',
                'email.unique' => 'Email này đã tồn tại trong hệ thống.',

                'phone.max' => 'Số điện thoại không được vượt quá :max ký tự.',

                'role_id.required' => 'Bạn phải chọn vai trò.',
                'role_id.exists' => 'Vai trò không hợp lệ.',

                'cinema_id.exists' => 'Rạp chiếu không hợp lệ.',

                'password.required' => 'Mật khẩu không được để trống.',
                'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
                'password.confirmed' => 'Xác nhận mật khẩu không khớp.',

                'status.boolean' => 'Trạng thái không hợp lệ.',
            ]
        );

        if ($data['role_id'] != 3) {
            $data['cinema_id'] = null;
        }

        $data['password'] = bcrypt($data['password']);
        $data['status'] = $request->has('status') ? 'active' : 'inactive';

        User::create($data);

        return redirect()->route('users.index')->with('success', 'Thêm người dùng thành công!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Xóa người dùng thành công!');
    }
}