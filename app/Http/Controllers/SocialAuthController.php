<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialAuthController extends Controller
{
    // Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback from Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Google login failed.');
        }

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => Hash::make(str()->random(16)), // secure random password
                'role' => User::ROLE_USER, // default role for regular residents
            ]
        );

        Auth::login($user);

        if ($user->isAdministrator()) {
            return redirect()->route('administrator.dashboard');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }

    // Redirect to Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Callback from Facebook
    public function handleFacebookCallback()
    {
        try {
            $fbUser = Socialite::driver('facebook')->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Facebook login failed.');
        }

        // Handle missing email gracefully
        $email = $fbUser->getEmail();
        if (!$email) {
            $email = $fbUser->getId() . '@facebook.local';
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $fbUser->getName() ?? 'Facebook User',
                'password' => Hash::make(str()->random(16)), // secure random password
                'role' => User::ROLE_USER, // default role for regular residents
            ]
        );

        Auth::login($user);

        if ($user->isAdministrator()) {
            return redirect()->route('administrator.dashboard');
        }

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
    }
}
