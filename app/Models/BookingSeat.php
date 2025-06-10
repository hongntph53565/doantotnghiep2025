<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSeat extends Model
{
    use HasFactory;

    protected $table = 'booking_seats';

    protected $primaryKey = 'id'; // hoặc 'booking_seat_id' nếu tên cột khác

    protected $fillable = [
        'booking_id',
        'showtime_seat_id',
        'price',
    ];

    // Quan hệ: BookingSeat thuộc về Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    // Quan hệ: BookingSeat thuộc về ShowtimeSeat
    public function showtimeSeat()
    {
        return $this->belongsTo(ShowtimeSeat::class, 'showtime_seat_id', 'id');
    }
    
}
