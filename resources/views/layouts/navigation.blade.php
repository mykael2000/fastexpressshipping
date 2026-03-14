<nav x-data="{ open: false }" class="border-b border-slate-200 bg-white/95 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <!-- Brand -->
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-fes-navy text-white shadow-sm">
                            <svg class="h-5 w-5 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h13l4 4v6a2 2 0 01-2 2h-1a3 3 0 11-6 0H9a3 3 0 11-6 0H2V9a2 2 0 012-2h1z"/>
                            </svg>
                        </div>
                        <div class="hidden sm:block">
                            <div class="text-sm font-semibold leading-tight text-fes-navy">Fast Express Shipping</div>
                            <div class="text-xs text-gray-500">Customer Dashboard</div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden sm:ml-10 sm:flex sm:items-center sm:space-x-2">
                    <a
                        href="{{ route('dashboard') }}"
                        class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-fes-orange text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-fes-navy' }}"
                    >
                        Dashboard
                    </a>

                    @if(Route::has('user.requests.create'))
                        <a
                            href="{{ route('user.requests.create') }}"
                            class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('user.requests.create') ? 'bg-fes-orange text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-fes-navy' }}"
                        >
                            New Request
                        </a>
                    @endif

                    @if(Route::has('user.requests.index'))
                        <a
                            href="{{ route('user.requests.index') }}"
                            class="inline-flex items-center rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('user.requests.index') ? 'bg-fes-orange text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-fes-navy' }}"
                        >
                            My Requests
                        </a>
                    @endif
                </div>
            </div>

            <!-- Desktop User Dropdown -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:border-gray-300 hover:bg-gray-50 focus:outline-none">
                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-fes-navy text-sm font-bold text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                            <div class="text-left">
                                <div class="text-sm font-semibold text-fes-navy">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                            </div>

                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-fes-navy">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')" class="text-sm">
                            {{ __('Profile Settings') }}
                        </x-dropdown-link>

                        @if(Route::has('dashboard'))
                            <x-dropdown-link :href="route('dashboard')" class="text-sm">
                                {{ __('Dashboard') }}
                            </x-dropdown-link>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link
                                :href="route('logout')"
                                class="text-sm text-red-600"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                            >
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button
                    @click="open = ! open"
                    class="inline-flex items-center justify-center rounded-xl p-2 text-gray-500 transition hover:bg-gray-100 hover:text-fes-navy focus:outline-none"
                >
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden border-t border-gray-100 bg-white sm:hidden">
        <div class="space-y-1 px-4 pb-4 pt-4">
            <a
                href="{{ route('dashboard') }}"
                class="block rounded-xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-fes-orange text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-fes-navy' }}"
            >
                Dashboard
            </a>

            @if(Route::has('user.requests.create'))
                <a
                    href="{{ route('user.requests.create') }}"
                    class="block rounded-xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('user.requests.create') ? 'bg-fes-orange text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-fes-navy' }}"
                >
                    New Request
                </a>
            @endif

            @if(Route::has('user.requests.index'))
                <a
                    href="{{ route('user.requests.index') }}"
                    class="block rounded-xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('user.requests.index') ? 'bg-fes-orange text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-fes-navy' }}"
                >
                    My Requests
                </a>
            @endif
        </div>

        <div class="border-t border-gray-100 px-4 py-4">
            <div class="mb-4">
                <div class="text-base font-semibold text-fes-navy">{{ Auth::user()->name }}</div>
                <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1">
                <a
                    href="{{ route('profile.edit') }}"
                    class="block rounded-xl px-4 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 hover:text-fes-navy"
                >
                    Profile Settings
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a
                        href="{{ route('logout') }}"
                        class="block rounded-xl px-4 py-3 text-sm font-medium text-red-600 transition hover:bg-red-50"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                    >
                        Log Out
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>
