<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;

class ComboController extends Controller
{
    public function getCombos()
    {
        $combos = Food::where('type', 'combo')
            ->where('status', 'active')
            ->get();
        $cart = session('cart', []);
        $totalQuantity = array_sum(array_column($cart, 'quantity'));
        return view('Client.cart.combo', compact('combos', 'totalQuantity'));
    }
    public function show($id)
    {
        $combo = Food::where('type', 'combo')
            ->where('status', 'active')
            ->where('food_id', $id)
            ->firstOrFail();
        $relatedCombos = Food::where('type', 'combo')
            ->where('status', 'active')
            ->where('food_id', '!=', $id) // bỏ combo hiện tại
            ->get();
        $cart = session('cart', []);
        $totalQuantity = array_sum(array_column($cart, 'quantity'));
        return view('Client.cart.show', compact('combo', 'relatedCombos', 'totalQuantity'));
    }
}
