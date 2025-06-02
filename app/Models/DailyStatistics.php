<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyStatistics extends Model
{
    use HasFactory;

    protected $fillable = [
        'stat_date', 'total_showtime', 'total_booking', 'total_revenue', 'food_revenue', 'ticket_revenue', 'total_customers', 'occupancy_rate', 'created_at'
    ];
}
