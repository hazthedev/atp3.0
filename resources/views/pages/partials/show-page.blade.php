@php
    $tabs = $tabs ?? [
        [
            'id' => 'overview',
            'label' => 'Overview',
            'items' => [
                ['label' => 'Reference', 'value' => 'Preview reference'],
                ['label' => 'Status', 'value' => 'Active'],
                ['label' => 'Owner', 'value' => 'Planning Team'],
                ['label' => 'Last Updated', 'value' => 'Today'],
            ],
        ],
        [
            'id' => 'details',
            'label' => 'Details',
            'items' => [
                ['label' => 'Description', 'value' => 'Detailed static placeholder content for the frontend rewrite.'],
                ['label' => 'Dependencies', 'value' => 'None in frontend phase'],
                ['label' => 'Source', 'value' => 'Legacy ATP reference module'],
            ],
        ],
        [
            'id' => 'history',
            'label' => 'History',
            'items' => [
                ['label' => 'Created', 'value' => '03 Mar 2026'],
                ['label' => 'Reviewed', 'value' => '26 Mar 2026'],
                ['label' => 'Next Step', 'value' => 'Backend integration'],
            ],
        ],
    ];
@endphp

<div class="space-y-6" x-data="tabs('{{ $tabs[0]['id'] }}')">
    <x-page-header :title="$title" :description="$description" />

    <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white p-2 shadow-sm">
        <div class="inline-flex min-w-full gap-2">
            @foreach ($tabs as $tab)
                <button
                    type="button"
                    class="rounded-lg px-4 py-2 text-sm font-medium transition"
                    :class="activeTab === '{{ $tab['id'] }}' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'"
                    @click="setTab('{{ $tab['id'] }}')"
                >
                    {{ $tab['label'] }}
                </button>
            @endforeach
        </div>
    </div>

    @foreach ($tabs as $tab)
        <div x-cloak x-show="activeTab === '{{ $tab['id'] }}'" class="grid gap-6 lg:grid-cols-2">
            @foreach ($tab['items'] as $item)
                <x-card :title="$item['label']">
                    <p class="text-sm leading-6 text-gray-600">{{ $item['value'] }}</p>
                </x-card>
            @endforeach
        </div>
    @endforeach
</div>
