<header class="sticky top-0 z-20 border-b border-gray-200 bg-white/95 backdrop-blur">
    <div class="flex h-16 items-center justify-between gap-4 px-4 md:px-6">
        <div class="flex items-center gap-3">
            <button type="button" class="btn-ghost px-3 md:hidden" @click="toggleMobileSidebar()" aria-label="Open navigation">
                <x-icon name="bars-3" />
            </button>

            <button type="button" class="btn-ghost hidden px-3 md:inline-flex" @click="toggleDesktopSidebar()" aria-label="Collapse navigation">
                <x-icon name="bars-3" />
            </button>

            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Weststar ATP</p>
                <h1 class="text-lg font-semibold text-gray-900">@yield('title', 'Dashboard')</h1>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" class="btn-ghost px-3" aria-label="Notifications">
                <x-icon name="bell" />
            </button>

            <button id="user-menu-button" data-dropdown-toggle="user-menu" data-dropdown-placement="bottom-end" type="button" class="inline-flex items-center gap-3 rounded-full border border-gray-200 bg-white px-3 py-2 shadow-sm transition hover:border-blue-200 hover:shadow-md">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-50 text-sm font-semibold text-blue-700">
                    {{ strtoupper(substr(auth()->user()->name ?? 'T', 0, 1)) }}
                </div>
                <div class="hidden text-left md:block">
                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name ?? 'Test User' }}</p>
                    <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role ?? 'Admin') }}</p>
                </div>
            </button>

            <div id="user-menu" class="z-50 hidden w-56 divide-y divide-gray-100 rounded-xl border border-gray-200 bg-white shadow-lg">
                <div class="px-4 py-3">
                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name ?? 'Test User' }}</p>
                    <p class="truncate text-xs text-gray-500">{{ auth()->user()->email ?? 'test@example.com' }}</p>
                </div>
                <div class="p-2">
                    <a href="{{ route('system.profile') }}" class="sidebar-link">Profile</a>
                    <a href="{{ route('system.settings') }}" class="sidebar-link">Settings</a>
                    <a href="{{ route('dashboard') }}" class="sidebar-link">Return to dashboard</a>
                </div>
            </div>
        </div>
    </div>
</header>
