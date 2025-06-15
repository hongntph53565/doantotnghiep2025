<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $primaryKey = 'item_id';
    protected $fillable = [
        'item_name',
        'is_combo',
        'price',
        'status',
        'description',
        'image',
    ];
}
