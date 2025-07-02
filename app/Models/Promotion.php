<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    protected $primaryKey = 'promo_id';
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'pro_code',
        'min_order_amount',
        'discount_percentage',
        'quantity',
        'used',
        'limit_per_user',
        'start_date',
        'end_date',
        'status',
    ];
    protected $dates = ['deleted_at'];
}
