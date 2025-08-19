<?php

namespace App\Listeners;

use App\Events\BookingEvents;
use App\Services\MailService;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Log;

class Bookingsuccessful
{
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

   public function handle(BookingEvents $event): void
{
    $booking = $event->booking;

    // Lấy danh sách ghế
    $seatCodes = $booking->seats->pluck('seat_code');
    $seatString = $seatCodes->isNotEmpty()
        ? $seatCodes->implode(', ')
        : 'Không có ghế nào được chọn';

    // Lấy danh sách đồ ăn
    $foods = $booking->foods->map(function ($food) {
        return $food->pivot->quantity . ' x ' . $food->name;
    })->implode(', ');

    // Lấy email & tên từ user liên kết
    $user = $booking->user;
    $user_mail = $user->email ?? null;

    if (!$user_mail) {
        Log::warning('Booking success: user không có email', ['booking_id' => $booking->booking_id]);
        return; // Không gửi nếu không có email
    }

    $data = [
        'customer_name' => $user->full_name ?? 'Khách hàng',
        'booking_code'  => $booking->booking_code,
        'movie_name'    => $booking->showtime->movie->title ?? 'N/A',
        'cinema_name'   => $booking->showtime->room->cinema->name ?? 'N/A',
        'room_name'     => $booking->showtime->room->room_name ?? 'N/A',
        'showtime'      => $booking->showtime->start_time ?? 'N/A',
        'seats'         => $seatString,
        'foods'         => $foods ?: 'Không có đồ ăn',
        'total_price'   => $booking->total_price,
        'ticket_url'    => route('profile') . '#transaction-history',
        'year'          => now()->year,
    ];

    // Ghi log để kiểm tra dữ liệu
    Log::info('Booking success data', $data);

    $template = EmailTemplate::where('template_name', 'booking_success')->first();

    if ($template) {
        $this->mailService->send($user_mail, $template->template_id, $data);
    }
}


}
