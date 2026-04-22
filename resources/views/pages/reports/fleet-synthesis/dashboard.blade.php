@extends('layouts.app')

@section('title', 'Fleet Synthesis — Dashboard')

@php
    // Schedules Details sub-columns — driven by CAM-FS-0090 admin setting.
    // Order and visibility are dummy-configured here.
    $taskTypeCols = ['AD/SB', 'EOAS', 'OOP', 'Kardex', 'Others', 'Checks'];
    $includeTechLogs = true; // MEL/CFD

    // One row per A/C. Each metric is [alarm, quantity, total].
    // alarm ∈ red | orange | green
    $rows = [
        [
            'type' => null, 'sn' => null, 'reg' => 'All', 'synthesis' => true,
            'all'     => ['red', 5, 371],
            'AD/SB'   => ['red', 2, 56],
            'EOAS'    => ['orange', 4, 34],
            'OOP'     => ['red', 2, 42],
            'Kardex'  => ['orange', 7, 174],
            'Others'  => ['red', 1, 16],
            'Checks'  => ['orange', 6, 38],
            'MEL/CFD' => ['red', 1, 11],
        ],
        [
            'type' => 'AW139', 'sn' => '31336', 'reg' => '9M-WAD',
            'all'     => ['red', 4, 69],
            'AD/SB'   => ['red', 1, 12],
            'EOAS'    => ['orange', 2, 8],
            'OOP'     => ['red', 2, 9],
            'Kardex'  => ['green', 30, 30],
            'Others'  => ['red', 1, 4],
            'Checks'  => ['orange', 1, 6],
            'MEL/CFD' => [null, null, null],
        ],
        [
            'type' => 'AW139', 'sn' => '31344', 'reg' => '9M-WAH',
            'all'     => ['orange', 6, 71],
            'AD/SB'   => ['green', 12, 12],
            'EOAS'    => ['green', 8, 8],
            'OOP'     => ['orange', 3, 9],
            'Kardex'  => ['orange', 2, 29],
            'Others'  => ['green', 5, 5],
            'Checks'  => ['orange', 1, 6],
            'MEL/CFD' => ['green', 2, 2],
        ],
        [
            'type' => 'AW139', 'sn' => '41249', 'reg' => '9M-WBB',
            'all'     => ['red', 1, 81],
            'AD/SB'   => ['red', 1, 12],
            'EOAS'    => ['orange', 1, 9],
            'OOP'     => ['orange', 2, 13],
            'Kardex'  => ['orange', 4, 35],
            'Others'  => ['orange', 3, 5],
            'Checks'  => ['orange', 3, 6],
            'MEL/CFD' => ['green', 1, 1],
        ],
        [
            'type' => 'AW189', 'sn' => '49030', 'reg' => '9M-WSU',
            'all'     => ['green', 76, 76],
            'AD/SB'   => ['green', 10, 10],
            'EOAS'    => ['green', 5, 5],
            'OOP'     => ['green', 5, 5],
            'Kardex'  => ['green', 40, 40],
            'Others'  => ['orange', 2, 2],
            'Checks'  => ['green', 10, 10],
            'MEL/CFD' => ['green', 4, 4],
        ],
        [
            'type' => 'AW189', 'sn' => '49051', 'reg' => '9M-WSV',
            'all'     => ['orange', 6, 74],
            'AD/SB'   => ['orange', 1, 10],
            'EOAS'    => ['orange', 1, 4],
            'OOP'     => ['orange', 1, 6],
            'Kardex'  => ['orange', 1, 40],
            'Others'  => [null, null, null],
            'Checks'  => ['orange', 1, 10],
            'MEL/CFD' => ['orange', 1, 4],
        ],
    ];

    $alarmClasses = [
        'red'    => 'bg-red-600 text-white',
        'orange' => 'bg-amber-500 text-white',
        'green'  => 'bg-emerald-500 text-white',
    ];
@endphp

@section('content')
    <div class="space-y-6" x-data="{ refreshing: false, refresh() { this.refreshing = true; setTimeout(() => this.refreshing = false, 900); } }">
        <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
            <div class="space-y-2">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-blue-600">Fleet Synthesis</p>
                <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
                <p class="max-w-3xl text-sm text-gray-500">Click any <em>Quantity</em> or <em>Total</em> cell to drill into the Fleet Synthesis – Details screen for that scope.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('reports.fleet-synthesis') }}" class="btn-ghost">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                    Back
                </a>
                <button type="button" class="btn-secondary" @click="refresh()" :disabled="refreshing">
                    <svg x-show="refreshing" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" stroke-opacity=".25"/><path d="M4 12a8 8 0 018-8"/></svg>
                    <x-icon name="arrow-path" x-show="!refreshing" class="h-4 w-4" /> Refresh
                </button>
            </div>
        </div>

        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-0 text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500">
                            <th class="sticky left-0 z-10 bg-slate-50 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">A/C Type</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">A/C SN</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">A/C Registration</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider" colspan="2">All Schedules</th>
                            <th class="border-l border-gray-200 px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider"
                                colspan="{{ (count($taskTypeCols) + ($includeTechLogs ? 1 : 0)) * 2 }}">
                                Schedules Details
                            </th>
                        </tr>
                        <tr class="bg-slate-50 text-slate-500">
                            <th class="sticky left-0 z-10 bg-slate-50 px-4 py-2"></th>
                            <th class="px-4 py-2"></th>
                            <th class="px-4 py-2"></th>
                            <th class="px-2 py-2 text-center text-[11px] font-medium uppercase">Qty</th>
                            <th class="px-2 py-2 text-center text-[11px] font-medium uppercase">Total</th>
                            @foreach ($taskTypeCols as $col)
                                <th class="border-l border-gray-200 px-2 py-2 text-center text-[11px] font-medium uppercase">Qty</th>
                                <th class="px-2 py-2 text-center text-[11px] font-medium uppercase">Total</th>
                            @endforeach
                            @if ($includeTechLogs)
                                <th class="border-l border-gray-200 px-2 py-2 text-center text-[11px] font-medium uppercase">Qty</th>
                                <th class="px-2 py-2 text-center text-[11px] font-medium uppercase">Total</th>
                            @endif
                        </tr>
                        <tr class="bg-blue-600 text-white">
                            <th class="sticky left-0 z-10 bg-blue-600 px-4 py-2 text-left text-[11px] font-semibold uppercase tracking-wider"></th>
                            <th class="px-4 py-2"></th>
                            <th class="px-4 py-2"></th>
                            <th class="px-2 py-2"></th>
                            <th class="px-2 py-2"></th>
                            @foreach ($taskTypeCols as $col)
                                <th class="border-l border-blue-500 px-2 py-2 text-center text-[11px] font-semibold uppercase tracking-wider" colspan="2">{{ $col }}</th>
                            @endforeach
                            @if ($includeTechLogs)
                                <th class="border-l border-blue-500 px-2 py-2 text-center text-[11px] font-semibold uppercase tracking-wider" colspan="2">MEL/CFD</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $row)
                            @php
                                $allCols = array_merge(['all'], $taskTypeCols);
                                if ($includeTechLogs) {
                                    $allCols[] = 'MEL/CFD';
                                }
                                $isSynthesis = ! empty($row['synthesis']);
                            @endphp
                            <tr class="border-b border-gray-100 {{ $isSynthesis ? 'bg-slate-50 font-semibold' : 'hover:bg-blue-50/40' }}">
                                <td class="sticky left-0 z-[1] px-4 py-4 {{ $isSynthesis ? 'bg-slate-50' : 'bg-white' }}">{{ $row['type'] ?? '' }}</td>
                                <td class="px-4 py-4">{{ $row['sn'] ?? '' }}</td>
                                <td class="px-4 py-4">
                                    @if ($isSynthesis)
                                        <span class="text-slate-700">{{ $row['reg'] }}</span>
                                    @else
                                        <a href="{{ route('reports.fleet-synthesis.details') }}?ac={{ $row['reg'] }}" class="font-medium text-blue-600 hover:underline">{{ $row['reg'] }}</a>
                                    @endif
                                </td>

                                @foreach ($allCols as $col)
                                    @php [$alarm, $qty, $total] = $row[$col]; @endphp
                                    <td class="{{ $col === 'all' || $col === $taskTypeCols[0] || $col === 'MEL/CFD' ? 'border-l border-gray-200' : '' }} px-2 py-3 text-center">
                                        @if ($alarm)
                                            <a href="{{ route('reports.fleet-synthesis.details') }}?ac={{ $row['reg'] }}&col={{ urlencode($col) }}&alarm={{ $alarm }}"
                                               class="inline-flex h-9 w-10 items-center justify-center rounded-md text-sm font-bold shadow-sm transition hover:scale-105 {{ $alarmClasses[$alarm] }}">
                                                {{ $qty }}
                                            </a>
                                        @endif
                                    </td>
                                    <td class="px-2 py-3 text-center text-slate-600">
                                        @if ($total !== null)
                                            <a href="{{ route('reports.fleet-synthesis.details') }}?ac={{ $row['reg'] }}&col={{ urlencode($col) }}" class="hover:text-blue-600 hover:underline">
                                                {{ $total }}
                                            </a>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <footer class="flex flex-wrap items-center justify-between gap-3 border-t border-gray-100 px-6 py-3 text-xs text-gray-500">
                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center gap-1.5"><span class="h-3 w-3 rounded bg-red-600"></span> Red &mdash; overdue</span>
                    <span class="inline-flex items-center gap-1.5"><span class="h-3 w-3 rounded bg-amber-500"></span> Orange &mdash; within alarm window</span>
                    <span class="inline-flex items-center gap-1.5"><span class="h-3 w-3 rounded bg-emerald-500"></span> Green &mdash; healthy</span>
                </div>
                <span class="text-gray-400">Dummy data · CAM-FS-0100</span>
            </footer>
        </section>
    </div>
@endsection
