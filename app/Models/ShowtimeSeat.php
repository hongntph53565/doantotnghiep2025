<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowtimeSeat extends Model
{
    // Nếu bạn đặt tên khóa chính là mặc định 'id', không cần khai báo $primaryKey
    // Nếu khác thì khai báo như sau:
    // protected $primaryKey = 'showtime_seat_id';

    protected $table = 'showtime_seats';

    // Các trường có thể gán hàng loạt
    protected $fillable = [
        'showtime_id',
        'seat_id',
        'status',
    ];

    /**
     * Liên kết tới suất chiếu (Showtime)
     */
    public function showtime()
    {
        return $this->belongsTo(Showtime::class, 'showtime_id', 'showtime_id');
    }

    /**
     * Liên kết tới ghế (Seat)
     */
    public function seat()
    {
        return $this->belongsTo(Seat::class, 'seat_id', 'seat_id');
    }
}
