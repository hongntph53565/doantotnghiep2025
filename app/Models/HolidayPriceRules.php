<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayPriceRules extends Model
{
    use HasFactory;

    protected $fillable = [
        'holiday_id', 'cinema_id', 'seat_type', 'special_price'
    ];
}
