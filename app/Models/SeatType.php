<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeatType extends Model
{
    protected $primaryKey = 'seat_type_id';

    protected $fillable = [
        'name',
        'default_price',
    ];

    // Một loại ghế có nhiều ghế cụ thể
    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class, 'seat_type_id');
    }

    // Một loại ghế có thể có giá khác nhau tại nhiều rạp
    public function cinemaPrices(): HasMany
    {
        return $this->hasMany(CinemaSeatTypePrice::class, 'seat_type_id');
    }
}