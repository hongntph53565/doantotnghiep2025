<?php

namespace App\Models;

use App\Models\Showtime;

use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{

    protected $primaryKey = 'cinema_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'name',
        'address_detail',
        'ward',
        'district',
        'city',
        'phone',
        'email',
        'status',

    ];

    public function rooms()
    {
         return $this->hasMany(Room::class, 'cinema_id', 'cinema_id');
    }


    public function movies()
    {
        return $this->hasManyThrough(
            Movie::class,
            Showtime::class,
            'cinema_id',  // Foreign key on showtimes table...
            'movie_id',   // Foreign key on movies table...
            'cinema_id',  // Local key on cinemas table...
            'movie_id'    // Local key on showtimes table...
        )->distinct(); // để không bị trùng phim
    }

      public function showtimes()
    {
        return $this->hasManyThrough(
            Showtime::class,
            Room::class,
            'cinema_id',
            'room_id',
            'cinema_id',
            'room_id'
        );
    }
}
