<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPriceRules extends Model
{
    use HasFactory;

    protected $fillable = [
        'cinema_id', 'seat_type', 'day_type', 'base_price', 'is_active'
    ];
}
