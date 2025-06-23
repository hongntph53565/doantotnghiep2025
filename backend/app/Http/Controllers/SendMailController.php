<?php

namespace App\Http\Controllers;

use App\Mail\Mailler;
use App\Models\EmailLog;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function create()
    {
        $templates = EmailTemplate::all();
        return view('Email.send-mail', compact('templates'));
    }

    public function send(Request $request, $data = null)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'template_id' => 'required|exists:email_templates,template_id',
            ]);
            $template = EmailTemplate::find($request->template_id);

            if ($data != null) {
                $htmlContent = Blade::render($template->content, $data);
            } else {
                $htmlContent = Blade::render($template->content, array());
            }
            Mail::to($request->email)->send(new Mailler(
                $template->subject,
                $htmlContent
            ));
            $userId = 1;
            EmailLog::create([
                'user_id'      => $userId ?? 1,
                'template_id'  => $request->template_id,
                'subject'      => $template->subject,
                'content'      => $template->content,
                'status'       => 'sent',
                'sent_at'      => now(),
            ]);
            return redirect()->route('mail.create');
        } catch (\Exception $e) {
            EmailLog::create([
                'user_id'       => $userId ?? 1,
                'template_id'   => $request->template_id,
                'subject'       => $template->subject,
                'content'       => $template->content,
                'status'        => 'failed',
                'error_message' => $e->getMessage(),
                'sent_at'       => now(),
            ]);
            return redirect()->route('mail.create');
        }
    }
}
