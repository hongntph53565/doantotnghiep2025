<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    protected $primaryKey = 'combo_id';

    protected $fillable = [
        'name',
        'price',
        'description',
    ];


}
