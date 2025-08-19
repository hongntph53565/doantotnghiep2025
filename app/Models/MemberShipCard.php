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

    /**
     * Cập nhật loại thẻ dựa vào điểm hiện tại
     */
    public function updateCardType()
    {
        if ($this->points >= 200) {
            $this->card_type = 'platinum';
        } elseif ($this->points >= 100) {
            $this->card_type = 'gold';
        } elseif ($this->points >= 50) {
            $this->card_type = 'silver';
        } else {
            $this->card_type = 'normal';
        }

        $this->save();
    }
}
