@extends('layouts.app')

@section('title', 'Repair Information Cockpit')

@php
    $activityRows = [
        ['code' => 'ACT-1182', 'date' => '2026-04-07', 'time' => '10:15', 'closed' => false, 'assigned_to' => 'Mohd Amirul Bakri Bin Abd. Halim', 'remarks' => 'Repair scope aligned', 'activity' => 'Planning'],
        ['code' => 'ACT-1183', 'date' => '2026-04-07', 'time' => '11:10', 'closed' => false, 'assigned_to' => 'Nur Husnina Binti Muhamad Zuraidi', 'remarks' => 'Awaiting part confirmation', 'activity' => 'Follow Up'],
    ];

    $salesRows = [
        ['closed' => false, 'assigned_to' => 'asyraf', 'remarks' => 'Customer estimate pending', 'activity' => 'Quotation', 'attachment' => 'quote-draft.pdf', 'doc' => 'QT-24017', 'created_by' => 'acap'],
    ];

    $workOrderRows = [
        ['level' => '1', 'code' => 'WO-240118', 'type' => 'Repair', 'title' => 'Main gearbox inspection', 'status' => 'Open', 'object_type' => 'Equipment', 'object_ref' => '9M-WAD', 'item_code' => 'AW139', 'serial_number' => '31336', 'category' => 'M104-01', 'intervention_type' => 'Workshop'],
        ['level' => '1', 'code' => 'WO-240124', 'type' => 'Repair', 'title' => 'Hydraulic valve rectification', 'status' => 'Open', 'object_type' => 'Functional Location', 'object_ref' => '9M-WAO', 'item_code' => 'AW139', 'serial_number' => '31419', 'category' => '9M-WAO', 'intervention_type' => 'Bench'],
    ];

    $attachments = [
        ['id' => 1, 'path' => 'repair-cockpit/2026/intake-report.pdf', 'file_name' => 'intake-report.pdf', 'attachment_date' => '2026-04-07'],
        ['id' => 2, 'path' => 'repair-cockpit/2026/quotation-request.xlsx', 'file_name' => 'quotation-request.xlsx', 'attachment_date' => '2026-04-07'],
    ];

    $summaryCostRows = [
        ['code' => 'CST-01', 'type' => 'Estimate', 'status' => 'Open', 'man_hour_cost' => '4,200', 'component_cost' => '8,500', 'other_cost' => '1,100'],
    ];

    $summaryRows = [
        ['code' => 'QTN-24017', 'remark' => 'Initial customer quotation', 'posting_date' => '2026-04-07', 'status' => 'Open', 'sales_pack_price' => '2,400', 'man_hour_price' => '4,800', 'component_price' => '8,500', 'service_price' => '1,100', 'total_price' => '16,800', 'sales' => 'Aero One Services'],
    ];
@endphp

@section('content')
    <div class="space-y-6" x-data="{ activeTab: 'general', summaryTab: 'cost', statusMessage: '' }">
        <x-page-header
            title="Repair Information Cockpit"
            description="Manage repair-event intake, activities, sales handling, work-order links, attachments, and summary in the ATP MRO workspace."
        />

        <section class="attach-workspace-shell max-w-[1480px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel muted class="space-y-5">
                <div class="grid gap-5 xl:grid-cols-2">
                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Owner Code" for="repair_owner_code" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><input id="repair_owner_code" type="text" value="300028" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Owner Name" for="repair_owner_name" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><input id="repair_owner_name" type="text" value="WESTSTAR" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Operator Code" for="repair_operator_code" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><input id="repair_operator_code" type="text" value="OP-001" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Operator Name" for="repair_operator_name" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><input id="repair_operator_name" type="text" value="Aero One Maintenance" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                    </div>

                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Status" for="repair_status" columns="sm:grid-cols-[112px_180px]"><select id="repair_status" class="input-field attach-input"><option selected>Open</option><option>In Progress</option><option>Closed</option></select></x-enterprise.field-row>
                        <x-enterprise.lookup-row label="Reference" for="repair_reference" columns="sm:grid-cols-[112px_180px]"><div class="attach-inline-control"><input id="repair_reference" type="text" value="WASSB/31336/1816" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                        <x-enterprise.field-row label="Created On" for="repair_created_on" columns="sm:grid-cols-[112px_180px]"><input id="repair_created_on" type="text" value="2026-04-07" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Date In" for="repair_date_in" columns="sm:grid-cols-[112px_180px]"><x-date-picker id="repair_date_in" value="2026-04-07" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Due Date" for="repair_due_date" columns="sm:grid-cols-[112px_180px]"><x-date-picker id="repair_due_date" value="2026-04-14" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Date Out" for="repair_date_out" columns="sm:grid-cols-[112px_180px]"><x-date-picker id="repair_date_out" value="" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="External Ref." for="repair_external_ref" columns="sm:grid-cols-[112px_180px]"><input id="repair_external_ref" type="text" value="EXT-1882" class="input-field attach-input" /></x-enterprise.field-row>
                    </div>
                </div>

                <div class="grid gap-5 xl:grid-cols-2">
                    <div class="space-y-2.5">
                        <x-enterprise.lookup-row label="Equipment No." for="repair_equipment_no" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><div class="attach-inline-control"><input id="repair_equipment_no" type="text" value="9M-WAD" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                        <x-enterprise.field-row label="Internal S/N" for="repair_internal_sn" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><input id="repair_internal_sn" type="text" value="31336" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Item Code" for="repair_item_code" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><input id="repair_item_code" type="text" value="AW139" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Item Description" for="repair_item_description" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><input id="repair_item_description" type="text" value="Helicopter airframe repair event" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Variant" for="repair_variant" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><input id="repair_variant" type="text" value="AW139" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Category Part" for="repair_category_part" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><input id="repair_category_part" type="text" value="M104-01" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                    </div>

                    <div class="space-y-2.5">
                        <x-enterprise.lookup-row label="Maintenance Center Code" for="repair_center_code" columns="sm:grid-cols-[180px_180px]"><div class="attach-inline-control"><input id="repair_center_code" type="text" value="MC-001" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                        <x-enterprise.field-row label="Maintenance Center Name" for="repair_center_name" columns="sm:grid-cols-[180px_180px]"><input id="repair_center_name" type="text" value="Subang Repair Center" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.lookup-row label="Branch" for="repair_branch" columns="sm:grid-cols-[180px_180px]"><div class="attach-inline-control"><input id="repair_branch" type="text" value="Kuala Lumpur" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                        <x-enterprise.field-row label="Priority" for="repair_priority" columns="sm:grid-cols-[180px_180px]"><select id="repair_priority" class="input-field attach-input"><option selected>Low</option><option>Medium</option><option>High</option></select></x-enterprise.field-row>
                    </div>
                </div>

                <x-enterprise.field-row label="Subject" for="repair_subject" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                    <input id="repair_subject" type="text" value="WASSB/31336/1816 - PORTA" class="input-field attach-input" />
                </x-enterprise.field-row>
            </x-enterprise.panel>

            <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
                <div class="subtab-shell">
                    <ul class="subtab-list">
                        @foreach (['general' => 'General', 'remarks' => 'Remarks', 'activities' => 'Activities', 'sales' => 'Sales & Purchasing', 'properties' => 'Properties', 'work-orders' => 'Work Orders', 'attachments' => 'Attachments', 'summary' => 'Summary'] as $key => $label)
                            <li class="subtab-item"><button type="button" class="subtab-link" :class="activeTab === '{{ $key }}' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = '{{ $key }}'">{{ $label }}</button></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div x-cloak x-show="activeTab === 'general'" class="space-y-5">
                <x-enterprise.panel class="grid gap-5 xl:grid-cols-2">
                    <div class="space-y-3">
                        @foreach (['Return Reason 1' => 'Customer Request', 'Return Reason 2' => 'Planning', 'Return Reason 3' => 'Component Delay'] as $label => $value)
                            <x-enterprise.lookup-row :label="$label" :for="'repair_'.\Illuminate\Support\Str::slug($label, '_')" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <div class="attach-inline-control">
                                    <input id="{{ 'repair_'.\Illuminate\Support\Str::slug($label, '_') }}" type="text" value="{{ $value }}" class="input-field attach-input" />
                                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                </div>
                            </x-enterprise.lookup-row>
                        @endforeach
                        <x-enterprise.field-row label="Intervention Type" for="repair_intervention_type" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><select id="repair_intervention_type" class="input-field attach-input"><option selected>Workshop</option><option>Bench</option></select></x-enterprise.field-row>
                        <label class="attach-checkbox-inline"><input type="checkbox" checked /><span>Scheduled</span></label>
                        <div class="pt-6 space-y-3">
                            <x-enterprise.field-row label="Receiving" for="repair_receiving" columns="sm:grid-cols-[132px_120px]"><input id="repair_receiving" type="text" value="RCV-24071" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                            <x-enterprise.field-row label="Shipping" for="repair_shipping" columns="sm:grid-cols-[132px_120px]"><input id="repair_shipping" type="text" value="SHP-24091" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <x-enterprise.lookup-row label="Customer Bill To" for="repair_customer_bill_to" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><div class="attach-inline-control"><input id="repair_customer_bill_to" type="text" value="300028" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                        <x-enterprise.field-row label="Name" for="repair_bill_to_name" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><input id="repair_bill_to_name" type="text" value="WESTSTAR" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <x-enterprise.lookup-row label="Project Name" for="repair_project_name" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><div class="attach-inline-control"><input id="repair_project_name" type="text" value="Repair Campaign 2026" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                        <x-enterprise.lookup-row label="Contract ID" for="repair_contract_id" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><div class="attach-inline-control"><input id="repair_contract_id" type="text" value="CN-24014" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                        <x-enterprise.lookup-row label="Contract Number" for="repair_contract_number" columns="sm:grid-cols-[132px_minmax(0,1fr)]"><div class="attach-inline-control"><input id="repair_contract_number" type="text" value="CNT-1882" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                        <x-enterprise.field-row label="Revision Number" for="repair_revision_number" columns="sm:grid-cols-[132px_180px]"><input id="repair_revision_number" type="text" value="03" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        <div class="pt-6 space-y-3">
                            <x-enterprise.lookup-row label="Assignee" for="repair_assignee" columns="sm:grid-cols-[132px_180px]"><div class="attach-inline-control"><input id="repair_assignee" type="text" value="asyraf" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                            <x-enterprise.lookup-row label="Technician" for="repair_technician" columns="sm:grid-cols-[132px_180px]"><div class="attach-inline-control"><input id="repair_technician" type="text" value="Mohd Amirul" class="input-field attach-input" /><button type="button" class="attach-mini-button attach-mini-button-ghost">...</button></div></x-enterprise.lookup-row>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'remarks'" class="space-y-5"><x-enterprise.panel class="space-y-4 min-h-[320px]"><textarea rows="12" class="input-field attach-textarea min-h-[280px]">Repair event opened after component intake and initial fault isolation. Awaiting cost confirmation and work-order release.</textarea></x-enterprise.panel></div>

            <div x-cloak x-show="activeTab === 'activities'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[980px]" datatable>
                        <x-slot name="thead"><tr><th>Code</th><th>Date</th><th>Time</th><th>Closed</th><th>Assigned to</th><th>Remarks</th><th>Activity</th></tr></x-slot>
                        <x-slot name="tbody"><template x-for="row in @js($activityRows)" :key="row.code"><tr><td x-text="row.code"></td><td x-text="row.date"></td><td x-text="row.time"></td><td><input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600" :checked="row.closed" /></td><td x-text="row.assigned_to"></td><td x-text="row.remarks"></td><td x-text="row.activity"></td></tr></template></x-slot>
                    </x-enterprise.table-shell>
                    <button type="button" class="btn-secondary" @click="statusMessage='New activity draft started for WASSB/31336/1816.'">New Activity</button>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'sales'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_180px]">
                        <div class="space-y-4">
                            <x-enterprise.field-row label="Document Type :" for="repair_document_type" columns="sm:grid-cols-[132px_220px]"><select id="repair_document_type" class="input-field attach-input"><option selected>Quotation Request</option><option>Sales Document</option><option>Purchase Request</option></select></x-enterprise.field-row>
                            <div class="min-h-[220px] rounded-xl border border-gray-200 bg-gray-50/70"></div>
                        </div>
                        <div class="space-y-3"><button type="button" class="btn-secondary" @click="statusMessage='New document draft created.'">New Document</button><button type="button" class="btn-secondary" @click="statusMessage='Generated sales documents for WASSB/31336/1816.'">Generate Sales Documents</button></div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'properties'" class="space-y-5"><x-enterprise.panel class="space-y-4 min-h-[320px]"><textarea rows="12" class="input-field attach-textarea min-h-[280px]">No dedicated cockpit property extensions configured for this repair event yet.</textarea></x-enterprise.panel></div>

            <div x-cloak x-show="activeTab === 'work-orders'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1460px]" datatable>
                        <x-slot name="thead"><tr><th>Level</th><th>Code</th><th>Type</th><th>Title</th><th>Status</th><th>Object Type</th><th>Object Ref</th><th>Item Code/FL Type/Qty</th><th>Serial Number</th><th>Categ. Part/Registration</th><th>Intervention Type</th></tr></x-slot>
                        <x-slot name="tbody"><template x-for="row in @js($workOrderRows)" :key="row.code"><tr><td x-text="row.level"></td><td x-text="row.code"></td><td x-text="row.type"></td><td x-text="row.title"></td><td x-text="row.status"></td><td x-text="row.object_type"></td><td x-text="row.object_ref"></td><td x-text="row.item_code"></td><td x-text="row.serial_number"></td><td x-text="row.category"></td><td x-text="row.intervention_type"></td></tr></template></x-slot>
                    </x-enterprise.table-shell>
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" class="btn-secondary" @click="statusMessage='New work order flow opened from repair cockpit.'">New Work Order</button>
                        <button type="button" class="btn-secondary" @click="statusMessage='New technical log flow opened from repair cockpit.'">New Technical Log</button>
                        <button type="button" class="btn-secondary" @click="statusMessage='Close work orders action prepared.'">Close WOs</button>
                        <button type="button" class="btn-secondary" @click="statusMessage='Fleet Management Cockpit launch prepared.'">Fleet Mngt Cckpit</button>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'attachments'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_160px]">
                        <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable>
                            <x-slot name="thead"><tr><th>#</th><th>Path</th><th>File Name</th><th>Attachment Date</th></tr></x-slot>
                            <x-slot name="tbody"><template x-for="(row, index) in @js($attachments)" :key="row.id"><tr><td x-text="index + 1"></td><td x-text="row.path"></td><td x-text="row.file_name"></td><td x-text="row.attachment_date"></td></tr></template></x-slot>
                        </x-enterprise.table-shell>
                        <div class="flex flex-col gap-3"><button type="button" class="btn-secondary" @click="statusMessage='Attachment picker opened.'">Browse</button><button type="button" class="btn-secondary" @click="statusMessage='Displaying intake-report.pdf.'">Display</button><button type="button" class="btn-secondary" @click="statusMessage='intake-report.pdf removed from the repair event.'">Delete</button></div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'summary'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="rounded-xl border border-gray-200 bg-white px-4 pt-3 shadow-sm">
                        <div class="subtab-shell">
                            <ul class="subtab-list">
                                @foreach (['cost' => 'Cost', 'quotations' => 'Quotations', 'sales-orders' => 'Sales Orders', 'invoices' => 'Invoices'] as $key => $label)
                                    <li class="subtab-item"><button type="button" class="subtab-link" :class="summaryTab === '{{ $key }}' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="summaryTab = '{{ $key }}'">{{ $label }}</button></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div x-cloak x-show="summaryTab === 'cost'" class="space-y-4">
                        <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1280px]" datatable>
                            <x-slot name="thead"><tr><th>Code</th><th>Type</th><th>Status</th><th>Man Hour Cost</th><th>Component Cost</th><th>Other Cost/Services</th></tr></x-slot>
                            <x-slot name="tbody"><template x-for="row in @js($summaryCostRows)" :key="row.code"><tr><td x-text="row.code"></td><td x-text="row.type"></td><td x-text="row.status"></td><td x-text="row.man_hour_cost"></td><td x-text="row.component_cost"></td><td x-text="row.other_cost"></td></tr></template></x-slot>
                        </x-enterprise.table-shell>
                        <div class="flex flex-wrap items-center gap-4">
                            <x-enterprise.field-row label="Labor Cost" for="repair_labor_cost" columns="sm:grid-cols-[88px_96px]"><input id="repair_labor_cost" type="text" value="4,200" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                            <x-enterprise.field-row label="Comp. Cost" for="repair_comp_cost" columns="sm:grid-cols-[88px_96px]"><input id="repair_comp_cost" type="text" value="8,500" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                            <x-enterprise.field-row label="Other Cost" for="repair_other_cost" columns="sm:grid-cols-[88px_96px]"><input id="repair_other_cost" type="text" value="1,100" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                            <x-enterprise.field-row label="Total Cost" for="repair_total_cost" columns="sm:grid-cols-[88px_96px]"><input id="repair_total_cost" type="text" value="13,800" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                        </div>
                    </div>

                    @foreach (['quotations', 'sales-orders', 'invoices'] as $tabKey)
                        <div x-cloak x-show="summaryTab === '{{ $tabKey }}'" class="space-y-4">
                            <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1280px]" datatable>
                                <x-slot name="thead"><tr><th>Code</th><th>Remark</th><th>Posting Date</th><th>Status</th><th>Sales Pack Price</th><th>Man Hour Price</th><th>Component Price</th><th>Service/Other Costs</th><th>Total Price</th><th>Sales</th></tr></x-slot>
                                <x-slot name="tbody"><template x-for="row in @js($summaryRows)" :key="`${row.code}-{{ $tabKey }}`"><tr><td x-text="row.code"></td><td x-text="row.remark"></td><td x-text="row.posting_date"></td><td x-text="row.status"></td><td x-text="row.sales_pack_price"></td><td x-text="row.man_hour_price"></td><td x-text="row.component_price"></td><td x-text="row.service_price"></td><td x-text="row.total_price"></td><td x-text="row.sales"></td></tr></template></x-slot>
                            </x-enterprise.table-shell>
                        </div>
                    @endforeach
                </x-enterprise.panel>
            </div>

            <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="btn-primary" @click="statusMessage='Loaded repair information WASSB/31336/1816.'">Find</button>
                    <button type="button" class="btn-secondary" @click="statusMessage='Repair information cockpit closed for this session.'">Cancel</button>
                </div>
                <div class="flex flex-wrap items-center gap-4">
                    <x-enterprise.field-row label="Updated By" for="repair_updated_by" columns="sm:grid-cols-[88px_132px]"><input id="repair_updated_by" type="text" value="acap" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="Update Date" for="repair_update_date" columns="sm:grid-cols-[92px_164px]"><input id="repair_update_date" type="text" value="2026-04-07" class="input-field attach-input input-field-filled" /></x-enterprise.field-row>
                </div>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
