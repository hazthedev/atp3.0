<li class="space-y-1" x-data="{ open: true }">
    <div class="sidebar-link justify-between cursor-pointer" style="padding-left: 0.75rem;" @click="open = !open" title="My Workspace">
        <span class="flex min-w-0 flex-1 items-center gap-3">
            <x-icon name="bookmark" class="h-5 w-5 shrink-0 text-yellow-500" />
            <span x-cloak x-show="!sidebarCollapsed" class="truncate">My Workspace</span>
        </span>
        <button type="button"
                class="ml-2 shrink-0 rounded-md p-1 text-gray-400 transition hover:bg-white hover:text-gray-700"
                x-cloak x-show="!sidebarCollapsed"
                @click.stop="open = !open"
                aria-label="Toggle My Workspace">
            <x-icon name="chevron-down" class="h-4 w-4 transition-transform duration-200" x-bind:class="open ? 'rotate-180' : ''" />
        </button>
    </div>

    <ul x-cloak x-show="open && !sidebarCollapsed" x-collapse class="ml-4 space-y-1 border-l border-gray-200 pl-2">
        <template x-if="$store.workspace.items.length === 0">
            <li class="px-3 py-2 text-xs text-gray-400">No items pinned yet</li>
        </template>
        <template x-for="ws in $store.workspace.items" :key="ws.route">
            <li class="group flex items-center">
                <a :href="ws.url"
                   class="sidebar-link flex-1 min-w-0"
                   style="padding-left: 0.75rem;"
                   :title="ws.label">
                    <x-icon name="bookmark" class="h-5 w-5 shrink-0 text-gray-400" />
                    <span x-text="ws.label" class="truncate"></span>
                </a>
                <button type="button"
                        class="ml-1 shrink-0 rounded-md p-1 text-gray-300 transition hover:bg-white hover:text-red-500"
                        @click.prevent.stop="$store.workspace.toggle(ws)"
                        title="Remove from My Workspace"
                        aria-label="Remove from My Workspace">
                    <x-icon name="x-circle" class="h-4 w-4" />
                </button>
            </li>
        </template>
    </ul>
</li>
