<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home()
    {
        return view('Client.home'); 
    }
    public function index()
    {
        return view('Client.cart'); 
    }
    public function booking2()
    {
        return view('Client.booking2'); 
    }
    public function booking3()
    {
        return view('Client.booking3'); 
    }
    public function booking4()
    {
        return view('Client.booking4'); 
    }
}
