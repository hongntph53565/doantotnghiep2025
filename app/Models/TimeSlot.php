<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $table = 'time_slots';

    protected $primaryKey = 'time_slot_id';

    protected $fillable = [
        'name',               // Tên khung giờ: "Sáng", "Chiều", "Tối", v.v.
        'start_time',
        'end_time',
        'extra_percentage'    // % cộng thêm giá vé
    ];

    public $timestamps = true;

    protected $casts = [
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
    ];
}
