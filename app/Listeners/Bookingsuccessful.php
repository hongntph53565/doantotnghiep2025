<?php

namespace App\Listeners;

use App\Events\BookingEvents;
use App\Events\UserRegistered;
use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Auth;

class Bookingsuccessful
{
    /**
     * Create the event listener.
     */
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Handle the event.
     */
    public function handle(BookingEvents $event): void
    {
        $seatCodes = $event->booking->seats->pluck('seat_code');

        if ($seatCodes->isNotEmpty()) {
            $seatString = $seatCodes->implode(', ');
        }

        $user_mail = Auth::user()->email;
        $data = [
            'customer_name' => Auth::user()->full_name,
            'booking_code' => $event->booking->booking_code,
            'movie_name' => $event->booking->showtime->movie->tỉle,
            'cinema_name' => $event->booking->showtime->room->cinema->name,
            'room_name' => $event->booking->showtime->room->name,
            'showtime' => $event->booking->showtime->start_time,
            'seats' => $seatString ?? 'Không có ghế nào được chọn',
            'total_price' => $event->booking->total_price,
        ];

        $template = EmailTemplate::where('subject', 'Xác nhận đặt vé thành công')->first();
        $this->mailService->send($user_mail, $template->template_id, $data);
    }
}