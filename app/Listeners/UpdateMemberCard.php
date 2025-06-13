<?php

namespace App\Listeners;

use App\Events\PaymentEvents;
use App\Models\EmailTemplate;
use App\Models\MemberShipCard;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class UpdateMemberCard
{
    /**
     * Create the event listener.
     */
    public $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentEvents $event): void
    {
        $payment = $event->payment;

        if ($payment->status !== 'paid' || empty($payment->user_id)) {
            return;
        }

        $oldpoints = MemberShipCard::select('points')->where('user_id', $payment->user_id)->value('points');
        $newPoint = floor($payment->price_amount / 1000);
        $newPoint += $oldpoints;
        $cardType = 'silver';
        if ($newPoint >= 50000) {
            $cardType = 'platinum';
        } elseif ($newPoint >= 5000) {
            $cardType = 'gold';
        }
        if ($payment->status == "paid") {
            MemberShipCard::where('user_id', $payment->user_id)
                ->update([
                    'points' => $newPoint,
                    'card_type' => $cardType,
                ]);
            if ($cardType !== 'silver') {
                $user = User::where('user_id', $payment->user_id)->first();
                $template = EmailTemplate::where('subject', 'Cảm ơn bạn đã đồng hành cùng Lumistar')->first();

                if ($user && $template) {
                    $this->mailService->send($user->email, $template, array(
                        'user_name' => $user->username,
                        'card_type' => $cardType,
                        'points' => $newPoint
                    ));
                }
            }
        }
    }
}
