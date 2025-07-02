<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\Mailler;
use App\Models\EmailLog;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;

class SendMailApiController extends Controller
{
    public function send(Request $request)
    {
        $userId = 1; // Thay bằng user auth nếu có

        $request->validate([
            'email'       => 'required|email',
            'template_id' => 'required|exists:email_templates,template_id',
            'data'        => 'nullable|array',  // Dữ liệu truyền vào template (nếu có)
        ]);

        try {
            $template = EmailTemplate::find($request->template_id);

            $htmlContent = Blade::render($template->content, $request->data ?? []);

            Mail::to($request->email)->send(new Mailler($template->subject, $htmlContent));

            EmailLog::create([
                'user_id'      => $userId,
                'template_id'  => $request->template_id,
                'subject'      => $template->subject,
                'content'      => $template->content,
                'status'       => 'sent',
                'sent_at'      => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email sent successfully',
            ], 200);

        } catch (\Exception $e) {

            EmailLog::create([
                'user_id'       => $userId,
                'template_id'   => $request->template_id ?? null,
                'subject'       => $template->subject ?? '',
                'content'       => $template->content ?? '',
                'status'        => 'failed',
                'error_message' => $e->getMessage(),
                'sent_at'       => now(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send email',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
