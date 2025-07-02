<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\Cinema;

class CinemaSeeder extends Seeder
{

    public function run(): void
    {
        Cinema::factory()->count(3)->create();
    }
}
