<?php

// app/Models/Post.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'content', 'thumbnail', 
        'status', 'author_id', 'published_at'
    ];

    protected $dates = ['published_at', 'deleted_at'];

    // Quan hệ với User (tác giả)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Quan hệ nhiều-nhiều với Category
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_category');
    }

    // Quan hệ nhiều-nhiều với Tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    // Quan hệ 1-1 với PostMeta (SEO)
    public function meta()
    {
        return $this->hasOne(PostMeta::class);
    }

    // Quan hệ 1-n với SEO Analytics
    public function seoAnalytics()
    {
        return $this->hasMany(SeoAnalytic::class);
    }
}