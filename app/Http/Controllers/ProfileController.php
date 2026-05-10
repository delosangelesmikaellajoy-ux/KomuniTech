<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\DocumentRequest;
use App\Models\Announcement; // ✅ Import Announcement model

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
        'user' => $request->user(),
        ]);
    }


    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Show the user's dashboard with requests and announcements.
     */
    public function dashboard(): View
    {
        $userId = auth()->id();

        // ✅ Get all requests for this user
        $requests = DocumentRequest::where('user_id', $userId)->latest()->get();

        // ✅ Get latest announcements from database (limit to 3 for dashboard preview)
        $announcements = Announcement::latest()->take(3)->get();

        // ✅ Correct view path since file is at resources/views/dashboard.blade.php
        return view('dashboard', compact('requests', 'announcements'));
    }
}
