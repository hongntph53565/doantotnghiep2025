<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log; // 👈 Thêm dòng này

class CancelBookingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bookingId;

    /**
     * Create a new job instance.
     */
    public function __construct($bookingId)
    {
        $this->bookingId = $bookingId;
    }

    /**
     * Execute the job.
     */
    public function handle(BookingService $bookingService)
    {
        Log::info("🕒 CancelBookingJob bắt đầu chạy cho booking_id={$this->bookingId}");

        $booking = Booking::find($this->bookingId);

        if ($booking && $booking->payment_status === 'unpaid') {
            $booking->update([
                'booking_status' => 'cancelled'
            ]);

            // Giải phóng ghế
            $bookingService->cancelSeats($booking);

            Log::info("✅ Booking {$this->bookingId} đã bị hủy và ghế được giải phóng");
        } else {
            Log::info("⚠️ Booking {$this->bookingId} không cần hủy (đã thanh toán hoặc không tồn tại)");
        }
    }
}
