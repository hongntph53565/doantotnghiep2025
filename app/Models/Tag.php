<?php

// app/Models/Tag.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'slug'];

    // Quan hệ nhiều-nhiều với Post
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag');
    }
}