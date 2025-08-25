<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{

    use SoftDeletes;
    
    // Đặt khóa chính thủ công
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



    public function bookings()
    {
        return $this->hasMany(Booking::class, 'showtime_id', 'showtime_id');
    }

    public function room()
{
    return $this->belongsTo(Room::class, 'room_id', 'room_id')->withTrashed();
}

    public function movie()
{
    return $this->belongsTo(Movie::class, 'movie_id')->withTrashed();
}

    public function cinema()
    {
        // lấy cinema thông qua room
        return $this->hasOneThrough(
            Cinema::class,
            Room::class,
            'room_id',    // foreign key ở bảng room
            'cinema_id',  // foreign key ở bảng cinema
            'room_id',    // local key ở showtimes
            'cinema_id'   // local key ở rooms
        );
    }

     // 👇 thêm quan hệ 1-n với bảng trung gian
    public function showtimeSeats()
    {
        return $this->hasMany(ShowtimeSeat::class, 'showtime_id', 'showtime_id');
    }

    // 👇 thêm quan hệ n-n với bảng seats (qua bảng trung gian)
    public function seats()
    {
        return $this->belongsToMany(
            Seat::class,
            'showtime_seats',    // tên bảng trung gian
            'showtime_id',       // cột khóa ngoại trỏ đến showtimes
            'seat_id'            // cột khóa ngoại trỏ đến seats
        )->withPivot('status'); // lấy thêm cột status trong bảng trung gian
    }
     public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}