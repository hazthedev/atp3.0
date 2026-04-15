@props([
    'tabs'      => [],   {{-- [['id' => '', 'label' => '', 'icon' => ''], ...] --}}
    'showIcons' => false,
])

<div {{ $attributes->class(['rounded-xl border border-gray-200']) }}>
    <div class="subtab-shell">
        <ul class="subtab-list">
            @foreach ($tabs as $tab)
                <li class="subtab-item">
                    <button
                        type="button"
                        class="subtab-link"
                        :class="activeTab === '{{ $tab['id'] }}' ? 'subtab-link-active' : 'subtab-link-inactive'"
                        @click="setTab('{{ $tab['id'] }}')"
                    >
                        @if ($showIcons && ! empty($tab['icon']))
                            <x-icon :name="$tab['icon']" class="h-4 w-4" />
                        @endif
                        {{ $tab['label'] }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
</div>
