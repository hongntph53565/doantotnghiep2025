<?php

namespace App\Http\Controllers\Admin;

use App\Events\PaymentEvents;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\BookingService;
use App\Services\VnpayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function Ramsey\Uuid\v1;

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

//   public function returnPage(Request $request, $description)
// {
//     $allParams = $request->query();
//     $booking = Booking::where('booking_code', $description)->first();

//     if (!$booking) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Không tìm thấy booking.'
//         ], 404);
//     }

//     if ($booking['payment_method'] === "vnpay") {
//         $payment = Payment::create([
//             'booking_id'     => $booking['booking_id'],
//             'payment_method' => $booking['payment_method'],
//             'price_amount'   => $booking->total_price,
//             'status'         => $allParams['vnp_ResponseCode'] == '00' ? 'paid' : 'unpaid'
//         ]);
//         $payment['user_id'] = $booking['user_id'];
//         event(new PaymentEvents($payment));
//     }

//     if ($allParams['vnp_ResponseCode'] == '00' && $booking['payment_method'] === "vnpay") {
//         $booking->update([
//             'payment_status' => 'paid',
//             'booking_status' => 'confirmed'
//         ]);

//         Log::info('Calling confirmSeats() for booking ID: ' . $booking->booking_id);
//         $this->bookingService->confirmSeats($booking);

//         $foods = json_decode($booking->selected_foods, true) ?? [];
//         $this->bookingService->attachFoodsToBooking($booking->booking_id, $foods);
//     } elseif ($allParams['vnp_ResponseCode'] !== '00' && $booking['payment_method'] === "vnpay") {
//         $booking->update([
//             'booking_status' => 'cancelled'
//         ]);
//         $this->bookingService->cancelSeats($booking);
//     }

//     // ✅ Redirect theo role giống PayOS
//     $user = $booking->user;
//     $isSuccess = $allParams['vnp_ResponseCode'] == '00';

//     if ($user && $user->role_id == 3) {
//         return redirect()->route('staff.search_ticket_online')
//             ->with('message', $isSuccess
//                 ? 'Thanh toán thành công, booking đã xác nhận.'
//                 : 'Thanh toán đã bị hủy, booking đã hủy.'
//             );
//     }

//     return redirect()->to(route('profile') . '#transaction-history')
//         ->with('message', $isSuccess
//             ? 'Thanh toán thành công, booking đã xác nhận.'
//             : 'Thanh toán đã bị hủy, booking đã hủy.'
//         );
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

//     if ($booking['payment_method'] === "vnpay") {
//         $payment = Payment::create([
//             'booking_id'     => $booking['booking_id'],
//             'payment_method' => $booking['payment_method'],
//             'price_amount'   => $booking->total_price,
//             'status'         => $allParams['vnp_ResponseCode'] == '00' ? 'paid' : 'unpaid'
//         ]);
//         $payment['user_id'] = $booking['user_id'];
//         event(new PaymentEvents($payment));
//     }

//     if ($allParams['vnp_ResponseCode'] == '00' && $booking['payment_method'] === "vnpay") {
//         $booking->update([
//             'payment_status' => 'paid',
//             'booking_status' => 'confirmed'
//         ]);

//         Log::info('Calling confirmSeats() for booking ID: ' . $booking->booking_id);
//         $this->bookingService->confirmSeats($booking);

//         $foods = json_decode($booking->selected_foods, true) ?? [];
//         $this->bookingService->attachFoodsToBooking($booking->booking_id, $foods);

//         // 🚀 Dispatch event gửi mail cho khách (giống PayOS)
//         event(new \App\Events\BookingEvents($booking));

//     } elseif ($allParams['vnp_ResponseCode'] !== '00' && $booking['payment_method'] === "vnpay") {
//         $booking->update([
//             'booking_status' => 'cancelled'
//         ]);
//         $this->bookingService->cancelSeats($booking);
//     }

//     // ✅ Redirect theo role giống PayOS
//     $user = $booking->user;
//     $isSuccess = $allParams['vnp_ResponseCode'] == '00';

//     if ($user && $user->role_id == 3) {
//         return redirect()->route('staff.search_ticket_online')
//             ->with('message', $isSuccess
//                 ? 'Thanh toán thành công, booking đã xác nhận.'
//                 : 'Thanh toán đã bị hủy, booking đã hủy.'
//             );
//     }

//     return redirect()->to(route('profile') . '#transaction-history')
//         ->with('message', $isSuccess
//             ? 'Thanh toán thành công, booking đã xác nhận.'
//             : 'Thanh toán đã bị hủy, booking đã hủy.'
//         );
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
            'payment_status' => 'paid',
            'booking_status' => 'confirmed'
        ]);

        Log::info('Calling confirmSeats() for booking ID: ' . $booking->booking_id);
        $this->bookingService->confirmSeats($booking);

        // 🚀 Quy đổi điểm từ total_price (giống PayOS)
        $points = floor($booking->total_price / 1000);

        $card = \App\Models\MemberShipCard::firstOrCreate(
            ['user_id' => $booking->user_id],
            [
                'card_number' => 'CARD' . time(),
                'card_type' => 'normal',
                'points' => 0,
            ]
        );

        $card->points += $points;
        $card->save();

        // Cập nhật loại thẻ dựa trên điểm hiện tại
        $card->updateCardType();

        // 📝 Log lại
        Log::info('MembershipCard updated (VNPAY)', [
            'booking_id'   => $booking->booking_id,
            'user_id'      => $booking->user_id,
            'total_price'  => $booking->total_price,
            'points_earned'=> $points,
            'new_points'   => $card->points,
            'card_type'    => $card->card_type,
        ]);

        // Gắn lại đồ ăn cho booking
        $foods = json_decode($booking->selected_foods, true) ?? [];
        $this->bookingService->attachFoodsToBooking($booking->booking_id, $foods);

        // Cập nhật used_count cho promotion (nếu có)
        $bookingPromotion = \App\Models\BookingPromotion::where('booking_id', $booking->booking_id)->first();
        if ($bookingPromotion) {
            $promotion = \App\Models\Promotion::find($bookingPromotion->promo_id);
            if ($promotion && isset($promotion->used_count)) {
                $promotion->increment('used_count');
            }
        }

        // 🚀 Gửi mail xác nhận booking
        event(new \App\Events\BookingEvents($booking));

    } elseif ($allParams['vnp_ResponseCode'] !== '00' && $booking['payment_method'] === "vnpay") {
        $booking->update([
            'booking_status' => 'cancelled'
        ]);
        $this->bookingService->cancelSeats($booking);
    }

    // ✅ Redirect theo role giống PayOS
    $user = $booking->user;
    $isSuccess = $allParams['vnp_ResponseCode'] == '00';

    if ($user && $user->role_id == 3) {
        return redirect()->route('staff.search_ticket_online')
            ->with('message', $isSuccess
                ? 'Thanh toán thành công, booking đã xác nhận.'
                : 'Thanh toán đã bị hủy, booking đã hủy.'
            );
    }

    return redirect()->to(route('profile') . '#transaction-history')
        ->with('message', $isSuccess
            ? 'Thanh toán thành công, booking đã xác nhận.'
            : 'Thanh toán đã bị hủy, booking đã hủy.'
        );
}



}
