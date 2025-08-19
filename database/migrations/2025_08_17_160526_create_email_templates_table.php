<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->bigIncrements('template_id');
            $table->string('template_name');
            $table->text('subject');
            $table->longText('content');
            $table->string('created_by');
            $table->timestamps();
        });

DB::table('email_templates')->insert([
[
        'template_name' => 'thank_you_upgrade',
    'subject' => 'Cảm ơn bạn đã đồng hành cùng Lumistar',
    'content' => '
        <!DOCTYPE html>
        <html lang="vi">
        <head>
            <meta charset="UTF-8" />
            <title>Chúc mừng nâng hạng hội viên</title>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                .email-container { max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 10px; }
                .header { text-align: center; margin-bottom: 20px; }
                .header img { width: 100px; }
                .content h2 { color: #2e3b55; }
                .button {
                    display: inline-block;
                    background-color: #2e3b55;
                    color: #fff;
                    text-decoration: none;
                    padding: 10px 20px;
                    border-radius: 5px;
                    margin-top: 20px;
                }
                .footer {
                    margin-top: 40px;
                    font-size: 12px;
                    text-align: center;
                    color: #888;
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="header">
                    <img src="https://yourdomain.com/logo.png" alt="LumiStar Logo" />
                </div>

                <div class="content">
                    <h2>🎉 Cảm ơn bạn đã đồng hành cùng LumiStar!</h2>
                    <p>Xin chào <strong>{user_name}</strong>,</p>

                    <p>Chúng tôi vô cùng trân trọng sự ủng hộ của bạn trong suốt thời gian qua.</p>

                    <p>Với tổng điểm hiện tại là <strong>{points} điểm</strong>, bạn đã chính thức trở thành hội viên <strong>{card_type}</strong> trong hệ thống LumiStar.</p>

                    <p>Đây là cột mốc đáng nhớ, và chúng tôi cam kết sẽ mang đến cho bạn nhiều trải nghiệm, ưu đãi đặc biệt dành riêng cho hạng hội viên của bạn.</p>

                    <p style="text-align: center;">
                        <a href="https://lumistar.vn/account" class="button">Xem tài khoản hội viên</a>
                    </p>

                    <p>Chúc bạn một ngày tuyệt vời và hẹn gặp lại tại LumiStar!</p>

                    <p>Trân trọng,<br/>Đội ngũ LumiStar</p>
                </div>

                <div class="footer">
                    © 2025 LumiStar – All rights reserved.
                </div>
            </div>
        </body>
        </html>
    ',
    'created_by' => 'system',
    'created_at' => now(),
    'updated_at' => now(),
],
['template_name' => 'welcome_user',
    'subject' => 'Chào mừng đến với Lumistar',
    'content' => '
        <!DOCTYPE html>
        <html lang="vi">
        <head>
            <meta charset="UTF-8">
            <title>Chào mừng đến với Lumistar</title>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; padding: 30px; border-radius: 10px; }
                .header { text-align: center; margin-bottom: 20px; }
                .header img { width: 100px; }
                h2 { color: #2e3b55; }
                .button {
                    display: inline-block;
                    background-color: #2e3b55;
                    color: #fff;
                    padding: 12px 24px;
                    border-radius: 5px;
                    text-decoration: none;
                    margin-top: 20px;
                }
                .footer {
                    margin-top: 40px;
                    font-size: 12px;
                    text-align: center;
                    color: #888;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <img src="https://yourdomain.com/logo.png" alt="LumiStar Logo">
                </div>

                <h2>✨ Chào mừng đến với LumiStar!</h2>

                <p>Chúng tôi rất vui mừng khi bạn đã trở thành một phần của cộng đồng LumiStar.</p>

                <p>Hãy bắt đầu hành trình khám phá và trải nghiệm những tiện ích độc đáo mà LumiStar mang lại.</p>

                <p style="text-align:center;">
                    <a href="https://lumistar.vn/login" class="button">Đăng nhập ngay</a>
                </p>

                <p>Nếu bạn cần hỗ trợ, đừng ngần ngại liên hệ với chúng tôi qua email: <a href="mailto:hotro@lumistar.vn">hotro@lumistar.vn</a></p>

                <div class="footer">
                    © 2025 LumiStar – Mọi quyền được bảo lưu.
                </div>
            </div>
        </body>
        </html>
    ',
    'created_by' => 'system',
    'created_at' => now(),
    'updated_at' => now(),],
   [
    'template_name' => 'booking_success',
    'subject' => 'Xác nhận đặt vé thành công',
    'content' => '
        <!DOCTYPE html>
        <html lang="vi">
        <head>
            <meta charset="UTF-8">
            <title>Xác nhận đặt vé thành công</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .email-container {
                    max-width: 600px;
                    margin: auto;
                    background-color: #ffffff;
                    padding: 30px;
                    border-radius: 10px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .header h1 {
                    color: #e50914;
                    margin: 0;
                }
                .ticket-info {
                    background-color: #f9f9f9;
                    padding: 15px;
                    border-radius: 5px;
                    margin-bottom: 20px;
                }
                .ticket-info h3 {
                    margin-top: 0;
                    color: #2e3b55;
                }
                .button {
                    display: inline-block;
                    background-color: #e50914;
                    color: #fff;
                    text-decoration: none;
                    padding: 10px 20px;
                    border-radius: 5px;
                    margin-top: 20px;
                }
                .footer {
                    margin-top: 40px;
                    font-size: 12px;
                    text-align: center;
                    color: #888;
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="header">
                    <h1>🎟 ĐẶT VÉ THÀNH CÔNG</h1>
                </div>

                <p>Xin chào <strong>{{ $customer_name }}</strong>,</p>
                <p>Cảm ơn bạn đã đặt vé tại <strong>{{ $cinema_name }}</strong>. Dưới đây là thông tin đặt vé của bạn:</p>

                <div class="ticket-info">
                    <h3>THÔNG TIN VÉ</h3>
                    <p><strong>Mã đặt vé:</strong> {{ $booking_code }}</p>
                    <p><strong>Phim:</strong> {{ $movie_name }}</p>
                    <p><strong>Rạp:</strong> {{ $cinema_name }}</p>
                    <p><strong>Phòng chiếu:</strong> {{ $room_name }}</p>
                    <p><strong>Suất chiếu:</strong> {{ $showtime }}</p>
                    <p><strong>Ghế:</strong> {{ $seats }}</p>
                    <p><strong>Đồ ăn:</strong> {{ $foods }}</p>
                    <p><strong>Tổng thanh toán:</strong> {{ $total_price }}₫</p>
                </div>

                <p>Vui lòng đến rạp trước 15 phút để làm thủ tục nhận vé.</p>

                <p style="text-align: center;">
                    <a href="{{ $ticket_url }}" class="button">XEM VÉ CỦA BẠN</a>
                </p>

                <p>Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi qua:</p>
                <p>Email: support@rapchieuphim.com<br>
                Hotline: 1900 9999</p>

                <div class="footer">
                    © {{ $year }} {{ $cinema_name }} – All rights reserved.<br>
                    Đây là email tự động, vui lòng không trả lời.
                </div>
            </div>
        </body>
        </html>
    ',
    'created_by' => 'system',
    'created_at' => now(),
    'updated_at' => now(),
],

]);

    }

    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};