<?php

namespace App\Listeners;

use App\Events\PaymentEvents;
use App\Models\MemberShipCard;
use App\Models\User;
use App\Services\MailService;

class UpdateMemberCard
{
    public $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function handle(PaymentEvents $event): void
    {
        $payment = $event->payment;

        // Chỉ xử lý khi thanh toán thành công và có user_id
        if ($payment->status !== 'paid' || empty($payment->user_id)) {
            return;
        }

        // Lấy thẻ thành viên, nếu chưa có thì tạo
        $card = MemberShipCard::firstOrCreate(
            ['user_id' => $payment->user_id],
            [
                'card_number' => 'CARD' . time(),
                'points' => 0,
                'card_type' => 'normal',
            ]
        );

        // Cộng điểm từ thanh toán
        $card->points += floor($payment->price_amount / 1000);

        // Cập nhật hạng thẻ theo hàm có sẵn
        $card->updateCardType();

        // Nếu muốn có thể gửi email nhưng ở đây tạm bỏ, không dùng $template
    }
}
