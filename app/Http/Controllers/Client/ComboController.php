<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Cinema;

class ComboController extends Controller
{
public function getCombos(Request $request)
{
    $cinemaId = $request->input('cinema_id');
    $sessionCinemaId = session('selected_cinema_id');

    // Nếu chọn rạp khác → reset giỏ hàng và lưu lại rạp mới
    if ($cinemaId && $cinemaId != $sessionCinemaId) {
        session()->forget('cart'); // Xoá giỏ hàng cũ
        session(['selected_cinema_id' => $cinemaId]); // Lưu rạp mới
    }

    // Lấy tất cả rạp để hiển thị dropdown
    $cinemas = Cinema::all();

    // Nếu có rạp → lọc combo theo rạp đó
    if ($cinemaId) {
        $combos = Food::where('type', 'combo')
            ->where('status', 'active')
            ->where('cinema_id', $cinemaId)
            ->get();
    } else {
        $combos = Food::where('type', 'combo')
            ->where('status', 'active')
            ->get();
    }

    // Tính tổng số lượng sản phẩm trong giỏ
    $cart = session('cart', []);
    $totalQuantity = array_sum(array_column($cart, 'quantity'));

    return view('Client.cart.combo', compact('combos', 'totalQuantity', 'cinemas', 'cinemaId'));
}

   public function show(Request $request, $id)
{
    $combo = Food::where('type', 'combo')
        ->where('status', 'active')
        ->where('food_id', $id)
        ->firstOrFail();

    $relatedCombos = Food::where('type', 'combo')
        ->where('status', 'active')
        ->where('food_id', '!=', $id)
        ->get();

    $cart = session('cart', []);
    $totalQuantity = array_sum(array_column($cart, 'quantity'));

    // Lấy lại danh sách rạp (để render dropdown nếu cần)
    $cinemas = Cinema::all();
    $cinemaId = $request->input('cinema_id');

    return view('Client.cart.show', compact(
        'combo',
        'relatedCombos',
        'totalQuantity',
        'cinemas',
        'cinemaId'
    ));
}

}