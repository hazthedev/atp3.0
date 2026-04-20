@php
    $items = config('navigation', []);

    $isItemActive = function (array $item) use (&$isItemActive): bool {
        $route = $item['route'] ?? null;
        $activeRoutes = $item['active_routes'] ?? [];

        if ($route && request()->routeIs($route)) {
            return true;
        }

        if ($activeRoutes !== [] && request()->routeIs($activeRoutes)) {
            return true;
        }

        foreach ($item['children'] ?? [] as $child) {
            if ($isItemActive($child)) {
                return true;
            }
        }

        return false;
    };
@endphp

<div>
    <div x-cloak x-show="sidebarOpen" class="fixed inset-0 z-30 bg-gray-900/40 md:hidden" @click="closeSidebar()"></div>

    <aside
        class="fixed inset-y-0 left-0 z-40 flex h-screen flex-col border-r border-gray-200 bg-white shadow-sm"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
        :style="sidebarCollapsed ? 'width:64px' : `width:${sidebarWidth}px`"
    >
        <div class="flex h-16 items-center gap-3 border-b border-gray-200 px-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">A3</div>
            <div x-cloak x-show="!sidebarCollapsed" class="min-w-0">
                <p class="truncate text-sm font-semibold text-gray-900">ATP 3.0</p>
                <p class="truncate text-xs text-gray-500">Weststar frontend preview</p>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto px-3 py-4">
            <nav aria-label="Sidebar navigation">
                <ul class="space-y-1">
                    @foreach ($items as $item)
                        @if ($item['workspace'] ?? false)
                            @include('components.sidebar-workspace', ['item' => $item])
                        @else
                            @include('components.sidebar-node', [
                                'item' => $item,
                                'level' => 0,
                                'isItemActive' => $isItemActive,
                            ])
                        @endif
                    @endforeach
                </ul>
            </nav>
        </div>

        <div class="border-t border-gray-200 p-3">
            <a href="{{ route('system.profile') }}" class="sidebar-link" title="Profile">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-50 text-xs font-semibold text-blue-700">
                    {{ strtoupper(substr(auth()->user()->name ?? 'T', 0, 1)) }}
                </div>
                <div x-cloak x-show="!sidebarCollapsed" class="min-w-0">
                    <p class="truncate text-sm font-medium text-gray-900">{{ auth()->user()->name ?? 'Test User' }}</p>
                    <p class="truncate text-xs text-gray-500">{{ auth()->user()->email ?? 'test@example.com' }}</p>
                </div>
            </a>
        </div>
        <div
            x-show="!sidebarCollapsed"
            @mousedown.prevent="startResize($event)"
            class="absolute inset-y-0 right-0 hidden w-1 cursor-col-resize bg-transparent transition-colors hover:bg-blue-400 md:block"
            title="Drag to resize"
        ></div>
    </aside>
</div>
