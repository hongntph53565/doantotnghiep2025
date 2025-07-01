<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $primaryKey = 'seat_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['room_id', 'seat_code', 'seat_type'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
