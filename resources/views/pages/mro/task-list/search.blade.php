@extends('layouts.app')

@section('title', 'Search Task List')

@php
    $parentTaskLists = [
        ['reference' => 'TL-AW139-001', 'description' => 'AW139 Engine Inspection Package'],
        ['reference' => 'TL-AW139-114', 'description' => 'Tail rotor recurring lubrication'],
    ];

    $childTaskLists = [
        ['reference' => 'TL-AW139-221', 'description' => 'Fuel filter recurring replacement'],
        ['reference' => 'TL-AW139-318', 'description' => 'Cabin equipment verification'],
    ];

    $linkedTaskLists = [
        ['reference' => 'TL-AW139-411', 'description' => 'Landing gear interval reset', 'type' => 'Predecessor'],
        ['reference' => 'TL-AW139-512', 'description' => 'Rotor blade balancing check', 'type' => 'Follower'],
    ];

    $damageRows = [
        ['type' => 'Corrosion', 'desc_1' => 'Surface oxidation', 'localization' => 'Door frame', 'desc_2' => 'Left hand side', 'gravity' => 'Medium', 'desc_3' => 'Requires treatment'],
        ['type' => 'Wear', 'desc_1' => 'Fastener elongation', 'localization' => 'Upper cowling', 'desc_2' => 'Panel hinge line', 'gravity' => 'Low', 'desc_3' => 'Monitor next visit'],
    ];

    $counterRows = [
        ['counter_type' => 'Flight Hours', 'first_value_dec' => '0.0000', 'first_value_time' => '00:00', 'interval_dec' => '250.0000', 'interval_time' => '250:00', 'cutoff_dec' => '15.0000', 'cutoff_time' => '15:00'],
        ['counter_type' => 'Flight Cycles', 'first_value_dec' => '0.0000', 'first_value_time' => '', 'interval_dec' => '180.0000', 'interval_time' => '', 'cutoff_dec' => '10.0000', 'cutoff_time' => ''],
    ];

    $resultRows = [
        ['reference' => 'AW139 1200H Checks', 'type' => '', 'ata_code' => '', 'short_description' => '1200HRS INSPEC', 'action_type' => 'INSP', 'status' => 'Released', 'external_ref' => ''],
        ['reference' => 'AW139 2YEAI Checks', 'type' => '', 'ata_code' => '', 'short_description' => '2YEAR INSPEC', 'action_type' => 'INSP', 'status' => 'Released', 'external_ref' => ''],
        ['reference' => 'AW139 4YEAI Checks', 'type' => '', 'ata_code' => '', 'short_description' => '4YEARS (A) INSF', 'action_type' => 'INSP', 'status' => 'Released', 'external_ref' => ''],
        ['reference' => 'AW139 4YEAI Checks', 'type' => '', 'ata_code' => '', 'short_description' => '4YEARS (B) INSF', 'action_type' => 'INSP', 'status' => 'Released', 'external_ref' => ''],
        ['reference' => 'AW139 4YEAI Checks', 'type' => '', 'ata_code' => '', 'short_description' => '4YEARS (C) INSF', 'action_type' => 'INSP', 'status' => 'Released', 'external_ref' => ''],
        ['reference' => 'AW139 1YEAR Checks', 'type' => '', 'ata_code' => '', 'short_description' => '1YEAR INSPECT', 'action_type' => 'INSP', 'status' => 'No Valid', 'external_ref' => ''],
        ['reference' => 'AW139 600HF Checks', 'type' => '', 'ata_code' => '', 'short_description' => '600HRS INSPEC', 'action_type' => 'INSP', 'status' => 'Released', 'external_ref' => ''],
        ['reference' => 'AW139 ENG 600H Checks', 'type' => '', 'ata_code' => '', 'short_description' => 'ENG 600HRS INS', 'action_type' => 'INSP', 'status' => 'Released', 'external_ref' => ''],
        ['reference' => 'AW139 RADI Checks', 'type' => '', 'ata_code' => '', 'short_description' => 'RADIO 1YEAR', 'action_type' => 'INSP', 'status' => 'Released', 'external_ref' => ''],
        ['reference' => 'AW139 300HF Checks', 'type' => '', 'ata_code' => '', 'short_description' => '300HRS INSPEC', 'action_type' => 'INSP', 'status' => 'Released', 'external_ref' => ''],
        ['reference' => 'AW139 ENG 300H Checks', 'type' => '', 'ata_code' => '', 'short_description' => 'ENG 300HRS INS', 'action_type' => 'INSP', 'status' => 'Released', 'external_ref' => ''],
        ['reference' => 'AW139 200HF Checks', 'type' => '', 'ata_code' => '', 'short_description' => '200HRS INSPEC', 'action_type' => 'INSP', 'status' => 'Released', 'external_ref' => ''],
        ['reference' => 'AW139 150HF Checks', 'type' => '', 'ata_code' => '', 'short_description' => '150HRS INSPEC', 'action_type' => 'INSP', 'status' => 'Released', 'external_ref' => ''],
        ['reference' => 'AW139 ENG 150H Checks', 'type' => '', 'ata_code' => '', 'short_description' => 'ENG 150HRS', 'action_type' => '', 'status' => 'Cancelled', 'external_ref' => ''],
        ['reference' => 'AW139 100HF Checks', 'type' => '', 'ata_code' => '', 'short_description' => '100HRS INSPEC', 'action_type' => 'INSP', 'status' => 'Released', 'external_ref' => ''],
        ['reference' => 'AW139 50HRS Checks', 'type' => '', 'ata_code' => '', 'short_description' => '50HRS INSPEC', 'action_type' => 'INSP', 'status' => 'Released', 'external_ref' => ''],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            activeTab: 'general',
            linkedTab: 'hierarchy',
            programTab: 'general-criteria',
            showResults: false,
            statusMessage: '',
            maxRecords: 200,
            resultRows: @js($resultRows),
            searchTaskLists() {
                this.showResults = true;
                this.statusMessage = 'Task list search completed.';
                this.$nextTick(() => window.refreshFlowbiteTables?.());
            },
            resetSearch() {
                this.activeTab = 'general';
                this.linkedTab = 'hierarchy';
                this.programTab = 'general-criteria';
                this.showResults = false;
                this.maxRecords = 200;
                this.statusMessage = 'Task list search filters reset to the default configuration.';
            },
            cancelSearch() {
                this.showResults = false;
                this.statusMessage = 'Task list search cancelled.';
            },
            chooseResult() {
                this.showResults = false;
                this.statusMessage = 'Task list selected from the search results.';
            },
        }"
    >
        <x-page-header
            title="Search Task List"
            description="Search task lists by reference, applicability, linked hierarchy, and maintenance-program execution filters in the ATP MRO workspace."
        >
            <x-slot name="actions">
                <button type="button" class="btn-secondary" @click="resetSearch()">Reset</button>
            </x-slot>
        </x-page-header>

        <section class="attach-workspace-shell max-w-[1360px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
                <div class="subtab-shell">
                    <ul class="subtab-list">
                        @foreach ([
                            'general' => 'General',
                            'properties' => 'Properties',
                            'linked-tasks' => 'Linked Tasks',
                            'miscellaneous' => 'Miscellaneous',
                            'maintenance-program' => 'Maintenance Program & Execution',
                        ] as $key => $label)
                            <li class="subtab-item">
                                <button type="button" class="subtab-link" :class="activeTab === '{{ $key }}' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = '{{ $key }}'">{{ $label }}</button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div x-cloak x-show="activeTab === 'general'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_280px]">
                        <div class="space-y-4">
                            <x-enterprise.field-row label="Task List References" for="task_list_references" columns="sm:grid-cols-[128px_minmax(0,1fr)]"><input id="task_list_references" type="text" class="input-field attach-input" /></x-enterprise.field-row>
                            <x-enterprise.field-row label="Short Description" for="task_list_description" columns="sm:grid-cols-[128px_minmax(0,1fr)]"><input id="task_list_description" type="text" class="input-field attach-input" /></x-enterprise.field-row>
                            <x-enterprise.field-row label="External Ref." for="task_list_external_ref" columns="sm:grid-cols-[128px_minmax(0,1fr)]"><input id="task_list_external_ref" type="text" class="input-field attach-input" /></x-enterprise.field-row>

                            <div class="grid grid-cols-[120px_40px_156px_24px_156px] items-center gap-3">
                                <span class="attach-field-label">Effective Date</span>
                                <span class="attach-field-label">From</span>
                                <x-date-picker id="task_list_effective_from" />
                                <span class="attach-field-label">To</span>
                                <x-date-picker id="task_list_effective_to" />
                            </div>

                            <div class="space-y-2">
                                <div class="attach-field-label">Chapter - Section - Subject - Sheet - Mark</div>
                                <div class="grid grid-cols-5 gap-2">
                                    @foreach (['Chapter', 'Section', 'Subject', 'Sheet', 'Mark'] as $part)
                                        <input type="text" class="input-field attach-input" placeholder="{{ $part }}" />
                                    @endforeach
                                </div>
                            </div>

                            @foreach (['Zoning', 'AMM Ref.', 'Disassembly Level'] as $field)
                                <x-enterprise.field-row :label="$field" :for="'task_list_'.\Illuminate\Support\Str::slug($field, '_')" columns="sm:grid-cols-[128px_minmax(0,1fr)]">
                                    <input id="{{ 'task_list_'.\Illuminate\Support\Str::slug($field, '_') }}" type="text" class="input-field attach-input" />
                                </x-enterprise.field-row>
                            @endforeach

                            @foreach ([
                                'Results Involve Actions',
                                'Cat Landing',
                                'ETOPS - Extended Twin engined Operations',
                                'CPCP - Corrosion Prevention and Control Program',
                                'Aging Aircraft Program',
                                'SSI - Structural Significant Items',
                                'STC Ref. - Maintenance Center Specific Task',
                            ] as $field)
                                <x-enterprise.field-row :label="$field" :for="'task_list_'.\Illuminate\Support\Str::slug($field, '_')" columns="sm:grid-cols-[128px_minmax(0,1fr)]">
                                    <select id="{{ 'task_list_'.\Illuminate\Support\Str::slug($field, '_') }}" class="input-field attach-input">
                                        <option>Any</option>
                                        <option>Yes</option>
                                        <option>No</option>
                                    </select>
                                </x-enterprise.field-row>
                            @endforeach

                            <div class="flex flex-wrap items-center gap-3 pt-2">
                                <label class="attach-checkbox-inline"><input type="checkbox" /><span>Commercial Item Code</span></label>
                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @foreach (['Status', 'Work Center', 'Type', 'Functional Location Ref.', 'Action Type', 'Modification Ref. SB/AD'] as $toggle)
                                <div class="flex flex-wrap items-center gap-3">
                                    <label class="attach-checkbox-inline"><input type="checkbox" /><span>{{ $toggle }}</span></label>
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                            @endforeach

                            <label class="attach-checkbox-inline pt-2"><input type="checkbox" /><span>Without Modification</span></label>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'properties'" class="space-y-5">
                <x-enterprise.panel class="min-h-[420px]">
                    <p class="text-sm text-gray-600">Choose only one task list type to see the properties.</p>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'linked-tasks'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="subtab-shell">
                        <ul class="subtab-list">
                            @foreach (['hierarchy' => 'Hierarchy', 'linked-task' => 'Linked Task'] as $key => $label)
                                <li class="subtab-item">
                                    <button type="button" class="subtab-link" :class="linkedTab === '{{ $key }}' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="linkedTab = '{{ $key }}'">{{ $label }}</button>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div x-cloak x-show="linkedTab === 'hierarchy'" class="space-y-5">
                        <div class="grid gap-5">
                            <div class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Parent Task Lists</div>
                                <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable>
                                    <x-slot name="thead"><tr><th>Task List Reference</th><th>Task List Description</th></tr></x-slot>
                                    <x-slot name="tbody">
                                        @foreach ($parentTaskLists as $row)
                                            <tr><td>{{ $row['reference'] }}</td><td>{{ $row['description'] }}</td></tr>
                                        @endforeach
                                    </x-slot>
                                </x-enterprise.table-shell>
                                <div class="flex justify-end"><button type="button" class="btn-secondary">Add Parent Task List</button></div>
                            </div>

                            <div class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Child Task Lists</div>
                                <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable>
                                    <x-slot name="thead"><tr><th>Task List Reference</th><th>Task List Description</th></tr></x-slot>
                                    <x-slot name="tbody">
                                        @foreach ($childTaskLists as $row)
                                            <tr><td>{{ $row['reference'] }}</td><td>{{ $row['description'] }}</td></tr>
                                        @endforeach
                                    </x-slot>
                                </x-enterprise.table-shell>
                                <div class="flex justify-end"><button type="button" class="btn-secondary">Add Child Task List</button></div>
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="linkedTab === 'linked-task'" class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Linked Task Lists</div>
                        <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable>
                            <x-slot name="thead"><tr><th>Task List Ref.</th><th>Task List Description</th><th>Link Type</th></tr></x-slot>
                            <x-slot name="tbody">
                                @foreach ($linkedTaskLists as $row)
                                    <tr><td>{{ $row['reference'] }}</td><td>{{ $row['description'] }}</td><td>{{ $row['type'] }}</td></tr>
                                @endforeach
                            </x-slot>
                        </x-enterprise.table-shell>
                        <div class="flex justify-end"><button type="button" class="btn-secondary">Add Linked Task List</button></div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'miscellaneous'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <x-enterprise.panel muted class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Apply To</div>
                        <div class="grid gap-5 xl:grid-cols-2">
                            <div class="space-y-3">
                                @foreach (['Item group', 'Category Part', 'Variant', 'Item Code', 'Functional Location Type'] as $toggle)
                                    <div class="flex flex-wrap items-center gap-3">
                                        <label class="attach-checkbox-inline"><input type="checkbox" /><span>{{ $toggle }}</span></label>
                                        <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                    </div>
                                @endforeach
                            </div>
                            <div class="space-y-3">
                                @foreach (['Work Order Type', 'Return Reason', 'Intervention Type', 'Removal Reason', 'Mission Type', 'Environment Type'] as $toggle)
                                    <div class="flex flex-wrap items-center gap-3">
                                        <label class="attach-checkbox-inline"><input type="checkbox" /><span>{{ $toggle }}</span></label>
                                        <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </x-enterprise.panel>

                    <div class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Damages</div>
                        <x-enterprise.table-shell table-class="min-w-[1260px] border-collapse" datatable>
                            <x-slot name="thead"><tr><th>Type</th><th>Desc.</th><th>Localization</th><th>Desc.</th><th>Gravity</th><th>Desc.</th></tr></x-slot>
                            <x-slot name="tbody">
                                @foreach ($damageRows as $row)
                                    <tr>
                                        <td>{{ $row['type'] }}</td>
                                        <td>{{ $row['desc_1'] }}</td>
                                        <td>{{ $row['localization'] }}</td>
                                        <td>{{ $row['desc_2'] }}</td>
                                        <td>{{ $row['gravity'] }}</td>
                                        <td>{{ $row['desc_3'] }}</td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-enterprise.table-shell>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'maintenance-program'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="subtab-shell">
                        <ul class="subtab-list">
                            @foreach (['general-criteria' => 'General Criteria', 'interval' => 'Interval'] as $key => $label)
                                <li class="subtab-item">
                                    <button type="button" class="subtab-link" :class="programTab === '{{ $key }}' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="programTab = '{{ $key }}'">{{ $label }}</button>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div x-cloak x-show="programTab === 'general-criteria'" class="space-y-5">
                        <div class="grid gap-5 xl:grid-cols-2">
                            <div class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Maintenance Program</div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <label class="attach-checkbox-inline"><input type="checkbox" /><span>Maintenance Program Name</span></label>
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                                <x-enterprise.field-row label="Status active on maintenance program" for="tasklist_program_status" columns="sm:grid-cols-[196px_minmax(0,1fr)]">
                                    <select id="tasklist_program_status" class="input-field attach-input"><option>Any</option><option>Active</option><option>Inactive</option></select>
                                </x-enterprise.field-row>

                                <x-enterprise.panel muted class="space-y-3">
                                    <div class="text-sm font-semibold text-gray-900">Effectivity</div>
                                    @foreach (['Apply to all objects', 'Depend on parameter and can change', 'Depend on parameter and cannot change'] as $option)
                                        <label class="attach-checkbox-inline"><input type="checkbox" /><span>{{ $option }}</span></label>
                                    @endforeach
                                </x-enterprise.panel>

                                <div class="space-y-3">
                                    <div class="attach-field-label">Object Type</div>
                                    <div class="flex flex-wrap items-center gap-4">
                                        @foreach (['Both', 'Equipment', 'Functional Location'] as $option)
                                            <label class="attach-checkbox-inline"><input type="radio" name="tasklist_object_type" @if($option === 'Both') checked @endif /><span>{{ $option }}</span></label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center gap-3">
                                    <label class="attach-checkbox-inline"><input type="checkbox" /><span>Status on object</span></label>
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                                <x-enterprise.field-row label="Status of counter active" for="tasklist_counter_status" columns="sm:grid-cols-[196px_minmax(0,1fr)]">
                                    <select id="tasklist_counter_status" class="input-field attach-input"><option>Any</option><option>Active</option><option>Inactive</option></select>
                                </x-enterprise.field-row>
                                <label class="attach-checkbox-inline"><input type="checkbox" /><span>Interval differences between maintenance plan and object assignment</span></label>
                            </div>

                            <div class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Execution</div>
                                <div class="space-y-3">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <label class="attach-checkbox-inline"><input type="checkbox" /><span>Work Order</span></label>
                                        <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                    </div>
                                    <label class="attach-checkbox-inline"><input type="checkbox" /><span>Show only task list with closed operations</span></label>
                                </div>

                                <div class="space-y-3">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <label class="attach-checkbox-inline"><input type="checkbox" /><span>Repair Information Cockpit</span></label>
                                        <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                    </div>
                                    <label class="attach-checkbox-inline"><input type="checkbox" /><span>Show only task list with closed operations</span></label>
                                </div>

                                @foreach (['Cut-Off', 'Which Ever Comes Last', 'Apply to Sub Equipment', 'Only Sub Equipment Counters', 'Swap to be Performed'] as $field)
                                    <x-enterprise.field-row :label="$field" :for="'tasklist_'.\Illuminate\Support\Str::slug($field, '_')" columns="sm:grid-cols-[176px_minmax(0,1fr)]">
                                        <select id="{{ 'tasklist_'.\Illuminate\Support\Str::slug($field, '_') }}" class="input-field attach-input"><option>Any</option><option>Yes</option><option>No</option></select>
                                    </x-enterprise.field-row>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div x-cloak x-show="programTab === 'interval'" class="space-y-5">
                        <div class="grid gap-5 xl:grid-cols-[minmax(0,420px)_minmax(0,1fr)]">
                            <div class="space-y-4">
                            <div class="grid grid-cols-[120px_40px_156px_24px_156px] items-center gap-3">
                                    <span class="attach-field-label">Effective Date:</span>
                                    <span class="attach-field-label">From</span>
                                    <x-date-picker id="tasklist_interval_effective_from" />
                                    <span class="attach-field-label">To</span>
                                    <x-date-picker id="tasklist_interval_effective_to" />
                                </div>

                            <div class="grid grid-cols-[120px_40px_156px_24px_156px] items-center gap-3">
                                    <span class="attach-field-label">Cut-Off Date:</span>
                                    <span class="attach-field-label">From</span>
                                    <x-date-picker id="tasklist_interval_cutoff_from" />
                                    <span class="attach-field-label">To</span>
                                    <x-date-picker id="tasklist_interval_cutoff_to" />
                                </div>

                                <x-enterprise.panel muted class="space-y-4">
                                    <div class="text-sm font-semibold text-gray-900">Task List Applicability</div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <label class="attach-checkbox-inline"><input type="checkbox" /><span>Visit</span></label>
                                        <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                    </div>
                                    <x-enterprise.field-row label="On Condition" for="tasklist_on_condition" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><select id="tasklist_on_condition" class="input-field attach-input"><option>Any</option><option>Yes</option><option>No</option></select></x-enterprise.field-row>
                                    <x-enterprise.field-row label="Key words (comma separator)" for="tasklist_keywords_1" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><input id="tasklist_keywords_1" type="text" class="input-field attach-input" /></x-enterprise.field-row>
                                    <x-enterprise.field-row label="Condition Monitoring" for="tasklist_condition_monitoring" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><select id="tasklist_condition_monitoring" class="input-field attach-input"><option>Any</option><option>Required</option><option>Not Required</option></select></x-enterprise.field-row>
                                    <x-enterprise.field-row label="Key words (comma separator)" for="tasklist_keywords_2" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><input id="tasklist_keywords_2" type="text" class="input-field attach-input" /></x-enterprise.field-row>
                                </x-enterprise.panel>
                            </div>

                            <div class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Counters</div>
                                <x-enterprise.table-shell table-class="min-w-[1260px] border-collapse min-w-[980px]" datatable>
                                    <x-slot name="thead"><tr><th>Counter type</th><th>First Value(dec.)</th><th>First Value (hh:mm)</th><th>Interval (dec.)</th><th>Interval (hh:mm)</th><th>Cut-Off (dec.)</th><th>Cut-Off (hh:mm)</th></tr></x-slot>
                                    <x-slot name="tbody">
                                        @foreach ($counterRows as $row)
                                            <tr>
                                                <td>{{ $row['counter_type'] }}</td>
                                                <td>{{ $row['first_value_dec'] }}</td>
                                                <td>{{ $row['first_value_time'] }}</td>
                                                <td>{{ $row['interval_dec'] }}</td>
                                                <td>{{ $row['interval_time'] }}</td>
                                                <td>{{ $row['cutoff_dec'] }}</td>
                                                <td>{{ $row['cutoff_time'] }}</td>
                                            </tr>
                                        @endforeach
                                    </x-slot>
                                </x-enterprise.table-shell>

                                <div class="flex items-start justify-end gap-4">
                                    <span class="attach-field-label">Link</span>
                                    <div class="space-y-2">
                                        <label class="attach-checkbox-inline"><input type="radio" name="tasklist_link_logic" checked /><span>Or</span></label>
                                        <label class="attach-checkbox-inline"><input type="radio" name="tasklist_link_logic" /><span>And</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="btn-primary" @click="searchTaskLists()">Search</button>
                </div>

                <div class="flex flex-wrap items-end gap-3">
                    <div class="grid gap-2">
                        <span class="attach-field-label">Maximum number of records</span>
                        <input type="text" x-model="maxRecords" class="input-field attach-input" />
                    </div>
                    <button type="button" class="btn-secondary" @click="cancelSearch()">Cancel</button>
                </div>
            </x-enterprise.action-bar>
        </section>

        <div
            x-cloak
            x-show="showResults"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/35 px-4 py-8"
        >
            <div
                @click.outside="showResults = false"
                class="w-full max-w-[1080px] rounded-2xl border border-gray-200 bg-white p-5 shadow-2xl"
            >
                <div class="space-y-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-semibold tracking-tight text-gray-900">Result of task list search</h2>
                        </div>
                        <button type="button" class="btn-secondary" @click="showResults = false">Close</button>
                    </div>

                        <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable datatable-selectable>
                        <x-slot name="thead">
                            <tr>
                                <th>Task List Refe...</th>
                                <th>Type</th>
                                <th>ATA Code</th>
                                <th>Short Descrip...</th>
                                <th>Action Type</th>
                                <th>Status</th>
                                <th>External Ref.</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            @foreach ($resultRows as $row)
                                <tr>
                                    <td class="whitespace-nowrap">
                                        <span class="mr-2 inline-flex text-amber-500" aria-hidden="true">&rarr;</span>
                                        <span>{{ $row['reference'] }}</span>
                                    </td>
                                    <td>{{ $row['type'] ?: '-' }}</td>
                                    <td>{{ $row['ata_code'] ?: '-' }}</td>
                                    <td>{{ $row['short_description'] }}</td>
                                    <td>{{ $row['action_type'] ?: '-' }}</td>
                                    <td>{{ $row['status'] }}</td>
                                    <td>{{ $row['external_ref'] ?: '-' }}</td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-enterprise.table-shell>

                    <div class="flex flex-wrap items-end justify-between gap-4">
                        <button type="button" class="btn-secondary" @click="showResults = false">Back</button>

                        <div class="grid gap-2">
                            <span class="attach-field-label">Number of records found</span>
                            <input type="text" :value="resultRows.length" class="input-field attach-input" readonly />
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="button" class="btn-primary" @click="chooseResult()">Choose</button>
                            <button type="button" class="btn-secondary" @click="cancelSearch()">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
