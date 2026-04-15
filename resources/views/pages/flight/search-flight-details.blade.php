@extends('layouts.app')

@php
    $resultRows = [
        ['code' => '0000000', 'flight_no' => 'E3458AF', 'status' => 'Arrived', 'cs' => false, 'ls' => false, 'fs' => false, 'ftr' => 'WAW-034057', 'fl_code' => '9M-WAW', 'fl_type' => 'AW139', 'sn' => '41348', 'registration' => '9M-WAW', 'departure' => 'WBKK', 'scheduled_date' => '15.06.17', 'scheduled_time' => '09:14', 'starting_date' => '15.06.17', 'starting_time' => '09:14', 'takeoff_date' => '15.06.17', 'takeoff_time' => '09:14', 'arrival' => 'KBB1', 'landing_date' => '15.06.17', 'landing_time' => '09:41', 'shutdown_date' => '15.06.17', 'shutdown_time' => '09:41', 'project' => '300008', 'customer_code' => '300008', 'customer' => 'HIBISCUS OI Revenue', 'flight_category' => 'Commercial', 'flight_rules' => 'VFR'],
        ['code' => '0000001', 'flight_no' => 'E3459C5', 'status' => 'Arrived', 'cs' => false, 'ls' => false, 'fs' => false, 'ftr' => 'WAW-034057', 'fl_code' => '9M-WAW', 'fl_type' => 'AW139', 'sn' => '41348', 'registration' => '9M-WAW', 'departure' => 'KBB1', 'scheduled_date' => '15.06.17', 'scheduled_time' => '09:52', 'starting_date' => '15.06.17', 'starting_time' => '09:52', 'takeoff_date' => '15.06.17', 'takeoff_time' => '09:52', 'arrival' => 'WBKK', 'landing_date' => '15.06.17', 'landing_time' => '10:20', 'shutdown_date' => '15.06.17', 'shutdown_time' => '10:20', 'project' => '300008', 'customer_code' => '300008', 'customer' => 'HIBISCUS OI Revenue', 'flight_category' => 'Commercial', 'flight_rules' => 'VFR'],
        ['code' => '0000002', 'flight_no' => 'E35FAB1', 'status' => 'Arrived', 'cs' => false, 'ls' => false, 'fs' => false, 'ftr' => 'WAW-034057', 'fl_code' => '9M-WAW', 'fl_type' => 'AW139', 'sn' => '41348', 'registration' => '9M-WAW', 'departure' => 'KBB1', 'scheduled_date' => '15.06.17', 'scheduled_time' => '12:10', 'starting_date' => '15.06.17', 'starting_time' => '12:10', 'takeoff_date' => '15.06.17', 'takeoff_time' => '12:10', 'arrival' => 'KBB1', 'landing_date' => '15.06.17', 'landing_time' => '12:38', 'shutdown_date' => '15.06.17', 'shutdown_time' => '12:38', 'project' => '300008', 'customer_code' => '300008', 'customer' => 'HIBISCUS OI Revenue', 'flight_category' => 'Commercial', 'flight_rules' => 'VFR'],
        ['code' => '0000003', 'flight_no' => 'E35BFB6', 'status' => 'Arrived', 'cs' => false, 'ls' => false, 'fs' => false, 'ftr' => 'WAW-034057', 'fl_code' => '9M-WAW', 'fl_type' => 'AW139', 'sn' => '41348', 'registration' => '9M-WAW', 'departure' => 'WBKK', 'scheduled_date' => '15.06.17', 'scheduled_time' => '12:48', 'starting_date' => '15.06.17', 'starting_time' => '12:48', 'takeoff_date' => '15.06.17', 'takeoff_time' => '12:48', 'arrival' => 'KBB1', 'landing_date' => '15.06.17', 'landing_time' => '13:13', 'shutdown_date' => '15.06.17', 'shutdown_time' => '13:13', 'project' => '300008', 'customer_code' => '300008', 'customer' => 'HIBISCUS OI Revenue', 'flight_category' => 'Commercial', 'flight_rules' => 'VFR'],
        ['code' => '0000004', 'flight_no' => 'E43BEEE', 'status' => 'Arrived', 'cs' => false, 'ls' => false, 'fs' => false, 'ftr' => 'WAW-034061', 'fl_code' => '9M-WAW', 'fl_type' => 'AW139', 'sn' => '41348', 'registration' => '9M-WAW', 'departure' => 'WBKK', 'scheduled_date' => '20.06.17', 'scheduled_time' => '14:51', 'starting_date' => '20.06.17', 'starting_time' => '14:51', 'takeoff_date' => '20.06.17', 'takeoff_time' => '14:51', 'arrival' => 'KBB1', 'landing_date' => '20.06.17', 'landing_time' => '15:18', 'shutdown_date' => '20.06.17', 'shutdown_time' => '15:18', 'project' => '300008', 'customer_code' => '300008', 'customer' => 'HIBISCUS OI Revenue', 'flight_category' => 'Commercial', 'flight_rules' => 'IFR'],
        ['code' => '0000005', 'flight_no' => 'E43BFF8', 'status' => 'Arrived', 'cs' => false, 'ls' => false, 'fs' => false, 'ftr' => 'WAW-034061', 'fl_code' => '9M-WAW', 'fl_type' => 'AW139', 'sn' => '41348', 'registration' => '9M-WAW', 'departure' => 'WBKK', 'scheduled_date' => '20.06.17', 'scheduled_time' => '15:27', 'starting_date' => '20.06.17', 'starting_time' => '15:27', 'takeoff_date' => '20.06.17', 'takeoff_time' => '15:27', 'arrival' => 'KBB1', 'landing_date' => '20.06.17', 'landing_time' => '15:54', 'shutdown_date' => '20.06.17', 'shutdown_time' => '15:54', 'project' => '300008', 'customer_code' => '300008', 'customer' => 'HIBISCUS OI Revenue', 'flight_category' => 'Technical', 'flight_rules' => 'IFR'],
    ];

    $leftToggles = [
        ['label' => 'FTR Number', 'model' => 'ftrEnabled'],
        ['label' => 'Functional Location', 'model' => 'functionalLocationEnabled'],
        ['label' => 'Crew Employee', 'model' => 'crewEmployeeEnabled'],
        ['label' => 'Departure Location', 'model' => 'departureLocationEnabled'],
        ['label' => 'Arrival Location', 'model' => 'arrivalLocationEnabled'],
    ];

    $middleToggles = [
        ['label' => 'Customer', 'model' => 'customerEnabled'],
        ['label' => 'Project', 'model' => 'projectEnabled'],
    ];

    $rightToggles = [
        ['label' => 'Status', 'model' => 'statusEnabled'],
        ['label' => 'Flight Rule', 'model' => 'flightRuleEnabled'],
        ['label' => 'Flight Category', 'model' => 'flightCategoryEnabled'],
        ['label' => 'Load Type', 'model' => 'loadTypeEnabled'],
    ];

    $departureRanges = [
        ['label' => 'Scheduled Date', 'dateFrom' => 'departureScheduledFromDate', 'timeFrom' => 'departureScheduledFromTime', 'dateTo' => 'departureScheduledToDate', 'timeTo' => 'departureScheduledToTime', 'id' => 'search_departure_scheduled'],
        ['label' => 'Starting Date', 'dateFrom' => 'departureStartingFromDate', 'timeFrom' => 'departureStartingFromTime', 'dateTo' => 'departureStartingToDate', 'timeTo' => 'departureStartingToTime', 'id' => 'search_departure_starting'],
        ['label' => 'Take Off Date', 'dateFrom' => 'departureTakeoffFromDate', 'timeFrom' => 'departureTakeoffFromTime', 'dateTo' => 'departureTakeoffToDate', 'timeTo' => 'departureTakeoffToTime', 'id' => 'search_departure_takeoff'],
    ];

    $arrivalRanges = [
        ['label' => 'Scheduled Date', 'dateFrom' => 'arrivalScheduledFromDate', 'timeFrom' => 'arrivalScheduledFromTime', 'dateTo' => 'arrivalScheduledToDate', 'timeTo' => 'arrivalScheduledToTime', 'id' => 'search_arrival_scheduled'],
        ['label' => 'Landing Date', 'dateFrom' => 'arrivalLandingFromDate', 'timeFrom' => 'arrivalLandingFromTime', 'dateTo' => 'arrivalLandingToDate', 'timeTo' => 'arrivalLandingToTime', 'id' => 'search_arrival_landing'],
        ['label' => 'Shutdown Date', 'dateFrom' => 'arrivalShutdownFromDate', 'timeFrom' => 'arrivalShutdownFromTime', 'dateTo' => 'arrivalShutdownToDate', 'timeTo' => 'arrivalShutdownToTime', 'id' => 'search_arrival_shutdown'],
    ];
@endphp

@section('title', 'Search Flight Details')

@section('content')
    <div
        class="space-y-6"
        x-data="{
            activeTab: 'flight-details',
            resultView: 'core',
            statusMessage: '',
            maxRecords: 150,
            flightCode: '',
            flightNumber: '',
            plannedPax: '',
            paxAboard: '',
            observations: '',
            pilotObservations: '',
            customerEnabled: false,
            projectEnabled: false,
            statusEnabled: false,
            flightRuleEnabled: false,
            flightCategoryEnabled: false,
            ftrEnabled: false,
            functionalLocationEnabled: false,
            crewEmployeeEnabled: false,
            loadTypeEnabled: false,
            departureLocationEnabled: false,
            arrivalLocationEnabled: false,
            departureScheduledFromDate: '',
            departureScheduledFromTime: '',
            departureScheduledToDate: '',
            departureScheduledToTime: '',
            departureStartingFromDate: '',
            departureStartingFromTime: '',
            departureStartingToDate: '',
            departureStartingToTime: '',
            departureTakeoffFromDate: '',
            departureTakeoffFromTime: '',
            departureTakeoffToDate: '',
            departureTakeoffToTime: '',
            arrivalScheduledFromDate: '',
            arrivalScheduledFromTime: '',
            arrivalScheduledToDate: '',
            arrivalScheduledToTime: '',
            arrivalLandingFromDate: '',
            arrivalLandingFromTime: '',
            arrivalLandingToDate: '',
            arrivalLandingToTime: '',
            arrivalShutdownFromDate: '',
            arrivalShutdownFromTime: '',
            arrivalShutdownToDate: '',
            arrivalShutdownToTime: '',
            results: @js($resultRows),
            searchFlights() {
                this.activeTab = 'result';
                this.statusMessage = `Loaded ${this.results.length} flight detail record(s).`;
                this.$nextTick(() => window.refreshFlowbiteTables?.());
            },
            resetSearch() {
                this.activeTab = 'flight-details';
                this.resultView = 'core';
                this.statusMessage = 'Flight detail search filters reset to the default configuration.';
            },
            chooseResult() {
                this.statusMessage = 'Selected flight detail record from the current result set.';
            },
            refreshResultTables() {
                this.$nextTick(() => window.refreshFlowbiteTables?.());
            },
        }"
    >
        <x-page-header
            title="Search Flight Details"
            description="Search flight records by flight, timing, and operational filters in the ATP flight workspace."
        >
            <x-slot name="actions">
                <button type="button" class="btn-secondary" @click="resetSearch()">Reset</button>
            </x-slot>
        </x-page-header>

        <section class="attach-workspace-shell max-w-[1380px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
                <div class="subtab-shell">
                    <ul class="subtab-list">
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'flight-details' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'flight-details'">Flight Details</button>
                        </li>
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'flight-time' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'flight-time'">Flight Time</button>
                        </li>
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'properties' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'properties'">Properties</button>
                        </li>
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'result' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'result'">Result</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div x-cloak x-show="activeTab === 'flight-details'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_220px_220px]">
                        <div class="space-y-4">
                            <x-enterprise.field-row label="Flight Code" for="search_flight_code" columns="sm:grid-cols-[96px_180px]">
                                <input id="search_flight_code" type="text" x-model="flightCode" class="input-field attach-input" />
                            </x-enterprise.field-row>
                            <x-enterprise.field-row label="Flight Number" for="search_flight_number" columns="sm:grid-cols-[96px_180px]">
                                <input id="search_flight_number" type="text" x-model="flightNumber" class="input-field attach-input" />
                            </x-enterprise.field-row>

                            @foreach ($leftToggles as $toggle)
                                <div class="flex items-center justify-between gap-3 rounded-xl border border-gray-200 bg-gray-50/60 px-4 py-3">
                                    <label class="attach-checkbox-inline">
                                        <input type="checkbox" x-model="{{ $toggle['model'] }}" />
                                        <span>{{ $toggle['label'] }}</span>
                                    </label>
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-4">
                            @foreach ($middleToggles as $toggle)
                                <div class="flex items-center justify-between gap-3 rounded-xl border border-gray-200 bg-gray-50/60 px-4 py-3">
                                    <label class="attach-checkbox-inline">
                                        <input type="checkbox" x-model="{{ $toggle['model'] }}" />
                                        <span>{{ $toggle['label'] }}</span>
                                    </label>
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-4">
                            @foreach ($rightToggles as $toggle)
                                <div class="flex items-center justify-between gap-3 rounded-xl border border-gray-200 bg-gray-50/60 px-4 py-3">
                                    <label class="attach-checkbox-inline">
                                        <input type="checkbox" x-model="{{ $toggle['model'] }}" />
                                        <span>{{ $toggle['label'] }}</span>
                                    </label>
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_240px]">
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <div class="attach-field-label">Observations</div>
                                <textarea x-model="observations" rows="4" class="input-field attach-textarea min-h-[120px]"></textarea>
                            </div>

                            <div class="space-y-2">
                                <div class="attach-field-label">Pilot Observations</div>
                                <textarea x-model="pilotObservations" rows="4" class="input-field attach-textarea min-h-[120px]"></textarea>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <x-enterprise.field-row label="Planned PAX" for="search_flight_planned_pax" columns="sm:grid-cols-[120px_92px]">
                                <input id="search_flight_planned_pax" type="text" x-model="plannedPax" class="input-field attach-input" />
                            </x-enterprise.field-row>
                            <x-enterprise.field-row label="Nb of PAX Aboard" for="search_flight_pax_aboard" columns="sm:grid-cols-[120px_92px]">
                                <input id="search_flight_pax_aboard" type="text" x-model="paxAboard" class="input-field attach-input" />
                            </x-enterprise.field-row>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'flight-time'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="grid gap-5 xl:grid-cols-2">
                        <x-enterprise.panel muted class="space-y-4">
                            <div class="text-sm font-semibold text-gray-900">Departure</div>
                            @foreach ($departureRanges as $row)
                                <div class="grid grid-cols-[132px_minmax(0,1fr)_84px_28px_minmax(0,1fr)_84px] items-center gap-[10px]">
                                    <span class="attach-field-label">{{ $row['label'] }} From</span>
                                    <x-date-picker :id="$row['id'].'_from_date'" class="min-w-0" x-model="{{ $row['dateFrom'] }}" />
                                    <input type="text" x-model="{{ $row['timeFrom'] }}" class="input-field attach-input min-w-0" placeholder="Time" />
                                    <span class="attach-field-label">To</span>
                                    <x-date-picker :id="$row['id'].'_to_date'" class="min-w-0" x-model="{{ $row['dateTo'] }}" />
                                    <input type="text" x-model="{{ $row['timeTo'] }}" class="input-field attach-input min-w-0" placeholder="Time" />
                                </div>
                            @endforeach
                        </x-enterprise.panel>

                        <x-enterprise.panel muted class="space-y-4">
                            <div class="text-sm font-semibold text-gray-900">Arrival</div>
                            @foreach ($arrivalRanges as $row)
                                <div class="grid grid-cols-[132px_minmax(0,1fr)_84px_28px_minmax(0,1fr)_84px] items-center gap-[10px]">
                                    <span class="attach-field-label">{{ $row['label'] }} From</span>
                                    <x-date-picker :id="$row['id'].'_from_date'" class="min-w-0" x-model="{{ $row['dateFrom'] }}" />
                                    <input type="text" x-model="{{ $row['timeFrom'] }}" class="input-field attach-input min-w-0" placeholder="Time" />
                                    <span class="attach-field-label">To</span>
                                    <x-date-picker :id="$row['id'].'_to_date'" class="min-w-0" x-model="{{ $row['dateTo'] }}" />
                                    <input type="text" x-model="{{ $row['timeTo'] }}" class="input-field attach-input min-w-0" placeholder="Time" />
                                </div>
                            @endforeach
                        </x-enterprise.panel>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'properties'" class="space-y-5">
                <x-enterprise.panel class="min-h-[360px] space-y-3">
                    <div class="text-sm font-semibold text-gray-900">Properties</div>
                    <p class="mt-1 text-sm text-gray-500">Property-driven flight filters can be surfaced here once the selected search profile requires them.</p>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'result'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" class="btn-secondary" :class="resultView === 'core' ? 'bg-blue-600 border-blue-600 text-white' : ''" @click="resultView = 'core'; refreshResultTables()">Core</button>
                        <button type="button" class="btn-secondary" :class="resultView === 'aircraft' ? 'bg-blue-600 border-blue-600 text-white' : ''" @click="resultView = 'aircraft'; refreshResultTables()">Aircraft</button>
                        <button type="button" class="btn-secondary" :class="resultView === 'timing' ? 'bg-blue-600 border-blue-600 text-white' : ''" @click="resultView = 'timing'; refreshResultTables()">Timing</button>
                        <button type="button" class="btn-secondary" :class="resultView === 'commercial' ? 'bg-blue-600 border-blue-600 text-white' : ''" @click="resultView = 'commercial'; refreshResultTables()">Commercial</button>
                    </div>

                    <template x-if="resultView === 'core'">
                        <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1180px]" datatable datatable-selectable>
                            <x-slot name="thead">
                                <tr>
                                    <th>Code</th>
                                    <th>Flight No.</th>
                                    <th>Status</th>
                                    <th>CS</th>
                                    <th>LS</th>
                                    <th>FS</th>
                                    <th>FTR No.</th>
                                    <th>FL Code</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                <template x-for="row in results" :key="`${row.code}-core`">
                                    <tr>
                                        <td x-text="row.code"></td>
                                        <td x-text="row.flight_no"></td>
                                        <td x-text="row.status"></td>
                                        <td><input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600" :checked="row.cs" /></td>
                                        <td><input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600" :checked="row.ls" /></td>
                                        <td><input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600" :checked="row.fs" /></td>
                                        <td x-text="row.ftr"></td>
                                        <td x-text="row.fl_code"></td>
                                    </tr>
                                </template>
                            </x-slot>
                        </x-enterprise.table-shell>
                    </template>

                    <template x-if="resultView === 'aircraft'">
                        <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1180px]" datatable datatable-selectable>
                            <x-slot name="thead">
                                <tr>
                                    <th>FL Code</th>
                                    <th>FL Type</th>
                                    <th>SN</th>
                                    <th>Registration</th>
                                    <th>Departure</th>
                                    <th>Scheduled Date</th>
                                    <th>Scheduled Time</th>
                                    <th>Starting Date</th>
                                    <th>Starting Time</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                <template x-for="row in results" :key="`${row.code}-aircraft`">
                                    <tr>
                                        <td x-text="row.fl_code"></td>
                                        <td x-text="row.fl_type"></td>
                                        <td x-text="row.sn"></td>
                                        <td x-text="row.registration"></td>
                                        <td x-text="row.departure"></td>
                                        <td x-text="row.scheduled_date"></td>
                                        <td x-text="row.scheduled_time"></td>
                                        <td x-text="row.starting_date"></td>
                                        <td x-text="row.starting_time"></td>
                                    </tr>
                                </template>
                            </x-slot>
                        </x-enterprise.table-shell>
                    </template>

                    <template x-if="resultView === 'timing'">
                        <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1180px]" datatable datatable-selectable>
                            <x-slot name="thead">
                                <tr>
                                    <th>Starting Date</th>
                                    <th>Starting Time</th>
                                    <th>TakeOff Date</th>
                                    <th>TakeOff Time</th>
                                    <th>Arrival</th>
                                    <th>Schedule Date</th>
                                    <th>Schedule Time</th>
                                    <th>Landing Date</th>
                                    <th>Landing Time</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                <template x-for="row in results" :key="`${row.code}-timing`">
                                    <tr>
                                        <td x-text="row.starting_date"></td>
                                        <td x-text="row.starting_time"></td>
                                        <td x-text="row.takeoff_date"></td>
                                        <td x-text="row.takeoff_time"></td>
                                        <td x-text="row.arrival"></td>
                                        <td x-text="row.scheduled_date"></td>
                                        <td x-text="row.scheduled_time"></td>
                                        <td x-text="row.landing_date"></td>
                                        <td x-text="row.landing_time"></td>
                                    </tr>
                                </template>
                            </x-slot>
                        </x-enterprise.table-shell>
                    </template>

                    <template x-if="resultView === 'commercial'">
                        <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1180px]" datatable datatable-selectable>
                            <x-slot name="thead">
                                <tr>
                                    <th>Landing Date</th>
                                    <th>Landing Time</th>
                                    <th>Shutdown Date</th>
                                    <th>Shutdown Time</th>
                                    <th>Project</th>
                                    <th>Customer Code</th>
                                    <th>Customer</th>
                                    <th>Flight Category</th>
                                    <th>Flight Rules</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                <template x-for="row in results" :key="`${row.code}-commercial`">
                                    <tr>
                                        <td x-text="row.landing_date"></td>
                                        <td x-text="row.landing_time"></td>
                                        <td x-text="row.shutdown_date"></td>
                                        <td x-text="row.shutdown_time"></td>
                                        <td x-text="row.project"></td>
                                        <td x-text="row.customer_code"></td>
                                        <td x-text="row.customer"></td>
                                        <td x-text="row.flight_category"></td>
                                        <td x-text="row.flight_rules"></td>
                                    </tr>
                                </template>
                            </x-slot>
                        </x-enterprise.table-shell>
                    </template>
                </x-enterprise.panel>
            </div>

            <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
                <div class="flex flex-wrap items-center gap-3" x-show="activeTab !== 'result'">
                    <button type="button" class="btn-primary" @click="searchFlights()">Search</button>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <div class="grid gap-2" x-show="activeTab !== 'result'">
                        <span class="attach-field-label">Maximum Number of Records</span>
                        <input type="text" x-model="maxRecords" class="input-field attach-input" />
                    </div>
                    <button type="button" class="btn-secondary" x-show="activeTab === 'result'" @click="chooseResult()">Choose</button>
                    <button type="button" class="btn-secondary" x-show="activeTab !== 'result'" @click="resetSearch()">Cancel</button>
                </div>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
