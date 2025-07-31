<?php

namespace App\Http\Controllers\Admin;

use App\Events\PaymentEvents;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\BookingService;
use App\Services\VnpayService;
use Illuminate\Http\Request;

class VnpayController extends Controller
{
    protected $Vnpay;
    public $bookingService;

    public function __construct(VnpayService $vnpay, BookingService $bookingService)
    {
        $this->Vnpay = $vnpay;
        $this->bookingService = $bookingService;
    }

    public function createLink($amount, $description)
    {
        $returnUrl = route('vnpay.return', ['description' => $description]);
        $amount = (int) $amount;
        $response = $this->Vnpay->createPaymentLink($amount, $description, $returnUrl);
        $response = json_decode($response, true);
        if (isset($response['code']) && $response['code'] == 200 && $response['message'] == 'Success') {
            return redirect($response['payment_url']);
        } else {
            return back()->with('error', 'Tạo link thanh toán thất bại: ' . ($response['desc'] ?? 'Không rõ lý do'));
        }
    }

    public function returnPage(Request $request, $description)
    {
        $allParams = $request->query();
        $booking = Booking::where('booking_code', $description)->first();
        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy booking.'
            ], 404);
        }
        if ($booking['payment_method'] === "vnpay") {
            $payment = Payment::create([
                'booking_id'     => $booking['booking_id'],
                'payment_method' => $booking['payment_method'],
                'price_amount'   => $booking->total_price,
                'status'         => $allParams['vnp_ResponseCode'] == '00' ? 'paid' : 'unpaid'
            ]);
            $payment['user_id'] = $booking['user_id'];
            event(new PaymentEvents($payment));
        }

        if ($allParams['vnp_ResponseCode'] == '00' && $booking['payment_method'] === "vnpay") {
            $booking->update([
                'booking_status' => 'confirmed'
            ]);
        } elseif ($allParams['vnp_ResponseCode'] !== '00' && $booking['payment_method'] === "vnpay") {
            $booking->update([
                'booking_status' => 'cancelled'
            ]);
            $this->bookingService->cancelSeats($booking);
        }
            return redirect()->route('home')->with('success', ($allParams['vnp_ResponseCode'] ?? '1') !== '00'
            ? 'Thanh toán đã bị hủy, booking đã hủy.'
            : 'Thanh toán thành công, booking đã xác nhận.');
    }
}
