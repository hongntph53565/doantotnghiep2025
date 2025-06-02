<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $primaryKey = 'movie_id'; // nếu không phải 'id'

    protected $fillable = [
        'title',
        'duration',
        'director',
        'cast',
        'release_date',
        'end_date',
        'poster',
        'trailer',
        'genre_id',
        'age_rating',
        'format',
        'language',
        'description',
    ];

    public $timestamps = false; // vì bảng này không có updated_at
}

