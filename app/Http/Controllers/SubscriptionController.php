<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class SubscriptionController extends Controller
{
    public function status()
    {
        $user = Auth::user();
        $subscription = $user->subscription;

        return view('admin.subscription.status', compact('subscription'));
    }

    public function pay(Request $request)
    {
        $request->validate([
            'payment_reference' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $subscription = $user->subscription;

        if (! $subscription) {
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'status' => Subscription::STATUS_ACTIVE,
                'amount' => 1500,
                'starts_at' => now(),
                'expires_at' => now()->addYear(),
                'payment_reference' => $request->payment_reference,
            ]);
        } else {
            $subscription->update([
                'status' => Subscription::STATUS_ACTIVE,
                'amount' => 1500,
                'starts_at' => now(),
                'expires_at' => now()->addYear(),
                'payment_reference' => $request->payment_reference,
            ]);
        }

        Transaction::create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'type' => Transaction::TYPE_SUBSCRIPTION_FEE,
            'amount' => $subscription->amount,
            'status' => Transaction::STATUS_COMPLETED,
            'description' => 'Subscription fee payment for barangay admin account',
            'barangay' => $user->barangay,
            'payment_status' => 'Completed',
        ]);

        return redirect()->route('admin.subscription.status')
            ->with('success', 'Subscription payment recorded. Your account is now active for one year.');
    }
}
