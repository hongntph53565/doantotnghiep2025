<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $primaryKey = 'template_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = ['template_name', 'subject', 'content', 'created_by'];
}
