@extends('layouts.app')

@section('title', 'Search Contact Reports')

@php
    $customerRows = [
        ['code' => 'BP-001284', 'name' => 'Weststar Aviation Services'],
        ['code' => 'BP-001155', 'name' => 'Aero One Services'],
        ['code' => 'BP-000882', 'name' => 'Heli Support APAC'],
    ];

    $businessAgents = [
        ['code' => 'BA-001', 'first_name' => 'Ahmad', 'last_name' => 'Shahrul', 'role' => 'Manager'],
        ['code' => 'BA-002', 'first_name' => 'Nadiah', 'last_name' => 'Rahman', 'role' => 'Planner'],
        ['code' => 'BA-003', 'first_name' => 'Aina', 'last_name' => 'Karim', 'role' => 'Sales Employee'],
    ];

    $contactReportTypes = [
        ['type' => 'Contact report'],
        ['type' => 'Service follow-up'],
        ['type' => 'Escalation review'],
    ];

    $chooseResults = [
        ['id' => 'CR-2026-0418', 'type' => 'Contact report', 'pilot' => 'Shahrul', 'bp_code' => 'BP-001284', 'bp_name' => 'Weststar Aviation Services', 'creation_date' => '2026-04-06'],
        ['id' => 'CR-2026-0409', 'type' => 'Contact report', 'pilot' => 'Nadiah', 'bp_code' => 'BP-001155', 'bp_name' => 'Aero One Services', 'creation_date' => '2026-03-30'],
    ];

    $listResults = [
        ['code' => 'CR-2026-0418', 'bp_name' => 'Weststar Aviation Services', 'creation_date' => '2026-04-06', 'status' => 'Draft', 'subject' => 'Scheduled visit follow-up review'],
        ['code' => 'CR-2026-0409', 'bp_name' => 'Aero One Services', 'creation_date' => '2026-03-30', 'status' => 'Ready', 'subject' => 'Customer support planning visibility'],
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
            selectedType: 'Contact report',
            statusMode: 'both',
            listMode: false,
            customerProperties: false,
            createdByEnabled: false,
            closedByEnabled: false,
            lastUpdateByEnabled: false,
            originEnabled: false,
            pilotEnabled: false,
            userBranchEnabled: false,
            userDepartmentEnabled: false,
            maxRecords: 200,
            creationDateFrom: '2026-04-06',
            creationDateTo: '',
            visitDateFrom: '',
            visitDateTo: '',
            closeDateFrom: '',
            closeDateTo: '',
            lastUpdateDateFrom: '',
            lastUpdateDateTo: '',
            customerRows: @js($customerRows),
            businessAgents: @js($businessAgents),
            contactReportTypes: @js($contactReportTypes),
            chooseResults: @js($chooseResults),
            listResults: @js($listResults),
            togglePriority(level) {
                if (this.priority.includes(level)) {
                    this.priority = this.priority.filter((item) => item !== level);
                    return;
                }

                this.priority = [...this.priority, level];
            },
            searchReports() {
                this.activeTab = 'result';
                const count = this.listMode ? this.listResults.length : this.chooseResults.length;
                this.statusMessage = `Loaded ${count} contact report result(s).`;
                this.$nextTick(() => window.refreshFlowbiteTables?.());
            },
            resetSearch() {
                this.activeTab = 'general';
                this.idFrom = '';
                this.idTo = '';
                this.priority = ['medium'];
                this.selectedType = 'Contact report';
                this.statusMode = 'both';
                this.listMode = false;
                this.customerProperties = false;
                this.createdByEnabled = false;
                this.closedByEnabled = false;
                this.lastUpdateByEnabled = false;
                this.originEnabled = false;
                this.pilotEnabled = false;
                this.userBranchEnabled = false;
                this.userDepartmentEnabled = false;
                this.maxRecords = 200;
                this.creationDateFrom = '2026-04-06';
                this.creationDateTo = '';
                this.visitDateFrom = '';
                this.visitDateTo = '';
                this.closeDateFrom = '';
                this.closeDateTo = '';
                this.lastUpdateDateFrom = '';
                this.lastUpdateDateTo = '';
                this.statusMessage = 'Search filters reset to the default configuration.';
            },
            chooseResult() {
                this.statusMessage = 'Selected contact report from the current result set.';
            },
            toggleResultMode() {
                this.$nextTick(() => window.refreshFlowbiteTables?.());
            },
            cancelSearch() {
                this.statusMessage = 'Search session cancelled.';
            },
        }"
    >
        <x-page-header
            title="Search Contact Reports"
            description="Find contact reports using customer, origin, date, and property filters in the ATP search workspace."
        >
            <x-slot name="actions">
                <button type="button" class="btn-secondary" @click="resetSearch()">Reset</button>
            </x-slot>
        </x-page-header>

        <section class="attach-workspace-shell max-w-[1280px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
                <div class="subtab-shell">
                    <ul class="subtab-list">
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'general' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'general'">General</button>
                        </li>
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'date-origin' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'date-origin'">Date & Origin</button>
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
                                            <template x-for="row in customerRows" :key="row.code">
                                                <tr>
                                                    <td x-text="row.code"></td>
                                                    <td x-text="row.name"></td>
                                                </tr>
                                            </template>
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
                                            <template x-for="row in businessAgents" :key="row.code">
                                                <tr>
                                                    <td x-text="row.code"></td>
                                                    <td x-text="row.first_name"></td>
                                                    <td x-text="row.last_name"></td>
                                                    <td x-text="row.role"></td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </x-enterprise.panel>
                        </div>

                        <div class="space-y-4">
                            <x-enterprise.panel muted class="space-y-4">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <x-enterprise.field-row label="ID" for="search_contact_id_from" columns="sm:grid-cols-[40px_148px]">
                                        <input id="search_contact_id_from" type="text" x-model="idFrom" class="input-field attach-input" placeholder="From" />
                                    </x-enterprise.field-row>

                                    <x-enterprise.field-row label="To" for="search_contact_id_to" columns="sm:grid-cols-[24px_148px]">
                                        <input id="search_contact_id_to" type="text" x-model="idTo" class="input-field attach-input" />
                                    </x-enterprise.field-row>
                                </div>

                                <div class="space-y-2">
                                    <div class="attach-field-label">Priority</div>
                                    <div class="space-y-2">
                                        <label class="attach-checkbox-inline">
                                            <input type="checkbox" :checked="priority.includes('low')" @change="togglePriority('low')" />
                                            <span>Low</span>
                                        </label>
                                        <label class="attach-checkbox-inline">
                                            <input type="checkbox" :checked="priority.includes('medium')" @change="togglePriority('medium')" />
                                            <span>Medium</span>
                                        </label>
                                        <label class="attach-checkbox-inline">
                                            <input type="checkbox" :checked="priority.includes('high')" @change="togglePriority('high')" />
                                            <span>High</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <div class="attach-field-label">Contact Report Type</div>
                                    <div class="attach-table-shell max-h-[180px] overflow-auto">
                                        <table class="min-w-full border-collapse">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template x-for="row in contactReportTypes" :key="row.type">
                                                    <tr
                                                        class="cursor-pointer"
                                                        :class="{ 'bg-blue-50': selectedType === row.type }"
                                                        @click="selectedType = row.type"
                                                    >
                                                        <td x-text="row.type"></td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <div class="attach-field-label">Status</div>
                                    <div class="flex flex-wrap items-center gap-4">
                                        <label class="attach-checkbox-inline">
                                            <input type="radio" name="search_contact_status" value="opened" x-model="statusMode" />
                                            <span>Opened</span>
                                        </label>
                                        <label class="attach-checkbox-inline">
                                            <input type="radio" name="search_contact_status" value="closed" x-model="statusMode" />
                                            <span>Closed</span>
                                        </label>
                                        <label class="attach-checkbox-inline">
                                            <input type="radio" name="search_contact_status" value="both" x-model="statusMode" />
                                            <span>Both</span>
                                        </label>
                                        <label class="attach-checkbox-inline">
                                            <input type="checkbox" x-model="listMode" @change="toggleResultMode()" />
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
                    <div class="grid gap-5">
                        <div class="space-y-4">
                            <div class="grid grid-cols-[108px_156px_24px_156px_minmax(0,1fr)_40px] items-center gap-3">
                                <span class="attach-field-label">Creation date</span>
                                <x-date-picker id="search_contact_creation_from" x-model="creationDateFrom" />
                                <span class="attach-field-label">To</span>
                                <x-date-picker id="search_contact_creation_to" x-model="creationDateTo" />
                                <label class="attach-checkbox-inline">
                                    <input type="checkbox" x-model="createdByEnabled" />
                                    <span>Created By</span>
                                </label>
                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>

                            <div class="grid grid-cols-[108px_156px_24px_156px_minmax(0,1fr)_40px] items-center gap-3">
                                <span class="attach-field-label">Date of visit</span>
                                <x-date-picker id="search_contact_visit_from" x-model="visitDateFrom" />
                                <span class="attach-field-label">To</span>
                                <x-date-picker id="search_contact_visit_to" x-model="visitDateTo" />
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="grid grid-cols-[108px_156px_24px_156px_minmax(0,1fr)_40px] items-center gap-3">
                                <span class="attach-field-label">Close date</span>
                                <x-date-picker id="search_contact_close_from" x-model="closeDateFrom" />
                                <span class="attach-field-label">To</span>
                                <x-date-picker id="search_contact_close_to" x-model="closeDateTo" />
                                <label class="attach-checkbox-inline">
                                    <input type="checkbox" x-model="closedByEnabled" />
                                    <span>Closed By</span>
                                </label>
                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>

                            <div class="grid grid-cols-[108px_156px_24px_156px_minmax(0,1fr)_40px] items-center gap-3">
                                <span class="attach-field-label">Last Update date</span>
                                <x-date-picker id="search_contact_last_update_from" x-model="lastUpdateDateFrom" />
                                <span class="attach-field-label">To</span>
                                <x-date-picker id="search_contact_last_update_to" x-model="lastUpdateDateTo" />
                                <label class="attach-checkbox-inline">
                                    <input type="checkbox" x-model="lastUpdateByEnabled" />
                                    <span>Last Update By</span>
                                </label>
                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                        <div class="space-y-3">
                            <label class="attach-checkbox-inline">
                                <input type="checkbox" x-model="originEnabled" />
                                <span>Origin</span>
                            </label>
                            <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                        </div>

                        <div class="space-y-3">
                            <label class="attach-checkbox-inline">
                                <input type="checkbox" x-model="pilotEnabled" />
                                <span>Pilot</span>
                            </label>
                            <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                        </div>

                        <div class="space-y-3">
                            <label class="attach-checkbox-inline">
                                <input type="checkbox" x-model="userBranchEnabled" />
                                <span>User Branch</span>
                            </label>
                            <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                        </div>

                        <div class="space-y-3">
                            <label class="attach-checkbox-inline">
                                <input type="checkbox" x-model="userDepartmentEnabled" />
                                <span>User Department</span>
                            </label>
                            <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'properties'" class="space-y-5">
                <x-enterprise.panel class="space-y-4 min-h-[420px]">
                    <div>
                        <div class="text-sm font-semibold text-gray-900">Properties</div>
                        <p class="mt-1 text-sm text-gray-500">Additional property filters can be layered here for more advanced report selection.</p>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'result'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <div>
                        <div class="text-sm font-semibold text-gray-900">Result</div>
                        <p class="mt-1 text-sm text-gray-500" x-text="listMode ? 'List-style report results for browsing.' : 'Selectable report results for direct choosing.'"></p>
                    </div>

                    <template x-if="!listMode">
                        <x-enterprise.table-shell table-class="pending-base-table min-w-[1260px]" datatable datatable-selectable>
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
                        <x-enterprise.table-shell table-class="pending-base-table min-w-[1260px]" datatable datatable-selectable>
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
                    <button type="button" class="btn-primary" @click="searchReports()">Search</button>
                    <button type="button" class="btn-secondary" x-show="activeTab === 'result'" @click="chooseResult()">Choose</button>
                </div>

                <div class="flex flex-wrap items-end gap-3">
                    <div class="grid gap-2">
                        <span class="attach-field-label">Maximum number of records</span>
                        <input type="text" x-model="maxRecords" class="input-field attach-input w-24" />
                    </div>
                    <button type="button" class="btn-secondary" @click="cancelSearch()">Cancel</button>
                </div>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
