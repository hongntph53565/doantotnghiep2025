<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\CinemaSeatTypePrice;
use App\Models\ExtraPrice;
use App\Models\Seat;
use App\Models\Showtime;
use App\Models\ShowtimeSeat;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PriceCalculator
{
public function Calculator(array $seat_ids, $showTime_id)
{
    $seats = Seat::with('room.cinema')->whereIn('seat_id', $seat_ids)->get();
    $showTime = Showtime::where('showtime_id', $showTime_id)->firstOrFail();

    $result = [];

    foreach ($seats as $seat) {
        $cinema_id = $seat->room->cinema_id ?? null;
        $seat_type_id = $seat->seat_type_id;

        if (!$cinema_id || !$seat_type_id) {
            $result[$seat->seat_id] = null;
            continue;
        }

        $price = CinemaSeatTypePrice::where('cinema_id', $cinema_id)
            ->where('seat_type_id', $seat_type_id)
            ->value('price');

        $result[$seat->seat_id] = $price ?? 0;
    }

    $basePrice = array_sum($result);

    $startTime = Carbon::parse($showTime->start_time)->format('H:i:s');
    $TimeExtra = TimeSlot::where('start_time', '<=', $startTime)
        ->where('end_time', '>=', $startTime    )
        ->value('extra_percentage') ?? 0;

    $date = Carbon::parse($showTime->start_time);
    $dateOnly = $date->format('m-d');
    $dayOfWeek = $date->dayOfWeek;

    $holidayDates = ExtraPrice::where('day_type', 'holiday')->pluck('date')->toArray();
    $isHoliday = in_array($dateOnly, $holidayDates);
    $isWeekend = in_array($dayOfWeek, [0, 6]);

    if ($isHoliday) {
        $DayExtra = ExtraPrice::where('day_type', 'holiday')->value('percentage') ?? 0;
    } elseif ($isWeekend) {
        $DayExtra = ExtraPrice::where('day_type', 'weekend')->value('percentage') ?? 0;
    } else {
        $DayExtra = 0;
    }

    $totalExtraPercentage = $TimeExtra + $DayExtra;

    $finalPrice = $basePrice + ($basePrice * $totalExtraPercentage / 100);

    return round($finalPrice);
}

}
