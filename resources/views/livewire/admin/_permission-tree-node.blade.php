@php
    $level = $levels[$permission->id] ?? 'none';
    $levelLabels = [
        'full' => ['Full Auth', 'bg-emerald-50 text-emerald-700 border-emerald-200'],
        'read_only' => ['Read Only', 'bg-amber-50 text-amber-700 border-amber-200'],
        'none' => ['No Authorization', 'bg-gray-50 text-gray-500 border-gray-200'],
    ];
    [$levelLabel, $levelClass] = $levelLabels[$level] ?? $levelLabels['none'];
    $isSelected = ($selectedPermissionId ?? null) === $permission->id;
    $indent = ($depth ?? 0) * 1.25;
    $hasChildren = $permission->children->isNotEmpty();
@endphp

<li x-data="{ expanded: {{ ($depth ?? 0) === 0 ? 'true' : 'false' }} }" class="border-b border-gray-100 last:border-b-0">
    <div class="flex items-center gap-2 py-1.5 pr-3 text-sm transition hover:bg-blue-50 {{ $isSelected ? 'bg-blue-50' : '' }}"
         style="padding-left: {{ 0.75 + $indent }}rem;">
        @if ($hasChildren)
            <button type="button" @click="expanded = !expanded" class="flex h-5 w-5 shrink-0 items-center justify-center rounded text-gray-400 hover:text-gray-700">
                <x-icon name="chevron-down" class="h-3.5 w-3.5 transition-transform" x-bind:class="expanded ? '' : '-rotate-90'" />
            </button>
        @else
            <span class="h-5 w-5 shrink-0"></span>
        @endif

        <button type="button" wire:click="selectPermission({{ $permission->id }})" class="flex-1 text-left font-medium {{ $isSelected ? 'text-blue-700' : 'text-gray-800' }}">
            {{ $permission->name }}
        </button>

        <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-xs font-medium {{ $levelClass }}">
            {{ $levelLabel }}
        </span>
    </div>

    @if ($hasChildren)
        <ul x-show="expanded" x-collapse class="border-l border-gray-100" style="margin-left: {{ 0.75 + $indent + 0.3 }}rem;">
            @foreach ($permission->children as $child)
                @include('livewire.admin._permission-tree-node', [
                    'permission' => $child,
                    'depth' => ($depth ?? 0) + 1,
                    'levels' => $levels,
                    'selectedPermissionId' => $selectedPermissionId ?? null,
                ])
            @endforeach
        </ul>
    @endif
</li>
