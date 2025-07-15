<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->input('food_id');
        $quantity = (int) $request->input('quantity', 1);
        $action = $request->input('action');

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

        if ($action === 'buy_now') {
            return redirect()->route('cart')->with('success', 'Chuyển đến giỏ hàng để thanh toán!');
        }

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);
        $totalQuantity = array_sum(array_column($cart, 'quantity'));
        return view('Client.cart.cart', compact('cart', 'totalQuantity'));
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
    public function updateCart(Request $request)
    {
        $foodId = $request->input('food_id');
        $quantity = (int) $request->input('quantity');

        $cart = session()->get('cart', []);

        $removed = false;

        if (isset($cart[$foodId])) {
            if ($quantity > 0) {
                $cart[$foodId]['quantity'] = $quantity;
            } else {
                unset($cart[$foodId]);
                $removed = true;
            }
        }

        session()->put('cart', $cart);

        $totalAll = 0;
        foreach ($cart as $item) {
            $totalAll += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'removed' => $removed,
            'totalAll' => number_format($totalAll, 3, '.', ',') . ' VND',
        ]);
    }
}
