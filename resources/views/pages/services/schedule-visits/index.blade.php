@extends('layouts.app')

@section('title', 'My Scheduled Visits')

@php
    $scheduledVisits = [
        [
            'code' => 'SV-24041',
            'bp_code' => 'BP-001284',
            'bp_name' => 'Weststar Aviation Services',
            'bp_agent' => 'Aero One Services',
            'role' => 'Customer Support',
            'country' => 'Malaysia',
            'state' => 'Selangor',
            'address' => 'Subang Hangar 2',
            'scheduled_visit_date' => '2026-04-06',
            'status' => 'Planned',
            'reprogrammed_date' => '2026-04-09',
            'is_mine' => true,
        ],
        [
            'code' => 'SV-24032',
            'bp_code' => 'BP-001155',
            'bp_name' => 'Aero One Services',
            'bp_agent' => 'Aero One Services',
            'role' => 'Observation Review',
            'country' => 'Malaysia',
            'state' => 'Selangor',
            'address' => 'Shah Alam Office',
            'scheduled_visit_date' => '2026-03-30',
            'status' => 'Ready',
            'reprogrammed_date' => '2026-04-01',
            'is_mine' => true,
        ],
        [
            'code' => 'SV-24018',
            'bp_code' => 'BP-000882',
            'bp_name' => 'Heli Support APAC',
            'bp_agent' => 'Regional Support',
            'role' => 'Escalation Visit',
            'country' => 'Singapore',
            'state' => 'Central',
            'address' => 'Seletar Service Hub',
            'scheduled_visit_date' => '2026-03-18',
            'status' => 'Completed',
            'reprogrammed_date' => '-',
            'is_mine' => false,
        ],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            onlyMyVisits: true,
            statusMessage: '',
            rows: @js($scheduledVisits),
            filteredRows() {
                return this.onlyMyVisits ? this.rows.filter((row) => row.is_mine) : this.rows;
            },
            refreshRows() {
                this.statusMessage = `Loaded ${this.filteredRows().length} scheduled visit record(s).`;
            },
            cancelView() {
                this.statusMessage = 'Scheduled visits queue closed for this review session.';
            },
        }"
    >
        <x-page-header
            title="My Scheduled Visits"
            description="Review scheduled customer visits, ownership, and reprogrammed planning dates in the ATP enterprise queue."
        />

        <section class="attach-workspace-shell max-w-[1280px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <div class="flex flex-col gap-3 border-b border-gray-200 pb-4 md:flex-row md:items-center md:justify-between">
                <label class="attach-checkbox-inline">
                    <input type="checkbox" x-model="onlyMyVisits" />
                    <span>Only my visits</span>
                </label>

                <button type="button" class="btn-secondary" @click="refreshRows()">Refresh</button>
            </div>

            <x-enterprise.table-shell table-class="pending-base-table min-w-[1320px]" :datatable="false">
                <x-slot name="thead">
                    <tr>
                        <th>Code</th>
                        <th>BP Code</th>
                        <th>BP Name</th>
                        <th>BP Agent</th>
                        <th>Role</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>Address</th>
                        <th>Scheduled Visit Date</th>
                        <th>Status</th>
                        <th>Reprogrammed Date</th>
                    </tr>
                </x-slot>

                <x-slot name="tbody">
                    <template x-if="filteredRows().length === 0">
                        <tr>
                            <td colspan="11" class="px-4 py-8 text-center text-sm text-gray-500">No scheduled visits match the current filter.</td>
                        </tr>
                    </template>

                    <template x-for="row in filteredRows()" :key="row.code">
                        <tr>
                            <td>
                                <a href="{{ route('services.schedule-visits.create') }}" class="font-semibold text-gray-900 transition hover:text-blue-700" x-text="row.code"></a>
                            </td>
                            <td x-text="row.bp_code"></td>
                            <td x-text="row.bp_name"></td>
                            <td x-text="row.bp_agent"></td>
                            <td x-text="row.role"></td>
                            <td x-text="row.country"></td>
                            <td x-text="row.state"></td>
                            <td x-text="row.address"></td>
                            <td x-text="row.scheduled_visit_date"></td>
                            <td>
                                <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700" x-text="row.status"></span>
                            </td>
                            <td x-text="row.reprogrammed_date"></td>
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
