<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Room extends Model
{

    use SoftDeletes;
    protected $primaryKey = 'room_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'cinema_id',
        'room_name',
        'total_seats',
        'created_at',
        'updated_at'
    ];

    public function cinema()
    {
        return $this->belongsTo(Cinema::class, 'cinema_id');
    }
    public function seats()
    {
        return $this->hasMany(Seat::class, 'room_id');
    }
}