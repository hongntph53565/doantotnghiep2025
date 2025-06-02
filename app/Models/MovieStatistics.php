<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieStatistics extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id', 'total_showtime', 'total_booking', 'total_revenue', 'total_customers', 'average_rating', 'occupancy_rate', 'start_date', 'end_date'
    ];
}
