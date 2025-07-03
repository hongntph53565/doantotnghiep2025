<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateApiController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::latest()->get();
        return response()->json([
            'success' => true,
            'data' => $templates
        ]);
    }

    public function show(EmailTemplate $template)
    {
        return response()->json([
            'success' => true,
            'data' => $template
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $template = EmailTemplate::create(array_merge($validated, [
            'created_by' => 'admin',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Template created successfully',
            'data' => $template
        ], 201);
    }

    public function update(Request $request, EmailTemplate $template)
    {
        $validated = $request->validate([
            'template_name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $template->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Template updated successfully',
            'data' => $template
        ]);
    }

    public function destroy(EmailTemplate $template)
    {
        $template->delete();

        return response()->json([
            'success' => true,
            'message' => 'Template deleted successfully'
        ]);
    }
}
