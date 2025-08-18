<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showEmailForm()
{
    return view('Client.forgotPassword');
}

public function checkEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Email không tồn tại']);
    }

    // Nếu tồn tại → chuyển sang form đổi mật khẩu
    return redirect()->route('reset.password', ['email' => $user->email]);
}

public function showResetForm($email)
{
    return view('Client.resetPassword', compact('email'));
}

public function updatePassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = User::where('email', $request->email)->firstOrFail();
    $user->password = Hash::make($request->password);
    $user->save();

    // Đăng nhập ngay sau khi đổi mật khẩu
    Auth::login($user);

    // Chuyển hướng đến form đăng ký
    return redirect()->route('register.form')->with('success', 'Đổi mật khẩu thành công và đã đăng nhập.');
}

}

