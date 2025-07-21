<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
     // Hiển thị form đăng nhập + đăng ký
    public function showLoginForm()
    {
        return view('Client.auth'); // Hiển thị view login.blade.php
    }

    public function login(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ], [
        'email.required' => 'Vui lòng nhập email.',
        'email.email' => 'Email không đúng định dạng.',
        'password.required' => 'Vui lòng nhập mật khẩu.',
    ]);

    if (Auth::attempt([
        'email' => $request->email,
        'password' => $request->password
    ])) {
        // Đăng nhập thành công
        $request->session()->regenerate();
        return redirect('/dashboard');
    }

    // Nếu đăng nhập thất bại:
    return back()
        ->withErrors(['login_error' => 'Email hoặc mật khẩu không đúng.'])
        ->withInput();
}

    public function register(Request $request)
    {
         $validator = Validator::make($request->all(), [
        'last_name' => 'required|string|max:255',
        'first_name' => 'required|string|max:255',
        'gender' => 'required|in:nam,nu,khac',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|unique:users,phone',
        'password' => 'required|confirmed|min:6',
        'birth_day' => 'required|integer|min:1|max:31',
        'birth_month' => 'required|integer|min:1|max:12',
        'birth_year' => 'required|integer|min:1950|max:' . now()->year,
    ], [
        'email.unique' => 'Email đã tồn tại trong hệ thống.',
        'phone.unique' => 'Số điện thoại đã tồn tại trong hệ thống.',
    ]);

    if ($validator->fails()) {
        return back()
            ->withErrors($validator, 'register')
            ->withInput();
    }

    $user = User::create([
        'last_name' => $request->last_name,
        'first_name' => $request->first_name,
        'gender' => $request->gender,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'birth_day' => $request->birth_day,
        'birth_month' => $request->birth_month,
        'birth_year' => $request->birth_year,
    ]);

        Auth::login($user);

        return redirect('/login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

}
