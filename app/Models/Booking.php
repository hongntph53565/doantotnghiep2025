<?php

namespace App\Models;

use Faker\Provider\ar_EG\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $primaryKey = 'booking_id';
    use HasFactory;
    
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
}
