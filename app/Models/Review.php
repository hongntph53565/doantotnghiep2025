<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $primaryKey = 'review_id'; // vì bạn dùng review_id thay vì id

    protected $fillable = [
        'user_id',
        'movie_id',
        'rating',
        'comment',
    ];

    /**
     * Review thuộc về người dùng.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Review thuộc về một phim.
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'movie_id');
    }
}
