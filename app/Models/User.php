<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $primaryKey = 'user_id'; // nếu khóa chính không phải 'id'

    protected $fillable = [
    'last_name',
    'first_name',
    'gender',
    'email',
    'password',
    'phone',
    'birth_day',
    'birth_month',
    'birth_year',
    'role', // Thêm trường role nếu cần
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
}
