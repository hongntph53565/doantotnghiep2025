<?php

namespace App\Models;

use Faker\Provider\ar_EG\Payment;
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function showtime()
    {
        return $this->belongsTo(Showtime::class, 'showtime_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id');
    }

    public function foods()
    {
        return $this->belongsToMany(Food::class, 'booking_food')
            ->withPivot('quantity')
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
        return $this->hasMany(BookingSeat::class, 'booking_id');
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

}