<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingPromotion extends Model
{
    protected $table = 'booking_promotions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'booking_id',
        'promo_id',
        'discount_amount',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promo_id', 'promo_id');
    }
}
