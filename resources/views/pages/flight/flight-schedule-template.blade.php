@extends('layouts.app')

@section('title', 'Flight Schedule Template')

@section('content')
    <div
        class="space-y-6"
        x-data="{
            activeTab: 'flight-detail',
            code: 'TPL-014',
            flightNumber: 'WSA-231',
            flightRules: 'VFR',
            category: 'Commercial',
            status: 'Active',
            area: 'Sarawak',
            observation: 'Reusable template for morning crew-transfer sectors with standard dispatch timing and customer gate allocation.',
            departureLocation: 'KUL',
            departureTerminal: 'Gate A1',
            departureTime: '06:30',
            departureZone: 'MYT',
            arrivalLocation: 'MYY',
            arrivalTerminal: 'Hangar 2',
            arrivalTime: '08:10',
            arrivalZone: 'MYT',
            totalDecimal: '1',
            totalMinutes: '40',
            flCode: 'FL-9M-WCM',
            registration: '9M-WCM',
            aircraftType: 'AW139',
            operator: 'Aero One Flight Operations',
            serialNumber: '31324',
            statusMessage: '',
            findTemplate() {
                this.statusMessage = `Template ${this.code} loaded successfully.`;
            },
            cancelTemplate() {
                this.statusMessage = 'Flight schedule template review cancelled.';
            },
            scheduleFlight() {
                this.statusMessage = `Flight scheduled from template ${this.code}.`;
            },
        }"
    >
        <x-page-header
            title="Flight Schedule Template"
            description="Maintain reusable flight-template details, scheduled routing, and aircraft defaults in the ATP flight workspace."
        />

        <section class="attach-workspace-shell max-w-[1240px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel class="space-y-5">
                <div class="grid gap-5 xl:grid-cols-[180px_280px_240px]">
                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Code" for="flight_template_code" columns="sm:grid-cols-[88px_140px]">
                            <input id="flight_template_code" type="text" x-model="code" class="input-field attach-input" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Flight Number" for="flight_template_number" columns="sm:grid-cols-[88px_140px]">
                            <input id="flight_template_number" type="text" x-model="flightNumber" class="input-field attach-input" />
                        </x-enterprise.field-row>
                    </div>

                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Flight Rules" for="flight_template_rules" columns="sm:grid-cols-[88px_180px]">
                            <select id="flight_template_rules" x-model="flightRules" class="input-field attach-input">
                                <option>VFR</option>
                                <option>IFR</option>
                            </select>
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Category" for="flight_template_category" columns="sm:grid-cols-[88px_180px]">
                            <select id="flight_template_category" x-model="category" class="input-field attach-input">
                                <option>Commercial</option>
                                <option>Technical</option>
                                <option>Customer Support</option>
                            </select>
                        </x-enterprise.field-row>
                    </div>

                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Status" for="flight_template_status" columns="sm:grid-cols-[64px_160px]">
                            <select id="flight_template_status" x-model="status" class="input-field attach-input">
                                <option>Active</option>
                                <option>Inactive</option>
                                <option>Draft</option>
                            </select>
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Area" for="flight_template_area" columns="sm:grid-cols-[64px_160px]">
                            <input id="flight_template_area" type="text" x-model="area" class="input-field attach-input" />
                        </x-enterprise.field-row>
                    </div>
                </div>

                <x-enterprise.field-row label="Observation" for="flight_template_observation" columns="sm:grid-cols-[88px_minmax(0,1fr)]">
                    <textarea id="flight_template_observation" x-model="observation" rows="4" class="input-field attach-textarea"></textarea>
                </x-enterprise.field-row>
            </x-enterprise.panel>

            <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
                <div class="subtab-shell">
                    <ul class="subtab-list">
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'flight-detail' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'flight-detail'">Flight Detail</button>
                        </li>
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'aircraft' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'aircraft'">Aircraft</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div x-cloak x-show="activeTab === 'flight-detail'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="grid gap-5 xl:grid-cols-2">
                        <div class="space-y-4">
                            <div class="text-sm font-semibold text-gray-900">Departure</div>

                            <x-enterprise.lookup-row label="Departure Location" for="flight_template_departure_location" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <div class="attach-inline-control">
                                    <input id="flight_template_departure_location" type="text" x-model="departureLocation" class="input-field attach-input" />
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                            </x-enterprise.lookup-row>

                            <x-enterprise.field-row label="Terminal/Gate" for="flight_template_departure_terminal" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <select id="flight_template_departure_terminal" x-model="departureTerminal" class="input-field attach-input">
                                    <option>Gate A1</option>
                                    <option>Gate A2</option>
                                    <option>Hangar Stand</option>
                                </select>
                            </x-enterprise.field-row>

                            <div class="grid grid-cols-[108px_96px_minmax(0,1fr)] items-center gap-[10px]">
                                <span class="attach-field-label">Scheduled Time</span>
                                <input type="text" class="input-field attach-input" x-model="departureTime" />
                                <div class="attach-inline-control">
                                    <input type="text" class="input-field attach-input" x-model="departureZone" />
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="text-sm font-semibold text-gray-900">Arrival</div>

                            <x-enterprise.lookup-row label="Arrival Location" for="flight_template_arrival_location" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <div class="attach-inline-control">
                                    <input id="flight_template_arrival_location" type="text" x-model="arrivalLocation" class="input-field attach-input" />
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                            </x-enterprise.lookup-row>

                            <x-enterprise.field-row label="Terminal/Gate" for="flight_template_arrival_terminal" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <select id="flight_template_arrival_terminal" x-model="arrivalTerminal" class="input-field attach-input">
                                    <option>Hangar 2</option>
                                    <option>Gate B1</option>
                                    <option>Remote Stand</option>
                                </select>
                            </x-enterprise.field-row>

                            <div class="grid grid-cols-[108px_96px_minmax(0,1fr)] items-center gap-[10px]">
                                <span class="attach-field-label">Scheduled Time</span>
                                <input type="text" class="input-field attach-input" x-model="arrivalTime" />
                                <div class="attach-inline-control">
                                    <input type="text" class="input-field attach-input" x-model="arrivalZone" />
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid max-w-[620px] grid-cols-[180px_52px_96px_52px_96px] items-center gap-[10px]">
                        <span class="attach-field-label">Total Flight Scheduled Time</span>
                        <div class="attach-field-label">Decimal</div>
                        <input type="text" class="input-field attach-input" x-model="totalDecimal" />
                        <div class="attach-field-label">Minutes</div>
                        <input type="text" class="input-field attach-input" x-model="totalMinutes" />
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'aircraft'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="grid max-w-[420px] gap-4">
                        <x-enterprise.lookup-row label="FL Code" for="flight_template_fl_code" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                            <div class="attach-inline-control">
                                <input id="flight_template_fl_code" type="text" x-model="flCode" class="input-field attach-input" />
                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>
                        </x-enterprise.lookup-row>

                        <x-enterprise.field-row label="Registration" for="flight_template_registration" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                            <input id="flight_template_registration" type="text" x-model="registration" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Type" for="flight_template_type" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                            <input id="flight_template_type" type="text" x-model="aircraftType" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Operator" for="flight_template_operator" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                            <input id="flight_template_operator" type="text" x-model="operator" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Serial Number" for="flight_template_serial_number" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                            <input id="flight_template_serial_number" type="text" x-model="serialNumber" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>
                    </div>
                </x-enterprise.panel>
            </div>

            <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="btn-primary" @click="findTemplate()">Find</button>
                    <button type="button" class="btn-secondary" @click="cancelTemplate()">Cancel</button>
                </div>

                <button type="button" class="btn-secondary" @click="scheduleFlight()">Schedule Flight</button>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
