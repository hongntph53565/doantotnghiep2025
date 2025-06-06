<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Services\PayOSService;
use Illuminate\Support\Facades\Log;

class PayosController extends Controller
{
    protected $payos;

    public function __construct(PayOSService $payos)
    {
        $this->payos = $payos;
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
        $booking = Booking::where('booking_code', $description)->first();
        if ($booking['payment_method'] == "payos") {
            Payment::create([
                'booking_id'     => $booking['booking_id'],
                'payment_method' => $booking['payment_method'],
                'price_amount'   => $booking->total_price,
                'status'         => $allParams['cancel'] === 'true' ? 'unpaid' : 'paid'
            ]);
        }
        if (($allParams['cancel'] ?? 'false') !== 'true' && $booking['payment_method'] == "payos") {
            $booking->update([
                'payment_status' => 'paid',
                'booking_status' => 'confirmed'
            ]);
        } elseif (($allParams['cancel'] ?? 'false') == 'true' && $booking['payment_method'] == "payos") {
            $booking->update([
                'booking_status' => 'canceled'
            ]);
        }

        return redirect()->route('booking.index');
    }
}
