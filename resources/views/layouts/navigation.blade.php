<nav x-data="{ open: false }" class="fixed top-0 left-0 right-0 bg-white border-b border-neutral-200 shadow-sm z-[100]">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo Section -->
            <div class="flex-shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                    <x-application-logo class="h-8 w-auto fill-current text-primary-600" />
                    <span class="hidden sm:inline text-xl font-bold text-primary-900">KomuniTech</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('dashboard') }}" 
                   class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-primary-100 text-primary-900' : 'text-neutral-700 hover:bg-neutral-100' }}">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>

                @if(Auth::check() && Auth::user()->role === \App\Models\User::ROLE_USER)
                    <a href="{{ route('document_requests.create') }}" 
                       class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('document_requests.create') ? 'bg-primary-100 text-primary-900' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <i class="fas fa-file-circle-plus mr-2"></i>Request Document
                    </a>
                    <a href="{{ route('document_requests.pending') }}" 
                       class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('document_requests.pending') ? 'bg-primary-100 text-primary-900' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <i class="fas fa-hourglass-half mr-2"></i>My Requests
                    </a>
                    <a href="{{ route('document_requests.history') }}" 
                       class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('document_requests.history') ? 'bg-primary-100 text-primary-900' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <i class="fas fa-history mr-2"></i>History
                    </a>
                    <a href="{{ route('user.announcements.index') }}" 
                       class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('user.announcements.index') ? 'bg-primary-100 text-primary-900' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <i class="fas fa-bell mr-2"></i>Announcements
                    </a>
                @endif

                @if(Auth::check() && Auth::user()->role === \App\Models\User::ROLE_ADMINISTRATOR)
                    <a href="{{ route('administrator.barangays.index') }}" 
                       class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('administrator.barangays.index') ? 'bg-primary-100 text-primary-900' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <i class="fas fa-map-location-dot mr-2"></i>All Barangays
                    </a>
                @endif

                @if(Auth::check() && Auth::user()->role === \App\Models\User::ROLE_ADMIN)
                    <a href="{{ route('admin.document_requests.index') }}" 
                       class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.document_requests.*') ? 'bg-primary-100 text-primary-900' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <i class="fas fa-tasks mr-2"></i>Manage Requests
                    </a>
                    <a href="{{ route('admin.document_types.index') }}" 
                       class="px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.document_types.*') ? 'bg-primary-100 text-primary-900' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <i class="fas fa-file-invoice mr-2"></i>Document Types
                    </a>
                @endif
            </div>

            <!-- User Dropdown & Mobile Menu Trigger -->
            <div class="flex items-center gap-2">
                <!-- User Dropdown (Desktop) -->
                <div class="hidden md:block">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-neutral-700 hover:text-primary-600 hover:bg-neutral-100 rounded-lg transition">
                                <i class="fas fa-user-circle mr-2"></i>
                                {{ Auth::user()->name }}
                                <i class="fas fa-chevron-down ml-2 h-4 w-4"></i>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                <i class="fas fa-user-edit mr-2"></i>{{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="fas fa-sign-out-alt mr-2"></i>{{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="open = !open" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-neutral-700 hover:bg-neutral-100 transition">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="open" x-transition class="md:hidden border-t border-neutral-200 py-2">
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-primary-100 text-primary-900' : 'text-neutral-700 hover:bg-neutral-100' }}">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>

                @if(Auth::check() && Auth::user()->role === \App\Models\User::ROLE_USER)
                    <a href="{{ route('document_requests.create') }}" 
                       class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('document_requests.create') ? 'bg-primary-100 text-primary-900' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <i class="fas fa-file-circle-plus mr-2"></i>Request Document
                    </a>
                    <a href="{{ route('document_requests.pending') }}" 
                       class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('document_requests.pending') ? 'bg-primary-100 text-primary-900' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <i class="fas fa-hourglass-half mr-2"></i>My Requests
                    </a>
                    <a href="{{ route('document_requests.history') }}" 
                       class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('document_requests.history') ? 'bg-primary-100 text-primary-900' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <i class="fas fa-history mr-2"></i>History
                    </a>
                    <a href="{{ route('user.announcements.index') }}" 
                       class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('user.announcements.index') ? 'bg-primary-100 text-primary-900' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <i class="fas fa-bell mr-2"></i>Announcements
                    </a>
                @endif

                @if(Auth::check() && Auth::user()->role === \App\Models\User::ROLE_ADMINISTRATOR)
                    <a href="{{ route('administrator.barangays.index') }}" 
                       class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('administrator.barangays.index') ? 'bg-primary-100 text-primary-900' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <i class="fas fa-map-location-dot mr-2"></i>All Barangays
                    </a>
                @endif

                @if(Auth::check() && Auth::user()->role === \App\Models\User::ROLE_ADMIN)
                    <a href="{{ route('admin.document_requests.index') }}" 
                       class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.document_requests.*') ? 'bg-primary-100 text-primary-900' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <i class="fas fa-tasks mr-2"></i>Manage Requests
                    </a>
                    <a href="{{ route('admin.document_types.index') }}" 
                       class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.document_types.*') ? 'bg-primary-100 text-primary-900' : 'text-neutral-700 hover:bg-neutral-100' }}">
                        <i class="fas fa-file-invoice mr-2"></i>Document Types
                    </a>
                @endif

                <!-- Mobile User Settings -->
                <div class="border-t border-neutral-200 pt-2 mt-2">
                    <a href="{{ route('profile.edit') }}" 
                       class="block px-4 py-2 rounded-lg text-sm font-medium text-neutral-700 hover:bg-neutral-100">
                        <i class="fas fa-user-edit mr-2"></i>Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full text-left px-4 py-2 rounded-lg text-sm font-medium text-neutral-700 hover:bg-neutral-100">
                            <i class="fas fa-sign-out-alt mr-2"></i>Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

