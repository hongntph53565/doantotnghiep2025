<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'payment_id'; 

    protected $fillable = [
        'booking_id',
        'payment_method',
        'price_amount',
        'status',
    ];
}
