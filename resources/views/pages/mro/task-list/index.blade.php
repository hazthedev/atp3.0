@extends('layouts.app')

@section('title', 'Task List')

@php
    $qualificationRows = [
        ['group' => 'Airframe', 'qualification' => 'Senior Structures Inspector', 'linked_op' => 'OP-110'],
        ['group' => 'Engine', 'qualification' => 'Powerplant Certifying Staff', 'linked_op' => 'OP-230'],
    ];

    $purchasingRows = [
        ['item_code' => 'MAT-0012', 'item_desc' => 'Corrosion inhibitor kit', 'uom' => 'SET', 'qty' => '1.0000', 'warehouse' => 'MRO-MAIN'],
        ['item_code' => 'MAT-0068', 'item_desc' => 'Fastener replacement pack', 'uom' => 'EA', 'qty' => '12.0000', 'warehouse' => 'MRO-LINE'],
    ];

    $attachmentRows = [
        ['path' => 'docs/tasklists/tl-aw139-001.pdf', 'file' => 'AW139 engine inspection.pdf'],
        ['path' => 'docs/tasklists/tl-aw139-001-scope.xlsx', 'file' => 'Scope matrix.xlsx'],
    ];

    $parentTaskLists = [
        ['reference' => 'TL-AW139-771', 'description' => 'Rotor system pre-inspection'],
        ['reference' => 'TL-AW139-882', 'description' => 'Main gearbox servicing'],
    ];

    $childTaskLists = [
        ['reference' => 'TL-AW139-101', 'description' => 'Filter contamination verification'],
        ['reference' => 'TL-AW139-202', 'description' => 'Cabin safety equipment check'],
    ];

    $linkedTaskLists = [
        ['reference' => 'TL-AW139-411', 'description' => 'Landing gear interval reset'],
        ['reference' => 'TL-AW139-512', 'description' => 'Rotor blade balancing check'],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            activeTab: 'general',
            detailTab: 'operations',
            detailSupplyTab: 'to-be-issued',
            toolSupplyTab: 'to-be-issued',
            applicabilityTab: 'apply-to',
            applyToTab: 'item-group',
            otherTab: 'work-order-type',
            linkedTab: 'hierarchy',
            statusMessage: '',
            setStatus(message) { this.statusMessage = message; },
            cancelPage() { this.statusMessage = 'Task list review cancelled.'; },
        }"
    >
        <x-page-header
            title="Task List"
            description="Review task-list metadata, execution details, applicability scope, linked tasks, and description content in the ATP MRO workspace."
        />

        <section class="attach-workspace-shell max-w-[1360px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel class="space-y-5">
                <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_280px]">
                    <x-enterprise.field-row label="Task List Ref." for="tasklist_ref" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                        <input id="tasklist_ref" type="text" value="TL-AW139-001" class="input-field attach-input" />
                    </x-enterprise.field-row>

                    <x-enterprise.field-row label="Status" for="tasklist_status" columns="sm:grid-cols-[56px_180px]">
                        <select id="tasklist_status" class="input-field attach-input">
                            <option>Released</option>
                            <option>Draft</option>
                            <option>Obsolete</option>
                        </select>
                    </x-enterprise.field-row>
                </div>

                <x-enterprise.field-row label="Short Description" for="tasklist_short_description" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                    <input id="tasklist_short_description" type="text" value="AW139 engine inspection package" class="input-field attach-input" />
                </x-enterprise.field-row>

                <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
                    <div class="subtab-shell">
                        <ul class="subtab-list">
                            @foreach ([
                                'general' => 'General',
                                'details' => 'Details',
                                'properties' => 'Properties',
                                'applicability' => 'Applicability',
                                'linked-tasks' => 'Linked Tasks',
                                'description' => 'Description',
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
                        <div class="grid gap-6 xl:grid-cols-2">
                            <div class="space-y-4">
                                @foreach (['External Ref.' => 'AW139-ENG-INS-001', 'Work Center' => 'ENG-CENTER-01'] as $label => $value)
                                    <x-enterprise.field-row :label="$label" :for="'tasklist_'.\Illuminate\Support\Str::slug($label, '_')" columns="sm:grid-cols-[116px_minmax(0,1fr)]">
                                        <div class="attach-inline-control">
                                            <input id="{{ 'tasklist_'.\Illuminate\Support\Str::slug($label, '_') }}" type="text" value="{{ $value }}" class="input-field attach-input" />
                                            @if ($label === 'Work Center')
                                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                            @endif
                                        </div>
                                    </x-enterprise.field-row>
                                @endforeach

                                <x-enterprise.field-row label="Type" for="tasklist_type" columns="sm:grid-cols-[116px_minmax(0,1fr)]">
                                    <select id="tasklist_type" class="input-field attach-input">
                                        <option>Inspection</option>
                                        <option>Replacement</option>
                                        <option>Workshop</option>
                                    </select>
                                </x-enterprise.field-row>

                                <x-enterprise.field-row label="Effective Date" for="tasklist_effective_date" columns="sm:grid-cols-[116px_minmax(0,1fr)]">
                                    <x-date-picker id="tasklist_effective_date" />
                                </x-enterprise.field-row>

                                <div class="space-y-2">
                                    <div class="attach-field-label">Chapter - Section - Subject - Sheet - Mark</div>
                                    <div class="grid grid-cols-5 gap-2">
                                        @foreach (['72', '10', '00', 'A', '1'] as $value)
                                            <input type="text" value="{{ $value }}" class="input-field attach-input" />
                                        @endforeach
                                    </div>
                                </div>

                                @foreach (['Zoning' => 'ZONE-ENG-01', 'AMM Ref.' => 'AMM 72-00-01', 'Disassembly Level' => 'Level 2'] as $label => $value)
                                    <x-enterprise.field-row :label="$label" :for="'tasklist_'.\Illuminate\Support\Str::slug($label, '_')" columns="sm:grid-cols-[116px_minmax(0,1fr)]">
                                        <input id="{{ 'tasklist_'.\Illuminate\Support\Str::slug($label, '_') }}" type="text" value="{{ $value }}" class="input-field attach-input" />
                                    </x-enterprise.field-row>
                                @endforeach

                                <div class="space-y-2">
                                    @foreach ([
                                        'Results Involve Actions',
                                        'Cat Landing',
                                        'ETOPS - Extended Twin engined Operations',
                                        'CPCP - Corrosion Prevention and Control Program',
                                        'Aging Aircraft Program',
                                        'SSI - Structural Significant Items',
                                        'STC Ref. - Maintenance Center Specific Task',
                                    ] as $option)
                                        <label class="attach-checkbox-inline"><input type="checkbox" /><span>{{ $option }}</span></label>
                                    @endforeach

                                    <div class="pl-6 space-y-2">
                                        @foreach (['EASA', 'FAA', 'Other'] as $option)
                                            <div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
                                                <label class="attach-checkbox-inline"><input type="checkbox" /><span>{{ $option }}</span></label>
                                                <input type="text" class="input-field attach-input" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                @foreach (['Create Date' => '2026-04-01', 'Created By' => 'asyraf', 'Update Date' => '2026-04-06', 'Updated By' => 'asyraf'] as $label => $value)
                                    <x-enterprise.field-row :label="$label" :for="'tasklist_'.\Illuminate\Support\Str::slug($label, '_')" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                                        <input id="{{ 'tasklist_'.\Illuminate\Support\Str::slug($label, '_') }}" type="text" value="{{ $value }}" class="input-field attach-input" />
                                    </x-enterprise.field-row>
                                @endforeach

                                <div class="pt-1">
                                    <input type="text" value="AW139 engine maintenance package for recurring heavy checks." class="input-field attach-input" />
                                </div>

                                @foreach ([
                                    'Functional Location Ref.' => ['type' => 'select'],
                                    'Action Type' => ['type' => 'lookup'],
                                    'Commercial Item Code' => ['type' => 'lookup'],
                                    'Modification Ref. SB/AD' => ['type' => 'lookup'],
                                    'Modification Link Type' => ['type' => 'select'],
                                ] as $label => $config)
                                    @if ($config['type'] === 'select')
                                        <x-enterprise.field-row :label="$label" :for="'tasklist_'.\Illuminate\Support\Str::slug($label, '_')" columns="sm:grid-cols-[140px_minmax(0,1fr)]">
                                            <select id="{{ 'tasklist_'.\Illuminate\Support\Str::slug($label, '_') }}" class="input-field attach-input">
                                                <option>Any</option>
                                                <option>FL-AW139</option>
                                                <option>Primary</option>
                                            </select>
                                        </x-enterprise.field-row>
                                    @else
                                        <x-enterprise.lookup-row :label="$label" :for="'tasklist_'.\Illuminate\Support\Str::slug($label, '_')" columns="sm:grid-cols-[140px_minmax(0,1fr)]">
                                            <div class="attach-inline-control">
                                                <input id="{{ 'tasklist_'.\Illuminate\Support\Str::slug($label, '_') }}" type="text" class="input-field attach-input" />
                                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                            </div>
                                        </x-enterprise.lookup-row>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </x-enterprise.panel>
                </div>
                <div x-cloak x-show="activeTab === 'details'" class="space-y-5">
                    <x-enterprise.panel class="space-y-5">
                        <div class="subtab-shell">
                            <ul class="subtab-list">
                                @foreach ([
                                    'operations' => 'Operations',
                                    'qualifications' => 'Qualifications',
                                    'components' => 'Components',
                                    'tools' => 'Tools',
                                    'purchasing' => 'Purchasing',
                                    'measurement-points' => 'Measurement Points',
                                    'attachments' => 'Attachments',
                                ] as $key => $label)
                                    <li class="subtab-item">
                                        <button type="button" class="subtab-link" :class="detailTab === '{{ $key }}' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="detailTab = '{{ $key }}'">{{ $label }}</button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div x-cloak x-show="detailTab === 'operations'" class="space-y-4">
                            <x-enterprise.panel muted class="min-h-[320px]"></x-enterprise.panel>
                            <div class="flex justify-start"><button type="button" class="btn-secondary">Delete</button></div>
                        </div>

                        <div x-cloak x-show="detailTab === 'qualifications'" class="space-y-4">
                            <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable>
                                <x-slot name="thead"><tr><th>Qualification Group</th><th>Qualification</th><th>Linked Op</th></tr></x-slot>
                                <x-slot name="tbody">
                                    @foreach ($qualificationRows as $row)
                                        <tr><td>{{ $row['group'] }}</td><td>{{ $row['qualification'] }}</td><td>{{ $row['linked_op'] }}</td></tr>
                                    @endforeach
                                </x-slot>
                            </x-enterprise.table-shell>
                        </div>

                        <div x-cloak x-show="detailTab === 'components'" class="space-y-4">
                            <div class="subtab-shell">
                                <ul class="subtab-list">
                                    @foreach (['to-be-issued' => 'To be Issued', 'to-be-received' => 'To be Received'] as $key => $label)
                                        <li class="subtab-item">
                                            <button type="button" class="subtab-link" :class="detailSupplyTab === '{{ $key }}' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="detailSupplyTab = '{{ $key }}'">{{ $label }}</button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <x-enterprise.panel muted class="min-h-[260px]"></x-enterprise.panel>
                            <div class="flex justify-start"><button type="button" class="btn-secondary">Delete</button></div>
                        </div>

                        <div x-cloak x-show="detailTab === 'tools'" class="space-y-4">
                            <div class="subtab-shell">
                                <ul class="subtab-list">
                                    @foreach (['to-be-issued' => 'To be Issued', 'to-be-received' => 'To be Received'] as $key => $label)
                                        <li class="subtab-item">
                                            <button type="button" class="subtab-link" :class="toolSupplyTab === '{{ $key }}' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="toolSupplyTab = '{{ $key }}'">{{ $label }}</button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <x-enterprise.panel muted class="min-h-[260px]"></x-enterprise.panel>
                            <div class="flex justify-start"><button type="button" class="btn-secondary">Delete</button></div>
                        </div>

                        <div x-cloak x-show="detailTab === 'purchasing'" class="space-y-4">
                            <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable>
                                <x-slot name="thead"><tr><th>Item Code</th><th>Item Desc</th><th>UoM</th><th>Qty</th><th>Warehouse</th></tr></x-slot>
                                <x-slot name="tbody">
                                    @foreach ($purchasingRows as $row)
                                        <tr><td>{{ $row['item_code'] }}</td><td>{{ $row['item_desc'] }}</td><td>{{ $row['uom'] }}</td><td>{{ $row['qty'] }}</td><td>{{ $row['warehouse'] }}</td></tr>
                                    @endforeach
                                </x-slot>
                            </x-enterprise.table-shell>
                        </div>

                        <div x-cloak x-show="detailTab === 'measurement-points'" class="space-y-4">
                            <x-enterprise.panel muted class="min-h-[320px]"></x-enterprise.panel>
                            <div class="flex justify-end"><button type="button" class="btn-primary" @click="setStatus('Measurement point added to task list.')">Add</button></div>
                        </div>

                        <div x-cloak x-show="detailTab === 'attachments'" class="space-y-4">
                            <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_120px]">
                                <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable>
                                    <x-slot name="thead"><tr><th>Path</th><th>File Name</th></tr></x-slot>
                                    <x-slot name="tbody">
                                        @foreach ($attachmentRows as $row)
                                            <tr><td>{{ $row['path'] }}</td><td>{{ $row['file'] }}</td></tr>
                                        @endforeach
                                    </x-slot>
                                </x-enterprise.table-shell>

                                <div class="space-y-3">
                                    <button type="button" class="btn-secondary">Browse</button>
                                    <button type="button" class="btn-secondary">Display</button>
                                    <button type="button" class="btn-secondary">Delete</button>
                                </div>
                            </div>
                        </div>
                    </x-enterprise.panel>
                </div>
                <div x-cloak x-show="activeTab === 'properties'" class="space-y-5">
                    <x-enterprise.panel class="min-h-[320px]">
                <div class="flex justify-center gap-6 pt-4">
                            <label class="attach-checkbox-inline"><input type="checkbox" /><span>CM</span></label>
                            <label class="attach-checkbox-inline"><input type="checkbox" /><span>MY</span></label>
                        </div>
                    </x-enterprise.panel>
                </div>
                <div x-cloak x-show="activeTab === 'applicability'" class="space-y-5">
                    <x-enterprise.panel class="space-y-5">
                        <div class="subtab-shell">
                            <ul class="subtab-list">
                                @foreach (['apply-to' => 'Apply to', 'others' => 'Others'] as $key => $label)
                                    <li class="subtab-item">
                                        <button type="button" class="subtab-link" :class="applicabilityTab === '{{ $key }}' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="applicabilityTab = '{{ $key }}'">{{ $label }}</button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div x-cloak x-show="applicabilityTab === 'apply-to'" class="space-y-4">
                            <div class="subtab-shell">
                                <ul class="subtab-list">
                                    @foreach ([
                                        'item-group' => 'Item Group',
                                        'category-part' => 'Category Part',
                                        'variant' => 'Variant',
                                        'item-code' => 'Item Code',
                                        'functional-location-type' => 'Functional Location Type',
                                    ] as $key => $label)
                                        <li class="subtab-item">
                                            <button type="button" class="subtab-link" :class="applyToTab === '{{ $key }}' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="applyToTab = '{{ $key }}'">{{ $label }}</button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <x-enterprise.panel muted class="min-h-[280px]">
                                <div class="flex min-h-[220px] items-start justify-center pt-10">
                                    <label class="attach-checkbox-inline" x-show="applyToTab === 'item-group'"><input type="checkbox" /><span>Apply to all Item Group</span></label>
                                    <label class="attach-checkbox-inline" x-show="applyToTab === 'category-part'"><input type="checkbox" /><span>Apply to all Category Part</span></label>
                                    <label class="attach-checkbox-inline" x-show="applyToTab === 'variant'"><input type="checkbox" /><span>Apply to all Variants</span></label>
                                    <label class="attach-checkbox-inline" x-show="applyToTab === 'item-code'"><input type="checkbox" /><span>Apply to all Item Code</span></label>
                                    <label class="attach-checkbox-inline" x-show="applyToTab === 'functional-location-type'"><input type="checkbox" /><span>Apply to all Functional Location Type</span></label>
                                </div>
                            </x-enterprise.panel>
                        </div>

                        <div x-cloak x-show="applicabilityTab === 'others'" class="space-y-4">
                            <div class="subtab-shell">
                                <ul class="subtab-list">
                                    @foreach ([
                                        'work-order-type' => 'Work Order Type',
                                        'return-reason' => 'Return Reason',
                                        'intervention-type' => 'Intervention Type',
                                        'removal-reason' => 'Removal Reason',
                                        'mission-type' => 'Mission Type',
                                        'environment-type' => 'Environment Type',
                                        'damages' => 'Damages',
                                    ] as $key => $label)
                                        <li class="subtab-item">
                                            <button type="button" class="subtab-link" :class="otherTab === '{{ $key }}' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="otherTab = '{{ $key }}'">{{ $label }}</button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <x-enterprise.panel muted class="min-h-[280px]">
                                <div class="flex min-h-[220px] items-start justify-center pt-10" x-show="otherTab !== 'damages'">
                                    <label class="attach-checkbox-inline" x-show="otherTab === 'work-order-type'"><input type="checkbox" /><span>Apply to all Work Order Type</span></label>
                                    <label class="attach-checkbox-inline" x-show="otherTab === 'return-reason'"><input type="checkbox" /><span>Apply to all Return Reason</span></label>
                                    <label class="attach-checkbox-inline" x-show="otherTab === 'intervention-type'"><input type="checkbox" /><span>Apply to all Intervention Type</span></label>
                                    <label class="attach-checkbox-inline" x-show="otherTab === 'removal-reason'"><input type="checkbox" /><span>Apply to all Removal Reason</span></label>
                                    <label class="attach-checkbox-inline" x-show="otherTab === 'mission-type'"><input type="checkbox" /><span>Apply to all Mission Type</span></label>
                                    <label class="attach-checkbox-inline" x-show="otherTab === 'environment-type'"><input type="checkbox" /><span>Apply to all Environment Type</span></label>
                                </div>

                                <x-enterprise.table-shell x-show="otherTab === 'damages'" table-class="min-w-[1260px] border-collapse" datatable>
                                    <x-slot name="thead"><tr><th>Type</th><th>Description</th><th>Localization</th></tr></x-slot>
                                    <x-slot name="tbody">
                                        <tr><td>Corrosion</td><td>Surface oxidation</td><td>Door frame LH</td></tr>
                                        <tr><td>Wear</td><td>Fastener elongation</td><td>Upper cowling</td></tr>
                                    </x-slot>
                                </x-enterprise.table-shell>
                            </x-enterprise.panel>
                        </div>
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

                        <div x-cloak x-show="linkedTab === 'linked-task'" class="space-y-4">
                            <div class="text-sm font-semibold text-gray-900">Linked Task Lists</div>
                            <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable>
                                <x-slot name="thead"><tr><th>Task List Ref.</th><th>Task List Description</th></tr></x-slot>
                                <x-slot name="tbody">
                                    @foreach ($linkedTaskLists as $row)
                                        <tr><td>{{ $row['reference'] }}</td><td>{{ $row['description'] }}</td></tr>
                                    @endforeach
                                </x-slot>
                            </x-enterprise.table-shell>
                            <div class="flex justify-end"><button type="button" class="btn-secondary">Add Linked Task List</button></div>
                        </div>
                    </x-enterprise.panel>
                </div>
                <div x-cloak x-show="activeTab === 'description'" class="space-y-5">
                    <x-enterprise.panel class="min-h-[320px]">
                        <textarea class="input-field attach-textarea h-[260px]" placeholder="Task list description">Engine inspection package covering recurring work scope, consumables, qualifications, and operational links.</textarea>
                    </x-enterprise.panel>
                </div>

                <x-enterprise.action-bar justify="start" class="border-t border-gray-200 pt-5">
                    <button type="button" class="btn-primary" @click="setStatus('Task list loaded for review.')">Find</button>
                    <button type="button" class="btn-secondary" @click="cancelPage()">Cancel</button>
                </x-enterprise.action-bar>
            </x-enterprise.panel>
        </section>
    </div>
@endsection
