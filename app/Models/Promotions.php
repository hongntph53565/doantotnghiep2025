<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotions extends Model
{
    use HasFactory;

    protected $fillable = [
        'promo_code', 'discount_percentage', 'start_date', 'end_date', 'status'
    ];
}
