@php
    $stats = $stats ?? [
        ['label' => 'Open items', 'value' => '128', 'trend' => '+12% vs last week', 'icon' => 'chart-bar'],
        ['label' => 'Scheduled today', 'value' => '24', 'trend' => '4 pending confirmation', 'icon' => 'clock', 'trendColor' => 'text-amber-600'],
        ['label' => 'Completed', 'value' => '96', 'trend' => 'On target', 'icon' => 'check-circle'],
        ['label' => 'Attention needed', 'value' => '7', 'trend' => 'Escalate by end of day', 'icon' => 'exclamation-triangle', 'trendColor' => 'text-red-600'],
    ];

    $columns = $columns ?? ['Reference', 'Description', 'Owner', 'Status', 'Updated'];
    $rows = $rows ?? [
        ['CKP-001', 'Operational summary for the current period', 'Planning Team', '<span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">Healthy</span>', '10 minutes ago'],
        ['CKP-002', 'Scheduled activity awaiting sign-off', 'Execution', '<span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">Watch</span>', '1 hour ago'],
        ['CKP-003', 'Deferred item queued for review', 'Support', '<span class="inline-flex rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">Escalated</span>', 'Yesterday'],
    ];
@endphp

<div class="space-y-6">
    <x-page-header :title="$title" :description="$description" />

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <x-stat-card :label="$stat['label']" :value="$stat['value']" :trend="$stat['trend']" :icon="$stat['icon']" :trend-color="$stat['trendColor'] ?? 'text-emerald-600'" />
        @endforeach
    </div>

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

    <x-skeleton type="stat" />
</div>
