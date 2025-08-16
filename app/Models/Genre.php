<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'genre_id';
    protected $fillable = ['genre_name', 'description', 'status'];

        public function movies()
    {
        return $this->hasMany(Movie::class, 'genre_id');
    }
}