@extends('layouts.app')

@section('title', 'My Observation')

@php
    $observations = [
        [
            'id' => 'OBS-240418',
            'flag' => 'attention',
            'created_on' => '2026-04-06',
            'priority' => 'High',
            'bp_code' => 'BP-001284',
            'bp_name' => 'Weststar Aviation Services',
            'variant' => 'AW139',
            'observation' => 'Customer requested earlier confirmation on pending component availability.',
            'issue_type' => 'Follow-up',
            'created_by' => 'acap',
            'status' => 'Open',
            'assignee' => 'Support Team',
            'remaining_days' => '2',
            'is_open' => true,
        ],
        [
            'id' => 'OBS-240409',
            'flag' => 'normal',
            'created_on' => '2026-03-30',
            'priority' => 'Medium',
            'bp_code' => 'BP-001155',
            'bp_name' => 'Aero One Services',
            'variant' => 'AW189',
            'observation' => 'Cabin speaker replacement to align with planned scheduled visit.',
            'issue_type' => 'Planned Work',
            'created_by' => 'acap',
            'status' => 'In Progress',
            'assignee' => 'Material Control',
            'remaining_days' => '5',
            'is_open' => true,
        ],
        [
            'id' => 'OBS-240331',
            'flag' => 'normal',
            'created_on' => '2026-03-18',
            'priority' => 'Low',
            'bp_code' => 'BP-000882',
            'bp_name' => 'Heli Support APAC',
            'variant' => 'AW139',
            'observation' => 'Review completed and customer notified after maintenance visit closure.',
            'issue_type' => 'Closure',
            'created_by' => 'acap',
            'status' => 'Closed',
            'assignee' => 'Customer Support',
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
            rows: @js($observations),
            filteredRows() {
                return this.showOpenOnly ? this.rows.filter((row) => row.is_open) : this.rows;
            },
            refreshRows() {
                this.statusMessage = `Loaded ${this.filteredRows().length} observation record(s).`;
            },
            cancelView() {
                this.statusMessage = 'Observation queue closed for this review session.';
            },
        }"
    >
        <x-page-header
            title="My Observation"
            description="Review the signed-in user's service observations and their follow-up workload in the ATP enterprise queue."
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

            <x-enterprise.table-shell table-class="pending-base-table min-w-[1480px]" :datatable="false">
                <x-slot name="thead">
                    <tr>
                        <th class="w-[120px]">Observation ID</th>
                        <th class="w-10">!</th>
                        <th class="w-[120px]">Created On</th>
                        <th class="w-[120px]">Priority</th>
                        <th class="w-[120px]">BP Code</th>
                        <th class="w-[180px]">BP Name</th>
                        <th class="w-[120px]">Variant</th>
                        <th class="w-[360px]">Observation</th>
                        <th class="w-[160px]">Issue Type</th>
                        <th class="w-[140px]">Created By</th>
                        <th class="w-[120px]">Status</th>
                        <th class="w-[160px]">Assignee</th>
                        <th class="w-[120px]">Remaining days</th>
                    </tr>
                </x-slot>

                <x-slot name="tbody">
                    <template x-if="filteredRows().length === 0">
                        <tr>
                            <td colspan="13" class="px-4 py-8 text-center text-sm text-gray-500">No observations match the current filter.</td>
                        </tr>
                    </template>

                    <template x-for="row in filteredRows()" :key="row.id">
                        <tr>
                            <td>
                                <a href="{{ route('services.observations.create') }}" class="font-semibold text-gray-900 transition hover:text-blue-700" x-text="row.id"></a>
                            </td>
                            <td>
                                <span
                                    class="inline-flex h-2.5 w-2.5 rounded-full"
                                    :class="row.flag === 'attention' ? 'bg-amber-500' : 'bg-gray-400'"
                                ></span>
                            </td>
                            <td x-text="row.created_on"></td>
                            <td>
                                <span
                                    class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold"
                                    :class="{
                                        'bg-rose-100 text-rose-700': row.priority === 'High',
                                        'bg-amber-100 text-amber-700': row.priority === 'Medium',
                                        'bg-blue-100 text-blue-700': row.priority === 'Low'
                                    }"
                                    x-text="row.priority"
                                ></span>
                            </td>
                            <td x-text="row.bp_code"></td>
                            <td x-text="row.bp_name"></td>
                            <td x-text="row.variant"></td>
                            <td class="max-w-[280px] whitespace-normal" x-text="row.observation"></td>
                            <td class="max-w-[180px] whitespace-normal" x-text="row.issue_type"></td>
                            <td class="max-w-[140px] whitespace-normal" x-text="row.created_by"></td>
                            <td>
                                <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700" x-text="row.status"></span>
                            </td>
                            <td x-text="row.assignee"></td>
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
