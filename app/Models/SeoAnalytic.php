<?php

// app/Models/SeoAnalytic.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoAnalytic extends Model
{
    protected $fillable = ['post_id', 'clicks', 'impressions', 'ctr', 'recorded_at'];

    // Quan hệ 1-n với Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}