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
            'username'   => 'required|string|max:50|unique:users,username',
            'full_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'email' => $request->email,
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
