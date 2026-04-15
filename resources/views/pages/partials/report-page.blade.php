@php
    $highlights = $highlights ?? [
        ['label' => 'Coverage', 'value' => '98%', 'trend' => 'Stable against last cycle'],
        ['label' => 'Exceptions', 'value' => '5', 'trend' => 'Two require follow-up'],
        ['label' => 'Published', 'value' => '14:30', 'trend' => 'Latest preview refresh'],
    ];

    $columns = $columns ?? ['Section', 'Summary', 'Owner', 'Updated'];
    $rows = $rows ?? [
        ['Executive Summary', 'Key operational highlights for the reporting window.', 'Reporting Office', 'Today'],
        ['Fleet Focus', 'Static placeholder metrics for the presentation layer.', 'Engineering', 'Today'],
        ['Risks', 'Items tracked for backend validation in the next phase.', 'Program Lead', 'Yesterday'],
    ];
@endphp

<div class="space-y-6">
    <x-page-header :title="$title" :description="$description" />

    <div class="grid gap-6 md:grid-cols-3">
        @foreach ($highlights as $highlight)
            <x-stat-card :label="$highlight['label']" :value="$highlight['value']" :trend="$highlight['trend']" icon="document" />
        @endforeach
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.4fr_1fr]">
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
                            <td class="table-td">{{ $cell }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </x-slot>
        </x-data-table>

        <x-card title="Report notes" description="Use this surface for analyst commentary, export hints, or caveats.">
            <div class="space-y-4 text-sm leading-6 text-gray-600">
                <p>This frontend-only page mirrors the final report experience with static data blocks, ready for live metrics in the backend phase.</p>
                <p>The surrounding UI intentionally leaves room for charts, downloads, and drill-down filters once the reporting APIs are connected.</p>
            </div>
        </x-card>
    </div>
</div>
