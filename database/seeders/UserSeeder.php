<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::create([
        'full_name' => 'Staff',
        'email' => 'staff@example.com',
        'phone' => '0123456788',
        'username' => 'staff',
        'password' => Hash::make('12345678'),
    ]);
    }
}
