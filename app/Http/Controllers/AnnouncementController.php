<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Announcement::create($request->only('title', 'content'));

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement created successfully.');
    }

    public function edit(Announcement $announcement)
    {
         return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $announcement->update($request->only('title', 'content'));

        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('admin.announcements.index')
                         ->with('success', 'Announcement deleted successfully.');
    }

    // ✅ Number 2: User-facing announcements
    public function userIndex()
    {
        $announcements = Announcement::latest()->get();
        return view('user.announcements.index', compact('announcements'));
    }
}
