<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TheaterController extends Controller
{
    public function show()
    {
        return view('client.theater_details'); 
    }
}
