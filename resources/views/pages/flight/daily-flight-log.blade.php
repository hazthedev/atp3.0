@extends('layouts.app')

@section('title', 'Daily Flight Log')

@php
    $flightInformation = [
        ['label' => 'Flight No.', 'value' => 'WSA-231'],
        ['label' => 'Sector', 'value' => 'KUL -> MYY'],
        ['label' => 'STD / ATD', 'value' => '06:30 / 06:37'],
        ['label' => 'STA / ATA', 'value' => '08:10 / 08:02'],
        ['label' => 'Purpose', 'value' => 'Crew Transfer'],
    ];

    $flightCrew = [
        ['role' => 'Captain', 'name' => 'Rahman Aziz'],
        ['role' => 'Co-Pilot', 'name' => 'Shahrul Karim'],
        ['role' => 'Crew', 'name' => 'Ops Support Team'],
    ];

    $afterFlightCounters = [
        ['counter' => 'Flight Hours', 'value' => '2,846:15'],
        ['counter' => 'Flight Cycles', 'value' => '1,894'],
        ['counter' => 'Engine 1 Hours', 'value' => '4,521:08'],
        ['counter' => 'Engine 2 Hours', 'value' => '4,488:54'],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            code: 'DFL-240407',
            projectName: 'PRJ-88014',
            techLogIds: 'TL-10492, TL-10495',
            acHoursBefore: '2,844:55',
            acHoursDaily: '01:20',
            acHoursAfter: '2,846:15',
            acCycleBefore: '1,893',
            acCycleDaily: '1',
            acCycleAfter: '1,894',
            date: '2026-04-07',
            ftrNumber: 'FTR-00231',
            flCode: 'FL-9M-WCM',
            serialNumber: '31324',
            registration: '9M-WCM',
            type: 'AW139',
            technicalLogsOpen: '1',
            technicalLogsClosed: '4',
            technicalLogsDeferred: '1',
            taskListsSelected: '2',
            taskListsOpen: '5',
            taskListsClosed: '12',
            statusMessage: '',
            flightInformation: @js($flightInformation),
            flightCrew: @js($flightCrew),
            afterFlightCounters: @js($afterFlightCounters),
            findLog() {
                this.statusMessage = `Daily flight log ${this.code} loaded successfully.`;
            },
            cancelLog() {
                this.statusMessage = 'Daily flight log review cancelled.';
            },
            openTechnicalLogs() {
                this.statusMessage = 'Technical logs workspace opened from daily flight log.';
            },
            openTaskLists() {
                this.statusMessage = 'Task list workspace opened from daily flight log.';
            },
            openCounterPenalties() {
                this.statusMessage = 'Counter penalties dialog opened.';
            },
            openTechnicalLogDetail() {
                this.statusMessage = 'Technical log detail opened for the selected flight.';
            },
        }"
    >
        <x-page-header
            title="Daily Flight Log"
            description="Review aircraft daily totals, technical logs, task lists, flight information, crew, and after-flight counters in the ATP flight workspace."
        />

        <section class="attach-workspace-shell max-w-[1400px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel class="space-y-5">
                <div class="grid gap-5 xl:grid-cols-[240px_minmax(0,1fr)_320px_280px]">
                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Code" for="daily_flight_log_code" columns="sm:grid-cols-[88px_160px]">
                            <input id="daily_flight_log_code" type="text" x-model="code" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.lookup-row label="Project Name" for="daily_flight_log_project" columns="sm:grid-cols-[88px_minmax(0,1fr)]">
                            <div class="attach-inline-control">
                                <input id="daily_flight_log_project" type="text" x-model="projectName" class="input-field attach-input" />
                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>
                        </x-enterprise.lookup-row>
                    </div>

                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="List of TechLog Ids" for="daily_flight_log_ids" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                            <input id="daily_flight_log_ids" type="text" x-model="techLogIds" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>
                    </div>

                    <div class="space-y-2.5">
                        <div class="grid grid-cols-[72px_1fr_1fr_1fr] items-center gap-x-[10px] gap-y-2">
                            <span></span>
                            <span class="attach-field-label">Before</span>
                            <span class="attach-field-label">Daily Total</span>
                            <span class="attach-field-label">After</span>

                            <span class="attach-field-label">A/C hours</span>
                            <input type="text" class="input-field attach-input input-field-filled" x-model="acHoursBefore" />
                            <input type="text" class="input-field attach-input input-field-filled" x-model="acHoursDaily" />
                            <input type="text" class="input-field attach-input input-field-filled" x-model="acHoursAfter" />

                            <span class="attach-field-label">A/C cycle</span>
                            <input type="text" class="input-field attach-input input-field-filled" x-model="acCycleBefore" />
                            <input type="text" class="input-field attach-input input-field-filled" x-model="acCycleDaily" />
                            <input type="text" class="input-field attach-input input-field-filled" x-model="acCycleAfter" />
                        </div>
                    </div>

                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Date" for="daily_flight_log_date" columns="sm:grid-cols-[56px_172px]">
                            <x-date-picker id="daily_flight_log_date" x-model="date" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="FTR Number" for="daily_flight_log_ftr" columns="sm:grid-cols-[88px_172px]">
                            <input id="daily_flight_log_ftr" type="text" x-model="ftrNumber" class="input-field attach-input" />
                        </x-enterprise.field-row>
                    </div>
                </div>

                <div class="grid gap-5 xl:grid-cols-[280px_280px_280px]">
                    <x-enterprise.panel muted class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Aircraft</div>
                        <x-enterprise.lookup-row label="FL Code" for="daily_flight_log_fl_code" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                            <div class="attach-inline-control">
                                <input id="daily_flight_log_fl_code" type="text" x-model="flCode" class="input-field attach-input" />
                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>
                        </x-enterprise.lookup-row>
                        <x-enterprise.field-row label="Serial Number" for="daily_flight_log_serial_number" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                            <input id="daily_flight_log_serial_number" type="text" x-model="serialNumber" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Registration" for="daily_flight_log_registration" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                            <input id="daily_flight_log_registration" type="text" x-model="registration" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Type" for="daily_flight_log_type" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                            <input id="daily_flight_log_type" type="text" x-model="type" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>
                    </x-enterprise.panel>

                    <x-enterprise.panel muted class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Technical Logs #</div>
                        <x-enterprise.field-row label="Open" for="daily_flight_log_tech_open" columns="sm:grid-cols-[72px_160px]">
                            <input id="daily_flight_log_tech_open" type="text" x-model="technicalLogsOpen" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Closed" for="daily_flight_log_tech_closed" columns="sm:grid-cols-[72px_160px]">
                            <input id="daily_flight_log_tech_closed" type="text" x-model="technicalLogsClosed" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Deferred" for="daily_flight_log_tech_deferred" columns="sm:grid-cols-[72px_160px]">
                            <input id="daily_flight_log_tech_deferred" type="text" x-model="technicalLogsDeferred" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>
                        <button type="button" class="btn-secondary" @click="openTechnicalLogs()">Technical Logs</button>
                    </x-enterprise.panel>

                    <x-enterprise.panel muted class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Task List #</div>
                        <x-enterprise.field-row label="Selected" for="daily_flight_log_task_selected" columns="sm:grid-cols-[72px_160px]">
                            <input id="daily_flight_log_task_selected" type="text" x-model="taskListsSelected" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Open" for="daily_flight_log_task_open" columns="sm:grid-cols-[72px_160px]">
                            <input id="daily_flight_log_task_open" type="text" x-model="taskListsOpen" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Closed" for="daily_flight_log_task_closed" columns="sm:grid-cols-[72px_160px]">
                            <input id="daily_flight_log_task_closed" type="text" x-model="taskListsClosed" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>
                        <button type="button" class="btn-secondary" @click="openTaskLists()">Task Lists</button>
                    </x-enterprise.panel>
                </div>

                <x-enterprise.panel muted class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">Flight Information</div>
                    <div class="min-h-[180px] rounded-xl border border-gray-200 bg-white p-4">
                        <template x-for="row in flightInformation" :key="row.label">
                            <div class="flex items-center justify-between gap-4 border-b border-gray-100 py-3 text-sm last:border-b-0">
                                <span class="font-medium text-gray-700" x-text="row.label"></span>
                                <span class="text-gray-900" x-text="row.value"></span>
                            </div>
                        </template>
                    </div>
                </x-enterprise.panel>

                <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
                    <x-enterprise.panel muted class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Flight Crew</div>
                        <div class="min-h-[180px] rounded-xl border border-gray-200 bg-white p-4">
                            <template x-for="row in flightCrew" :key="row.role">
                                <div class="flex items-center justify-between gap-4 border-b border-gray-100 py-3 text-sm last:border-b-0">
                                    <span class="font-medium text-gray-700" x-text="row.role"></span>
                                    <span class="text-gray-900" x-text="row.name"></span>
                                </div>
                            </template>
                        </div>
                    </x-enterprise.panel>

                    <x-enterprise.panel muted class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">After flight counter values</div>
                        <div class="min-h-[180px] rounded-xl border border-gray-200 bg-white p-4">
                            <template x-for="row in afterFlightCounters" :key="row.counter">
                                <div class="flex items-center justify-between gap-4 border-b border-gray-100 py-3 text-sm last:border-b-0">
                                    <span class="font-medium text-gray-700" x-text="row.counter"></span>
                                    <span class="text-gray-900" x-text="row.value"></span>
                                </div>
                            </template>
                        </div>
                    </x-enterprise.panel>
                </div>
            </x-enterprise.panel>

            <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="btn-primary" @click="findLog()">Find</button>
                    <button type="button" class="btn-secondary" @click="cancelLog()">Cancel</button>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <span class="attach-field-label">Counter Penalties</span>
                    <button type="button" class="btn-secondary" @click="openCounterPenalties()">...</button>
                    <button type="button" class="btn-secondary" @click="openTechnicalLogDetail()">Technical Log</button>
                </div>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
