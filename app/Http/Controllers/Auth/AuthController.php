<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
    'last_name' => 'required|string|max:50',
    'first_name' => 'required|string|max:50',
    'email' => [
        'required',
        'email',
        'regex:/^[\w.+\-]+@gmail\.com$/i',
        'unique:users,email',
    ],
    'password' => 'required|string|min:8|confirmed',
    'phone' => ['required', 'regex:/^0\d{9}$/'],
    'gender' => 'required|in:nam,nu,khac',
    'birth_day' => 'required|integer|min:1|max:31',
    'birth_month' => 'required|integer|min:1|max:12',
    'birth_year' => 'required|integer|min:1900|max:' . now()->year,
    'province' => 'required|string|max:100',
], [
    'email.required' => 'Vui lòng nhập email.',
    'email.regex' => 'Email phải là địa chỉ Gmail hợp lệ.',
    'email.unique' => 'Email này đã được sử dụng.', // <-- Dòng này!
    'phone.regex' => 'Số điện thoại phải đúng 10 chữ số và bắt đầu bằng 0.',
    'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
    'password.required' => 'Vui lòng nhập mật khẩu.',
    'first_name.required' => 'Vui lòng nhập tên.',
    'last_name.required' => 'Vui lòng nhập họ.',
    'gender.required' => 'Vui lòng chọn giới tính.',
    'province.required' => 'Vui lòng chọn tỉnh/thành phố.',
]);



    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator, 'register')->withInput();

    }

    $username = strtolower(trim($request->last_name));
    if (User::where('username', $username)->exists()) {
        return redirect()->back()->withErrors(['register' => ['username' => 'Tên tài khoản đã tồn tại!']])->withInput();
    }

    $birthday = sprintf('%04d-%02d-%02d', $request->birth_year, $request->birth_month, $request->birth_day);

    $user = User::create([
        'username' => $username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'full_name' => trim($request->last_name . ' ' . $request->first_name),
        'phone' => $request->phone,
        'address' => $request->province,
        'birthday' => $birthday,
        'gender' => $request->gender,
        'role_id' => 4,
    ]);

    event(new UserRegistered($user));

    // Đăng nhập ngay sau khi đăng ký
    Auth::login($user);

    // Nếu dùng API thì tạo token
    // $token = $user->createToken('api_token')->plainTextToken;

    // Chuyển hướng về trang chủ
    return redirect()->route('home')->with('success', 'Đăng ký và đăng nhập thành công');
}




 public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Đăng nhập thành công');
    }

    return back()->withErrors([
        'login_error' => 'Email hoặc mật khẩu không đúng!',
    ])->withInput();
}


 public function showLoginForm(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Đăng nhập thành công');
    }

    return back()->withErrors([
        'login_error' => 'Email hoặc mật khẩu không đúng!',
    ])->withInput();
}


    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home')->with('success', 'Đăng xuất thành công');
}
//     public function profile()
// {
//     $user = Auth::user();
//     return view('Client.profile', compact('user'));
// }

// public function profile(Request $request)
// {
//     $user = Auth::user();

//     // Nhận dữ liệu lọc từ query string
//     $typeFilter = $request->query('type'); // booking | combo | null
//     $monthFilter = $request->query('month'); // YYYY-MM | null

//     $bookingsQuery = Booking::with([
//         'showtime.room.cinema',
//         'bookingSeats.showtimeSeat.seat',
//         'bookingFoods.food.cinema',
//         'bookingPromotions',
//     ])
//         ->where('user_id', $user->user_id)
//         ->where('payment_status', 'paid');

//     // Lọc theo loại giao dịch
//     if ($typeFilter === 'booking') {
//         $bookingsQuery->whereNotNull('showtime_id');
//     } elseif ($typeFilter === 'combo') {
//         $bookingsQuery->whereNull('showtime_id');
//     }

//     // Lọc theo tháng
//     if ($monthFilter) {
//         try {
//             [$year, $month] = explode('-', $monthFilter);
//             $bookingsQuery->whereYear('created_at', $year)->whereMonth('created_at', $month);
//         } catch (\Exception $e) {
//             // Trường hợp định dạng sai
//         }
//     }

//     $bookings = $bookingsQuery->orderByDesc('created_at')->paginate(10);

//     // Tính tổng chi tiêu và điểm RP (của tất cả các booking đã lọc)
//     $filteredBookings = $bookings->getCollection();

//     $totalSpending = $filteredBookings->sum('total_price');
//     $totalRP = $filteredBookings->sum(fn ($b) => floor($b->total_price / 1000));

//     if ($totalSpending >= 100000) {
//         $cardLevel = 'Vàng';
//     } elseif ($totalSpending >= 50000) {
//         $cardLevel = 'Bạc';
//     } else {
//         $cardLevel = 'Bình thường';
//     }

//     return view('Client.profile', compact(
//         'user',
//         'bookings',
//         'totalSpending',
//         'totalRP',
//         'cardLevel',
//         'typeFilter',
//         'monthFilter'
//     ));
// }
public function profile(Request $request)
{
    $user = Auth::user();

    $typeFilter = $request->query('type'); // booking | combo | null
    $monthFilter = $request->query('month'); // YYYY-MM | null

    // Query chính để hiển thị danh sách booking
    $bookingsQuery = Booking::with([
        'showtime.room.cinema',
        'bookingSeats.showtimeSeat.seat',
        'bookingFoods.food.cinema',
        'bookingPromotions',
    ])
        ->where('user_id', $user->user_id)
        ->where('payment_status', 'paid');

    // Lọc theo loại giao dịch
    if ($typeFilter === 'booking') {
        $bookingsQuery->whereNotNull('showtime_id');
    } elseif ($typeFilter === 'combo') {
        $bookingsQuery->whereNull('showtime_id');
    }

    // Lọc theo tháng
    if ($monthFilter) {
        try {
            [$year, $month] = explode('-', $monthFilter);
            $bookingsQuery->whereYear('created_at', $year)->whereMonth('created_at', $month);
        } catch (\Exception $e) {
            // Bỏ qua nếu định dạng không hợp lệ
        }
    }

    // Phân trang kết quả
    $bookings = $bookingsQuery->orderByDesc('created_at')->paginate(10);

    // ✅ Tính tổng chi tiêu & RP theo dữ liệu đã lọc (bỏ qua phân trang)
    $allFilteredBookings = (clone $bookingsQuery)->get();
    $totalSpending = $allFilteredBookings->sum('total_price');
    $totalRP = $allFilteredBookings->sum(fn($b) => floor($b->total_price / 1000));

    // ✅ Tổng chi tiêu thực tế để xét hạng thẻ (tất cả đơn paid + confirmed)
    $totalSpendingForCard = Booking::where('user_id', $user->user_id)
        ->where('payment_status', 'paid')
        ->where('booking_status', 'confirmed')
        ->sum('total_price');

    // ✅ Xét hạng thẻ
    if ($totalSpendingForCard >= 100000) {
        $cardLevel = 'Vàng';
    } elseif ($totalSpendingForCard >= 50000) {
        $cardLevel = 'Bạc';
    } else {
        $cardLevel = 'Bình thường';
    }

    // ✅ Tổng chi tiêu theo từng tháng (tất cả đơn đã thanh toán)
    $allPaidBookings = Booking::where('user_id', $user->user_id)
        ->where('payment_status', 'paid')
        ->get();

    $monthlySpending = $allPaidBookings->groupBy(function ($booking) {
        return \Carbon\Carbon::parse($booking->created_at)->format('Y-m'); // nhóm theo tháng
    })->map(function ($bookingsInMonth) {
        return $bookingsInMonth->sum('total_price');
    });

    return view('Client.profile', compact(
        'user',
        'bookings',
        'totalSpending',
        'totalRP',
        'cardLevel',
        'typeFilter',
        'monthFilter',
        'monthlySpending'
    ));
}






}