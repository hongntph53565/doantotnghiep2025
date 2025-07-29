<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'review_id';

    protected $fillable = [
        'user_id',
        'movie_id',
        'rating',
        'comment',
        'status',
    ];

    // Liên kết với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Liên kết với Movie
    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'movie_id');
    }
}
