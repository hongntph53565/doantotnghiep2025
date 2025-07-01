<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\PayOSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayosApiController extends Controller
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
            return response()->json([
                'success' => true,
                'checkoutUrl' => $response['data']['checkoutUrl'],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tạo link thanh toán thất bại: ' . ($response['desc'] ?? 'Không rõ lý do'),
            ], 400);
        }
    }

    public function returnPage(Request $request, $description)
    {
        $allParams = $request->query();
        $booking = Booking::where('booking_code', $description)->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking không tồn tại',
            ], 404);
        }

        if ($booking->payment_method == "payos") {
            Payment::create([
                'booking_id'     => $booking->booking_id,
                'payment_method' => $booking->payment_method,
                'price_amount'   => $booking->total_price,
                'status'         => ($allParams['cancel'] ?? 'false') === 'true' ? 'unpaid' : 'paid',
            ]);
        }

        if (($allParams['cancel'] ?? 'false') !== 'true' && $booking->payment_method == "payos") {
            $booking->update([
                'payment_status' => 'paid',
                'booking_status' => 'confirmed',
            ]);
        } elseif (($allParams['cancel'] ?? 'false') === 'true' && $booking->payment_method == "payos") {
            $booking->update([
                'booking_status' => 'canceled',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thanh toán thành công',
            'booking' => $booking,
        ]);
    }
}
