<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingFood extends Model
{
    use HasFactory;

    protected $table = 'booking_food';

    protected $primaryKey = 'id';

    protected $fillable = [
    'booking_id',
    'food_id',
    'quantity',
    'price',
];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function food()
    {
        return $this->belongsTo(Food::class, 'food_id');
    }
}