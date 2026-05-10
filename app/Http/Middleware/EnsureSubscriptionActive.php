<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSubscriptionActive
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $user = $request->user();

        if ($user && $user->isAdmin() && ! $user->hasActiveSubscription()) {
            return redirect()->route('admin.subscription.status')
                ->with('warning', 'Your barangay subscription must be active to access this section.');
        }

        return $next($request);
    }
}
