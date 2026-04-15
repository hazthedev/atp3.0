@extends('layouts.app')

@section('title', 'Search Information On Repair events')

@php
    $customerRows = [
        ['#' => 1, 'code' => '300028', 'name' => 'WESTSTAR'],
    ];

    $agentRows = [
        ['#' => 1, 'code' => 'BA-001', 'first' => 'Mohd Amirul', 'last' => 'Bakri Bin Abd. Halim', 'role' => 'Manager'],
    ];

    $chooseResults = [
        ['id' => '131730', 'ext' => 'WASSB/31336/1816', 'type' => 'Info On Repair', 'cust_code' => '300028', 'customer_name' => '*WESTSTAR', 'object_type' => 'Functional Location', 'object_ref' => '9M-WDV'],
        ['id' => '131729', 'ext' => 'WASSB/31336/1815', 'type' => 'Info On Repair', 'cust_code' => '300028', 'customer_name' => '*WESTSTAR', 'object_type' => 'Functional Location', 'object_ref' => '9M-WDV'],
        ['id' => '131728', 'ext' => 'WASSB/31336/1814', 'type' => 'Info On Repair', 'cust_code' => '300028', 'customer_name' => '*WESTSTAR', 'object_type' => 'Functional Location', 'object_ref' => '9M-WDV'],
        ['id' => '131727', 'ext' => 'WASSB/31362/1813', 'type' => 'Info On Repair', 'cust_code' => '300028', 'customer_name' => '*WESTSTAR', 'object_type' => 'Functional Location', 'object_ref' => '9M-WAB'],
    ];

    $objectResults = [
        ['object_ref' => '9M-WAD', 'item_code' => 'AW139', 'serial_number' => '31336', 'category' => 'M104-01', 'subject' => 'WASSB/31336/1816 - PORTA'],
        ['object_ref' => '9M-WAD', 'item_code' => 'AW139', 'serial_number' => '31336', 'category' => 'M104-01', 'subject' => 'WASSB/31336/1815 - 32-12 L'],
        ['object_ref' => '9M-WAO', 'item_code' => 'AW139', 'serial_number' => '31419', 'category' => '9M-WAO', 'subject' => 'WASSB/31419/1953 - ACCP'],
        ['object_ref' => '9M-WBI', 'item_code' => 'AW139', 'serial_number' => '41558', 'category' => '9M-WBI', 'subject' => 'WASSB/41558/0042 - ACCP'],
    ];

    $statusResults = [
        ['marker' => '', 'status' => 'Open', 'creation_date' => '17.12.25', 'closure_date' => '', 'assignee' => 'Mohd Amirul Bakri Bin Abd. Halim', 'queue' => '', 'bp_level' => ''],
        ['marker' => '', 'status' => 'Open', 'creation_date' => '17.12.25', 'closure_date' => '', 'assignee' => 'Mohd Amirul Bakri Bin Abd. Halim', 'queue' => '', 'bp_level' => ''],
        ['marker' => 'SP]', 'status' => 'Open', 'creation_date' => '17.12.25', 'closure_date' => '', 'assignee' => 'Nur Husnina Binti Muhamad Zuraidi', 'queue' => '', 'bp_level' => ''],
        ['marker' => '', 'status' => 'Open', 'creation_date' => '17.12.25', 'closure_date' => '', 'assignee' => 'Nur Husnina Binti Muhamad Zuraidi', 'queue' => '', 'bp_level' => ''],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            activeTab: 'general',
            resultView: 'summary',
            maxRecords: 200,
            statusMessage: '',
            selectedType: 'Info On Repair',
            chooseResults: @js($chooseResults),
            objectResults: @js($objectResults),
            statusResults: @js($statusResults),
            search() {
                this.activeTab = 'result';
                const counts = {
                    summary: this.chooseResults.length,
                    object: this.objectResults.length,
                    status: this.statusResults.length,
                };
                this.statusMessage = `Loaded ${counts[this.resultView]} repair event result(s).`;
                this.$nextTick(() => window.refreshFlowbiteTables?.());
            },
            reset() {
                this.activeTab = 'general';
                this.resultView = 'summary';
                this.maxRecords = 200;
                this.statusMessage = 'Repair-event search filters reset to the default configuration.';
            },
            cancelSearch() {
                this.statusMessage = 'Repair-event search cancelled.';
            },
        }"
    >
        <x-page-header
            title="Search Information On Repair events"
            description="Search repair events using customer, origin, object, property, and miscellaneous filters in the ATP MRO workspace."
        >
            <x-slot name="actions">
                <button type="button" class="btn-secondary" @click="reset()">Reset</button>
            </x-slot>
        </x-page-header>

        <section class="attach-workspace-shell max-w-[1380px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
                <div class="subtab-shell">
                    <ul class="subtab-list">
                        @foreach (['general' => 'General', 'date-origin' => 'Date & Origin', 'object-info' => 'Object Info', 'properties' => 'Properties', 'miscellaneous' => 'Miscellaneous', 'result' => 'Result'] as $key => $label)
                            <li class="subtab-item">
                                <button
                                    type="button"
                                    class="subtab-link"
                                    :class="activeTab === '{{ $key }}' ? 'subtab-link-active' : 'subtab-link-inactive'"
                                    @click="activeTab = '{{ $key }}'; $nextTick(() => window.refreshFlowbiteTables?.())"
                                >{{ $label }}</button>
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
                                <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable>
                                    <x-slot name="thead">
                                        <tr><th>#</th><th>Code</th><th>Name</th></tr>
                                    </x-slot>
                                    <x-slot name="tbody">
                                        @foreach ($customerRows as $row)
                                            <tr><td>{{ $row['#'] }}</td><td>{{ $row['code'] }}</td><td>{{ $row['name'] }}</td></tr>
                                        @endforeach
                                    </x-slot>
                                </x-enterprise.table-shell>
                                <div class="flex flex-wrap items-center gap-3">
                                    <label class="attach-checkbox-inline"><input type="checkbox" /><span>Customer Properties</span></label>
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                            </x-enterprise.panel>

                            <x-enterprise.panel muted class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Business Agent</div>
                                <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable>
                                    <x-slot name="thead">
                                        <tr><th>#</th><th>Code</th><th>First Name</th><th>Last Name</th><th>Role</th></tr>
                                    </x-slot>
                                    <x-slot name="tbody">
                                        @foreach ($agentRows as $row)
                                            <tr><td>{{ $row['#'] }}</td><td>{{ $row['code'] }}</td><td>{{ $row['first'] }}</td><td>{{ $row['last'] }}</td><td>{{ $row['role'] }}</td></tr>
                                        @endforeach
                                    </x-slot>
                                </x-enterprise.table-shell>
                            </x-enterprise.panel>
                        </div>

                        <div class="space-y-4">
                            <x-enterprise.panel muted class="space-y-4">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <x-enterprise.field-row label="ID" for="repair_id_from" columns="sm:grid-cols-[40px_148px]">
                                        <input id="repair_id_from" type="text" class="input-field attach-input" placeholder="From" />
                                    </x-enterprise.field-row>
                                    <x-enterprise.field-row label="To" for="repair_id_to" columns="sm:grid-cols-[24px_148px]">
                                        <input id="repair_id_to" type="text" class="input-field attach-input" />
                                    </x-enterprise.field-row>
                                </div>

                                <div class="space-y-2">
                                    <div class="attach-field-label">Priority</div>
                                    @foreach (['Low', 'Medium', 'High'] as $priority)
                                        <label class="attach-checkbox-inline"><input type="checkbox" /><span>{{ $priority }}</span></label>
                                    @endforeach
                                </div>

                                <div class="space-y-3">
                                    <div class="attach-field-label">Status</div>
                                    <div class="flex flex-wrap items-center gap-4">
                                        @foreach (['Opened', 'Closed', 'Both'] as $status)
                                            <label class="attach-checkbox-inline"><input type="radio" name="repair_status" @if($status === 'Both') checked @endif /><span>{{ $status }}</span></label>
                                        @endforeach
                                        <label class="attach-checkbox-inline"><input type="checkbox" /><span>List</span></label>
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
                            @foreach (['Created On', 'Closed On', 'Resolved On', 'Event Start On', 'Event End On'] as $label)
                                <div class="grid items-center gap-3 [grid-template-columns:120px_156px_24px_156px]">
                                    <span class="attach-field-label">{{ $label }}</span>
                                    <x-date-picker :id="'repair_'.\Illuminate\Support\Str::slug($label, '_').'_from'" />
                                    <span class="attach-field-label">To</span>
                                    <x-date-picker :id="'repair_'.\Illuminate\Support\Str::slug($label, '_').'_to'" />
                                </div>
                            @endforeach

                            @foreach (['Created By', 'Closed By', 'Assignee', 'Queue', 'Technician', 'Origin'] as $toggle)
                                <div class="flex flex-wrap items-center gap-3">
                                    <label class="attach-checkbox-inline"><input type="checkbox" /><span>{{ $toggle }}</span></label>
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-4">
                            @foreach (['AOG', 'Complaint', 'In Service Event', 'Warranty', 'Noria', 'Technical Event'] as $field)
                                <x-enterprise.field-row :label="$field" :for="'repair_'.\Illuminate\Support\Str::slug($field, '_')" columns="sm:grid-cols-[132px_180px]">
                                    <select :id="'repair_'.\Illuminate\Support\Str::slug($field, '_')" class="input-field attach-input">
                                        <option>Any</option>
                                        <option>Yes</option>
                                        <option>No</option>
                                    </select>
                                </x-enterprise.field-row>
                            @endforeach
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'object-info'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_360px]">
                        <div class="space-y-4">
                            <x-enterprise.field-row label="Equipment Code" for="repair_equipment_code" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><input id="repair_equipment_code" type="text" class="input-field attach-input" /></x-enterprise.field-row>
                            <x-enterprise.field-row label="Serial Number" for="repair_serial_number" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><input id="repair_serial_number" type="text" class="input-field attach-input" /></x-enterprise.field-row>
                            <x-enterprise.lookup-row label="Item No." for="repair_item_no" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><div class="attach-inline-control"><input id="repair_item_no" type="text" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                            <x-enterprise.field-row label="Part Description" for="repair_part_description" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><input id="repair_part_description" type="text" class="input-field attach-input" /></x-enterprise.field-row>

                            @foreach (['Variant', 'Category Part', 'Item Group'] as $toggle)
                                <div class="flex flex-wrap items-center gap-3">
                                    <label class="attach-checkbox-inline"><input type="checkbox" /><span>{{ $toggle }}</span></label>
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                            @endforeach

                            <div class="space-y-2 pt-2">
                                <div class="text-sm font-semibold text-gray-900">Functional Location</div>
                                <x-enterprise.field-row label="Serial Number" for="repair_fl_serial" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><input id="repair_fl_serial" type="text" class="input-field attach-input" /></x-enterprise.field-row>
                                <x-enterprise.field-row label="Registration" for="repair_registration" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><input id="repair_registration" type="text" class="input-field attach-input" /></x-enterprise.field-row>
                                <div class="flex flex-wrap items-center gap-3">
                                    <label class="attach-checkbox-inline"><input type="checkbox" /><span>Type</span></label>
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <x-enterprise.panel muted class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Chapter - Section - Subject - Sheet - Mark</div>
                                <div class="grid grid-cols-5 gap-2">
                                    @foreach (['Chapter', 'Section', 'Subject', 'Sheet', 'Mark'] as $part)
                                        <input type="text" class="input-field attach-input" placeholder="{{ $part }}" />
                                    @endforeach
                                </div>
                            </x-enterprise.panel>

                            <div class="space-y-2">
                                @foreach (['With Item Code Attached', 'With Equipment Attached', 'With Functional Location Attached'] as $toggle)
                                    <label class="attach-checkbox-inline"><input type="checkbox" /><span>{{ $toggle }}</span></label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'properties'" class="space-y-5">
                <x-enterprise.panel class="space-y-4 min-h-[320px]">
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'miscellaneous'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
                        <div class="space-y-4">
                            @foreach (['Mission Type', 'Return Reason', 'Problem Type', 'Sub Problem Type', 'Environment Type'] as $toggle)
                                <div class="flex flex-wrap items-center gap-3">
                                    <label class="attach-checkbox-inline"><input type="checkbox" /><span>{{ $toggle }}</span></label>
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                            @endforeach

                            <x-enterprise.field-row label="External Ref." for="repair_external_ref" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><input id="repair_external_ref" type="text" class="input-field attach-input" /></x-enterprise.field-row>
                            <x-enterprise.field-row label="Words in Remark Field" for="repair_words" columns="sm:grid-cols-[112px_minmax(0,1fr)]"><textarea id="repair_words" rows="4" class="input-field attach-textarea"></textarea></x-enterprise.field-row>

                            <div class="grid items-center gap-x-3 gap-y-2.5 [grid-template-columns:minmax(0,1fr)_180px]">
                                <select class="input-field attach-input"><option>Field</option><option>Status</option><option>Queue</option></select>
                                <input type="text" class="input-field attach-input" placeholder="Value" />
                                <select class="input-field attach-input"><option>Field</option><option>Assignee</option><option>Priority</option></select>
                                <input type="text" class="input-field attach-input" placeholder="Value" />
                            </div>
                        </div>

                        <div class="space-y-4">
                            <x-enterprise.panel muted class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Father</div>
                                <x-enterprise.field-row label="Object Type" for="repair_father_type" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                                    <select id="repair_father_type" class="input-field attach-input">
                                        <option>Repair Event</option>
                                        <option>Work Order</option>
                                        <option>Observation</option>
                                    </select>
                                </x-enterprise.field-row>
                                <x-enterprise.field-row label="Code" for="repair_father_code" columns="sm:grid-cols-[96px_minmax(0,1fr)]"><input id="repair_father_code" type="text" class="input-field attach-input" /></x-enterprise.field-row>
                            </x-enterprise.panel>

                            @foreach (['BP Perception Level', 'Intervention Type'] as $toggle)
                                <div class="flex flex-wrap items-center gap-3">
                                    <label class="attach-checkbox-inline"><input type="checkbox" /><span>{{ $toggle }}</span></label>
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'result'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" class="btn-secondary" :class="resultView === 'summary' ? 'bg-blue-600 border-blue-600 text-white' : ''" @click="resultView = 'summary'; $nextTick(() => window.refreshFlowbiteTables?.())">Summary</button>
                        <button type="button" class="btn-secondary" :class="resultView === 'object' ? 'bg-blue-600 border-blue-600 text-white' : ''" @click="resultView = 'object'; $nextTick(() => window.refreshFlowbiteTables?.())">Object</button>
                        <button type="button" class="btn-secondary" :class="resultView === 'status' ? 'bg-blue-600 border-blue-600 text-white' : ''" @click="resultView = 'status'; $nextTick(() => window.refreshFlowbiteTables?.())">Status</button>
                    </div>

                    <template x-if="resultView === 'summary'">
                        <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1180px]" datatable datatable-selectable>
                            <x-slot name="thead">
                                <tr>
                                    <th>ID</th>
                                    <th>Ext. Ref.</th>
                                    <th>Type</th>
                                    <th>Cust. Code</th>
                                    <th>Customer Name</th>
                                    <th>Object Type</th>
                                    <th>Object Ref</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                @foreach ($chooseResults as $row)
                                    <tr>
                                        <td>{{ $row['id'] }}</td>
                                        <td>{{ $row['ext'] }}</td>
                                        <td>{{ $row['type'] }}</td>
                                        <td>{{ $row['cust_code'] }}</td>
                                        <td>{{ $row['customer_name'] }}</td>
                                        <td>{{ $row['object_type'] }}</td>
                                        <td>{{ $row['object_ref'] }}</td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-enterprise.table-shell>
                    </template>

                    <template x-if="resultView === 'object'">
                        <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1180px]" datatable datatable-selectable>
                            <x-slot name="thead">
                                <tr>
                                    <th>Object Ref</th>
                                    <th>Item Code/FL Type/Qty</th>
                                    <th>Serial Number</th>
                                    <th>Categ. Part/Registration</th>
                                    <th>Subject</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                @foreach ($objectResults as $row)
                                    <tr>
                                        <td>{{ $row['object_ref'] }}</td>
                                        <td>{{ $row['item_code'] }}</td>
                                        <td>{{ $row['serial_number'] }}</td>
                                        <td>{{ $row['category'] }}</td>
                                        <td>{{ $row['subject'] }}</td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-enterprise.table-shell>
                    </template>

                    <template x-if="resultView === 'status'">
                        <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1180px]" datatable datatable-selectable>
                            <x-slot name="thead">
                                <tr>
                                    <th data-sortable="false"></th>
                                    <th>Status</th>
                                    <th>Creation Date</th>
                                    <th>Closure Date</th>
                                    <th>Assignee</th>
                                    <th>Queue</th>
                                    <th>BP Perception Level</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                @foreach ($statusResults as $row)
                                    <tr>
                                        <td>{{ $row['marker'] }}</td>
                                        <td>{{ $row['status'] }}</td>
                                        <td>{{ $row['creation_date'] }}</td>
                                        <td>{{ $row['closure_date'] ?: '-' }}</td>
                                        <td>{{ $row['assignee'] }}</td>
                                        <td>{{ $row['queue'] ?: '-' }}</td>
                                        <td>{{ $row['bp_level'] ?: '-' }}</td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-enterprise.table-shell>
                    </template>
                </x-enterprise.panel>
            </div>

            <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="btn-primary" @click="search()">Search</button>
                </div>

                <div class="flex flex-wrap items-end gap-3">
                    <div class="grid gap-2">
                        <span class="attach-field-label">Maximum number of records</span>
                        <input type="text" x-model="maxRecords" class="input-field attach-input" />
                    </div>
                    <button type="button" class="btn-secondary" x-show="activeTab === 'result'">Choose</button>
                    <button type="button" class="btn-secondary" @click="cancelSearch()">Cancel</button>
                </div>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
