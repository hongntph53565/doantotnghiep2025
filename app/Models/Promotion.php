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
        'type_discount',
        'discount_value',
        'max_uses',
        'used_count',
        'max_discount',
        'min_order_value',
        'status',
        'card_type',
        'start_date',
        'end_date',
    ];
}