<nav x-data="{ open: false }" 
     class="bg-gradient-to-r from-[#6BB1F3] to-[#A2D3F9] shadow-lg rounded-b-lg border-b-4 border-[#0B1F3A]">
    <div class="max-w-full mx-auto px-6 lg:px-12">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo + KomuniTech Name -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                        <x-application-logo class="block h-10 w-auto fill-current text-[#0B1F3A]" />
                        <span class="text-xl font-bold text-[#0B1F3A] tracking-wide">KomuniTech</span>
                    </a>
                </div>

                <!-- Navigation Links (SMALLER) -->
                <div class="hidden sm:flex sm:space-x-4 sm:ml-8">
                    <!-- Dashboard -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                                class="text-sm font-semibold text-[#0B1F3A] hover:text-[#0B1F3A] hover:bg-[#6BB1F3] px-2 py-1 rounded-md transition">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- User-only links -->
                    @if(Auth::check() && Auth::user()->role === \App\Models\User::ROLE_USER)
                        <x-nav-link :href="route('document_requests.create')" :active="request()->routeIs('document_requests.create')" 
                                    class="text-sm font-semibold text-[#0B1F3A] hover:text-[#0B1F3A] hover:bg-[#6BB1F3] px-2 py-1 rounded-md transition">
                            {{ __('Request Document') }}
                        </x-nav-link>

                        <x-nav-link :href="route('document_requests.pending')" :active="request()->routeIs('document_requests.pending')" 
                                    class="text-sm font-semibold text-[#0B1F3A] hover:text-[#0B1F3A] hover:bg-[#6BB1F3] px-2 py-1 rounded-md transition">
                            {{ __('My Requests') }}
                        </x-nav-link>

                        <x-nav-link :href="route('document_requests.history')" :active="request()->routeIs('document_requests.history')" 
                                    class="text-sm font-semibold text-[#0B1F3A] hover:text-[#0B1F3A] hover:bg-[#6BB1F3] px-2 py-1 rounded-md transition">
                            {{ __('My Request History') }}
                        </x-nav-link>

                        <x-nav-link :href="route('user.announcements.index')" :active="request()->routeIs('user.announcements.index')" 
                                    class="text-sm font-semibold text-[#0B1F3A] hover:text-[#0B1F3A] hover:bg-[#6BB1F3] px-2 py-1 rounded-md transition">
                            {{ __('Announcements') }}
                        </x-nav-link>
                    @endif

                    <!-- Administrator-only -->
                    @if(Auth::check() && Auth::user()->role === \App\Models\User::ROLE_ADMINISTRATOR)
                        <x-nav-link :href="route('administrator.barangays.index')" :active="request()->routeIs('administrator.barangays.index')" 
                                    class="text-sm font-semibold text-[#0B1F3A] hover:text-[#0B1F3A] hover:bg-[#6BB1F3] px-2 py-1 rounded-md transition">
                            {{ __('All Barangays') }}
                        </x-nav-link>
                    @endif

                    <!-- Admin-only -->
                    @if(Auth::check() && Auth::user()->role === \App\Models\User::ROLE_ADMIN)
                        <x-nav-link :href="route('admin.document_requests.index')" :active="request()->routeIs('admin.document_requests.*')" 
                                    class="text-sm font-semibold text-[#0B1F3A] hover:text-[#0B1F3A] hover:bg-[#6BB1F3] px-2 py-1 rounded-md transition">
                            {{ __('Manage Requests') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-md text-[#0B1F3A] bg-white hover:bg-[#6BB1F3] hover:text-[#0B1F3A] transition">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="ml-2 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" 
                        class="inline-flex items-center justify-center p-2 rounded-md text-[#0B1F3A] hover:bg-[#6BB1F3] hover:text-[#0B1F3A] transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" 
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" 
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (SMALLER) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white shadow-md rounded-b-lg">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-sm px-3 py-2 hover:bg-[#6BB1F3]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::check() && Auth::user()->role === \App\Models\User::ROLE_USER)
                <x-responsive-nav-link :href="route('document_requests.create')" :active="request()->routeIs('document_requests.create')" class="text-sm px-3 py-2 hover:bg-[#6BB1F3]">
                    {{ __('Request Document') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('document_requests.pending')" :active="request()->routeIs('document_requests.pending')" class="text-sm px-3 py-2 hover:bg-[#6BB1F3]">
                    {{ __('My Requests') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('document_requests.history')" :active="request()->routeIs('document_requests.history')" class="text-sm px-3 py-2 hover:bg-[#6BB1F3]">
                    {{ __('My Request History') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('user.announcements.index')" :active="request()->routeIs('user.announcements.index')" class="text-sm px-3 py-2 hover:bg-[#6BB1F3]">
                    {{ __('Announcements') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::check() && Auth::user()->role === \App\Models\User::ROLE_ADMINISTRATOR)
                <x-responsive-nav-link :href="route('administrator.barangays.index')" :active="request()->routeIs('administrator.barangays.index')" class="text-sm px-3 py-2 hover:bg-[#6BB1F3]">
                    {{ __('All Barangays') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::check() && Auth::user()->role === \App\Models\User::ROLE_ADMIN)
                <x-responsive-nav-link :href="route('admin.document_requests.index')" :active="request()->routeIs('admin.document_requests.*')" class="text-sm px-3 py-2 hover:bg-[#6BB1F3]">
                    {{ __('Manage Requests') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-sm text-[#0B1F3A]">{{ Auth::user()->name }}</div>
                <div class="font-medium text-xs text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-sm px-3 py-2 hover:bg-[#6BB1F3]">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="text-sm px-3 py-2 hover:bg-[#6BB1F3]"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
