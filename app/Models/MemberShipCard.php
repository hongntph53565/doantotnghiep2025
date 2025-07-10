<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberShipCard extends Model
{
    protected $table = 'membership_cards';
    protected $primaryKey = 'card_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'card_number',
        'card_type',
        'points',
        'created_at',
        'updated_at',
    ];
}
