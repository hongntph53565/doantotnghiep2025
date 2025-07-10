<?php

// app/Models/Category.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'parent_id'];

    // Quan hệ nhiều-nhiều với Post
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_category');
    }

    // Quan hệ đệ quy (danh mục cha - con)
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}