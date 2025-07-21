<?php

namespace App\Models;

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
        return $this->hasMany(Room::class, 'cinema_id');
    }
}
