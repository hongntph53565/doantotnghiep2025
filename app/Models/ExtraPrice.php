<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraPrice extends Model
{
    protected $table = 'extra_prices';

    protected $primaryKey = 'extra_price_id';

    protected $fillable = [
        'day_type',
        'date',
        'percentage',
        'description'
    ];

    public $timestamps = true;

    protected $casts = [
        'date' => 'date',
    ];
}
