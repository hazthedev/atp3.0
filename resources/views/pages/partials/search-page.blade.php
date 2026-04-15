@php
    $filters = $filters ?? [
        ['component' => 'input', 'label' => 'Keyword', 'name' => 'keyword', 'placeholder' => 'Search keyword'],
        ['component' => 'input', 'label' => 'Reference', 'name' => 'reference', 'placeholder' => 'Reference number'],
        ['component' => 'select', 'label' => 'Status', 'name' => 'status', 'options' => ['open' => 'Open', 'closed' => 'Closed', 'planned' => 'Planned']],
        ['component' => 'input', 'type' => 'date', 'label' => 'Updated Since', 'name' => 'updated_since'],
    ];

    $columns = $columns ?? ['Reference', 'Result', 'Owner', 'Status', 'Updated'];
    $rows = $rows ?? [
        ['SRH-101', 'Matched preview record for ' . $title, 'Planning Team', '<span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">Indexed</span>', 'Today'],
        ['SRH-102', 'Historical match for comparison', 'Operations', '<span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700">Archived</span>', 'Yesterday'],
    ];
@endphp

<div class="space-y-6" x-data="{ filtersOpen: true }">
    <x-page-header :title="$title" :description="$description" />

    <x-card title="Search filters" description="Use the collapsible panel below to preview the filtering experience.">
        <button type="button" class="flex w-full items-center justify-between rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-left transition hover:bg-gray-100" @click="filtersOpen = !filtersOpen">
            <span class="font-medium text-gray-900">Toggle filters</span>
            <x-icon name="chevron-down" class="h-4 w-4 transition-transform duration-200" x-bind:class="filtersOpen ? 'rotate-180' : ''" />
        </button>

        <div x-cloak x-show="filtersOpen" x-collapse class="mt-4 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($filters as $filter)
                @switch($filter['component'])
                    @case('select')
                        <x-form.select :label="$filter['label']" :name="$filter['name']" :options="$filter['options']" />
                        @break
                    @default
                        <x-form.input :label="$filter['label']" :name="$filter['name']" :type="$filter['type'] ?? 'text'" :placeholder="$filter['placeholder'] ?? null" />
                @endswitch
            @endforeach
        </div>

        <div class="mt-4 flex flex-wrap justify-end gap-3">
            <button type="button" class="btn-secondary">Reset</button>
            <button type="button" class="btn-primary">Search</button>
        </div>
    </x-card>

    <x-data-table datatable>
        <x-slot name="thead">
            <tr>
                @foreach ($columns as $column)
                    <th class="table-th">{{ $column }}</th>
                @endforeach
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach ($rows as $row)
                <tr class="table-row">
                    @foreach ($row as $cell)
                        <td class="table-td">{!! $cell !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>
