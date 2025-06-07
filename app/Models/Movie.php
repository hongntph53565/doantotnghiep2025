<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'movie_id';

    protected $fillable = [
        'genre_id',
        'title',
        'duration',
        'director',
        'cast',
        'release_date',
        'end_date',
        'poster',
        'trailer',
        'age_rating',
        'format',
        'language',
        'description',
    ];

    protected $dates = ['deleted_at'];

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id', 'genre_id');
    }
}
