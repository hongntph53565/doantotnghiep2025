<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\BookingFood;
use App\Models\ShowtimeSeat;
use Illuminate\Support\Facades\Log;
class BookingService
{
    public function createSeats(Booking $booking, array $seatIds)
    {
        if (empty($seatIds)) {
            throw new \Exception('No seat selected.');
        }

        foreach ($seatIds as $seatId) {
            $showtimeSeat = ShowtimeSeat::where('seat_id', $seatId)
                ->where('showtime_id', $booking->showtime_id)
                ->firstOrFail();

            if ($showtimeSeat->status === 'pending') {
    throw new \Exception("Ghế đã được chọn, vui lòng chọn ghế khác.");
}

            BookingSeat::create([
                'booking_id'        => $booking->booking_id,
                'showtime_seat_id'  => $showtimeSeat->id,
                'price'             => $booking->total_price / count($seatIds),
            ]);

            $showtimeSeat->update(['status' => 'pending']);
        }
    }

    public function attachFoodsToBooking($bookingId, array $foods)
    {
        foreach ($foods as $food) {
            if (!empty($food['food_id']) && !empty($food['qty'])) {
                BookingFood::create([
                    'booking_id' => $bookingId,
                    'food_id'    => $food['food_id'],
                    'quantity'   => $food['qty'],
                ]);
            }
        }
    }

    public function handleAfterBooking(Booking $booking, array $seatIds, array $foods = [])
    {
        $this->createSeats($booking, $seatIds);

        if (!empty($foods)) {
            $this->attachFoodsToBooking($booking->booking_id, $foods);
        }
    }

    public function cancelSeats(Booking $booking)
    {
        $bookingSeats = BookingSeat::where('booking_id', $booking->booking_id)->with('showtimeSeat')->get();

        foreach ($bookingSeats as $bookingSeat) {
            $bookingSeat->showtimeSeat->update(['status' => 'available']);
            $bookingSeat->delete();
        }
    }

// public function confirmSeats(Booking $booking)
// {
//     foreach ($booking->seats as $bookingSeat) {
//         $showtimeSeat = $bookingSeat->showtimeSeat;
//         if ($showtimeSeat) {
//             $showtimeSeat->update(['status' => 'booked']);
//         }
//     }
// }
public function confirmSeats(Booking $booking)
{
    if (!$booking->showtime_id) {
        Log::info("⚠️ Booking ID {$booking->booking_id} has no showtime_id — skipping seat confirmation.");
        return;
    }

    Log::info("✅ Confirming seats for booking ID: {$booking->booking_id}");

    $booking->loadMissing('bookingSeats.showtimeSeat');
    if ($booking->bookingSeats->isEmpty()) {
        Log::warning("⚠️ Booking ID {$booking->booking_id} has NO seats attached.");
        return;
    }

    foreach ($booking->bookingSeats as $bookingSeat) {
        Log::info("🔍 BookingSeat ID: {$bookingSeat->id} - ShowtimeSeat ID: {$bookingSeat->showtime_seat_id}");

        $showtimeSeat = $bookingSeat->showtimeSeat;

        if ($showtimeSeat) {
            Log::info("🔒 Updating seat_id {$showtimeSeat->seat_id} (showtime_id: {$showtimeSeat->showtime_id}) to 'booked'");
            $showtimeSeat->update(['status' => 'booked']);
        } else {
            Log::warning("❌ No ShowtimeSeat found for BookingSeat ID {$bookingSeat->id}, ShowtimeSeat ID: {$bookingSeat->showtime_seat_id}");
        }
    }
}



}