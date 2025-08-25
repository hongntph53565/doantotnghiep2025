<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'foods';
    protected $primaryKey = 'food_id';

    protected $fillable = [
        'cinema_id',
        'name',
        'type',
        'description',
        'price',
        'image',
        'status'
    ];

    protected $dates = ['deleted_at']; // để Eloquent hiểu deleted_at là kiểu ngày

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
