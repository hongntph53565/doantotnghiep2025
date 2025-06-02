<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingQrcodes extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id', 'qr_code', 'qr_type', 'created_at', 'expired_at', 'is_printed', 'printed_at', 'printed_by'
    ];
}
