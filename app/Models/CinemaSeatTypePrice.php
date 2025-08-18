<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CinemaSeatTypePrice extends Model
{
        use SoftDeletes; 
    protected $table = 'cinema_seat_type_prices';

    protected $fillable = [
        'cinema_id',
        'seat_type_id',
        'price',
    ];

    public function cinema()
    {
        return $this->belongsTo(Cinema::class, 'cinema_id');
    }

    public function seatType()
    {
        return $this->belongsTo(SeatType::class, 'seat_type_id');
    }
}