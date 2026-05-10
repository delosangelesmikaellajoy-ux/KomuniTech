<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-[#0B1F3A]">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <!-- Trigger button -->
    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-700 text-white font-semibold rounded-lg shadow hover:scale-105 transition"
    >
        {{ __('Delete Account') }}
    </button>

    <!-- Confirmation modal -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-[#0B1F3A]">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <!-- Password input -->
            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 border-gray-300 rounded-lg shadow-sm focus:ring-[#6BB1F3] focus:border-[#6BB1F3]"
                    placeholder="{{ __('Password') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <!-- Action buttons -->
            <div class="mt-6 flex justify-end">
                <button type="button"
                    x-on:click="$dispatch('close')"
                    class="px-4 py-2 bg-gray-300 text-[#0B1F3A] font-semibold rounded-lg shadow hover:bg-gray-400 transition">
                    {{ __('Cancel') }}
                </button>

                <button type="submit"
                    class="ms-3 px-4 py-2 bg-gradient-to-r from-red-500 to-red-700 text-white font-semibold rounded-lg shadow hover:scale-105 transition">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
