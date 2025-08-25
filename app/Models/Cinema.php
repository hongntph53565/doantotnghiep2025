<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cinema extends Model
{

    use SoftDeletes;
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

    protected $dates = ['deleted_at'];

        public function rooms()
    {
        return $this->hasMany(Room::class, 'cinema_id');
    }
}