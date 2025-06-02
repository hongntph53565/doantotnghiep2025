<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CinemaStatistics extends Model
{
    use HasFactory;

    protected $fillable = [
        'cinema_id', 'stat_date', 'total_showtime', 'total_revenue', 'food_revenue', 'ticket_revenue', 'total_customers'
    ];
}
