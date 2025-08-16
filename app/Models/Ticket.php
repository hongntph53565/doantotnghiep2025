<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $primaryKey = 'ticket_id';

    protected $fillable = [
        'booking_id',
        'seat_id',
        'price',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class, 'seat_id');
    }
}