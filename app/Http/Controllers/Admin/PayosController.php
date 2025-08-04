<?php

namespace App\Http\Controllers\Admin;

use App\Events\PaymentEvents;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\BookingService;
use Illuminate\Http\Request;
use App\Services\PayOSService;
use Illuminate\Support\Facades\Log;

class PayosController extends Controller
{
    protected $payos;
    public BookingService $bookingService;

    public function __construct(PayOSService $payos, BookingService $bookingService)
    {
        $this->payos = $payos;
        $this->bookingService = $bookingService;
    }

    public function createLink($amount, $description)
    {
        $returnUrl = route('payos.return', ['description' => $description]);
        $amount = (int) $amount;
        $response = $this->payos->createPaymentLink($amount, $description, $returnUrl);

        Log::info('PayOS Response: ', $response);

        if (isset($response['code']) && $response['code'] == '00') {
            return redirect($response['data']['checkoutUrl']);
        } else {
            return back()->with('error', 'Tạo link thanh toán thất bại: ' . ($response['desc'] ?? 'Không rõ lý do'));
        }
    }

public function returnPage(Request $request, $description)
{
    $allParams = $request->query();

    $booking = Booking::with('bookingSeats.showtimeSeat')->where('booking_code', $description)->first();

    if (!$booking) {
        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy booking.'
        ], 404);
    }

    // Ghi nhận thanh toán nếu dùng payos
    if ($booking['payment_method'] === "payos") {
        $payment = Payment::create([
            'booking_id'     => $booking['booking_id'],
            'payment_method' => $booking['payment_method'],
            'price_amount'   => $booking->total_price,
            'status'         => ($allParams['cancel'] ?? 'false') === 'true' ? 'unpaid' : 'paid'
        ]);

        $payment['user_id'] = $booking['user_id'];
        event(new PaymentEvents($payment));
    }

    if (($allParams['cancel'] ?? 'false') !== 'true' && $booking['payment_method'] === "payos") {
        $booking->update([
            'payment_status' => 'paid',
            'booking_status' => 'confirmed'
        ]);

        Log::info('Calling confirmSeats() for booking ID: ' . $booking->booking_id);
        $this->bookingService->confirmSeats($booking);

        // Gắn lại đồ ăn cho booking
        $foods = json_decode($booking->selected_foods, true) ?? [];
        $this->bookingService->attachFoodsToBooking($booking->booking_id, $foods);
    }
    elseif (($allParams['cancel'] ?? 'false') === 'true' && $booking['payment_method'] === "payos") {
        $booking->update([
            'booking_status' => 'cancelled'
        ]);

        Log::info('Calling cancelSeats() for booking ID: ' . $booking->booking_id);
        $this->bookingService->cancelSeats($booking);
    }

    // ✅ Redirect theo role
    $user = $booking->user; // Booking có quan hệ tới user
    $isCancel = ($allParams['cancel'] ?? 'false') === 'true';

    if ($user && $user->role_id == 3) {
        return redirect()->route('staff.search_ticket_online')
            ->with('message', $isCancel ? 'Đã hủy giao dịch.' : 'Thanh toán thành công. Đơn đã được xác nhận.');
    }

    // Mặc định là người dùng bình thường (role_id = 4)
    return redirect()->to(route('profile') . '#transaction-history')
        ->with('message', $isCancel ? 'Thanh toán đã bị hủy, booking đã hủy.' : 'Thanh toán thành công, booking đã xác nhận.');
}


}