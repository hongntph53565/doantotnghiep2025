<?php

// app/Models/PostMeta.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    protected $fillable = [
        'post_id', 'meta_title', 'meta_description', 
        'meta_keywords', 'canonical_url', 'og_image'
    ];

    // Quan hệ 1-1 với Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}