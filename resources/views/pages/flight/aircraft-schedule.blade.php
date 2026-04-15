@extends('layouts.app')

@section('title', 'Aircraft Schedule')

@php
    $scheduleDays = [
        ['label' => 'Tue', 'date' => '2026-04-07'],
        ['label' => 'Wed', 'date' => '2026-04-08'],
        ['label' => 'Thu', 'date' => '2026-04-09'],
        ['label' => 'Fri', 'date' => '2026-04-10'],
        ['label' => 'Sat', 'date' => '2026-04-11'],
        ['label' => 'Sun', 'date' => '2026-04-12'],
        ['label' => 'Mon', 'date' => '2026-04-13'],
        ['label' => 'Tue', 'date' => '2026-04-14'],
        ['label' => 'Wed', 'date' => '2026-04-15'],
        ['label' => 'Thu', 'date' => '2026-04-16'],
    ];

    $tailNumbers = [
        ['tail' => '9M-WCM'],
        ['tail' => '9M-WST'],
        ['tail' => '9M-S92'],
        ['tail' => '9M-WAL'],
    ];

    $scheduleEntries = [
        [
            'id' => 'WSA-231',
            'tail' => '9M-WCM',
            'tail_index' => 1,
            'start' => 1,
            'span' => 2,
            'status' => 'scheduled',
            'label' => 'WSA-231 KUL -> MYY',
            'scheduled_date' => '2026-04-07',
            'scheduled_time' => '06:30',
            'start_date' => '2026-04-07',
            'start_time' => '06:22',
            'detail' => 'Crew transfer sector from Kuala Lumpur to Miri. Aircraft remains allocated for the afternoon return window.',
        ],
        [
            'id' => 'WSA-412',
            'tail' => '9M-WST',
            'tail_index' => 2,
            'start' => 3,
            'span' => 2,
            'status' => 'arrived',
            'label' => 'WSA-412 MYY -> BTU',
            'scheduled_date' => '2026-04-09',
            'scheduled_time' => '09:20',
            'start_date' => '2026-04-09',
            'start_time' => '09:05',
            'detail' => 'Customer transfer sector completed successfully and aircraft is available for the next assigned leg.',
        ],
        [
            'id' => 'WSA-518',
            'tail' => '9M-S92',
            'tail_index' => 3,
            'start' => 5,
            'span' => 2,
            'status' => 'delayed',
            'label' => 'WSA-518 LBU -> OFS',
            'scheduled_date' => '2026-04-11',
            'scheduled_time' => '12:15',
            'start_date' => '2026-04-11',
            'start_time' => '13:05',
            'detail' => 'Offshore support leg delayed pending crew-duty confirmation and weather clearance at Labuan.',
        ],
        [
            'id' => 'ALT-044',
            'tail' => '9M-WAL',
            'tail_index' => 4,
            'start' => 7,
            'span' => 1,
            'status' => 'alert',
            'label' => 'Standby Alert',
            'scheduled_date' => '2026-04-13',
            'scheduled_time' => '15:00',
            'start_date' => '2026-04-13',
            'start_time' => '15:00',
            'detail' => 'Aircraft placed on operational alert due to customer standby request and pending dispatch confirmation.',
        ],
    ];

    $alertLog = [
        ['flight_number' => 'WSA-231', 'status' => 'Scheduled', 'scheduled_date' => '2026-04-07', 'scheduled_time' => '06:30', 'start_date' => '2026-04-07', 'start_time' => '06:22'],
        ['flight_number' => 'WSA-412', 'status' => 'Arrived', 'scheduled_date' => '2026-04-09', 'scheduled_time' => '09:20', 'start_date' => '2026-04-09', 'start_time' => '09:05'],
        ['flight_number' => 'WSA-518', 'status' => 'Delayed', 'scheduled_date' => '2026-04-11', 'scheduled_time' => '12:15', 'start_date' => '2026-04-11', 'start_time' => '13:05'],
        ['flight_number' => 'ALT-044', 'status' => 'Alert', 'scheduled_date' => '2026-04-13', 'scheduled_time' => '15:00', 'start_date' => '2026-04-13', 'start_time' => '15:00'],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            filterCategory: 'All aircraft',
            dateFrom: '2026-04-07',
            dateTo: '2026-04-14',
            dayTitle: 'April 12, 2026',
            statusMessage: '',
            days: @js($scheduleDays),
            tails: @js($tailNumbers),
            entries: @js($scheduleEntries),
            alertLog: @js($alertLog),
            selectedFlight: @js($scheduleEntries[0]),
            entryClass(status) {
                return {
                    scheduled: 'border border-blue-200 bg-blue-100 text-blue-900',
                    arrived: 'border border-emerald-200 bg-emerald-100 text-emerald-900',
                    delayed: 'border border-amber-200 bg-amber-100 text-amber-900',
                    alert: 'border border-red-200 bg-red-100 text-red-900',
                }[status] || 'border border-blue-200 bg-blue-100 text-blue-900';
            },
            selectFlight(entry) {
                this.selectedFlight = entry;
                this.statusMessage = `${entry.id} selected from the aircraft schedule.`;
            },
            runSearch() {
                this.statusMessage = `Aircraft schedule refreshed from ${this.dateFrom} to ${this.dateTo} for ${this.filterCategory}.`;
            },
        }"
    >
        <x-page-header
            title="Aircraft Schedule"
            description="Review aircraft utilization, sector timing, alert logs, and selected-flight details in the ATP flight scheduling workspace."
        />

        <section class="attach-workspace-shell max-w-[1440px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel class="space-y-5">
                <div class="text-sm font-semibold text-gray-900">Aircraft Schedule Information</div>

                <div class="grid gap-4 xl:grid-cols-[320px_minmax(0,1fr)_120px_180px]">
                    <x-enterprise.field-row label="Filter by Category" for="flight_aircraft_category" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                        <select id="flight_aircraft_category" x-model="filterCategory" class="input-field attach-input">
                            <option>All aircraft</option>
                            <option>AW139</option>
                            <option>AW189</option>
                            <option>S92</option>
                        </select>
                    </x-enterprise.field-row>

                    <div class="grid grid-cols-[36px_172px_20px_172px] items-center gap-[10px]">
                        <span class="attach-field-label">From</span>
                        <x-date-picker id="flight_aircraft_date_from" x-model="dateFrom" />
                        <span class="attach-field-label">To</span>
                        <x-date-picker id="flight_aircraft_date_to" x-model="dateTo" />
                    </div>

                    <button type="button" class="btn-primary" @click="runSearch()">Search</button>
                    <a href="{{ route('flight.flight-record.create') }}" class="btn-secondary">Create New Flight</a>
                </div>

                <div class="space-y-3 overflow-hidden rounded-xl border border-gray-200 bg-white p-4">
                    <div class="text-sm font-semibold text-gray-700" x-text="dayTitle"></div>

                    <div class="grid grid-cols-[160px_minmax(0,1fr)] grid-rows-[40px_auto] gap-0">
                        <div class="flex items-center border border-gray-200 bg-gray-50 px-4 text-xs font-semibold uppercase tracking-[0.12em] text-gray-600">Tail Number</div>

                        <div class="grid min-w-[1100px] grid-cols-[repeat(10,minmax(110px,1fr))]">
                            <template x-for="day in days" :key="day.date">
                                <div class="flex min-h-[40px] items-center justify-center border-y border-r border-gray-200 bg-gray-50 px-2 text-xs font-semibold uppercase tracking-[0.12em] text-gray-600" x-text="day.label"></div>
                            </template>
                        </div>

                        <div class="grid grid-rows-[repeat(4,72px)]">
                            <template x-for="tail in tails" :key="tail.tail">
                                <div class="flex items-center border-x border-b border-gray-200 bg-gray-50 px-4 text-sm font-semibold text-gray-700" x-text="tail.tail"></div>
                            </template>
                        </div>

                        <div class="relative overflow-x-auto border-r border-b border-gray-200 bg-white">
                            <div class="relative z-0 grid min-w-[1100px] grid-cols-[repeat(10,minmax(110px,1fr))] grid-rows-[repeat(4,72px)]">
                                <template x-for="tail in tails" :key="`row-${tail.tail}`">
                                    <template x-for="day in days" :key="`${tail.tail}-${day.date}`">
                                        <div class="border-r border-b border-gray-100 bg-white"></div>
                                    </template>
                                </template>
                            </div>

                            <div class="absolute inset-0 z-10 p-2">
                                <template x-for="entry in entries" :key="entry.id">
                                    <button
                                        type="button"
                                        class="m-1 flex flex-col items-start justify-center rounded-xl px-3 py-2 text-left shadow-sm transition hover:shadow-md"
                                        :class="entryClass(entry.status)"
                                        :style="`grid-column: ${entry.start} / span ${entry.span}; grid-row: ${entry.tail_index};`"
                                        @click="selectFlight(entry)"
                                    >
                                        <span class="text-xs font-semibold uppercase tracking-[0.12em]" x-text="entry.id"></span>
                                        <span class="text-sm font-medium" x-text="entry.label"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_240px]">
                    <x-enterprise.panel muted class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Alert Log</div>

                        <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[760px]" datatable>
                            <x-slot name="thead">
                                <tr>
                                    <th>Flight Number</th>
                                    <th>Status</th>
                                    <th>Scheduled Date</th>
                                    <th>Scheduled Time</th>
                                    <th>Start Date</th>
                                    <th>Start Time</th>
                                </tr>
                            </x-slot>

                            <x-slot name="tbody">
                                <template x-for="row in alertLog" :key="`${row.flight_number}-${row.status}`">
                                    <tr>
                                        <td x-text="row.flight_number"></td>
                                        <td x-text="row.status"></td>
                                        <td x-text="row.scheduled_date"></td>
                                        <td x-text="row.scheduled_time"></td>
                                        <td x-text="row.start_date"></td>
                                        <td x-text="row.start_time"></td>
                                    </tr>
                                </template>
                            </x-slot>
                        </x-enterprise.table-shell>
                    </x-enterprise.panel>

                    <x-enterprise.panel muted class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Legend</div>

                        <div class="space-y-3">
                            <div class="flex items-center gap-3 text-sm text-gray-700">
                                <span class="inline-flex h-3.5 w-3.5 rounded-full border border-blue-500 bg-blue-500"></span>
                                <span>Scheduled flight</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-700">
                                <span class="inline-flex h-3.5 w-3.5 rounded-full border border-emerald-500 bg-emerald-500"></span>
                                <span>Arrived flight</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-700">
                                <span class="inline-flex h-3.5 w-3.5 rounded-full border border-amber-500 bg-amber-400"></span>
                                <span>Delayed flight</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-700">
                                <span class="inline-flex h-3.5 w-3.5 rounded-full border border-red-500 bg-red-500"></span>
                                <span>Alert</span>
                            </div>
                        </div>
                    </x-enterprise.panel>
                </div>

                <x-enterprise.panel muted class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">Selected Flight : Information Detail</div>

                    <div class="rounded-xl border border-gray-200 bg-white p-4">
                        <div class="mb-3 flex items-start justify-between gap-3">
                            <div>
                                <div class="font-semibold text-gray-900" x-text="selectedFlight.id"></div>
                                <div class="text-sm text-gray-500" x-text="`${selectedFlight.tail} • ${selectedFlight.scheduled_date} ${selectedFlight.scheduled_time}`"></div>
                            </div>
                            <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700" x-text="selectedFlight.status"></span>
                        </div>

                        <div class="text-sm text-gray-700" x-text="selectedFlight.detail"></div>
                    </div>
                </x-enterprise.panel>
            </x-enterprise.panel>

            <x-enterprise.action-bar class="border-t border-gray-200 pt-5">
                <button type="button" class="btn-primary">OK</button>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
