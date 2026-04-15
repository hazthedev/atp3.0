@extends('layouts.app')

@section('title', 'Search Activities')

@php
    $customerRows = [
        ['code' => 'BP-001284', 'name' => 'Weststar Aviation Services'],
        ['code' => 'BP-001155', 'name' => 'Aero One Services'],
        ['code' => 'BP-000882', 'name' => 'Heli Support APAC'],
    ];

    $agentRows = [
        ['code' => 'BA-001', 'first' => 'Ahmad', 'last' => 'Shahrul', 'role' => 'Manager'],
        ['code' => 'BA-002', 'first' => 'Nadiah', 'last' => 'Rahman', 'role' => 'Planner'],
        ['code' => 'BA-003', 'first' => 'Aina', 'last' => 'Karim', 'role' => 'Sales Employee'],
    ];

    $activityTypes = ['Commercial', 'Quality', 'Technical'];

    $dateRows = [
        ['key' => 'creation_date', 'label' => 'Creation date'],
        ['key' => 'start_date', 'label' => 'Start date'],
        ['key' => 'due_date', 'label' => 'Due date'],
        ['key' => 'validate_date', 'label' => 'Validate date'],
        ['key' => 'accepted_date', 'label' => 'Accepted date'],
        ['key' => 'refused_date', 'label' => 'Refused date'],
        ['key' => 'negotiated_date', 'label' => 'Negotiated date'],
        ['key' => 'rescheduled_date', 'label' => 'Rescheduled date'],
        ['key' => 'response_date', 'label' => 'Response date'],
        ['key' => 'close_date', 'label' => 'Close date'],
        ['key' => 'last_update_date', 'label' => 'Last Update date'],
    ];

    $auditToggles = [
        'Created By',
        'Validated By',
        'Accepted By',
        'Refused By',
        'Negotiated By',
        'Rescheduled By',
        'Responded By',
        'Closed By',
        'Last Update By',
        'User Branch',
        'User Department',
    ];

    $chooseResults = [
        ['id' => 'ACT-240418', 'type' => 'Technical', 'pilot' => 'Shahrul', 'bp_code' => 'BP-001284', 'bp_name' => 'Weststar Aviation Services', 'creation_date' => '2026-04-06'],
        ['id' => 'ACT-240409', 'type' => 'Commercial', 'pilot' => 'Nadiah', 'bp_code' => 'BP-001155', 'bp_name' => 'Aero One Services', 'creation_date' => '2026-03-30'],
    ];

    $listResults = [
        ['code' => 'ACT-240418', 'bp_name' => 'Weststar Aviation Services', 'creation_date' => '2026-04-06', 'status' => 'Open', 'subject' => 'Pending customer response requires follow-up'],
        ['code' => 'ACT-240409', 'bp_name' => 'Aero One Services', 'creation_date' => '2026-03-30', 'status' => 'In Progress', 'subject' => 'Commercial planning alignment with customer'],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            activeTab: 'general',
            statusMessage: '',
            idFrom: '',
            idTo: '',
            priority: ['medium'],
            selectedType: 'Commercial',
            statusMode: 'both',
            listMode: false,
            customerProperties: false,
            pilotEnabled: false,
            fieldRepsEnabled: false,
            followUpActivity: false,
            maxRecords: 200,
            remainingDays: '',
            parentActivityCode: '',
            dateValues: {
                creation_date_from: '2026-04-06',
                creation_date_to: '',
                start_date_from: '',
                start_date_to: '',
                due_date_from: '',
                due_date_to: '',
                validate_date_from: '',
                validate_date_to: '',
                accepted_date_from: '',
                accepted_date_to: '',
                refused_date_from: '',
                refused_date_to: '',
                negotiated_date_from: '',
                negotiated_date_to: '',
                rescheduled_date_from: '',
                rescheduled_date_to: '',
                response_date_from: '',
                response_date_to: '',
                close_date_from: '',
                close_date_to: '',
                last_update_date_from: '',
                last_update_date_to: '',
            },
            auditEnabled: {
                'Created By': false,
                'Validated By': false,
                'Accepted By': false,
                'Refused By': false,
                'Negotiated By': false,
                'Rescheduled By': false,
                'Responded By': false,
                'Closed By': false,
                'Last Update By': false,
                'User Branch': false,
                'User Department': false,
            },
            chooseResults: @js($chooseResults),
            listResults: @js($listResults),
            togglePriority(level) {
                if (this.priority.includes(level)) {
                    this.priority = this.priority.filter((item) => item !== level);
                    return;
                }

                this.priority = [...this.priority, level];
            },
            resultCount() {
                return this.listMode ? this.listResults.length : this.chooseResults.length;
            },
            searchActivities() {
                this.activeTab = 'result';
                this.statusMessage = `Loaded ${this.resultCount()} activity result(s).`;
                this.$nextTick(() => window.refreshFlowbiteTables?.());
            },
            resetSearch() {
                this.activeTab = 'general';
                this.statusMessage = 'Activity search filters reset to the default configuration.';
                this.idFrom = '';
                this.idTo = '';
                this.priority = ['medium'];
                this.selectedType = 'Commercial';
                this.statusMode = 'both';
                this.listMode = false;
                this.customerProperties = false;
                this.pilotEnabled = false;
                this.fieldRepsEnabled = false;
                this.followUpActivity = false;
                this.maxRecords = 200;
                this.remainingDays = '';
                this.parentActivityCode = '';

                Object.keys(this.dateValues).forEach((key) => {
                    this.dateValues[key] = key === 'creation_date_from' ? '2026-04-06' : '';
                });

                Object.keys(this.auditEnabled).forEach((key) => {
                    this.auditEnabled[key] = false;
                });
            },
            chooseResult() {
                this.statusMessage = 'Selected activity from the current result set.';
            },
            refreshResultTables() {
                this.$nextTick(() => window.refreshFlowbiteTables?.());
            },
            cancelSearch() {
                this.statusMessage = 'Search session cancelled.';
            },
        }"
    >
        <x-page-header
            title="Search Activities"
            description="Find activities using customer, date, property, and miscellaneous filters in the ATP search workspace."
        >
            <x-slot name="actions">
                <button type="button" class="btn-secondary" @click="resetSearch()">Reset</button>
            </x-slot>
        </x-page-header>

        <section class="attach-workspace-shell max-w-[1320px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
                <div class="subtab-shell">
                    <ul class="subtab-list">
                        @foreach (['general' => 'General', 'date-origin' => 'Date & Origin', 'properties' => 'Properties', 'miscellaneous' => 'Miscellaneous', 'result' => 'Result'] as $key => $label)
                            <li class="subtab-item">
                                <button
                                    type="button"
                                    class="subtab-link"
                                    :class="activeTab === '{{ $key }}' ? 'subtab-link-active' : 'subtab-link-inactive'"
                                    @click="activeTab = '{{ $key }}'"
                                >
                                    {{ $label }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div x-cloak x-show="activeTab === 'general'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_360px]">
                        <div class="space-y-4">
                            <x-enterprise.panel muted class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Customer</div>

                                <div class="attach-table-shell max-h-[220px] overflow-auto">
                                    <table class="min-w-full border-collapse">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customerRows as $row)
                                                <tr>
                                                    <td>{{ $row['code'] }}</td>
                                                    <td>{{ $row['name'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="flex flex-wrap items-center gap-3">
                                    <label class="attach-checkbox-inline">
                                        <input type="checkbox" x-model="customerProperties" />
                                        <span>Customer Properties</span>
                                    </label>
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                            </x-enterprise.panel>

                            <x-enterprise.panel muted class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Business agents</div>

                                <div class="attach-table-shell max-h-[220px] overflow-auto">
                                    <table class="min-w-full border-collapse">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($agentRows as $row)
                                                <tr>
                                                    <td>{{ $row['code'] }}</td>
                                                    <td>{{ $row['first'] }}</td>
                                                    <td>{{ $row['last'] }}</td>
                                                    <td>{{ $row['role'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </x-enterprise.panel>
                        </div>

                        <div class="space-y-4">
                            <x-enterprise.panel muted class="space-y-4">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <x-enterprise.field-row label="ID" for="search_activity_id_from" columns="sm:grid-cols-[40px_148px]">
                                        <input id="search_activity_id_from" type="text" x-model="idFrom" class="input-field attach-input" placeholder="From" />
                                    </x-enterprise.field-row>

                                    <x-enterprise.field-row label="To" for="search_activity_id_to" columns="sm:grid-cols-[24px_148px]">
                                        <input id="search_activity_id_to" type="text" x-model="idTo" class="input-field attach-input" />
                                    </x-enterprise.field-row>
                                </div>

                                <div class="space-y-2">
                                    <div class="attach-field-label">Priority</div>
                                    <div class="space-y-2">
                                        @foreach (['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $key => $label)
                                            <label class="attach-checkbox-inline">
                                                <input type="checkbox" :checked="priority.includes('{{ $key }}')" @change="togglePriority('{{ $key }}')" />
                                                <span>{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <div class="attach-field-label">Activity Type</div>
                                    <div class="attach-table-shell max-h-[180px] overflow-auto">
                                        <table class="min-w-full border-collapse">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($activityTypes as $type)
                                                    <tr
                                                        class="cursor-pointer"
                                                        :class="{ 'bg-blue-50': selectedType === '{{ $type }}' }"
                                                        @click="selectedType = '{{ $type }}'"
                                                    >
                                                        <td>{{ $type }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <div class="attach-field-label">Status</div>
                                    <div class="flex flex-wrap items-center gap-4">
                                        @foreach (['opened' => 'Opened', 'closed' => 'Closed', 'both' => 'Both'] as $key => $label)
                                            <label class="attach-checkbox-inline">
                                                <input type="radio" name="search_activity_status" value="{{ $key }}" x-model="statusMode" />
                                                <span>{{ $label }}</span>
                                            </label>
                                        @endforeach

                                        <label class="attach-checkbox-inline">
                                            <input type="checkbox" x-model="listMode" @change="refreshResultTables()" />
                                            <span>List</span>
                                        </label>

                                        <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                    </div>
                                </div>
                            </x-enterprise.panel>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'date-origin'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_260px]">
                        <div class="space-y-4">
                            @foreach ($dateRows as $row)
                                <div class="grid grid-cols-[132px_156px_24px_156px] items-center gap-3">
                                    <span class="attach-field-label">{{ $row['label'] }}</span>
                                    <x-date-picker :id="'search_activity_'.$row['key'].'_from'" x-model="dateValues['{{ $row['key'] }}_from']" />
                                    <span class="attach-field-label">To</span>
                                    <x-date-picker :id="'search_activity_'.$row['key'].'_to'" x-model="dateValues['{{ $row['key'] }}_to']" />
                                </div>
                            @endforeach

                            <div class="grid grid-cols-[280px_180px_minmax(0,1fr)_40px] items-center gap-3">
                                <span class="attach-field-label">Maximum Remaining Days before target date</span>
                                <select class="input-field attach-input" x-model="remainingDays">
                                    <option value="">Not set</option>
                                    <option value="3">3</option>
                                    <option value="7">7</option>
                                    <option value="14">14</option>
                                </select>

                                <label class="attach-checkbox-inline">
                                    <input type="checkbox" x-model="pilotEnabled" />
                                    <span>Pilot</span>
                                </label>

                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @foreach ($auditToggles as $toggle)
                                <div class="flex flex-wrap items-center gap-3">
                                    <label class="attach-checkbox-inline">
                                        <input type="checkbox" x-model="auditEnabled['{{ $toggle }}']" />
                                        <span>{{ $toggle }}</span>
                                    </label>
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'properties'" class="space-y-5">
                <x-enterprise.panel class="space-y-4 min-h-[420px]">
                    <div>
                        <div class="text-sm font-semibold text-gray-900">Properties</div>
                        <p class="mt-1 text-sm text-gray-500">Property filters can be layered here after an activity has been selected from the current search criteria.</p>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'miscellaneous'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="grid gap-5 xl:grid-cols-2">
                        <div class="space-y-4">
                            <x-enterprise.field-row label="Words in Content" for="activity_words_content" columns="sm:grid-cols-[148px_minmax(0,1fr)]">
                                <textarea id="activity_words_content" rows="4" class="input-field attach-textarea" placeholder="comma separator"></textarea>
                            </x-enterprise.field-row>

                            <div class="flex flex-wrap items-center gap-3">
                                <label class="attach-checkbox-inline">
                                    <input type="checkbox" x-model="fieldRepsEnabled" />
                                    <span>Field Reps</span>
                                </label>
                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>

                            <x-enterprise.panel muted class="space-y-3 max-w-[420px]">
                                <label class="attach-checkbox-inline">
                                    <input type="checkbox" x-model="followUpActivity" />
                                    <span>Is a follow-up activity</span>
                                </label>

                                <x-enterprise.field-row label="Parent activity code" for="activity_parent_code" columns="sm:grid-cols-[148px_minmax(0,1fr)]">
                                    <input id="activity_parent_code" type="text" x-model="parentActivityCode" class="input-field attach-input" />
                                </x-enterprise.field-row>
                            </x-enterprise.panel>
                        </div>

                        <div class="space-y-4">
                            <x-enterprise.field-row label="Words in Response" for="activity_words_response" columns="sm:grid-cols-[148px_minmax(0,1fr)]">
                                <textarea id="activity_words_response" rows="4" class="input-field attach-textarea" placeholder="comma separator"></textarea>
                            </x-enterprise.field-row>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'result'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <div>
                        <div class="text-sm font-semibold text-gray-900">Result</div>
                        <p class="mt-1 text-sm text-gray-500" x-text="listMode ? 'List-style activity results for browsing.' : 'Selectable activity results for direct choosing.'"></p>
                    </div>

                    <template x-if="!listMode">
                        <x-enterprise.table-shell table-class="pending-base-table min-w-[980px]" datatable datatable-selectable>
                            <x-slot name="thead">
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Pilot</th>
                                    <th>BP Code</th>
                                    <th>BP Name</th>
                                    <th>Creation Date</th>
                                </tr>
                            </x-slot>

                            <x-slot name="tbody">
                                <template x-for="row in chooseResults" :key="row.id">
                                    <tr>
                                        <td x-text="row.id"></td>
                                        <td x-text="row.type"></td>
                                        <td x-text="row.pilot"></td>
                                        <td x-text="row.bp_code"></td>
                                        <td x-text="row.bp_name"></td>
                                        <td x-text="row.creation_date"></td>
                                    </tr>
                                </template>
                            </x-slot>
                        </x-enterprise.table-shell>
                    </template>

                    <template x-if="listMode">
                        <x-enterprise.table-shell table-class="pending-base-table min-w-[980px]" datatable datatable-selectable>
                            <x-slot name="thead">
                                <tr>
                                    <th>Code</th>
                                    <th>BP Name</th>
                                    <th>Creation Date</th>
                                    <th>Status</th>
                                    <th>Subject</th>
                                </tr>
                            </x-slot>

                            <x-slot name="tbody">
                                <template x-for="row in listResults" :key="row.code">
                                    <tr>
                                        <td x-text="row.code"></td>
                                        <td x-text="row.bp_name"></td>
                                        <td x-text="row.creation_date"></td>
                                        <td>
                                            <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700" x-text="row.status"></span>
                                        </td>
                                        <td class="max-w-[360px] whitespace-normal" x-text="row.subject"></td>
                                    </tr>
                                </template>
                            </x-slot>
                        </x-enterprise.table-shell>
                    </template>
                </x-enterprise.panel>
            </div>

            <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="btn-primary" x-show="activeTab !== 'result'" @click="searchActivities()">Search</button>
                    <div x-show="activeTab === 'result'" class="grid gap-2">
                        <span class="attach-field-label">Number of records found</span>
                        <input type="text" :value="resultCount()" class="input-field attach-input" readonly />
                    </div>
                </div>

                <div class="flex flex-wrap items-end gap-3">
                    <div class="grid gap-2" x-show="activeTab !== 'result'">
                        <span class="attach-field-label">Maximum number of records</span>
                        <input type="text" x-model="maxRecords" class="input-field attach-input w-24" />
                    </div>

                    <button type="button" class="btn-secondary" x-show="activeTab === 'result'" @click="chooseResult()">Choose</button>
                    <button type="button" class="btn-secondary" @click="cancelSearch()">Cancel</button>
                </div>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
