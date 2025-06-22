<?php

namespace App\Services;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use App\Models\EmailLog;
use App\Mail\Mailler;

class MailService
{
    public function send($email, $templateID, $data = null, $userID = 1)
    {
        try {

            $template = EmailTemplate::findOrFail($templateID);

            $htmlContent = Blade::render($template->content ?? '', $data ?? []);

            Mail::to($email)->send(new Mailler(
                $template->subject,
                $htmlContent
            ));
            EmailLog::create([
                'user_id'      => $userID,
                'template_id'  => $templateID,
                'subject'      => $template->subject,
                'content'      => $template->content,
                'status'       => 'sent',
                'sent_at'      => now(),
            ]);
            return true;
        } catch (\Exception $e) {
            EmailLog::create([
                'user_id'       => $userID,
                'template_id'   => $templateID,
                'subject'       => $template->subject,
                'content'       => $template->content,
                'status'        => 'failed',
                'error_message' => $e->getMessage(),
                'sent_at'       => now(),
            ]);

            return false;
        }
    }
}
