<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtimes extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id', 'room_id', 'show_date', 'start_time', 'end_time', 'price', 'status'
    ];
}
