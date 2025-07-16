<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailLog;
use Illuminate\Http\Request;

class EmailLogController extends Controller
{
public function index(Request $request)
{
    $status = $request->input('status');

    $query = EmailLog::query();

    if ($status) {
        $query->where('status', $status);
    }

    $logs = $query->latest()->paginate(10);
    $index = ($logs->currentPage() - 1) * $logs->perPage() + 1;
    $countSent = EmailLog::where('status', 'sent')->count();
    $countFailed = EmailLog::where('status', 'failed')->count();

    return view('admin.list.mailLog', compact('logs', 'index', 'countSent', 'countFailed'));
}


}
