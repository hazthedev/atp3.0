@extends('layouts.app')

@section('title', 'Flight Details')

@php
    $crewRows = [
        ['position' => 'Captain', 'first_name' => 'Rahman', 'last_name' => 'Aziz', 'lic_status' => 'Valid', 'first_pilot' => true, 'takeoff' => 1, 'landing' => 1, 'day_vfr' => '01:20', 'day_ifr' => '00:00', 'night_vfr' => '00:00', 'night_ifr' => '00:00', 'flight_time' => '01:20', 'assignment' => 'Flight crew'],
        ['position' => 'Co-Pilot', 'first_name' => 'Shahrul', 'last_name' => 'Karim', 'lic_status' => 'Valid', 'first_pilot' => false, 'takeoff' => 0, 'landing' => 0, 'day_vfr' => '01:20', 'day_ifr' => '00:00', 'night_vfr' => '00:00', 'night_ifr' => '00:00', 'flight_time' => '01:20', 'assignment' => 'Flight crew'],
    ];
    $fluidRows = [
        'fuel' => [['location' => 'Main Tank', 'recorded' => '0.0000', 'confirmed' => '0.0000', 'uom' => 'KG'], ['location' => 'Aux Tank', 'recorded' => '0.0000', 'confirmed' => '0.0000', 'uom' => 'KG']],
        'oil' => [['location' => 'Engine 1', 'recorded' => '0.0000', 'confirmed' => '0.0000', 'uom' => 'L'], ['location' => 'Engine 2', 'recorded' => '0.0000', 'confirmed' => '0.0000', 'uom' => 'L']],
        'hyd' => [['location' => 'Hydraulic Sys A', 'recorded' => '0.0000', 'confirmed' => '0.0000', 'uom' => 'L'], ['location' => 'Hydraulic Sys B', 'recorded' => '0.0000', 'confirmed' => '0.0000', 'uom' => 'L']],
    ];
    $loadRows = [['type' => 'Cargo', 'qty' => '0.0000', 'uom' => 'KG'], ['type' => 'Baggage', 'qty' => '0.0000', 'uom' => 'KG']];
    $attachments = [['id' => 1, 'path' => 'flight/2026/manifest-231.pdf', 'file_name' => 'manifest-231.pdf', 'attachment_date' => '2026-04-07'], ['id' => 2, 'path' => 'flight/2026/dispatch-note-231.pdf', 'file_name' => 'dispatch-note-231.pdf', 'attachment_date' => '2026-04-07']];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            activeTab: 'general',
            code: 'FD-240231', flightNumber: 'WSA-231', flightTemplateCode: 'TPL-014', techlogId: 'TL-10492', scheduledDate: '2026-04-07',
            departureLocation: 'KUL', arrivalLocation: 'MYY', category: 'Commercial', flightRules: 'VFR', customer: 'Weststar Aviation Services',
            project: 'PRJ-88014', area: 'Sarawak', departureTerminal: 'Gate A1', arrivalTerminal: 'Hangar 2', status: 'Scheduled',
            tailStatus: '', crewStatus: '', fuelStatus: '', paxStatus: '',
            observation: 'Morning customer crew-transfer sector with standard offshore support dispatch configuration.',
            flCode: 'FL-9M-WCM', serialNumber: '31324', registration: '9M-WCM', type: 'AW139', operator: 'Aero One Flight Operations',
            pilotObservations: 'Crew brief completed. Weather acceptable for departure. No dispatch limitation currently open.',
            departureScheduledDate: '2026-04-07', departureScheduledTime: '06:30', departureScheduledZone: 'MYT',
            departureStartingDate: '2026-04-07', departureStartingTime: '06:22', departureStartingZone: 'MYT',
            departureTakeoffDate: '2026-04-07', departureTakeoffTime: '06:37', departureTakeoffZone: 'MYT',
            arrivalScheduledDate: '2026-04-07', arrivalScheduledTime: '08:10', arrivalScheduledZone: 'MYT',
            arrivalLandingDate: '2026-04-07', arrivalLandingTime: '08:02', arrivalLandingZone: 'MYT',
            arrivalShutdownDate: '2026-04-07', arrivalShutdownTime: '08:09', arrivalShutdownZone: 'MYT',
            totalFlightScheduledDecimal: '0', totalFlightScheduledMinutes: '0', totalFlightRealDecimal: '0', totalFlightRealMinutes: '0', airframeRealDecimal: '0', airframeRealMinutes: '0',
            plannedPax: '9', aboardPax: '9', deplanedPax: '9', internalLoad: '180', paxWeight: '720', fuelWeight: '420', externalLoad: '0', acEmptyWeight: '4,310', acMaxWeight: '6,800', allUpWeight: '5,630',
            totalFuelDeparture: '420', totalFuelArrival: '180', totalOilDeparture: '12', totalOilArrival: '11', totalHydDeparture: '9', totalHydArrival: '9',
            crewComplete: false, fuelComplete: false, paxLoadComplete: false,
            crewRows: @js($crewRows), fuelRows: @js($fluidRows['fuel']), oilRows: @js($fluidRows['oil']), hydraulicRows: @js($fluidRows['hyd']), loadRows: @js($loadRows), attachments: @js($attachments),
            statusMessage: '',
            checkStatuses() { this.tailStatus = this.registration ? 'Ready' : 'Missing'; this.crewStatus = this.crewRows.length ? 'Assigned' : 'Missing'; this.fuelStatus = this.totalFuelDeparture ? 'Captured' : 'Missing'; this.paxStatus = this.plannedPax ? 'Balanced' : 'Missing'; this.statusMessage = `Validation completed for ${this.flightNumber}.`; },
            addFlight() { this.status = 'Scheduled'; this.statusMessage = `Flight ${this.flightNumber} saved successfully.`; },
            cancelFlight() { this.statusMessage = 'Flight detail editing cancelled.'; },
            browseAttachment() { this.statusMessage = 'Attachment picker opened for flight details.'; },
            displayAttachment() { this.statusMessage = this.attachments.length ? `Displaying ${this.attachments[0].file_name}.` : 'There is no attachment available to display.'; },
            deleteAttachment() { if (!this.attachments.length) { this.statusMessage = 'There is no attachment available to delete.'; return; } const removed = this.attachments.shift(); this.statusMessage = `${removed.file_name} removed from the flight record.`; },
        }"
    >
        <x-page-header title="Flight Details" description="Create a new flight entry, capture operational timing, crew, fuel, PAX/load, and supporting records in the ATP flight workspace." />

        <section class="attach-workspace-shell max-w-[1440px] space-y-5">
            <template x-if="statusMessage"><div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div></template>

            <x-enterprise.panel class="space-y-5">
                <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_280px]">
                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Code" for="flight_details_code" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><input id="flight_details_code" type="text" x-model="code" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Flight Number" for="flight_details_flight_number" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><input id="flight_details_flight_number" type="text" x-model="flightNumber" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.lookup-row label="Flight Template Code" for="flight_details_template_code" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><div class="attach-inline-control"><input id="flight_details_template_code" type="text" x-model="flightTemplateCode" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                        <x-enterprise.field-row label="Techlog ID" for="flight_details_techlog" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><input id="flight_details_techlog" type="text" x-model="techlogId" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Scheduled Date" for="flight_details_scheduled_date" columns="sm:grid-cols-[112px_172px]"><x-date-picker id="flight_details_scheduled_date" x-model="scheduledDate" /></x-enterprise.field-row>
                        <x-enterprise.lookup-row label="Departure Location" for="flight_details_departure_location" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><div class="attach-inline-control"><input id="flight_details_departure_location" type="text" x-model="departureLocation" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                        <x-enterprise.lookup-row label="Arrival Location" for="flight_details_arrival_location" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><div class="attach-inline-control"><input id="flight_details_arrival_location" type="text" x-model="arrivalLocation" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                    </div>

                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Category" for="flight_details_category" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><select id="flight_details_category" x-model="category" class="input-field attach-input"><option>Commercial</option><option>Technical</option><option>Customer Support</option></select></x-enterprise.field-row>
                        <x-enterprise.field-row label="Flight Rules" for="flight_details_rules" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><select id="flight_details_rules" x-model="flightRules" class="input-field attach-input"><option>VFR</option><option>IFR</option></select></x-enterprise.field-row>
                        <x-enterprise.lookup-row label="Customer" for="flight_details_customer" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><div class="attach-inline-control"><input id="flight_details_customer" type="text" x-model="customer" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                        <x-enterprise.lookup-row label="Project" for="flight_details_project" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><div class="attach-inline-control"><input id="flight_details_project" type="text" x-model="project" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                        <x-enterprise.field-row label="Area" for="flight_details_area" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><input id="flight_details_area" type="text" x-model="area" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Departure Terminal/Gate" for="flight_details_departure_terminal" columns="sm:grid-cols-[140px_minmax(0,1fr)]"><select id="flight_details_departure_terminal" x-model="departureTerminal" class="input-field attach-input"><option>Gate A1</option><option>Gate A2</option><option>Hangar Stand</option></select></x-enterprise.field-row>
                        <x-enterprise.field-row label="Arrival Terminal/Gate" for="flight_details_arrival_terminal" columns="sm:grid-cols-[140px_minmax(0,1fr)]"><select id="flight_details_arrival_terminal" x-model="arrivalTerminal" class="input-field attach-input"><option>Hangar 2</option><option>Gate B1</option><option>Remote Stand</option></select></x-enterprise.field-row>
                    </div>

                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Status" for="flight_details_status" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><select id="flight_details_status" x-model="status" class="input-field attach-input"><option>Scheduled</option><option>Released</option><option>Completed</option><option>Cancelled</option></select></x-enterprise.field-row>
                        <x-enterprise.field-row label="Tail Status" for="flight_details_tail_status" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><input id="flight_details_tail_status" type="text" x-model="tailStatus" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Crew Status" for="flight_details_crew_status" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><input id="flight_details_crew_status" type="text" x-model="crewStatus" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Fuel & Others Status" for="flight_details_fuel_status" columns="sm:grid-cols-[136px_minmax(0,1fr)]"><input id="flight_details_fuel_status" type="text" x-model="fuelStatus" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="PAX/Load Status" for="flight_details_pax_status" columns="sm:grid-cols-[136px_minmax(0,1fr)]"><input id="flight_details_pax_status" type="text" x-model="paxStatus" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <div class="pt-2"><button type="button" class="btn-secondary" @click="checkStatuses()">Check</button></div>
                    </div>
                </div>

                <x-enterprise.field-row label="Observation" for="flight_details_observation" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                    <textarea id="flight_details_observation" x-model="observation" rows="4" class="input-field attach-textarea"></textarea>
                </x-enterprise.field-row>
            </x-enterprise.panel>

            <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
                <div class="subtab-shell">
                    <ul class="subtab-list">
                        @foreach (['general' => 'General', 'time' => 'Time', 'crew' => 'Crew', 'fuel-others' => 'Fuel & Others', 'pax-load' => 'PAX/Load', 'counters' => 'Counters', 'attachments' => 'Attachments', 'properties' => 'Properties'] as $key => $label)
                            <li class="subtab-item"><button type="button" class="subtab-link" :class="activeTab === '{{ $key }}' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = '{{ $key }}'">{{ $label }}</button></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div x-cloak x-show="activeTab === 'general'" class="space-y-5">
                <x-enterprise.panel class="grid gap-5 xl:grid-cols-[320px_minmax(0,1fr)]">
                    <x-enterprise.panel muted class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Aircraft</div>
                        <x-enterprise.lookup-row label="FL Code" for="flight_details_fl_code" columns="sm:grid-cols-[96px_minmax(0,1fr)]"><div class="attach-inline-control"><input id="flight_details_fl_code" type="text" x-model="flCode" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                        <x-enterprise.field-row label="Serial Number" for="flight_details_serial_number" columns="sm:grid-cols-[96px_minmax(0,1fr)]"><input id="flight_details_serial_number" type="text" x-model="serialNumber" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Registration" for="flight_details_registration" columns="sm:grid-cols-[96px_minmax(0,1fr)]"><input id="flight_details_registration" type="text" x-model="registration" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.lookup-row label="Type" for="flight_details_type" columns="sm:grid-cols-[96px_minmax(0,1fr)]"><div class="attach-inline-control"><input id="flight_details_type" type="text" x-model="type" class="input-field attach-input input-field-filled" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                        <x-enterprise.field-row label="Operator" for="flight_details_operator" columns="sm:grid-cols-[96px_minmax(0,1fr)]"><input id="flight_details_operator" type="text" x-model="operator" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <button type="button" class="btn-secondary">Technical Log</button>
                    </x-enterprise.panel>

                    <x-enterprise.panel muted class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Pilot Observations</div>
                        <textarea x-model="pilotObservations" rows="12" class="input-field attach-textarea min-h-[260px]"></textarea>
                    </x-enterprise.panel>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'time'" class="space-y-5">
                <x-enterprise.panel class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
                    <div class="space-y-5">
                        <x-enterprise.panel muted class="space-y-4">
                            <div class="text-sm font-semibold text-gray-900">Departure</div>
                            <div class="grid grid-cols-[88px_172px_96px_minmax(0,1fr)] items-center gap-[10px]"><span></span><span class="attach-field-label">Date</span><span class="attach-field-label">Time</span><span class="attach-field-label">Time Zone</span></div>
                            @foreach ([['label' => 'Scheduled', 'date' => 'departureScheduledDate', 'time' => 'departureScheduledTime', 'zone' => 'departureScheduledZone'], ['label' => 'Starting', 'date' => 'departureStartingDate', 'time' => 'departureStartingTime', 'zone' => 'departureStartingZone'], ['label' => 'Take Off', 'date' => 'departureTakeoffDate', 'time' => 'departureTakeoffTime', 'zone' => 'departureTakeoffZone']] as $row)
                                <div class="grid grid-cols-[88px_172px_96px_minmax(0,1fr)] items-center gap-[10px]">
                                    <span class="attach-field-label">{{ $row['label'] }}</span>
                                    <x-date-picker :id="'flight_details_'.$row['date']" x-model="{{ $row['date'] }}" />
                                    <input type="text" class="input-field attach-input" x-model="{{ $row['time'] }}" />
                                    <div class="attach-inline-control"><input type="text" class="input-field attach-input" x-model="{{ $row['zone'] }}" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div>
                                </div>
                            @endforeach
                        </x-enterprise.panel>

                        <x-enterprise.panel muted class="space-y-4">
                            <div class="text-sm font-semibold text-gray-900">Arrival</div>
                            <div class="grid grid-cols-[88px_172px_96px_minmax(0,1fr)] items-center gap-[10px]"><span></span><span class="attach-field-label">Date</span><span class="attach-field-label">Time</span><span class="attach-field-label">Time Zone</span></div>
                            @foreach ([['label' => 'Scheduled', 'date' => 'arrivalScheduledDate', 'time' => 'arrivalScheduledTime', 'zone' => 'arrivalScheduledZone'], ['label' => 'Landing', 'date' => 'arrivalLandingDate', 'time' => 'arrivalLandingTime', 'zone' => 'arrivalLandingZone'], ['label' => 'Shut Down', 'date' => 'arrivalShutdownDate', 'time' => 'arrivalShutdownTime', 'zone' => 'arrivalShutdownZone']] as $row)
                                <div class="grid grid-cols-[88px_172px_96px_minmax(0,1fr)] items-center gap-[10px]">
                                    <span class="attach-field-label">{{ $row['label'] }}</span>
                                    <x-date-picker :id="'flight_details_'.$row['date']" x-model="{{ $row['date'] }}" />
                                    <input type="text" class="input-field attach-input" x-model="{{ $row['time'] }}" />
                                    <div class="attach-inline-control"><input type="text" class="input-field attach-input" x-model="{{ $row['zone'] }}" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div>
                                </div>
                            @endforeach
                        </x-enterprise.panel>
                    </div>

                    <x-enterprise.panel muted class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Total Flight Time</div>
                        <div class="grid grid-cols-[110px_1fr_1fr] items-center gap-[10px]">
                            <div></div><div class="attach-field-label">Decimal</div><div class="attach-field-label">Minutes</div>
                            <div class="attach-field-label">Scheduled</div><input type="text" class="input-field attach-input" x-model="totalFlightScheduledDecimal" /><input type="text" class="input-field attach-input" x-model="totalFlightScheduledMinutes" />
                            <div class="attach-field-label">Total Real</div><input type="text" class="input-field attach-input" x-model="totalFlightRealDecimal" /><input type="text" class="input-field attach-input" x-model="totalFlightRealMinutes" />
                            <div class="attach-field-label">Airframe Real</div><input type="text" class="input-field attach-input" x-model="airframeRealDecimal" /><input type="text" class="input-field attach-input" x-model="airframeRealMinutes" />
                        </div>
                    </x-enterprise.panel>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'crew'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1280px]" datatable>
                        <x-slot name="thead">
                            <tr>
                                <th>Position</th><th>First Name</th><th>Last Name</th><th>Lic. Status</th><th>1st P</th><th>#TO</th><th>#LD</th><th>Day VFR</th><th>Day IFR</th><th>Night VFR</th><th>Night IFR</th><th>Flight Time</th><th>Assignment</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            <template x-for="row in crewRows" :key="`${row.position}-${row.first_name}`">
                                <tr>
                                    <td x-text="row.position"></td><td x-text="row.first_name"></td><td x-text="row.last_name"></td><td x-text="row.lic_status"></td>
                                    <td><input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600" :checked="row.first_pilot" /></td>
                                    <td x-text="row.takeoff"></td><td x-text="row.landing"></td><td x-text="row.day_vfr"></td><td x-text="row.day_ifr"></td><td x-text="row.night_vfr"></td><td x-text="row.night_ifr"></td><td x-text="row.flight_time"></td><td x-text="row.assignment"></td>
                                </tr>
                            </template>
                        </x-slot>
                    </x-enterprise.table-shell>
                    <label class="attach-checkbox-inline"><input type="checkbox" x-model="crewComplete" /><span>Crew complete</span></label>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'fuel-others'" class="space-y-5">
                <div class="grid gap-5 xl:grid-cols-3">
                    @foreach ([['title' => 'Fuel', 'rows' => 'fuelRows', 'total_label' => 'Total Fuel', 'departure' => 'totalFuelDeparture', 'arrival' => 'totalFuelArrival'], ['title' => 'Oil', 'rows' => 'oilRows', 'total_label' => 'Total Oil', 'departure' => 'totalOilDeparture', 'arrival' => 'totalOilArrival'], ['title' => 'Hydraulics', 'rows' => 'hydraulicRows', 'total_label' => 'Total Hydraulics', 'departure' => 'totalHydDeparture', 'arrival' => 'totalHydArrival']] as $block)
                        <x-enterprise.panel class="space-y-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $block['title'] }}</div>
                            <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable>
                                <x-slot name="thead"><tr><th>Location</th><th>Recorded</th><th>Confirmed</th><th>UoM</th></tr></x-slot>
                                <x-slot name="tbody">
                                    <template x-for="row in {{ $block['rows'] }}" :key="row.location">
                                        <tr><td x-text="row.location"></td><td x-text="row.recorded"></td><td x-text="row.confirmed"></td><td x-text="row.uom"></td></tr>
                                    </template>
                                </x-slot>
                            </x-enterprise.table-shell>
                            <div class="grid grid-cols-[84px_72px_1fr_52px_1fr] items-center gap-[10px]">
                                <span class="attach-field-label">{{ $block['total_label'] }}</span><div class="attach-field-label">Departure</div><input type="text" class="input-field attach-input" x-model="{{ $block['departure'] }}" /><div class="attach-field-label">Arrival</div><input type="text" class="input-field attach-input" x-model="{{ $block['arrival'] }}" />
                            </div>
                        </x-enterprise.panel>
                    @endforeach
                </div>
                <x-enterprise.panel class="space-y-4"><label class="attach-checkbox-inline"><input type="checkbox" x-model="fuelComplete" /><span>Fuel &amp; Others complete</span></label></x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'pax-load'" class="space-y-5">
                <div class="grid gap-5 xl:grid-cols-[260px_minmax(0,1fr)_320px]">
                    <x-enterprise.panel class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">PAX</div>
                        <x-enterprise.field-row label="Planned PAX" for="flight_details_planned_pax" columns="sm:grid-cols-[112px_120px]"><input id="flight_details_planned_pax" type="text" x-model="plannedPax" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Nb. of PAX aboard" for="flight_details_aboard_pax" columns="sm:grid-cols-[112px_120px]"><input id="flight_details_aboard_pax" type="text" x-model="aboardPax" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Deplaned PAX" for="flight_details_deplaned_pax" columns="sm:grid-cols-[112px_120px]"><input id="flight_details_deplaned_pax" type="text" x-model="deplanedPax" class="input-field attach-input" /></x-enterprise.field-row>
                    </x-enterprise.panel>

                    <x-enterprise.panel class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Load Information</div>
                        <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable>
                            <x-slot name="thead"><tr><th>Type</th><th>Qty</th><th>UoM</th></tr></x-slot>
                            <x-slot name="tbody">
                                <template x-for="row in loadRows" :key="row.type">
                                    <tr><td x-text="row.type"></td><td x-text="row.qty"></td><td x-text="row.uom"></td></tr>
                                </template>
                            </x-slot>
                        </x-enterprise.table-shell>
                    </x-enterprise.panel>

                    <x-enterprise.panel class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Weight Information</div>
                        <div class="space-y-2.5">
                            @foreach ([['label' => 'Internal Load', 'model' => 'internalLoad'], ['label' => 'PAX', 'model' => 'paxWeight'], ['label' => 'Fuel', 'model' => 'fuelWeight'], ['label' => 'External Load', 'model' => 'externalLoad'], ['label' => 'A/C Empty Weight', 'model' => 'acEmptyWeight'], ['label' => 'A/C Max TO Weight', 'model' => 'acMaxWeight'], ['label' => 'All Up Weight', 'model' => 'allUpWeight']] as $field)
                                <x-enterprise.field-row :label="$field['label']" :for="'flight_details_'.\Illuminate\Support\Str::slug($field['label'], '_')" columns="sm:grid-cols-[132px_minmax(0,1fr)_72px]">
                                    <input id="{{ 'flight_details_'.\Illuminate\Support\Str::slug($field['label'], '_') }}" type="text" x-model="{{ $field['model'] }}" class="input-field attach-input" />
                                    <select class="input-field attach-input"><option>KG</option><option>LB</option></select>
                                </x-enterprise.field-row>
                            @endforeach
                        </div>
                    </x-enterprise.panel>
                </div>
                <x-enterprise.panel class="space-y-4"><label class="attach-checkbox-inline"><input type="checkbox" x-model="paxLoadComplete" /><span>PAX/Load complete</span></label></x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'counters'" class="space-y-5">
                <x-enterprise.panel class="space-y-4 min-h-[320px]">
                    <div class="text-sm font-semibold text-gray-900">Counters</div>
                    <p class="mt-1 text-sm text-gray-500">Counter updates for the selected flight can be added here in the next pass.</p>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'attachments'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_160px]">
                        <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable>
                            <x-slot name="thead"><tr><th>#</th><th>Path</th><th>File Name</th><th>Attachment Date</th></tr></x-slot>
                            <x-slot name="tbody">
                                <template x-if="attachments.length === 0"><tr><td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">No attachments linked to this flight.</td></tr></template>
                                <template x-for="(row, index) in attachments" :key="row.id"><tr><td x-text="index + 1"></td><td x-text="row.path"></td><td x-text="row.file_name"></td><td x-text="row.attachment_date"></td></tr></template>
                            </x-slot>
                        </x-enterprise.table-shell>
                        <div class="flex flex-col gap-3">
                            <button type="button" class="btn-secondary" @click="browseAttachment()">Browse</button>
                            <button type="button" class="btn-secondary" @click="displayAttachment()">Display</button>
                            <button type="button" class="btn-secondary" @click="deleteAttachment()">Delete</button>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'properties'" class="space-y-5">
                <x-enterprise.panel class="space-y-4 min-h-[320px]">
                    <div class="text-sm font-semibold text-gray-900">Properties</div>
                    <p class="mt-1 text-sm text-gray-500">Additional flight properties and derived values can be surfaced here in the next pass.</p>
                </x-enterprise.panel>
            </div>

            <x-enterprise.action-bar class="border-t border-gray-200 pt-5">
                <button type="button" class="btn-primary" @click="addFlight()">Add</button>
                <button type="button" class="btn-secondary" @click="cancelFlight()">Cancel</button>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
