<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingFoodDrinks extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id', 'item_id', 'quantity', 'price'
    ];
}
