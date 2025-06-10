<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    // Đặt khóa chính thủ công
    protected $primaryKey = 'showtime_id';
    public $incrementing = true;
    protected $keyType = 'int';

    // Các trường có thể gán hàng loạt
    protected $fillable = [
        'movie_id',
        'room_id',
        'start_time',
        'end_time',
        'price',
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

    
}
