<?php

// app/Models/SeoRedirect.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoRedirect extends Model
{
    protected $fillable = ['old_url', 'new_url', 'status_code'];
}
