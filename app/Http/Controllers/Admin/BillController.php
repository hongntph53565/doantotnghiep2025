<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BillController extends Controller
{

      public function index()
    {
     return view('admin.list.bill');
    }

     public function show()
    {
     return view('admin.show.bill');
    }
}