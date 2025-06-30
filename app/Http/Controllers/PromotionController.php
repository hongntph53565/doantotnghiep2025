<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
public function index(Request $request)
{

    return view('admin.list.promotion');
}

}
