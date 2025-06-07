<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\EmailTemplate;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     */
    protected $mailService;
    
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {   
        $data = array();
        $template = EmailTemplate::where('subject', 'Chào mừng đăng ký')->first();
        $this->mailService->send($event->user->email,$template->template_id,$data);
    }
}
