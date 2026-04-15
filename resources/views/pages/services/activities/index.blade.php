@extends('layouts.app')

@section('title', 'My Activities')

@php
    $activities = [
        [
            'activity_number' => 'ACT-240418',
            'flag' => 'attention',
            'status' => 'Open',
            'start_date' => '2026-04-06',
            'due_date' => '2026-04-08',
            'bp_issue_level' => 'GREEN',
            'type' => 'Service Follow-up',
            'bp_code' => 'BP-001284',
            'bp_name' => 'Weststar Aviation Services',
            'created_by' => 'acap',
            'pilot' => 'Shahrul',
            'remaining_days' => '2',
            'is_open' => true,
        ],
        [
            'activity_number' => 'ACT-240409',
            'flag' => 'normal',
            'status' => 'In Progress',
            'start_date' => '2026-03-30',
            'due_date' => '2026-04-04',
            'bp_issue_level' => 'AMBER',
            'type' => 'Observation Review',
            'bp_code' => 'BP-001155',
            'bp_name' => 'Aero One Services',
            'created_by' => 'acap',
            'pilot' => 'Nadiah',
            'remaining_days' => '1',
            'is_open' => true,
        ],
        [
            'activity_number' => 'ACT-240331',
            'flag' => 'normal',
            'status' => 'Closed',
            'start_date' => '2026-03-18',
            'due_date' => '2026-03-21',
            'bp_issue_level' => 'GREEN',
            'type' => 'Contact Report Closure',
            'bp_code' => 'BP-000882',
            'bp_name' => 'Heli Support APAC',
            'created_by' => 'acap',
            'pilot' => 'Aina',
            'remaining_days' => '0',
            'is_open' => false,
        ],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            showOpenOnly: true,
            statusMessage: '',
            rows: @js($activities),
            filteredRows() {
                return this.showOpenOnly ? this.rows.filter((row) => row.is_open) : this.rows;
            },
            refreshRows() {
                this.statusMessage = `Loaded ${this.filteredRows().length} activity record(s).`;
            },
            cancelView() {
                this.statusMessage = 'Activity queue closed for this review session.';
            },
        }"
    >
        <x-page-header
            title="My Activities"
            description="Review the signed-in user's open service activities, due dates, and business-partner workload in the ATP enterprise queue."
        />

        <section class="attach-workspace-shell max-w-[1280px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <div class="flex flex-col gap-3 border-b border-gray-200 pb-4 md:flex-row md:items-center md:justify-between">
                <label class="attach-checkbox-inline">
                    <input type="checkbox" x-model="showOpenOnly" />
                    <span>Display Only Open</span>
                </label>

                <button type="button" class="btn-secondary" @click="refreshRows()">Refresh</button>
            </div>

            <x-enterprise.table-shell table-class="pending-base-table min-w-[1200px]" :datatable="false">
                <x-slot name="thead">
                    <tr>
                        <th>Activity Number</th>
                        <th>!</th>
                        <th>Status</th>
                        <th>Start date</th>
                        <th>Due date</th>
                        <th>BP Issue Level</th>
                        <th>Type</th>
                        <th>BP Code</th>
                        <th>BP Name</th>
                        <th>Created by</th>
                        <th>Pilot</th>
                        <th>Remaining days</th>
                    </tr>
                </x-slot>

                <x-slot name="tbody">
                    <template x-if="filteredRows().length === 0">
                        <tr>
                            <td colspan="12" class="px-4 py-8 text-center text-sm text-gray-500">No activities match the current filter.</td>
                        </tr>
                    </template>

                    <template x-for="row in filteredRows()" :key="row.activity_number">
                        <tr>
                            <td>
                                <a href="{{ route('services.activities.create') }}" class="font-semibold text-gray-900 transition hover:text-blue-700" x-text="row.activity_number"></a>
                            </td>
                            <td>
                                <span
                                    class="inline-flex h-2.5 w-2.5 rounded-full"
                                    :class="row.flag === 'attention' ? 'bg-amber-500' : 'bg-gray-400'"
                                ></span>
                            </td>
                            <td>
                                <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700" x-text="row.status"></span>
                            </td>
                            <td x-text="row.start_date"></td>
                            <td x-text="row.due_date"></td>
                            <td>
                                <span
                                    class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold"
                                    :class="{
                                        'bg-emerald-100 text-emerald-700': row.bp_issue_level === 'GREEN',
                                        'bg-amber-100 text-amber-700': row.bp_issue_level === 'AMBER',
                                        'bg-rose-100 text-rose-700': row.bp_issue_level === 'RED'
                                    }"
                                    x-text="row.bp_issue_level"
                                ></span>
                            </td>
                            <td x-text="row.type"></td>
                            <td x-text="row.bp_code"></td>
                            <td x-text="row.bp_name"></td>
                            <td x-text="row.created_by"></td>
                            <td x-text="row.pilot"></td>
                            <td x-text="row.remaining_days"></td>
                        </tr>
                    </template>
                </x-slot>
            </x-enterprise.table-shell>

            <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
                <button type="button" class="btn-secondary" @click="cancelView()">Cancel</button>

                <div class="flex items-center gap-3">
                    <span class="attach-field-label">Number of records found</span>
                    <span class="inline-flex min-w-[72px] justify-center rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-900" x-text="filteredRows().length"></span>
                </div>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
