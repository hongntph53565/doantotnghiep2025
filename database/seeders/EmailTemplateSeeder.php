<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('email_templates')->insert([
            'template_name' => 'Welcome Email',
            'subject' => 'Chào mừng đăng ký',
            'content' => '<h1>Chào mừng bạn đến với hệ thống của chúng tôi!</h1><p>Cảm ơn bạn đã đăng ký tài khoản.</p>',
            'created_by' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
