<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::latest()->get();
        return view('templates.index', compact('templates'));
    }

    public function create()
    {
        return view('templates.create');
    }

public function store(Request $request)
{
    $request->validate([
        'template_name' => 'required',
        'subject' => 'required',
        'content' => 'required',
    ]);

    EmailTemplate::create([
        'template_name' => $request->template_name,
        'subject' => $request->subject,
        'content' => $request->content,
        'created_by' => 'admin',
    ]);

    return redirect()->route('template.index')->with('success', 'Đã tạo template mới');
}

    public function edit(EmailTemplate $template)
    {
        return view('template.edit', compact('template'));
    }

public function update(Request $request, EmailTemplate $template)
{
    $request->validate([
        'template_name' => 'required',
        'subject' => 'required',
        'content' => 'required',
    ]);

    $template->update([
        'template_name' => $request->template_name,
        'subject' => $request->subject,
        'content' => $request->content,
    ]);

    return redirect()->route('template.index')->with('success', 'Đã cập nhật template');
}
    public function destroy(EmailTemplate $template)
    {
        $template->delete();
        return redirect()->route('template.index')->with('success', 'Đã xoá template');
    }
}
