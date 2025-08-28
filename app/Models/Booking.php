<?php

namespace App\Models;

// use Faker\Provider\ar_EG\Payment;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $primaryKey = 'booking_id';

    protected $fillable = [
        'user_id',
        'showtime_id',
        'booking_status',
        'payment_status',
        'payment_method',
        'booking_code',
        'total_price'
    ];
    protected $casts = [
        'printed_at' => 'datetime',
    ];

    public function getIsPrintedAttribute(): bool
    {
        return ($this->printed_count ?? 0) > 0 || !is_null($this->printed_at);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function showtime()
{
    return $this->belongsTo(Showtime::class, 'showtime_id', 'showtime_id')->withTrashed();
}


    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id');
    }

    public function foods()
    {
        return $this->belongsToMany(Food::class, 'booking_food', 'booking_id', 'food_id')
            ->withPivot(['quantity', 'price'])
            ->withTimestamps();
    }
    public function seats()
    {
        return $this->hasManyThrough(
            Seat::class,
            BookingSeat::class,
            'booking_id',
            'seat_id',
            'booking_id',
            'showtime_seat_id'
        )->join('showtime_seats', 'showtime_seats.seat_id', '=', 'seats.seat_id');
    }
    public function bookingSeats()
{
    return $this->hasMany(BookingSeat::class, 'booking_id')
        ->with(['showtimeSeat' => function ($q) {
            $q->with(['showtime' => function ($q2) {
                $q2->withTrashed(); // lấy showtime đã xóa mềm
            }]);
        }]);
}

public function getTotalSeatPriceAttribute()
{
    $cinema_id = $this->showtime->room->cinema_id ?? null;
    if (!$cinema_id) return 0;

    $seats = $this->bookingSeats->sortBy(fn($b) => $b->showtimeSeat->seat->seat_code)->values();
    $total = 0;
    $skipNext = false;

    for ($i = 0; $i < $seats->count(); $i++) {
        if ($skipNext) { 
            $skipNext = false; 
            continue; 
        }

        $seat = $seats[$i]->showtimeSeat->seat;
        $price = \App\Models\CinemaSeatTypePrice::where('cinema_id', $cinema_id)
            ->where('seat_type_id', $seat->seat_type_id ?? null)
            ->value('price') ?? 0;

        $nextSeat = $seats[$i + 1]->showtimeSeat->seat ?? null;

        if (
            strtolower($seat->seatType->name) === 'double' &&
            $nextSeat &&
            strtolower($nextSeat->seatType->name) === 'double'
        ) {
            $total += $price; // chỉ tính 1 lần cho cặp đôi
            $skipNext = true;  // bỏ ghế thứ 2
        } else {
            $total += $price;
        }
    }

    return $total;
}


    public function promotion()
    {
        return $this->hasOne(BookingPromotion::class, 'booking_id', 'booking_id');
    }
    public function bookingFoods()
    {
        return $this->hasMany(BookingFood::class, 'booking_id');
    }
    public function bookingPromotions()
    {
        return $this->hasMany(BookingPromotion::class, 'booking_id');
    }
    public function getTotalDiscountAttribute()
{
    return $this->bookingPromotions->sum('discount_amount');
}
    public function getSeatsAttribute()
    {
        return $this->bookingSeats->map(function ($bookingSeat) {
            return $bookingSeat->showtimeSeat->seat ?? null;
        })->filter(); // bỏ null nếu có ghế lỗi
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'booking_id');
    }
    public function printer()
    {
        return $this->belongsTo(User::class, 'printed_by', 'user_id');
    }
}