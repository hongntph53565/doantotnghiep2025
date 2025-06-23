<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cinema;

class CinemasTableSeeder extends Seeder
{
    public function run(): void
    {
        Cinema::insert([
            [
                'name' => 'BETA thanh xuân',
                'address_detail' => '123 thanh xuân',
                'ward' => 'Phường 1',
                'district' => 'Quận 5',
                'city' => 'TP. HN',
                'phone' => '0123456789',
                'email' => 'example@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
