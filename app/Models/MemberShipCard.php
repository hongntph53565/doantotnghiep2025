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

    // ✅ Giá trị mặc định
    protected $attributes = [
        'card_type' => 'normal',
        'points' => 0,
    ];

    /**
     * Cập nhật loại thẻ dựa vào điểm hiện tại
     */
    public function updateCardType()
    {
        if ($this->points >= 5000) {
            $this->card_type = 'platinum';
        } elseif ($this->points >= 2000) {
            $this->card_type = 'gold';
        } elseif ($this->points >= 1000) {
            $this->card_type = 'silver';
        } else {
            $this->card_type = 'normal';
        }

        $this->save();
    }
}
