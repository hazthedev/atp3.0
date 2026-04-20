<li x-data="{ open: true }" class="space-y-1">
    {{-- Section header --}}
    <div class="sidebar-link justify-between" style="padding-left: 0.75rem;">
        <button type="button"
                class="flex min-w-0 flex-1 items-center gap-3 text-left"
                @click="open = !open"
                title="{{ $item['label'] }}">
            <x-icon :name="$item['icon'] ?? 'star'" class="h-5 w-5 shrink-0" />
            <span x-cloak x-show="!sidebarCollapsed" class="truncate">{{ $item['label'] }}</span>
        </button>
        <button type="button"
                class="ml-2 shrink-0 rounded-md p-1 text-gray-400 transition hover:bg-white hover:text-gray-700"
                @click.stop="open = !open"
                x-cloak x-show="!sidebarCollapsed"
                aria-label="Toggle My Workspace">
            <x-icon name="chevron-down"
                    class="h-4 w-4 transition-transform duration-200"
                    x-bind:class="open ? 'rotate-180' : ''" />
        </button>
    </div>

    {{-- Item list --}}
    <ul x-cloak x-show="open && !sidebarCollapsed" x-collapse class="ml-4 space-y-1 border-l border-gray-200 pl-2">
        <template x-if="$store.workspace.items.length === 0">
            <li class="px-3 py-2 text-xs text-gray-400">No items added yet</li>
        </template>
        <template x-for="wsItem in $store.workspace.items" :key="wsItem.route">
            <li x-data="{ ctxOpen: false }" @click.outside="ctxOpen = false" class="relative">
                <a :href="wsItem.url"
                   @contextmenu.prevent="ctxOpen = !ctxOpen"
                   class="sidebar-link"
                   style="padding-left: 0.75rem;"
                   :title="wsItem.label">
                    <x-icon name="document" class="h-5 w-5 shrink-0" />
                    <span x-text="wsItem.label" class="truncate"></span>
                </a>
                <div x-cloak x-show="ctxOpen"
                     class="absolute left-full top-0 z-50 ml-1 min-w-44 rounded-lg border border-gray-200 bg-white py-1 text-sm shadow-lg">
                    <button type="button"
                            class="w-full px-3 py-1.5 text-left text-gray-700 hover:bg-gray-50"
                            @click="$store.workspace.remove(wsItem.route); ctxOpen = false">
                        Remove from My Workspace
                    </button>
                </div>
            </li>
        </template>
    </ul>
</li>
