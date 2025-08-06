<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\ShowtimeSeat;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Promotion;
use App\Models\BookingPromotion;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $bookings = Booking::with(['user', 'showtime'])->paginate(10);
        return view('Booking.index', compact('bookings'));
    }

    public function store(Request $request, BookingService $bookingService)
{
    $data = $request->validate([
        'user_id' => 'required|exists:users,user_id',
        'showtime_id' => 'required|exists:showtimes,showtime_id',
        'booking_code' => 'unique:bookings,booking_code',
        'payment_method' => 'required|in:cash,payos,zalopay,vnpay',
        'total_price' => 'required|numeric|min:1',
        'seats_id' => 'required|string',
        'selected_foods' => 'nullable|string',
        'promo_code' => 'nullable|string',
        'movie_id' => 'required|exists:movies,movie_id', 
    ]);

    $selectedFoods = json_decode($data['selected_foods'], true) ?? [];
    $seatIds = json_decode($data['seats_id'], true);

    if (!is_array($seatIds)) {
        return back()->withErrors(['seats_id' => 'Định dạng seats_id không hợp lệ.']);
    }

    $data['booking_code'] = strtoupper(substr(md5(time()), 0, 9));
    $originalTotal = $data['total_price'];
    $discountAmount = 0;
    $promotion = null;

  
    if (!empty($data['promo_code'])) {
        $promotion = Promotion::where('discount_code', $data['promo_code'])
            ->where('status', 'active')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();

        if ($promotion && (!$promotion->min_order_value || $originalTotal >= $promotion->min_order_value)) {
            $discountAmount = $promotion->type_discount === 'percent'
                ? ($originalTotal * $promotion->discount_value) / 100
                : $promotion->discount_value;

            if ($promotion->max_discount) {
                $discountAmount = min($discountAmount, $promotion->max_discount);
            }

            $discountAmount = round($discountAmount);
            $data['total_price'] -= $discountAmount;
        }
    }

   
    $booking = Booking::create([
        'user_id' => $data['user_id'],
        'showtime_id' => $data['showtime_id'],
        'booking_code' => $data['booking_code'],
        'total_price' => $data['total_price'],
        'payment_method' => $data['payment_method'],
    ]);

    
    try {
        $bookingService->createSeats($booking, $seatIds);
    } catch (\Exception $e) {
        $booking->delete(); 
        return redirect()
            ->route('Client.booking.home', [
                'movie_id' => $data['movie_id'],
                'showtime_id' => $data['showtime_id'],
            ])
            ->withInput()
            ->with('error', $e->getMessage());
    }

    $bookingService->attachFoodsToBooking($booking->booking_id, $selectedFoods);

   
    if (!empty($promotion)) {
        BookingPromotion::create([
            'booking_id' => $booking->booking_id,
            'promo_id' => $promotion->promo_id,
            'discount_amount' => $discountAmount,
        ]);
    }

    
    switch ($data['payment_method']) {
        case 'payos':
            return redirect()->route('payos.create', [
                'amount' => $data['total_price'],
                'description' => $data['booking_code'],
            ]);
        case 'zalopay':
            return redirect()->route('zalopay.create', [
                'amount' => $data['total_price'],
                'description' => $data['booking_code'],
            ]);
        case 'vnpay':
            return redirect()->route('vnpay.create', [
                'amount' => $data['total_price'],
                'description' => $data['booking_code'],
            ]);
        default:
            return redirect()->route('bookings.index')->with('success', 'Đặt vé thành công.');
    }
}

    public function storeFoodOnly(Request $request, BookingService $bookingService)
    {
        // \Log::info(' [BookingController@storeFoodOnly] Called');
        $data = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'payment_method' => 'required|in:cash,payos,zalopay,vnpay',
            'total_price' => 'required|numeric|min:1',
            'selected_foods' => 'required|string', // bắt buộc chọn combo
            'promo_code' => 'nullable|string',
        ]);

        $selectedFoods = json_decode($data['selected_foods'], true) ?? [];

        $data['booking_code'] = strtoupper(substr(md5(time()), 0, 9));
        $originalTotal = $data['total_price'];
        $discountAmount = 0;

        // Nếu có mã khuyến mãi
        if (!empty($data['promo_code'])) {
            $promotion = Promotion::where('discount_code', $data['promo_code'])
                ->where('status', 'active')
                ->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->first();

            if ($promotion && (!$promotion->min_order_value || $originalTotal >= $promotion->min_order_value)) {
                $discountAmount = $promotion->type_discount === 'percent'
                    ? ($originalTotal * $promotion->discount_value) / 100
                    : $promotion->discount_value;

                if ($promotion->max_discount) {
                    $discountAmount = min($discountAmount, $promotion->max_discount);
                }

                $discountAmount = round($discountAmount);
                $data['total_price'] -= $discountAmount;
            }
        }

        // Tạo booking KHÔNG CÓ showtime
        $booking = Booking::create([
            'user_id' => $data['user_id'],
            'booking_code' => $data['booking_code'],
            'total_price' => $data['total_price'],
            'payment_method' => $data['payment_method'],
            'showtime_id' => null, // 👈
        ]);

        // Gắn combo food
        $bookingService->attachFoodsToBooking($booking->booking_id, $selectedFoods);

        // Lưu khuyến mãi nếu có
        if (!empty($promotion)) {
            \App\Models\BookingPromotion::create([
                'booking_id' => $booking->booking_id,
                'promo_id' => $promotion->promo_id,
                'discount_amount' => $discountAmount,
            ]);
        }

        // Redirect đến thanh toán
        switch ($data['payment_method']) {
            case 'payos':
                return redirect()->route('payos.create', [
                    'amount' => $data['total_price'],
                    'description' => $data['booking_code'],
                ]);
            case 'zalopay':
                return redirect()->route('zalopay.create', [
                    'amount' => $data['total_price'],
                    'description' => $data['booking_code'],
                ]);
            case 'vnpay':
                return redirect()->route('vnpay.create', [
                    'amount' => $data['total_price'],
                    'description' => $data['booking_code'],
                ]);
            case 'cash':
                $booking->update([
                    'payment_status' => 'paid',
                    'booking_status' => 'confirmed',
                ]);
                return redirect()->route('staff.cart')->with('success_cash', 'true');
            default:
                return redirect()->route('cart')->with('success', 'Mua đồ ăn thành công.');
        }
    }



    public function delete($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('booking.index')->with('success', 'Booking deleted successfully.');
    }

    public function getSeatsByShowtime($showtime_id)
    {
        $showtime = Showtime::with('room.seats')->findOrFail($showtime_id);

        if (!$showtime->room) {
            return response()->json(['error' => 'Showtime không có phòng!'], 500);
        }

        $seats = $showtime->room->seats->map(function ($seat) use ($showtime_id) {
            $isBooked = DB::table('showtime_seats')
                ->where('showtime_id', $showtime_id)
                ->where('seat_id', $seat->id)
                ->exists();

            return [
                'id' => $seat->id,
                'seat_id' => $seat->seat_id,
                'seat_type' => $seat->seat_type,
                'price' => $seat->price,
                'status' => $isBooked ? 'booked' : 'available',
            ];
        });

        return response()->json($seats);
    }
}