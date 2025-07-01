<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function index()
    {
        return view('Client.booking2');
    }
}
