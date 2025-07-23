<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function indexlogin()
    {
        return view('admin.test.login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name'   => 'required|string|max:50',
            'last_name'  => 'required|string|max:100',
            'gender'    => 'required|in:nam,nu,khac',
            'phone'     => 'required|unique:users,phone',
            'birth_day' => 'required|integer|min:1|max:31',
            'birth_month' => 'required|integer|min:1|max:12',
            'birth_year' => 'required|integer|min:1950',
            'province' => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:6|confirmed',
            'role' => 'required',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'birth_day' => $request->birth_day,
            'birth_month' => $request->birth_month,
            'birth_year' => $request->birth_year,
            'province' => $request->province,
            'role' => $request->role,
            'status' => 'active',
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        if ($user) {
            Auth::login($user);
            event(New UserRegistered($user));
            return redirect('/admin/dashboard');
        } else {
            return back()->withErrors(['register' => 'Đăng ký thất bại, vui lòng thử lại.']);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            session(['my_name' => Auth::user()->full_name]);
            session(['my_id' => Auth::user()->user_id]);

            return redirect('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/dashboard');
    }
}
