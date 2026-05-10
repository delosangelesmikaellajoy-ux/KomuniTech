<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentRequest;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $requests = DocumentRequest::where('user_id', $userId)->get();

        return view('user.dashboard', compact('requests'));
    }
}
