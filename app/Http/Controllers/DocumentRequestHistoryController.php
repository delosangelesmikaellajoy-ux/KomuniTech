<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use App\Models\RequestHistory;

class DocumentRequestHistoryController extends Controller
{
    // User: view their own request history
    public function userHistory()
    {
        $requests = DocumentRequest::with('history')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('documents.request.index', compact('requests'));
    }

    // Admin: view all audit logs
    public function adminAudit()
    {
        $logs = RequestHistory::with(['request', 'causer'])
            ->latest()
            ->paginate(25);

        return view('admin.request_logs.index', compact('logs'));
    }
}
