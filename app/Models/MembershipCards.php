<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipCards extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'card_type', 'points', 'issue_date', 'expiry_date'
    ];
}
