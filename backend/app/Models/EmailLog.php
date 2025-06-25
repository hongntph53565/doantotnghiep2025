<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = [
        'user_id',
        'template_id',
        'subject',
        'content',
        'status',
        'error_message',
        'sent_at',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function template() {
        return $this->belongsTo(EmailTemplate::class);
    }
}

