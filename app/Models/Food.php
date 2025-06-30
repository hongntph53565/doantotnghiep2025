<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $primaryKey = 'food_id';

    protected $fillable = [
        'cinema_id',
        'name',
        'type',
        'price',
        'image',
    ];

    // Quan hệ nhiều-many với bookings thông qua bảng trung gian booking_food
    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_food', 'food_id', 'booking_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

public function cinema()
{
    return $this->belongsTo(Cinema::class, 'cinema_id', 'cinema_id');
}
}
