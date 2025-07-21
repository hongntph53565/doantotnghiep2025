<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\MemberShipCard;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateMemberShipCard
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
    public function handle(UserRegistered $event): void
    {
        $user = $event->user;

        MemberShipCard::create([
            'user_id' => $user->user_id,
            'card_number' => 'CARD' . time(),
            'card_type' => 'silver',
            'points' => 0,
        ]);
    }
}
