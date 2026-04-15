@extends('layouts.app')

@section('title', 'Schedule Flight')

@section('content')
    <div
        class="space-y-6"
        x-data="{
            templateCode: 'TPL-014',
            flightNumber: 'WSA-231',
            status: 'Draft',
            recurrenceMode: 'daily',
            dateFrom: '2026-04-07',
            dateTo: '2026-04-14',
            weeklyDays: ['mon', 'wed', 'fri'],
            statusMessage: '',
            toggleDay(day) {
                if (this.weeklyDays.includes(day)) {
                    this.weeklyDays = this.weeklyDays.filter((item) => item !== day);
                    return;
                }
                this.weeklyDays = [...this.weeklyDays, day];
            },
            scheduleFlight() {
                this.statusMessage = `Recurring flight schedule prepared for ${this.flightNumber}.`;
            },
            cancelSchedule() {
                this.statusMessage = 'Schedule flight dialog cancelled.';
            },
            uploadTemplate() {
                this.statusMessage = 'Recurring schedule template upload opened.';
            },
            openScheduleDates() {
                this.statusMessage = 'Specific schedule dates helper opened.';
            },
        }"
    >
        <x-page-header
            title="Schedule Flight"
            description="Configure recurring flight scheduling rules from an existing template in the ATP flight scheduling workspace."
        />

        <section class="attach-workspace-shell max-w-[1120px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel class="space-y-5">
                <div class="grid gap-5 xl:grid-cols-[360px_260px]">
                    <x-enterprise.lookup-row label="Flight Schedule Template" for="schedule_flight_template" columns="sm:grid-cols-[160px_minmax(0,1fr)]">
                        <div class="attach-inline-control">
                            <input id="schedule_flight_template" type="text" x-model="templateCode" class="input-field attach-input" />
                            <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                        </div>
                    </x-enterprise.lookup-row>

                    <x-enterprise.field-row label="Status" for="schedule_flight_status" columns="sm:grid-cols-[56px_180px]">
                        <select id="schedule_flight_status" x-model="status" class="input-field attach-input">
                            <option>Draft</option>
                            <option>Ready</option>
                            <option>Released</option>
                        </select>
                    </x-enterprise.field-row>
                </div>

                <x-enterprise.field-row label="Flight Number" for="schedule_flight_number" columns="sm:grid-cols-[160px_160px]">
                    <input id="schedule_flight_number" type="text" x-model="flightNumber" class="input-field attach-input input-field-filled" />
                </x-enterprise.field-row>
            </x-enterprise.panel>

            <x-enterprise.panel class="space-y-5">
                <div class="text-sm font-semibold text-gray-900">Recurring Information</div>

                <div class="grid max-w-[460px] grid-cols-[36px_172px_20px_172px] items-center gap-[10px]">
                    <span class="attach-field-label">From</span>
                    <x-date-picker id="schedule_flight_from" x-model="dateFrom" />
                    <span class="attach-field-label">To</span>
                    <x-date-picker id="schedule_flight_to" x-model="dateTo" />
                </div>

                <div class="space-y-5">
                    <label class="attach-checkbox-inline">
                        <input type="radio" name="schedule_flight_mode" value="daily" x-model="recurrenceMode" />
                        <span>Daily</span>
                    </label>

                    <div class="grid items-center gap-4 xl:grid-cols-[120px_repeat(7,minmax(0,1fr))]">
                        <label class="attach-checkbox-inline">
                            <input type="radio" name="schedule_flight_mode" value="weekly" x-model="recurrenceMode" />
                            <span>Weekly</span>
                        </label>

                        @foreach ([
                            'mon' => 'Monday',
                            'tue' => 'Tuesday',
                            'wed' => 'Wednesday',
                            'thu' => 'Thursday',
                            'fri' => 'Friday',
                            'sat' => 'Saturday',
                            'sun' => 'Sunday',
                        ] as $key => $label)
                            <label class="attach-checkbox-inline">
                                <input type="checkbox" :checked="weeklyDays.includes('{{ $key }}')" @change="toggleDay('{{ $key }}')" />
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <label class="attach-checkbox-inline">
                            <input type="radio" name="schedule_flight_mode" value="custom" x-model="recurrenceMode" />
                            <span>Custom</span>
                        </label>

                        <button type="button" class="btn-secondary" @click="uploadTemplate()">Upload template</button>
                        <button type="button" class="btn-secondary" @click="openScheduleDates()">Schedule Dates</button>
                    </div>
                </div>
            </x-enterprise.panel>

            <x-enterprise.action-bar class="border-t border-gray-200 pt-5">
                <button type="button" class="btn-primary" @click="scheduleFlight()">OK</button>
                <button type="button" class="btn-secondary" @click="cancelSchedule()">Cancel</button>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
