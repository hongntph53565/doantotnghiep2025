<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    protected $primaryKey = 'promo_id';

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'discount_code',
        'discount_percentage',
        'discount_amount',
        'start_date',
        'end_date',
        'status',
    ];
}
