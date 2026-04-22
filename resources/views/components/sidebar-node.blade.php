@php
    $active = $isItemActive($item);
    $hasChildren = filled($item['children'] ?? []);
    $hasRoute = filled($item['route'] ?? null);
    $indent = 0.75 + ($level * 0.85);
    $linkClass = $active ? 'sidebar-link-active' : 'sidebar-link';
    $chevronButtonClass = 'ml-2 shrink-0 rounded-md p-1 text-gray-400 transition hover:bg-white hover:text-gray-700';
    $chevronIconClass = 'h-4 w-4 transition-transform duration-200';
    $isL1 = $level === 0;
    // L1 click: collapse other L1s (accordion), then expand this subtree.
    $l1Expression = $isL1 && $hasChildren
        ? "const self = \$el.closest('li'); document.querySelectorAll('[data-sidebar-l1]').forEach(el => { if (el !== self) el.dispatchEvent(new CustomEvent('sidebar-collapse')); }); if (open) { self.querySelectorAll('[data-sidebar-node]').forEach(n => n.dispatchEvent(new CustomEvent('sidebar-expand'))); }"
        : '';
@endphp

<li class="space-y-1"
    x-data="{ open: @js($active) }"
    data-sidebar-node
    @if ($isL1) data-sidebar-l1 @sidebar-collapse.stop="open = false" @endif
    @sidebar-expand="open = true">
    @if ($hasChildren && $hasRoute)
        <div class="{{ $linkClass }} justify-between" style="padding-left: {{ $indent }}rem;">
            <a href="{{ route($item['route']) }}" class="flex min-w-0 flex-1 items-center gap-3" title="{{ $item['label'] }}" @click="open = true; {{ $l1Expression }}">
                <x-icon :name="$item['icon'] ?? 'document'" class="h-5 w-5 shrink-0" />
                <span x-cloak x-show="!sidebarCollapsed" class="truncate">{{ $item['label'] }}</span>
            </a>
            <button type="button" class="{{ $chevronButtonClass }}" @click.stop="open = !open; {{ $l1Expression }}" x-cloak x-show="!sidebarCollapsed" aria-label="Toggle section">
                <x-icon name="chevron-down" class="{{ $chevronIconClass }}" x-bind:class="open ? 'rotate-180' : ''" />
            </button>
        </div>
    @elseif ($hasChildren)
        <div class="{{ $linkClass }} justify-between" style="padding-left: {{ $indent }}rem;">
            <button type="button" class="flex min-w-0 flex-1 items-center gap-3 text-left" @click="open = !open; {{ $l1Expression }}" title="{{ $item['label'] }}">
                <x-icon :name="$item['icon'] ?? 'document'" class="h-5 w-5 shrink-0" />
                <span x-cloak x-show="!sidebarCollapsed" class="truncate">{{ $item['label'] }}</span>
            </button>
            <button type="button" class="{{ $chevronButtonClass }}" @click.stop="open = !open; {{ $l1Expression }}" x-cloak x-show="!sidebarCollapsed" aria-label="Toggle section">
                <x-icon name="chevron-down" class="{{ $chevronIconClass }}" x-bind:class="open ? 'rotate-180' : ''" />
            </button>
        </div>
    @else
        <div x-data="{ ctxOpen: false }" @click.outside="ctxOpen = false" class="relative">
            <a href="{{ route($item['route']) }}"
               class="{{ $linkClass }}"
               style="padding-left: {{ $indent }}rem;"
               title="{{ $item['label'] }}"
               @contextmenu.prevent="ctxOpen = !ctxOpen">
                <x-icon :name="$item['icon'] ?? 'document'" class="h-5 w-5 shrink-0" />
                <span x-cloak x-show="!sidebarCollapsed" class="truncate">{{ $item['label'] }}</span>
            </a>
            <div x-cloak x-show="ctxOpen"
                 class="absolute left-full top-0 z-50 ml-1 min-w-44 rounded-lg border border-gray-200 bg-white py-1 text-sm shadow-lg">
                <template x-if="!$store.workspace.has('{{ $item['route'] }}')">
                    <button type="button"
                            class="w-full px-3 py-1.5 text-left text-gray-700 hover:bg-gray-50"
                            @click="$store.workspace.add(@js(['label' => $item['label'], 'route' => $item['route'], 'icon' => $item['icon'] ?? '', 'url' => route($item['route'])])); ctxOpen = false">
                        Add to My Workspace
                    </button>
                </template>
                <template x-if="$store.workspace.has('{{ $item['route'] }}')">
                    <button type="button"
                            class="w-full px-3 py-1.5 text-left text-gray-700 hover:bg-gray-50"
                            @click="$store.workspace.remove('{{ $item['route'] }}'); ctxOpen = false">
                        Remove from My Workspace
                    </button>
                </template>
            </div>
        </div>
    @endif

    @if ($hasChildren)
        <ul x-cloak x-show="open && !sidebarCollapsed" x-collapse class="ml-4 space-y-1 border-l border-gray-200 pl-2">
            @foreach ($item['children'] as $child)
                @include('components.sidebar-node', [
                    'item' => $child,
                    'level' => $level + 1,
                    'isItemActive' => $isItemActive,
                ])
            @endforeach
        </ul>
    @endif
</li>
