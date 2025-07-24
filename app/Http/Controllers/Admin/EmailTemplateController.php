<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
public function index(Request $request)
{
    $keyword = $request->input('keyword');

    $query = EmailTemplate::query();

    if ($keyword) {
        $query->where('template_name', 'like', "%$keyword%")
              ->orWhere('subject', 'like', "%$keyword%");
    }

    $templates = $query->latest()->paginate(10);
    $index = 1;
    return view('admin.list.template', compact('templates', 'index'));
}


    public function create()
    {
        return view('admin.create.template');
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

    public function edit($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return view('admin.edit.template', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'template_name' => 'required',
            'subject' => 'required',
            'content' => 'required',
        ]);

        $template = EmailTemplate::findOrFail($id);

        $template->update([
            'template_name' => $request->template_name,
            'subject' => $request->subject,
            'content' => $request->content,
        ]);

        return redirect()->route('template.index')->with('success', 'Đã cập nhật template');
    }

    public function show($id){
        $template = EmailTemplate::findOrFail($id);
        return view('admin.show.template', compact('template'));
    }

    public function delete($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $template->delete();

        return redirect()->route('template.index')->with('success', 'Xoá mẫu email thành công!');
    }

}