<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\ShowtimeSeat;
use Illuminate\Support\Facades\Log;

class BookingService
{
    public function createSeats(Booking $booking, array $seatIds)
    {

        if (count($seatIds) === 0) {
            throw new \Exception('No seat selected.');
        }

        foreach ($seatIds as $seatId) {
            $showtimeSeat = ShowtimeSeat::where('seat_id', $seatId)
                ->where('showtime_id', $booking->showtime_id) // thêm điều kiện này
                ->first();


            if ($showtimeSeat->status === 'booked') {
                throw new \Exception("Seat ID $seatId is already booked.");
            }

            BookingSeat::create([
                'booking_id' => $booking->booking_id,
                'showtime_seat_id' => $showtimeSeat->id,
                'price' => $booking->total_price / count($seatIds),
            ]);

            $showtimeSeat->status = 'booked';
            $showtimeSeat->save();
        }
    }

    public function cancelSeats(Booking $booking)
    {
        $bookingSeats = BookingSeat::where('booking_id', $booking->booking_id)->with('showtimeSeat')->get();

        foreach ($bookingSeats as $bookingSeat) {
            $seat = $bookingSeat->showtimeSeat;
            $seat->status = 'available';
            $seat->save();

            $bookingSeat->delete();
        }
    }
}
