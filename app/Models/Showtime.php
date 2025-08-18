<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Showtime extends Model
{
    use SoftDeletes;

    // Khóa chính
    protected $primaryKey = 'showtime_id';
    public $incrementing = true;
    protected $keyType = 'int';

    // Các trường có thể gán hàng loạt
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
        return $this->belongsTo(Movie::class, 'movie_id', 'movie_id')->withTrashed();
    }

    /**
     * Liên kết với booking
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'showtime_id', 'showtime_id');
    }

    /**
     * Liên kết với ghế (nếu dùng bảng pivot showtime_seats)
     */
    public function seats()
    {
        return $this->belongsToMany(Seat::class, 'showtime_seats', 'showtime_id', 'seat_id');
    }
}
