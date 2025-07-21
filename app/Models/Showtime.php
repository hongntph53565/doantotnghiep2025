<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Showtime extends Model
{
    // Đặt khóa chính thủ công
    protected $primaryKey = 'showtime_id';
    public $incrementing = true;
    protected $keyType = 'int';
use HasFactory;
    protected $fillable = [
        'movie_id',
        'room_id',
        'date',
        'start_time',
        'end_time',
        'status',
    ];

    /**
     * Liên kết với phòng chiếu
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }

    /**
     * Liên kết với phim
     */

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'movie_id');
    }

    public function cinema()
    {
        return $this->belongsTo(Cinema::class, 'cinema_id', 'cinema_id');
    }

    public function bookings()
{
    return $this->hasMany(Booking::class, 'showtime_id', 'id');
}

}
