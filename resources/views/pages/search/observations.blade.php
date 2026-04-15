@extends('layouts.app')

@section('title', 'Search Observations')

@php
    $customerRows = [['#' => 1, 'code' => 'BP-001284', 'name' => 'Weststar Aviation Services'], ['#' => 2, 'code' => 'BP-001155', 'name' => 'Aero One Services']];
    $agentRows = [['#' => 1, 'code' => 'BA-001', 'first' => 'Ahmad', 'last' => 'Shahrul', 'role' => 'Manager'], ['#' => 2, 'code' => 'BA-002', 'first' => 'Nadiah', 'last' => 'Rahman', 'role' => 'Planner']];
    $types = ['Technical Event', 'Complaint', 'Warranty', 'In Service Event'];
    $dateRows = ['Created On', 'Closed On', 'Due Date', 'Event Start On', 'Event End On'];
    $dateToggles = ['Created By', 'Closed By', 'Assignee', 'Queue', 'Technician', 'Origin'];
    $objectToggles = ['Variant', 'Category Part', 'Item Group'];
    $attachToggles = ['With Item Code Attached', 'With Equipment Attached', 'With Functional Location Attached'];
    $miscToggles = ['Mission Type', 'Return Reason', 'Problem Type', 'Sub Problem Type', 'Environment Type'];
    $rightMiscToggles = ['BP Perception Level', 'Intervention Type', 'User Department', 'User Branch'];
    $chooseResults = [
        ['id' => 'OBS-240418', 'ext' => 'EXT-8821', 'type' => 'Technical Event', 'cust' => 'BP-001284', 'name' => 'Weststar Aviation Services', 'equi' => 'EQ-000184', 'item' => 'A139-27-118', 'serial' => 'MR-31324', 'subject' => 'Pending component availability', 'status' => 'Open'],
        ['id' => 'OBS-240409', 'ext' => 'EXT-8802', 'type' => 'Complaint', 'cust' => 'BP-001155', 'name' => 'Aero One Services', 'equi' => 'EQ-000245', 'item' => 'A189-53-220', 'serial' => 'SPK-44191', 'subject' => 'Cabin speaker planning alignment', 'status' => 'In Progress'],
    ];
    $listResults = [
        ['code' => 'OBS-240418', 'serial' => 'MR-31324', 'subject' => 'Pending component availability', 'status' => 'Open', 'created' => '2026-04-06', 'closed' => '-', 'assignee' => 'Support Team', 'queue' => 'Customer', 'bp' => 'Attention Needed'],
        ['code' => 'OBS-240409', 'serial' => 'SPK-44191', 'subject' => 'Cabin speaker planning alignment', 'status' => 'In Progress', 'created' => '2026-03-30', 'closed' => '-', 'assignee' => 'Material Control', 'queue' => 'Planning', 'bp' => 'Neutral'],
    ];
@endphp

@section('content')
    <div class="space-y-6" x-data="{ activeTab: 'general', listMode: false, maxRecords: 200, selectedType: 'Technical Event', statusMessage: '', chooseResults: @js($chooseResults), listResults: @js($listResults), search() { this.activeTab = 'result'; this.statusMessage = `Loaded ${(this.listMode ? this.listResults : this.chooseResults).length} observation result(s).`; this.$nextTick(() => window.refreshFlowbiteTables?.()); }, reset() { this.activeTab = 'general'; this.listMode = false; this.maxRecords = 200; this.selectedType = 'Technical Event'; this.statusMessage = 'Observation search filters reset to the default configuration.'; }, refreshResultTables() { this.$nextTick(() => window.refreshFlowbiteTables?.()); } }">
        <x-page-header title="Search Observations" description="Find observations using customer, date, object, property, and miscellaneous filters in the ATP search workspace.">
            <x-slot name="actions"><button type="button" class="btn-secondary" @click="reset()">Reset</button></x-slot>
        </x-page-header>

        <section class="attach-workspace-shell max-w-[1320px] space-y-5">
            <template x-if="statusMessage"><div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div></template>

            <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
                <div class="subtab-shell">
                    <ul class="subtab-list">
                        @foreach (['general' => 'General', 'date-origin' => 'Date & Origin', 'object-info' => 'Object Info', 'properties' => 'Properties', 'miscellaneous' => 'Miscellaneous', 'result' => 'Result'] as $key => $label)
                            <li class="subtab-item"><button type="button" class="subtab-link" :class="activeTab === '{{ $key }}' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = '{{ $key }}'">{{ $label }}</button></li>
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
                                        <thead><tr><th>#</th><th>Code</th><th>Name</th></tr></thead>
                                        <tbody>@foreach ($customerRows as $row)<tr><td>{{ $row['#'] }}</td><td>{{ $row['code'] }}</td><td>{{ $row['name'] }}</td></tr>@endforeach</tbody>
                                    </table>
                                </div>
                                <div class="flex flex-wrap items-center gap-3"><label class="attach-checkbox-inline"><input type="checkbox" /><span>Customer Properties</span></label><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div>
                            </x-enterprise.panel>
                            <x-enterprise.panel muted class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Business Agent</div>
                                <div class="attach-table-shell max-h-[220px] overflow-auto">
                                    <table class="min-w-full border-collapse">
                                        <thead><tr><th>#</th><th>Code</th><th>First Name</th><th>Last Name</th><th>Role</th></tr></thead>
                                        <tbody>@foreach ($agentRows as $row)<tr><td>{{ $row['#'] }}</td><td>{{ $row['code'] }}</td><td>{{ $row['first'] }}</td><td>{{ $row['last'] }}</td><td>{{ $row['role'] }}</td></tr>@endforeach</tbody>
                                    </table>
                                </div>
                            </x-enterprise.panel>
                        </div>

                        <div class="space-y-4">
                            <x-enterprise.panel muted class="space-y-4">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <x-enterprise.field-row label="ID" for="obs_id_from" columns="sm:grid-cols-[40px_148px]"><input id="obs_id_from" type="text" class="input-field attach-input" placeholder="From" /></x-enterprise.field-row>
                                    <x-enterprise.field-row label="To" for="obs_id_to" columns="sm:grid-cols-[24px_148px]"><input id="obs_id_to" type="text" class="input-field attach-input" /></x-enterprise.field-row>
                                </div>
                                <div class="space-y-2">
                                    <div class="attach-field-label">Priority</div>
                                    @foreach (['Low', 'Medium', 'High'] as $priority)
                                        <label class="attach-checkbox-inline"><input type="checkbox" @if($priority === 'Medium') checked @endif /><span>{{ $priority }}</span></label>
                                    @endforeach
                                </div>
                                <div class="space-y-3">
                                    <div class="attach-field-label">Observations Type</div>
                                    <div class="attach-table-shell max-h-[180px] overflow-auto">
                                        <table class="min-w-full border-collapse">
                                            <thead><tr><th>Type</th></tr></thead>
                                            <tbody>@foreach ($types as $type)<tr class="cursor-pointer" :class="{ 'bg-blue-50': selectedType === '{{ $type }}' }" @click="selectedType = '{{ $type }}'"><td>{{ $type }}</td></tr>@endforeach</tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <div class="attach-field-label">Status</div>
                                    <div class="flex flex-wrap items-center gap-4">
                                        @foreach (['Opened', 'Closed', 'Both'] as $status)<label class="attach-checkbox-inline"><input type="radio" name="obs_status" @if($status === 'Both') checked @endif /><span>{{ $status }}</span></label>@endforeach
                                        <label class="attach-checkbox-inline"><input type="checkbox" x-model="listMode" @change="refreshResultTables()" /><span>List</span></label>
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
                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_360px]">
                        <div class="space-y-4">
                            @foreach ($dateRows as $label)
                                <div class="grid grid-cols-[120px_156px_24px_156px] items-center gap-3"><span class="attach-field-label">{{ $label }}</span><x-date-picker :id="'obs_'.\Illuminate\Support\Str::slug($label, '_').'_from'" /><span class="attach-field-label">To</span><x-date-picker :id="'obs_'.\Illuminate\Support\Str::slug($label, '_').'_to'" /></div>
                            @endforeach
                            @foreach ($dateToggles as $toggle)
                                <div class="flex flex-wrap items-center gap-3"><label class="attach-checkbox-inline"><input type="checkbox" /><span>{{ $toggle }}</span></label><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div>
                            @endforeach
                        </div>
                        <div class="space-y-4">
                            @foreach (['AOG', 'Complaint', 'In Service Event', 'Warranty', 'Noria', 'Technical Event'] as $field)
                                <x-enterprise.field-row :label="$field" :for="'obs_'.\Illuminate\Support\Str::slug($field, '_')" columns="sm:grid-cols-[132px_180px]"><select :id="'obs_'.\Illuminate\Support\Str::slug($field, '_')" class="input-field attach-input"><option>Any</option><option>Yes</option><option>No</option></select></x-enterprise.field-row>
                            @endforeach
                        </div>
                    </div>
                    <x-enterprise.field-row label="Maximum Remaining Days before target date" for="obs_max_days" columns="sm:grid-cols-[280px_180px]"><select id="obs_max_days" class="input-field attach-input"><option>Not set</option><option>3</option><option>7</option><option>14</option></select></x-enterprise.field-row>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'object-info'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_360px]">
                        <div class="space-y-4">
                            <x-enterprise.lookup-row label="Equipment Code" for="obs_equipment_code" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><div class="attach-inline-control"><input id="obs_equipment_code" type="text" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                            <x-enterprise.field-row label="Serial Number" for="obs_serial_number" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><input id="obs_serial_number" type="text" class="input-field attach-input" /></x-enterprise.field-row>
                            <x-enterprise.lookup-row label="Item No." for="obs_item_no" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><div class="attach-inline-control"><input id="obs_item_no" type="text" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                            <x-enterprise.field-row label="Part Description" for="obs_part_description" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><input id="obs_part_description" type="text" class="input-field attach-input" /></x-enterprise.field-row>
                            @foreach ($objectToggles as $toggle)
                                <div class="flex flex-wrap items-center gap-3"><label class="attach-checkbox-inline"><input type="checkbox" /><span>{{ $toggle }}</span></label><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div>
                            @endforeach
                            <div class="space-y-2 pt-2">
                                <div class="text-sm font-semibold text-gray-900">Functional Location</div>
                                <x-enterprise.field-row label="Serial Number" for="obs_fl_serial" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><input id="obs_fl_serial" type="text" class="input-field attach-input" /></x-enterprise.field-row>
                                <x-enterprise.field-row label="Registration" for="obs_registration" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><input id="obs_registration" type="text" class="input-field attach-input" /></x-enterprise.field-row>
                                <div class="flex flex-wrap items-center gap-3"><label class="attach-checkbox-inline"><input type="checkbox" /><span>Type</span></label><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <x-enterprise.panel muted class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Chapter / Section / Subject / Sheet / Mark</div>
                                <div class="grid grid-cols-5 gap-2">@foreach (['Chapter', 'Section', 'Subject', 'Sheet', 'Mark'] as $part)<input type="text" class="input-field attach-input" placeholder="{{ $part }}" />@endforeach</div>
                            </x-enterprise.panel>
                            <div class="space-y-2">@foreach ($attachToggles as $toggle)<label class="attach-checkbox-inline"><input type="checkbox" /><span>{{ $toggle }}</span></label>@endforeach</div>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'properties'" class="space-y-5"><x-enterprise.panel class="space-y-4 min-h-[420px]"><p class="text-sm text-gray-600">You have to choose one observation to see the properties.</p></x-enterprise.panel></div>

            <div x-cloak x-show="activeTab === 'miscellaneous'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
                        <div class="space-y-4">
                            @foreach ($miscToggles as $toggle)
                                <div class="flex flex-wrap items-center gap-3"><label class="attach-checkbox-inline"><input type="checkbox" /><span>{{ $toggle }}</span></label><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div>
                            @endforeach
                            <x-enterprise.field-row label="External Ref." for="obs_external_ref" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><input id="obs_external_ref" type="text" class="input-field attach-input" /></x-enterprise.field-row>
                            <x-enterprise.field-row label="Words in Remark Field" for="obs_words" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><textarea id="obs_words" rows="4" class="input-field attach-textarea"></textarea></x-enterprise.field-row>
                            <div class="grid grid-cols-[minmax(0,1fr)_180px] items-center gap-x-3 gap-y-2">
                                <select class="input-field attach-input"><option>Subject</option><option>Status</option><option>Queue</option></select>
                                <input type="text" class="input-field attach-input" placeholder="Value" />
                                <select class="input-field attach-input"><option>Queue</option><option>Assignee</option><option>Priority</option></select>
                                <input type="text" class="input-field attach-input" placeholder="Value" />
                            </div>
                        </div>
                        <div class="space-y-4">
                            <x-enterprise.panel muted class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Father</div>
                                <x-enterprise.field-row label="Object Type" for="obs_father_type" columns="sm:grid-cols-[96px_minmax(0,1fr)]"><select id="obs_father_type" class="input-field attach-input"><option>Observation</option><option>Contact Report</option><option>Scheduled Visit</option></select></x-enterprise.field-row>
                                <x-enterprise.field-row label="Code" for="obs_father_code" columns="sm:grid-cols-[96px_minmax(0,1fr)]"><input id="obs_father_code" type="text" class="input-field attach-input" /></x-enterprise.field-row>
                            </x-enterprise.panel>
                            @foreach ($rightMiscToggles as $toggle)
                                <div class="flex flex-wrap items-center gap-3"><label class="attach-checkbox-inline"><input type="checkbox" /><span>{{ $toggle }}</span></label><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div>
                            @endforeach
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'result'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <div><div class="text-sm font-semibold text-gray-900">Result</div><p class="mt-1 text-sm text-gray-500" x-text="listMode ? 'List-style observation results for browsing.' : 'Selectable observation results for direct choosing.'"></p></div>
                    <template x-if="!listMode">
                        <x-enterprise.table-shell table-class="pending-base-table min-w-[1260px]" datatable datatable-selectable>
                            <x-slot name="thead"><tr><th>ID</th><th>Ext. Ref.</th><th>Type</th><th>Cust. Code</th><th>Customer Name</th><th>Equi. ID</th><th>Item Code</th><th>Serial Number</th><th>Subject</th><th>Status</th></tr></x-slot>
                            <x-slot name="tbody"><template x-for="row in chooseResults" :key="row.id"><tr><td x-text="row.id"></td><td x-text="row.ext"></td><td x-text="row.type"></td><td x-text="row.cust"></td><td x-text="row.name"></td><td x-text="row.equi"></td><td x-text="row.item"></td><td x-text="row.serial"></td><td class="max-w-[280px] whitespace-normal" x-text="row.subject"></td><td><span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700" x-text="row.status"></span></td></tr></template></x-slot>
                        </x-enterprise.table-shell>
                    </template>
                    <template x-if="listMode">
                        <x-enterprise.table-shell table-class="pending-base-table min-w-[1260px]" datatable datatable-selectable>
                            <x-slot name="thead"><tr><th>Code</th><th>Serial Number</th><th>Subject</th><th>Status</th><th>Creation Date</th><th>Closure Date</th><th>Assignee</th><th>Queue</th><th>BP Perception Level</th></tr></x-slot>
                            <x-slot name="tbody"><template x-for="row in listResults" :key="row.code"><tr><td x-text="row.code"></td><td x-text="row.serial"></td><td class="max-w-[280px] whitespace-normal" x-text="row.subject"></td><td><span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700" x-text="row.status"></span></td><td x-text="row.created"></td><td x-text="row.closed"></td><td x-text="row.assignee"></td><td x-text="row.queue"></td><td x-text="row.bp"></td></tr></template></x-slot>
                        </x-enterprise.table-shell>
                    </template>
                </x-enterprise.panel>
            </div>

            <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="btn-primary" @click="search()">Search</button>
                    <button type="button" class="btn-secondary" x-show="activeTab === 'result'">Choose</button>
                </div>
                <div class="flex flex-wrap items-end gap-3">
                    <div class="grid gap-2"><span class="attach-field-label">Maximum number of records</span><input type="text" x-model="maxRecords" class="input-field attach-input w-24" /></div>
                    <button type="button" class="btn-secondary" @click="cancelSearch()">Cancel</button>
                </div>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
