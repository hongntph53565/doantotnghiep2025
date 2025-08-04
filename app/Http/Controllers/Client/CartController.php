<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;
use Illuminate\Support\Facades\Auth;
use App\Models\Cinema;

class CartController extends Controller
{
   public function addToCart(Request $request)
{
    $productId = $request->input('food_id');
    $quantity = (int) $request->input('quantity', 1);
    $action = $request->input('action');
    $cinemaId = $request->input('cinema_id'); // Lấy từ form

    $product = Food::where('type', 'combo')
        ->where('status', 'active')
        ->findOrFail($productId);

    $cart = session()->get('cart', []);

    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] += $quantity;
    } else {
        $cart[$productId] = [
            'food_id' => $product->food_id,
            'name' => $product->name,
            'price' => $product->price,
            'description' => $product->description,
            'image' => $product->image,
            'quantity' => $quantity,
        ];
    }

    session()->put('cart', $cart);

    // ✅ Lưu rạp đã chọn
    if ($cinemaId) {
        session(['selected_cinema_id' => $cinemaId]);
    }

    if ($action === 'buy_now') {
        return redirect()->route('cart')->with('success', 'Chuyển đến giỏ hàng để thanh toán!');
    }

    return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
}


public function showCart(Request $request)
{
    $user = Auth::user();
    $cinemas = Cinema::all();

    $requestedCinemaId = $request->query('cinema_id'); // Lấy ?cinema_id từ URL
    $sessionCinemaId = session('selected_cinema_id');

    // Nếu có rạp mới được chọn, và khác rạp cũ → reset cart
    if ($requestedCinemaId && $requestedCinemaId != $sessionCinemaId) {
        session()->forget('cart'); // Xóa giỏ hàng cũ
        session(['selected_cinema_id' => $requestedCinemaId]); // Lưu rạp mới
    }

    $cinemaId = session('selected_cinema_id');
    $selectedCinema = $cinemaId ? Cinema::find($cinemaId) : null;

    $cart = session()->get('cart', []);
    $totalQuantity = array_sum(array_column($cart, 'quantity'));

    return view('Client.cart.cart', compact('cart', 'totalQuantity', 'user', 'selectedCinema', 'cinemas', 'cinemaId'));
}

    // public function updateCart(Request $request)
    // {
    //     $cart = session()->get('cart', []);

    //     $foodId = $request->input('food_id');
    //     $quantity = (int) $request->input('quantity');

    //     if (isset($cart[$foodId])) {
    //         if ($quantity > 0) {
    //             $cart[$foodId]['quantity'] = $quantity;
    //         } else {
    //             unset($cart[$foodId]);
    //         }
    //         session()->put('cart', $cart);
    //     }

    //     return redirect()->back();
    // }

    public function removeFromCart(Request $request)
    {
        $productId = $request->input('food_id');
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
    }
    // public function updateCart(Request $request)
    // {
    //     $foodId = $request->input('food_id');
    //     $quantity = (int) $request->input('quantity');

    //     $cart = session()->get('cart', []);

    //     $removed = false;

    //     if (isset($cart[$foodId])) {
    //         if ($quantity > 0) {
    //             $cart[$foodId]['quantity'] = $quantity;
    //         } else {
    //             unset($cart[$foodId]);
    //             $removed = true;
    //         }
    //     }

    //     session()->put('cart', $cart);

    //     $totalAll = 0;
    //     foreach ($cart as $item) {
    //         $totalAll += $item['price'] * $item['quantity'];
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'removed' => $removed,
    //         'totalAll' => number_format($totalAll, 3, '.', ',') . ' VND',
    //     ]);
    // }
    public function updateCart(Request $request)
{
    $foodId = $request->input('food_id');
    $quantity = (int) $request->input('quantity');

    $cart = session()->get('cart', []);

    $removed = false;

    if (isset($cart[$foodId])) {
        if ($quantity <= 0) {
            unset($cart[$foodId]);
            $removed = true;
        } else {
            $cart[$foodId]['quantity'] = $quantity;
        }
    }

    session()->put('cart', $cart);

    // Tính tổng lại
    $totalAll = 0;
    foreach ($cart as $item) {
        $totalAll += $item['quantity'] * $item['price'];
    }

    return response()->json([
    'success' => true,
    'removed' => $removed,
    'totalAll' => number_format($totalAll, 0, '.', ',') . ' VND',
    'totalQuantity' => array_sum(array_column($cart, 'quantity')), // 👈 Thêm dòng này
]);
}

}