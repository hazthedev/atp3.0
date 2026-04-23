@php
    /**
     * Simple reference/lookup table renderer.
     *
     * Required:
     *   $title        string
     *   $description  string
     *   $columns      array<string>  (display headers)
     *   $rows         iterable<array<string|int>>
     * Optional:
     *   $countLabel   string         defaults to count($rows) . ' records'
     *   $emptyLabel   string
     *   $source       string         e.g. '@MRO_OSTA'
     */

    $countLabel = $countLabel ?? (count($rows) . ' records');
    $emptyLabel = $emptyLabel ?? 'No records';
@endphp

<div class="space-y-6">
    <x-page-header :title="$title" :description="$description">
        @if (! empty($source))
            <x-slot name="actions">
                <span class="inline-flex items-center gap-2 rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
                    <x-icon name="document" class="h-3.5 w-3.5" />
                    Source: {{ $source }}
                </span>
                <span class="inline-flex items-center gap-2 rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-700">{{ $countLabel }}</span>
            </x-slot>
        @endif
    </x-page-header>

    <x-data-table datatable>
        <x-slot name="search">
            <input type="text" class="input-field w-full md:w-72" placeholder="Search {{ strtolower($title) }}…" />
        </x-slot>

        <x-slot name="thead">
            <tr>
                @foreach ($columns as $column)
                    <th class="table-th">{{ $column }}</th>
                @endforeach
            </tr>
        </x-slot>

        <x-slot name="tbody">
            @forelse ($rows as $row)
                <tr class="table-row">
                    @foreach ($row as $cell)
                        <td class="table-td">{!! $cell !!}</td>
                    @endforeach
                </tr>
            @empty
                <tr><td colspan="{{ count($columns) }}" class="table-td text-center text-gray-400">{{ $emptyLabel }}</td></tr>
            @endforelse
        </x-slot>
    </x-data-table>
</div>
