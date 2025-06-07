<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    protected $primaryKey = 'showtime_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'movie_id',
        'room_id',
        'show_date',
        'price',
        'status',
        'created_at',
        'updated_at'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'movie_id');
    }

    public function cinema()
    {
        return $this->belongsTo(Cinema::class, 'cinema_id', 'cinema_id');
    }
}
