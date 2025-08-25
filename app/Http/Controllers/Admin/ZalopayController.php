<?php

namespace App\Http\Controllers\Admin;

use App\Events\PaymentEvents;
use App\Http\Controllers\Controller;
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
    $response = $this->zalopay->createPaymentLink($amount, $description, $returnUrl);
    $response = json_decode($response, true);

    if (isset($response['return_code']) && $response['return_code'] == '1') {
        // Debug thêm
        Log::info('ZaloPay Link', ['url' => $response['order_url']]);
        return redirect($response['order_url']);
    } else {
        Log::error('ZaloPay Error', $response);
        return back()->with('error', 'Tạo link thanh toán thất bại: ' . ($response['desc'] ?? 'Không rõ lý do'));
    }
}

//   public function returnPage(Request $request, $description)
// {
//     $allParams = $request->query();
//     $booking = Booking::where('booking_code', $description)->first();
//     $payment = Payment::where('booking_id', $booking->booking_id)->first();

//     if (!$booking) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Không tìm thấy booking.'
//         ], 404);
//     }

//     if ($booking['payment_method'] === "zalopay") {
//         $payment = Payment::create([
//             'booking_id'     => $booking['booking_id'],
//             'payment_method' => $booking['payment_method'],
//             'price_amount'   => $booking->total_price,
//             'status'         => ($allParams['cancel'] ?? 'false') === 'true' ? 'unpaid' : 'paid'
//         ]);
//         $payment['user_id'] = $booking['user_id'];
//         event(new PaymentEvents($payment));
//     }

//     if (($allParams['status'] ?? '1') !== '-49' && $booking['payment_method'] === "zalopay") {
//         $booking->update([
//             'booking_status' => 'confirmed'
//         ]);
//     } elseif (($allParams['status'] ?? '1') === '-49' && $booking['payment_method'] === "zalopay") {
//         $booking->update([
//             'booking_status' => 'cancelled'
//         ]);
//         $payment->update([
//             'status' => 'cancelled'
//         ]);
//         $this->bookingService->cancelSeats($booking);
//     }

//     // ✅ Redirect theo role giống PayOS
//     $user = $booking->user;
//     $isCancel = ($allParams['status'] ?? '1') === '-49';

//     if ($user && $user->role_id == 3) {
//         return redirect()->route('staff.search_ticket_online')
//             ->with('message', $isCancel ? 'Thanh toán đã bị hủy, booking đã hủy.' : 'Thanh toán thành công, booking đã xác nhận.');
//     }

//     return redirect()->to(route('profile') . '#transaction-history')
//         ->with('message', $isCancel ? 'Thanh toán đã bị hủy, booking đã hủy.' : 'Thanh toán thành công, booking đã xác nhận.');
// }



// public function returnPage(Request $request, $description)
// {
//     $allParams = $request->query();
//     $booking = Booking::where('booking_code', $description)->first();

//     if (!$booking) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Không tìm thấy booking.'
//         ], 404);
//     }

//     if ($booking['payment_method'] === "zalopay") {
//         $payment = Payment::create([
//             'booking_id'     => $booking['booking_id'],
//             'payment_method' => $booking['payment_method'],
//             'price_amount'   => $booking->total_price,
//             'status'         => ($allParams['cancel'] ?? 'false') === 'true' ? 'unpaid' : 'paid'
//         ]);

//         // ❌ không lưu DB, chỉ gán tạm để truyền qua event
//         $payment->user_id = $booking['user_id'];

//         event(new PaymentEvents($payment));
//     }

//     // Thanh toán thành công
//     if (($allParams['status'] ?? '1') !== '-49' && $booking['payment_method'] === "zalopay") {
//         $booking->update([
//             'payment_status' => 'paid',
//             'booking_status' => 'confirmed'
//         ]);

//         // ✅ xác nhận ghế
//         $this->bookingService->confirmSeats($booking);

//         // ✅ xử lý combo food nếu có
//         $foods = json_decode($booking->selected_foods, true) ?? [];
//         $this->bookingService->attachFoodsToBooking($booking->booking_id, $foods);

//         // ✅ gửi mail cho khách
//         event(new \App\Events\BookingEvents($booking));

//     // Thanh toán thất bại/hủy
//     } elseif (($allParams['status'] ?? '1') === '-49' && $booking['payment_method'] === "zalopay") {
//         $booking->update([
//             'booking_status' => 'cancelled'
//         ]);

//         // chỉ update trạng thái payment, không dính user_id
//         Payment::where('payment_id', $payment->payment_id)->update([
//             'status' => 'cancelled'
//         ]);

//         // ✅ hủy ghế
//         $this->bookingService->cancelSeats($booking);
//     }

//     // ✅ Redirect theo role giống PayOS
//     $user = $booking->user;
//     $isCancel = ($allParams['status'] ?? '1') === '-49';

//     if ($user && $user->role_id == 3) {
//         return redirect()->route('staff.search_ticket_online')
//             ->with('message', $isCancel 
//                 ? 'Thanh toán đã bị hủy, booking đã hủy.' 
//                 : 'Thanh toán thành công, booking đã xác nhận.');
//     }

//     return redirect()->to(route('profile') . '#transaction-history')
//         ->with('message', $isCancel 
//             ? 'Thanh toán đã bị hủy, booking đã hủy.' 
//             : 'Thanh toán thành công, booking đã xác nhận.');
// }
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

        // ❌ không lưu DB, chỉ gán tạm để truyền qua event
        $payment->user_id = $booking['user_id'];
        event(new PaymentEvents($payment));
    }

    // ✅ Thành công (status khác -49)
    if (($allParams['status'] ?? '1') !== '-49' && $booking['payment_method'] === "zalopay") {
        $booking->update([
            'payment_status' => 'paid',
            'booking_status' => 'confirmed'
        ]);

        // ✅ Xác nhận ghế
        $this->bookingService->confirmSeats($booking);

        
        // $points = floor($booking->total_price / 1000);
        // $card = \App\Models\MemberShipCard::firstOrCreate(
        //     ['user_id' => $booking->user_id],
        //     [
        //         'card_number' => 'CARD' . time(),
        //         'card_type' => 'normal',
        //         'points' => 0,
        //     ]
        // );
        // $card->points += $points;
        // $card->save();
        // $card->updateCardType();

       
        // Log::info('MembershipCard updated (ZaloPay)', [
        //     'booking_id'   => $booking->booking_id,
        //     'user_id'      => $booking->user_id,
        //     'total_price'  => $booking->total_price,
        //     'points_earned'=> $points,
        //     'new_points'   => $card->points,
        //     'card_type'    => $card->card_type,
        // ]);

        // ✅ Gắn combo food
        $foods = json_decode($booking->selected_foods, true) ?? [];
        $this->bookingService->attachFoodsToBooking($booking->booking_id, $foods);

        // ✅ Cập nhật promotion nếu có
        $bookingPromotion = \App\Models\BookingPromotion::where('booking_id', $booking->booking_id)->first();
        if ($bookingPromotion) {
            $promotion = \App\Models\Promotion::find($bookingPromotion->promo_id);
            if ($promotion && isset($promotion->used_count)) {
                $promotion->increment('used_count');
            }
        }

        // ✅ Gửi mail
        event(new \App\Events\BookingEvents($booking));

    // ❌ Thanh toán thất bại/hủy
    } elseif (($allParams['status'] ?? '1') === '-49' && $booking['payment_method'] === "zalopay") {
        $booking->update([
            'booking_status' => 'cancelled'
        ]);

        // ❌ chỉ update trạng thái payment
        Payment::where('payment_id', $payment->payment_id)->update([
            'status' => 'cancelled'
        ]);

        // ✅ hủy ghế
        $this->bookingService->cancelSeats($booking);
    }

    // ✅ Redirect theo role giống PayOS/VNPAY
    $user = $booking->user;
    $isCancel = ($allParams['status'] ?? '1') === '-49';

    if ($user && $user->role_id == 3) {
        return redirect()->route('staff.search_ticket_online')
            ->with('message', $isCancel 
                ? 'Thanh toán đã bị hủy, booking đã hủy.' 
                : 'Thanh toán thành công, booking đã xác nhận.');
    }

    return redirect()->to(route('profile') . '#transaction-history')
        ->with('message', $isCancel 
            ? 'Thanh toán đã bị hủy' 
            : 'Thanh toán thành công');
}



}