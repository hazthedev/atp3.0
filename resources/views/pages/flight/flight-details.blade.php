@extends('layouts.app')

@section('title', 'Flight Details')

@php
    $flightRows = [
        ['flight_no' => 'WSA-231', 'date' => '2026-04-07', 'registration' => '9M-WCM', 'route' => 'KUL -> MYY', 'std' => '06:30', 'sta' => '08:10', 'status' => 'Scheduled', 'captain' => 'Capt. Rahman', 'purpose' => 'Crew Transfer'],
        ['flight_no' => 'WSA-412', 'date' => '2026-04-07', 'registration' => '9M-WST', 'route' => 'MYY -> BTU', 'std' => '09:20', 'sta' => '10:05', 'status' => 'Boarding', 'captain' => 'Capt. Salleh', 'purpose' => 'Customer Transfer'],
        ['flight_no' => 'WSA-518', 'date' => '2026-04-07', 'registration' => '9M-S92', 'route' => 'LBU -> OFS', 'std' => '12:15', 'sta' => '13:40', 'status' => 'Planning', 'captain' => 'Capt. Lim', 'purpose' => 'Standby Support'],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            openOnly: false,
            selectedBase: 'All Bases',
            rows: @js($flightRows),
            statusMessage: '',
            refresh() {
                this.statusMessage = `Flight details refreshed for ${this.selectedBase}.`;
            },
        }"
    >
        <x-page-header
            title="Flight Details"
            description="Review scheduled and active flight sectors, crew assignments, routing, and operational status."
        >
            <x-slot name="actions">
                <a href="{{ route('flight.daily-flight-log') }}" class="btn-primary">Daily Flight Log</a>
            </x-slot>
        </x-page-header>

        <section class="attach-workspace-shell max-w-[1360px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel muted class="space-y-5">
                <div class="flex flex-wrap items-center gap-4">
                    <label class="attach-checkbox-inline">
                        <input type="checkbox" x-model="openOnly" />
                        <span>Display active sectors only</span>
                    </label>

                    <x-enterprise.field-row label="Base" for="flight_details_base" columns="sm:grid-cols-[40px_180px]">
                        <select id="flight_details_base" x-model="selectedBase" class="input-field attach-input">
                            <option>All Bases</option>
                            <option>KUL</option>
                            <option>MYY</option>
                            <option>LBU</option>
                        </select>
                    </x-enterprise.field-row>

                    <button type="button" class="btn-secondary" @click="refresh()">Refresh</button>
                </div>
            </x-enterprise.panel>

            <x-enterprise.panel class="space-y-4">
                <div>
                    <div class="text-sm font-semibold text-gray-900">Flight sector list</div>
                    <p class="mt-1 text-sm text-gray-500">Dispatch-facing list of planned and active flights for the selected operating window.</p>
                </div>

                <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1120px]" datatable>
                    <x-slot name="thead">
                        <tr>
                            <th>Flight No.</th>
                            <th>Date</th>
                            <th>Aircraft</th>
                            <th>Route</th>
                            <th>STD</th>
                            <th>STA</th>
                            <th>Status</th>
                            <th>Captain</th>
                            <th>Purpose</th>
                        </tr>
                    </x-slot>

                    <x-slot name="tbody">
                        <template x-for="row in rows" :key="row.flight_no">
                            <tr>
                                <td x-text="row.flight_no"></td>
                                <td x-text="row.date"></td>
                                <td x-text="row.registration"></td>
                                <td x-text="row.route"></td>
                                <td x-text="row.std"></td>
                                <td x-text="row.sta"></td>
                                <td><span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700" x-text="row.status"></span></td>
                                <td x-text="row.captain"></td>
                                <td x-text="row.purpose"></td>
                            </tr>
                        </template>
                    </x-slot>
                </x-enterprise.table-shell>
            </x-enterprise.panel>
        </section>
    </div>
@endsection
