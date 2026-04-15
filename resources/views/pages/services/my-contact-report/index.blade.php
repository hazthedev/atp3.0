@extends('layouts.app')

@section('title', 'My Contact Reports')

@php
    $contactReports = [
        [
            'number' => 'CR-2026-0418',
            'issue_level' => 'GREEN',
            'bp_code' => 'BP-001284',
            'bp_name' => 'Weststar Aviation Services',
            'origin' => 'Scheduled Visit',
            'visit_date' => '2026-04-06',
            'status' => 'Draft',
            'created_by' => 'acap',
            'is_open' => true,
        ],
        [
            'number' => 'CR-2026-0409',
            'issue_level' => 'AMBER',
            'bp_code' => 'BP-001155',
            'bp_name' => 'Aero One Services',
            'origin' => 'Customer Call',
            'visit_date' => '2026-03-30',
            'status' => 'Ready for review',
            'created_by' => 'acap',
            'is_open' => true,
        ],
        [
            'number' => 'CR-2026-0331',
            'issue_level' => 'GREEN',
            'bp_code' => 'BP-000882',
            'bp_name' => 'Heli Support APAC',
            'origin' => 'Observation Follow-up',
            'visit_date' => '2026-03-18',
            'status' => 'Closed',
            'created_by' => 'acap',
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
            rows: @js($contactReports),
            filteredRows() {
                return this.showOpenOnly ? this.rows.filter((row) => row.is_open) : this.rows;
            },
            refreshRows() {
                this.statusMessage = `Loaded ${this.filteredRows().length} contact report record(s).`;
            },
            cancelView() {
                this.statusMessage = 'My Contact Reports list closed for this review session.';
            },
        }"
    >
        <x-page-header
            title="My Contact Reports"
            description="Review the contact reports authored by the signed-in user using the ATP enterprise list workspace."
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

            <x-enterprise.table-shell table-class="pending-base-table min-w-full" :datatable="false">
                <x-slot name="thead">
                    <tr>
                        <th>Contact Report Number</th>
                        <th>BP Issue Level</th>
                        <th>BP Code</th>
                        <th>BP Name</th>
                        <th>Origin</th>
                        <th>Date of Visit</th>
                        <th>Status</th>
                        <th>Created by</th>
                    </tr>
                </x-slot>

                <x-slot name="tbody">
                    <template x-if="filteredRows().length === 0">
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-sm text-gray-500">No contact reports match the current filter.</td>
                        </tr>
                    </template>

                    <template x-for="row in filteredRows()" :key="row.number">
                        <tr>
                            <td>
                                <a href="{{ route('services.contact-report.create') }}" class="font-semibold text-gray-900 transition hover:text-blue-700" x-text="row.number"></a>
                            </td>
                            <td>
                                <span
                                    class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold"
                                    :class="{
                                        'bg-emerald-100 text-emerald-700': row.issue_level === 'GREEN',
                                        'bg-amber-100 text-amber-700': row.issue_level === 'AMBER',
                                        'bg-rose-100 text-rose-700': row.issue_level === 'RED'
                                    }"
                                    x-text="row.issue_level"
                                ></span>
                            </td>
                            <td x-text="row.bp_code"></td>
                            <td x-text="row.bp_name"></td>
                            <td x-text="row.origin"></td>
                            <td x-text="row.visit_date"></td>
                            <td>
                                <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700" x-text="row.status"></span>
                            </td>
                            <td x-text="row.created_by"></td>
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
