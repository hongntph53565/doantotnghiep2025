<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieStatistic extends Model
{
    protected $table = 'movie_statistics';

    protected $primaryKey = 'stat_id';

    protected $fillable = [
        'movie_id',
        'total_showtime',
        'total_booking',
        'total_revenue',
        'total_customer',
        'average_rating',
        'occupancy_rate',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }
}
