<section>
    <header>
        <h2 class="text-lg font-bold text-[#0B1F3A]">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <!-- Verification form -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Profile update form -->
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#6BB1F3] focus:border-[#6BB1F3]"
                :value="old('name', Auth::user()->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#6BB1F3] focus:border-[#6BB1F3]"
                :value="old('email', Auth::user()->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Barangay -->
        <div>
            <x-input-label for="barangay" :value="__('Barangay')" />
            <x-text-input id="barangay" name="barangay" type="text"
                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#6BB1F3] focus:border-[#6BB1F3]"
                :value="old('barangay', Auth::user()->barangay)" required autocomplete="organization" />
            <x-input-error class="mt-2" :messages="$errors->get('barangay')" />
        </div>

            @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-[#0B1F3A] hover:text-[#6BB1F3] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6BB1F3]">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Save button -->
        <div class="flex items-center gap-4">
            <x-primary-button class="bg-gradient-to-r from-[#6BB1F3] to-[#A2D3F9] text-[#0B1F3A] font-semibold px-6 py-2 rounded-lg shadow hover:scale-105 transition">
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
