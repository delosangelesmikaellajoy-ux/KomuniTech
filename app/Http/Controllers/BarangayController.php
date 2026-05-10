<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class BarangayController extends Controller
{
    public function index()
    {
        $admins = User::where('role', User::ROLE_ADMIN)->get();

        $barangays = $admins->map(function (User $admin) {
            return [
                'admin' => $admin,
                'barangay' => $admin->barangay ?: $admin->name,
                'active_users' => User::where('role', User::ROLE_USER)
                    ->where('barangay', $admin->barangay)
                    ->count(),
                'subscription' => $admin->subscription,
                'total_revenue' => \App\Models\DocumentRequest::where('barangay', $admin->barangay)
                    ->where('status', 'Approved')
                    ->sum('service_fee'),
            ];
        });

        return view('administrator.barangays.index', compact('barangays'));
    }

    public function admins()
    {
        $admins = User::where('role', User::ROLE_ADMIN)
            ->with('subscription')
            ->get();

        return view('administrator.barangays.admins', compact('admins'));
    }

    public function create()
    {
        return view('administrator.barangays.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class, 'email')],
            'password' => ['required', 'string', 'min:8'],
            'barangay' => ['required', 'string', 'max:255'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => User::ROLE_ADMIN,
            'barangay' => $validated['barangay'],
            'is_seeder' => false,
        ]);

        return redirect()->route('administrator.barangay_admins.index')
            ->with('success', 'Barangay admin created successfully.');
    }
}
