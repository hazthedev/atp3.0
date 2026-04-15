@extends('layouts.app')

@section('title', 'Work Orders Calendar')

@php
    $weeks = [
        ['label' => 'Apr 12, 26', 'days' => [7, 8, 9, 10, 11, 12, 13]],
        ['label' => 'Apr 19, 26', 'days' => [14, 15, 16, 17, 18, 19, 20]],
        ['label' => 'Apr 26, 26', 'days' => [21, 22, 23, 24, 25, 26, 27]],
        ['label' => 'May 3, 26', 'days' => [28, 29, 30, 1, 2, 3, 4]],
    ];

    $treeRows = [
        ['group' => '1 - Maintenance - Customer - 300028 - Weststar', 'items' => [
            ['code' => 'WO-06609', 'label' => 'Eng - Equipment - 10028 - 3...'],
            ['code' => 'WO-06610', 'label' => 'Eng - Equipment - 472 - 3G6...'],
            ['code' => 'WO-12194', 'label' => 'others - Customer - 300028 ...'],
            ['code' => 'WO-84835', 'label' => 'others - Customer - 300028 ...'],
        ]],
        ['group' => '100054 - Maintenance - Functional Location', 'items' => [
            ['code' => '100129', 'label' => 'Maintenance - Functional Location...'],
            ['code' => '100211', 'label' => 'Maintenance - Functional Location...'],
            ['code' => 'WO-86832', 'label' => 'Hard Time Component Limit - ...'],
        ]],
        ['group' => '100309 - Maintenance - Functional Location', 'items' => [
            ['code' => 'WO-86887', 'label' => 'others - Functional Location ...'],
            ['code' => '100516', 'label' => 'Maintenance - Functional Location...'],
            ['code' => '100635', 'label' => 'Maintenance - Functional Location...'],
        ]],
    ];

    $calendarBars = [
        ['row' => 1, 'column' => 1, 'span' => 2, 'label' => 'WO-06609'],
        ['row' => 2, 'column' => 2, 'span' => 1, 'label' => 'WO-06610'],
        ['row' => 5, 'column' => 3, 'span' => 1, 'label' => 'WO-86832'],
        ['row' => 8, 'column' => 4, 'span' => 1, 'label' => 'WO-86887'],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            expanded: false,
            statusMessage: '',
            bars: @js($calendarBars),
            toggleExpand() {
                this.expanded = !this.expanded;
                this.statusMessage = this.expanded ? 'Work order groups expanded.' : 'Work order groups collapsed.';
            },
            refreshCalendar() {
                this.statusMessage = 'Work orders calendar refreshed.';
            },
            closeCalendar() {
                this.statusMessage = 'Work orders calendar closed.';
            },
        }"
    >
        <x-page-header
            title="Work Orders Calendar"
            description="Review work-order timing across repair groups in the ATP MRO calendar workspace."
        />

        <section class="attach-workspace-shell max-w-[1560px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel class="space-y-5">
                <div class="grid gap-5 xl:grid-cols-[320px_minmax(0,1fr)]">
                    <div class="min-h-[540px] rounded-xl border border-gray-200 bg-gray-50/70 p-4">
                        <div class="text-sm font-semibold text-gray-900">Information</div>
                        <div class="space-y-3">
                            @foreach ($treeRows as $groupIndex => $group)
                                <div class="space-y-2" :class="{ 'opacity-90': expanded || {{ $groupIndex }} === 0 }">
                                    <div class="text-sm font-semibold text-gray-800">{{ $group['group'] }}</div>
                                    <div class="space-y-1.5 pl-4">
                                        @foreach ($group['items'] as $item)
                                            <div class="text-sm text-blue-700">{{ $item['code'] }} - {{ $item['label'] }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="min-h-[540px] rounded-xl border border-gray-200 bg-white p-4">
                        <div class="grid gap-3 md:grid-cols-4">
                            @foreach ($weeks as $week)
                                <div class="rounded-lg border border-gray-200 bg-gray-50">
                                    <div class="border-b border-gray-200 px-3 py-2 text-sm font-semibold text-gray-800">{{ $week['label'] }}</div>
                                    <div class="grid grid-cols-7 gap-0">
                                        @foreach ($week['days'] as $day)
                                            <div class="border-r border-gray-200 px-2 py-2 text-center text-xs text-gray-600 last:border-r-0">{{ $day }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 grid grid-cols-4 gap-2">
                            @for ($row = 0; $row < 12; $row++)
                                @for ($col = 0; $col < 4; $col++)
                                    <div class="rounded-md border border-dashed border-gray-200 bg-gray-50/50"></div>
                                @endfor
                            @endfor

                            <template x-for="bar in bars" :key="`${bar.row}-${bar.column}-${bar.label}`">
                                <div
                                    class="flex items-center rounded-md bg-blue-100 px-3 text-sm font-medium text-blue-800"
                                    :style="`grid-column: ${bar.column} / span ${bar.span}; grid-row: ${bar.row};`"
                                    x-text="bar.label"
                                ></div>
                            </template>
                        </div>
                    </div>
                </div>

                <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" class="btn-primary" @click="closeCalendar()">OK</button>
                        <button type="button" class="btn-secondary" @click="closeCalendar()">Cancel</button>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" class="btn-secondary" @click="toggleExpand()">Expand</button>
                        <button type="button" class="btn-secondary" @click="refreshCalendar()">Refresh</button>
                    </div>
                </x-enterprise.action-bar>
            </x-enterprise.panel>
        </section>
    </div>
@endsection
