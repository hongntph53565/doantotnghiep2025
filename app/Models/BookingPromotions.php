<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingPromotions extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id', 'promo_id', 'discount_amount'
    ];
}
