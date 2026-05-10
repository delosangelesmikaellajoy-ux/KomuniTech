<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-[#0B1F3A]" />
            <x-text-input id="email" class="block mt-1 w-full" 
                          type="email" name="email" :value="old('email')" 
                          required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-[#0B1F3A]" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me + Forgot Password -->
        <div class="flex items-center justify-between mt-4">
            <!-- Remember Me -->
            <label for="remember_me" class="flex items-center">
                <input id="remember_me" type="checkbox" 
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                       name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            <!-- Forgot Password -->
            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-600 hover:text-indigo-900" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button (centered) -->
        <div class="mt-4 flex justify-center">
            <x-primary-button class="px-6">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <!-- Social Login with Circular Logos -->
        <div class="mt-6 flex items-center justify-center space-x-6">
            <!-- Google Login -->
            <a href="{{ route('login.google') }}" 
               class="flex items-center justify-center w-12 h-12 rounded-full bg-white shadow-md hover:scale-110 transition-transform">
                <img src="{{ asset('images/google-logo.png') }}" alt="Google Login" class="w-6 h-6">
            </a>

            <!-- Facebook Login -->
            <a href="{{ route('login.facebook') }}" 
               class="flex items-center justify-center w-12 h-12 rounded-full bg-white shadow-md hover:scale-110 transition-transform">
                <img src="{{ asset('images/facebook-logo.png') }}" alt="Facebook Login" class="w-6 h-6">
            </a>
        </div>
    </form>
</x-guest-layout>
