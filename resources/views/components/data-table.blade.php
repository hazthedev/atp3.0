@props([
    'empty' => false,
    'emptyLabel' => 'No records found',
    'emptyDescription' => 'Adjust the filters or add a new record to populate this table.',
    'searchMeta' => 'Preview data only. Filters are non-persistent in this frontend phase.',
    'tableClass' => 'pending-base-table',
    'datatable' => true,
    'datatablePerPage' => 10,
    'datatablePerPageSelect' => [5, 10, 25, 50],
    'datatableFixedHeight' => false,
    'datatableSelectable' => true,
    'datatableMultiSelect' => false,
    'datatableRowNavigation' => false,
    'minRows' => 0,
    'rowCount' => 0,
])

@php
    $searchSlot = isset($search) ? trim((string) $search) : '';
    $paginationSlot = isset($pagination) ? trim((string) $pagination) : '';
    $tbodySlot = isset($tbody) ? trim((string) $tbody) : '';
    $hasRows = ! $empty && $tbodySlot !== '';
    $useDatatable = $datatable && $hasRows;
@endphp

<div {{ $attributes->class(['overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm']) }}>
    @if ($searchSlot !== '' && ! $useDatatable)
        <div class="flex flex-col gap-3 border-b border-gray-200 bg-white px-4 py-4 md:flex-row md:items-center md:justify-between">
            <div class="max-w-md flex-1">
                {{ $search }}
            </div>
            @if ($searchMeta !== '')
                <div class="text-xs text-gray-500">{{ $searchMeta }}</div>
            @endif
        </div>
    @endif

    @if ($hasRows)
        <x-enterprise.table-shell
            :shell="false"
            :table-class="$tableClass"
            :datatable="$useDatatable"
            :datatable-per-page="$datatablePerPage"
            :datatable-per-page-select="$datatablePerPageSelect"
            :datatable-fixed-height="$datatableFixedHeight"
            :datatable-selectable="$datatableSelectable"
            :datatable-multi-select="$datatableMultiSelect"
            :datatable-row-navigation="$datatableRowNavigation"
            :min-rows="$minRows"
            :row-count="$rowCount"
        >
            <x-slot name="thead">
                {{ $thead }}
            </x-slot>

            <x-slot name="tbody">
                {{ $tbody }}
            </x-slot>
        </x-enterprise.table-shell>
    @else
        <div class="p-6">
            <x-empty-state :label="$emptyLabel" :description="$emptyDescription" />
        </div>
    @endif

    @if ($paginationSlot !== '' && ! $useDatatable)
        <div class="border-t border-gray-200 bg-white px-4 py-4">
            {{ $pagination }}
        </div>
    @endif
</div>
