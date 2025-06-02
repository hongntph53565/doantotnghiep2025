<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'showtime_id', 'seat_id', 'booking_status', 'payment_status',
        'created_at', 'total_amount', 'booking_code', 'booking_source', 'created_by'
    ];
}
