@php
    $active = $isItemActive($item);
    $hasChildren = filled($item['children'] ?? []);
    $hasRoute = filled($item['route'] ?? null);
    $indent = 0.75 + ($level * 0.85);
    $linkClass = $active ? 'sidebar-link-active' : 'sidebar-link';
    $chevronButtonClass = 'ml-2 shrink-0 rounded-md p-1 text-gray-400 transition hover:bg-white hover:text-gray-700';
    $chevronIconClass = 'h-4 w-4 transition-transform duration-200';
@endphp

<li class="space-y-1" x-data="{ open: @js($active) }">
    @if ($hasChildren && $hasRoute)
        <div class="{{ $linkClass }} justify-between" style="padding-left: {{ $indent }}rem;">
            <a href="{{ route($item['route']) }}" class="flex min-w-0 flex-1 items-center gap-3" title="{{ $item['label'] }}" @click="open = true">
                <x-icon :name="$item['icon'] ?? 'document'" class="h-5 w-5 shrink-0" />
                <span x-cloak x-show="!sidebarCollapsed" class="truncate">{{ $item['label'] }}</span>
            </a>
            <button type="button" class="{{ $chevronButtonClass }}" @click.stop="open = !open" x-cloak x-show="!sidebarCollapsed" aria-label="Toggle section">
                <x-icon name="chevron-down" class="{{ $chevronIconClass }}" x-bind:class="open ? 'rotate-180' : ''" />
            </button>
        </div>
    @elseif ($hasChildren)
        <div class="{{ $linkClass }} justify-between" style="padding-left: {{ $indent }}rem;">
            <button type="button" class="flex min-w-0 flex-1 items-center gap-3 text-left" @click="open = !open" title="{{ $item['label'] }}">
                <x-icon :name="$item['icon'] ?? 'document'" class="h-5 w-5 shrink-0" />
                <span x-cloak x-show="!sidebarCollapsed" class="truncate">{{ $item['label'] }}</span>
            </button>
            <button type="button" class="{{ $chevronButtonClass }}" @click.stop="open = !open" x-cloak x-show="!sidebarCollapsed" aria-label="Toggle section">
                <x-icon name="chevron-down" class="{{ $chevronIconClass }}" x-bind:class="open ? 'rotate-180' : ''" />
            </button>
        </div>
    @else
        <div class="{{ $linkClass }} justify-between" style="padding-left: {{ $indent }}rem;">
            <a href="{{ route($item['route']) }}" class="flex min-w-0 flex-1 items-center gap-3" title="{{ $item['label'] }}">
                <x-icon :name="$item['icon'] ?? 'document'" class="h-5 w-5 shrink-0" />
                <span x-cloak x-show="!sidebarCollapsed" class="truncate">{{ $item['label'] }}</span>
            </a>
            <button type="button"
                    class="ml-2 shrink-0 rounded-md p-1 text-gray-300 transition hover:bg-white"
                    :class="$store.workspace.has('{{ $item['route'] }}') ? 'text-yellow-500' : 'text-gray-300 hover:text-yellow-500'"
                    x-cloak x-show="!sidebarCollapsed"
                    @click.prevent.stop="$store.workspace.toggle(@js([
                        'label' => $item['label'],
                        'route' => $item['route'],
                        'url'   => route($item['route']),
                    ]))"
                    :title="$store.workspace.has('{{ $item['route'] }}') ? 'Remove from My Workspace' : 'Pin to My Workspace'"
                    :aria-label="$store.workspace.has('{{ $item['route'] }}') ? 'Remove from My Workspace' : 'Pin to My Workspace'">
                <x-icon name="bookmark-outline" class="h-4 w-4" x-show="!$store.workspace.has('{{ $item['route'] }}')" />
                <x-icon name="bookmark" class="h-4 w-4" x-show="$store.workspace.has('{{ $item['route'] }}')" />
            </button>
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
