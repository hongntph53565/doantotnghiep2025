<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\Cinema;
use App\Models\Food;
use Carbon\Carbon;
use App\Models\Promotion;


use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StaffBookingController extends Controller
{
    public function show($id)
    {
        $today = Carbon::today()->toDateString();

        $movie = Movie::with([
            'showtimes' => function ($query) use ($today) {
                $query->whereDate('date', $today)
                    ->where('status', 'active')
                    ->with('room.cinema');
            },
            'genre'
        ])->findOrFail($id);

        return view('staff.booking1', [
            'movie' => $movie,
            'selectedDate' => $today
        ]);
    }

    public function showtimesByDate(Request $request, $movieId)
    {
        $date = $request->input('date'); 

        $movie = Movie::with([
            'showtimes' => function ($query) use ($date) {
                $query->whereDate('date', $date)->where('status', 'active')->with('room.cinema');
            },
            'genre'
        ])->findOrFail($movieId);

        $cinema = null;
        $firstShowtime = $movie->showtimes->first();
        if ($firstShowtime && $firstShowtime->room && $firstShowtime->room->cinema) {
            $cinema = $firstShowtime->room->cinema;
        }


        return view('staff.booking.showtimes', compact('movie', 'cinema'))->render();
    }

    public function showSeatsByRoom(Request $request, $movie_id)
    {
        $movie = Movie::with('genre')->findOrFail($movie_id);
        $date = $request->input('date', now()->toDateString());

        $query = Showtime::with('room.cinema')
            ->where('movie_id', $movie_id)
            ->where('status', 'active')
            ->whereDate('date', Carbon::parse($date)->toDateString());

        $showtimes = $query
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn($item) => $item->room->cinema->cinema_id);

        $selectedShowtimeId = $request->input('showtime');
        $selectedShowtime = null;
        $seats = collect();
        $foods = collect();
        $step = 0;

        if ($selectedShowtimeId) {
            $selectedShowtime = Showtime::with([
                'room.cinema',
                'room.seats.seatType',
                'movie'
            ])->find($selectedShowtimeId);

            if ($selectedShowtime && $selectedShowtime->room) {
                $seats = $selectedShowtime->room->seats;

                if ($seats->isEmpty()) {
                    abort(404, 'Không tìm thấy ghế nào trong phòng chiếu này.');
                }

                $step = 1;

                $cinemaId = $selectedShowtime->room->cinema_id;
                $foods = Food::where('cinema_id', $cinemaId)
                    ->where('status', 'active')
                    ->get()
                    ->groupBy('type');
            }
        }
        return view('staff.booking2', compact(
            'movie',
            'showtimes',
            'selectedShowtimeId',
            'selectedShowtime',
            'seats',
            'step',
            'foods'
        ));
    }

public function booking(Request $request, $movie_id)
{
    $movie = Movie::with('genre')->findOrFail($movie_id);
    $date = $request->input('date', now()->toDateString());

    $selectedCity = trim(strtolower(Session::get('selected_city')));

    $query = Showtime::with(['room.cinema'])
        ->where('movie_id', $movie_id)
        ->where('status', 'active')
        ->whereDate('date', Carbon::parse($date)->toDateString());

    // Nếu là nhân viên -> chỉ lấy suất chiếu của cinema_id mà nhân viên thuộc về
    if (Auth::check() && Auth::user()->role_id == 3 && Auth::user()->cinema_id) {
        $cinemaId = Auth::user()->cinema_id;
        $query->whereHas('room.cinema', function ($q) use ($cinemaId) {
            $q->where('cinema_id', $cinemaId);
        });
    }
    // Nếu không phải nhân viên, lọc theo city nếu có
    elseif ($selectedCity) {
        $query->whereHas('room.cinema', function ($q) use ($selectedCity) {
            $q->whereRaw('LOWER(city) LIKE ?', ['%' . strtolower($selectedCity) . '%']);
        });
    }

    $showtimes = $query->orderBy('start_time')->get()
        ->groupBy(fn($item) => $item->room->cinema->cinema_id);

    $promotions = Promotion::where('status', 'active')
        ->whereDate('start_date', '<=', now())
        ->whereDate('end_date', '>=', now())
        ->get();

    $selectedShowtimeId = $request->input('showtime_id');
    $selectedShowtime = null;
    $seats = collect();
    $foods = collect();
    $step = 0;
    $showtimeSeatStatuses = [];

    if ($selectedShowtimeId) {
        if (!Auth::check()) {
            return redirect()->route('register.form')
                ->with('message', 'Vui lòng đăng ký hoặc đăng nhập để tiếp tục đặt vé.');
        }

        $selectedShowtime = Showtime::with(['room.cinema', 'room.seats.seatType', 'movie'])
            ->find($selectedShowtimeId);

        if ($selectedShowtime && $selectedShowtime->room) {
            $seats = $selectedShowtime->room->seats;
            $step = 1;

            $showtimeSeatStatuses = \App\Models\ShowtimeSeat::where('showtime_id', $selectedShowtime->showtime_id)
                ->pluck('status', 'seat_id')
                ->toArray();

            $cinemaId = $selectedShowtime->room->cinema_id;
            $foods = Food::where('cinema_id', $cinemaId)
                ->where('status', 'active')
                ->get()
                ->groupBy('type');
        }
    }

    return view('staff.booking1', compact(
        'movie',
        'showtimes',
        'selectedShowtimeId',
        'selectedShowtime',
        'seats',
        'step',
        'foods',
        'showtimeSeatStatuses',
        'promotions',
        'selectedCity'
    ));
}


public function getCombos(Request $request)
{
    $cinemaId = $request->input('cinema_id');
    $sessionCinemaId = session('selected_cinema_id');

     if (!Auth::check() || !Auth::user()) {
        return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập vào trang này.');
    }

    $user = Auth::user();

    // Nếu là nhân viên → mặc định cinemaId = rạp của họ
    if (Auth::user()->role_id == 3 && !$cinemaId) {
        $cinemaId = Auth::user()->cinema_id;
    }

    // Nếu chọn rạp khác → reset giỏ hàng và lưu lại rạp mới
    if ($cinemaId && $cinemaId != $sessionCinemaId) {
        session()->forget('cart'); // Xoá giỏ hàng cũ
        session(['selected_cinema_id' => $cinemaId]); // Lưu rạp mới
    }

    // Lấy tất cả rạp để hiển thị dropdown
    $cinemas = Cinema::all();

    // Nếu có rạp → lọc combo theo rạp đó
    if ($cinemaId) {
    $combos = Food::whereIn('type', ['combo', 'food'])
        ->where('status', 'active')
        ->where('cinema_id', $cinemaId)
        ->get();
} else {
    $combos = collect(); // không chọn rạp thì trả về rỗng
}

    // Tính tổng số lượng sản phẩm trong giỏ
    $cart = session('cart', []);
    $totalQuantity = array_sum(array_column($cart, 'quantity'));

    return view('staff.cart.combo', compact('combos', 'totalQuantity', 'cinemas', 'cinemaId'));
}


  public function showCombo(Request $request, $id)
{
    $combo = Food::whereIn('type', ['combo', 'food']) 
        ->where('status', 'active')
        ->where('food_id', $id)
        ->firstOrFail();

    $cart = session('cart', []);
    $totalQuantity = array_sum(array_column($cart, 'quantity'));

    $cinemas = Cinema::all();
    $cinemaId = $request->input('cinema_id');

    // Query mặc định
    $relatedQuery = Food::whereIn('type', ['combo', 'food'])
        ->where('status', 'active')
        ->where('food_id', '!=', $id);

    // Nếu nhân viên → chỉ lấy theo rạp của họ
    if (Auth::check() && Auth::user()->role_id == 3) {
        $relatedQuery->where('cinema_id', Auth::user()->cinema_id);
    } elseif ($cinemaId) {
        // Nếu có chọn cinema → lọc theo cinema đó
        $relatedQuery->where('cinema_id', $cinemaId);
    }

    $relatedCombos = $relatedQuery->get();

    return view('staff.cart.show', compact(
        'combo',
        'relatedCombos',
        'totalQuantity',
        'cinemas',
        'cinemaId'
    ));
}


  public function addToCart(Request $request)
{
    $productId = $request->input('food_id');
    $quantity = (int) $request->input('quantity', 1);
    $action = $request->input('action');
    $cinemaId = $request->input('cinema_id'); // Lấy từ form

    $product = Food::whereIn('type', ['combo', 'food'])
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
        return redirect()->route('staff.cart')->with('success', 'Chuyển đến giỏ hàng để thanh toán!');
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

    return view('staff.cart.cart', compact('cart', 'totalQuantity', 'user', 'selectedCinema', 'cinemas', 'cinemaId'));
}


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
    'totalQuantity' => array_sum(array_column($cart, 'quantity')), 
]);
}


}