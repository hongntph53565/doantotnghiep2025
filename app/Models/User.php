<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    protected $primaryKey = 'user_id';
   protected $fillable = [
    'username',
    'full_name',
    'email',
    'password',
    'phone',
    'address',  
    'birthday',
    'role_id',
    'cinema_id', 
    'status',
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }
    public function managedCinemas()
{
    return $this->belongsToMany(Cinema::class, 'manager_cinema', 'user_id', 'cinema_id')
                ->withTimestamps();
}

}