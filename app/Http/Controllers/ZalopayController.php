<?php

namespace App\Http\Controllers;

use App\Events\PaymentEvents;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\BookingService;
use Illuminate\Http\Request;
use App\Services\ZalopayService;
use Illuminate\Support\Facades\Log;

use function Ramsey\Uuid\v1;

class ZalopayController extends Controller
{
    protected $zalopay;
    public $bookingService;

    public function __construct(ZalopayService $zalopay, BookingService $bookingService)
    {
        $this->zalopay = $zalopay;
        $this->bookingService = $bookingService;
    }

    public function createLink($amount, $description)
    {
        $returnUrl = route('zalopay.return', ['description' => $description]);
        $amount = (int) $amount;
        $response = $this->zalopay->createPaymentLink($amount, $description,$returnUrl);
        $response = json_decode($response,true);
        if (isset($response['return_code']) && $response['return_code'] == '1') {
            return redirect($response['order_url']);
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

    if ($booking['payment_method'] === "zalopay") {
        $payment = Payment::create([
            'booking_id'     => $booking['booking_id'],
            'payment_method' => $booking['payment_method'],
            'price_amount'   => $booking->total_price,
            'status'         => ($allParams['cancel'] ?? 'false') === 'true' ? 'unpaid' : 'paid'
        ]);
        $payment['user_id'] = $booking['user_id'];
        event(new PaymentEvents($payment));
    }

    if (($allParams['status'] ?? '1') !== '-49' && $booking['payment_method'] === "zalopay") {
        $booking->update([
            'payment_status' => 'paid',
            'booking_status' => 'confirmed'
        ]);
    } elseif (($allParams['status'] ?? '1') === '-49' && $booking['payment_method'] === "zalopay") {
        $booking->update([
            'booking_status' => 'cancelled'
        ]);
        $this->bookingService->cancelSeats($booking);
    }

    return response()->json([
        'success' => true,
        'message' => ($allParams['status'] ?? '1') === '-49' 
            ? 'Thanh toán đã bị hủy, booking đã hủy.'
            : 'Thanh toán thành công, booking đã xác nhận.',
        'booking' => $booking
    ]);
}

}
