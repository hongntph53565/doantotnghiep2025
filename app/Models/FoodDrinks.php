<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodDrinks extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name', 'price', 'combo_type', 'status'
    ];
}
