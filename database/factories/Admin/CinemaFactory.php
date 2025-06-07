<?php

namespace Database\Factories\Admin;
use App\Models\Admin\Cinema;

use Illuminate\Database\Eloquent\Factories\Factory;

class CinemaFactory extends Factory
{
    protected $model = Cinema::class;

    public function definition(): array
    {
        static $cinemas = [
            [
                'name' => 'LumiStar Vincom Bà Triệu',
                'address_detail' => 'Tầng 6, TTTM Vincom, 191 Bà Triệu',
                'ward' => 'Lê Đại Hành',
                'district' => 'Hai Bà Trưng',
                'city' => 'Hà Nội',
                'phone' => '02439740333',
                'email' => 'lumibatrieu@gmail.com',
            ],
            [
                'name' => 'LumiStar Landmark',
                'address_detail' => 'Tầng 5, Keangnam Landmark 72, Phạm Hùng',
                'ward' => 'Mễ Trì',
                'district' => 'Nam Từ Liêm',
                'city' => 'Hà Nội',
                'phone' => '02466821111',
                'email' => 'lumilandmark@gmail.com',
            ],
            [
                'name' => 'LumiStar Phạm Ngọc Thạch',
                'address_detail' => 'Tầng 8, Vincom Center, 2 Phạm Ngọc Thạch',
                'ward' => 'Trung Tự',
                'district' => 'Đống Đa',
                'city' => 'Hà Nội',
                'phone' => '02432181234',
                'email' => 'lumingocthach@gmail.com',
            ]
        ];

        static $index = 0;
        $data = $cinemas[$index];
        $index++;

        return $data;
    }
}
