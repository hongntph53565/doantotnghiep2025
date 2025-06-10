<?php

namespace App\Listeners;

use App\Events\PaymentEvents;
use App\Models\MemberShipCard;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateMemberCard
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
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
        }
    }
}
