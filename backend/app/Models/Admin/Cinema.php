<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    use HasFactory;  

    protected $primaryKey = 'cinema_id';
    public $incrementing = true;

    protected $fillable = [
        'name',
        'address_detail',
        'ward',
        'district',
        'city',
        'phone',
        'email'
    ];
}
