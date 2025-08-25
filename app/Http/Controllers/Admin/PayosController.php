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


        if ($booking['payment_method'] === "payos") {
            $payment = Payment::create([
                'booking_id' => $booking->booking_id,
                'payment_method' => $booking->payment_method,
                'price_amount' => $booking->total_price,
                'status' => ($allParams['cancel'] ?? 'false') === 'true' ? 'unpaid' : 'paid'
            ]);

            $payment['user_id'] = $booking->user_id;
            event(new PaymentEvents($payment));
        }


        if (
            ($allParams['cancel'] ?? 'false') !== 'true'
            && $booking['payment_method'] === "payos"
            && $booking->payment_status !== 'paid'
        ) {
            $booking->update([
                'payment_status' => 'paid',
                'booking_status' => 'confirmed'
            ]);

            Log::info('Calling confirmSeats() for booking ID: ' . $booking->booking_id);
            $this->bookingService->confirmSeats($booking);

           
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

           
            $card->updateCardType();

            Log::info('MembershipCard updated', [
                'booking_id' => $booking->booking_id,
                'user_id' => $booking->user_id,
                'total_price' => $booking->total_price,
                'points_earned' => $points,
                'new_points' => $card->points,
                'card_type' => $card->card_type,
            ]);

            
            $foods = json_decode($booking->selected_foods, true) ?? [];
            $this->bookingService->attachFoodsToBooking($booking->booking_id, $foods);

            
            $bookingPromotion = \App\Models\BookingPromotion::where('booking_id', $booking->booking_id)->first();
            if ($bookingPromotion) {
                $promotion = \App\Models\Promotion::find($bookingPromotion->promo_id);
                if ($promotion && isset($promotion->used_count)) {
                    $promotion->increment('used_count');
                }
            }

            
            event(new \App\Events\BookingEvents($booking));
        } elseif (($allParams['cancel'] ?? 'false') === 'true' && $booking['payment_method'] === "payos") {
            $booking->update([
                'booking_status' => 'cancelled'
            ]);

            Log::info('Calling cancelSeats() for booking ID: ' . $booking->booking_id);
            $this->bookingService->cancelSeats($booking);
        }


        $user = $booking->user;
        $isCancel = ($allParams['cancel'] ?? 'false') === 'true';

        if ($user && $user->role_id == 3) {
            return redirect()->route('staff.search_ticket_online')
                ->with('message', $isCancel ? 'Đã hủy giao dịch.' : 'Thanh toán thành công. Đơn đã được xác nhận.');
        }

        return redirect()->to(route('profile') . '#transaction-history')
            ->with('message', $isCancel ? 'Thanh toán đã bị hủy, booking đã hủy.' : 'Thanh toán thành công, booking đã xác nhận.');
    }



}