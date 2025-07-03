<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
     // Hiển thị form đăng nhập + đăng ký
    public function showLoginForm()
    {
        return view('client.auth'); // Hiển thị view login.blade.php
    }


}
