<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cinemas extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address_detail', 'ward', 'district', 'province', 'phone', 'created_at'
    ];
}
