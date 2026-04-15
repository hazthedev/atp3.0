@extends('layouts.app')

@section('title', 'List of Postponed Operations')

@php
    $operationsRows = [
        [
            'object_type' => 'Functional Location',
            'object_ref' => '9M-WAY',
            'item_code' => 'AW139',
            'serial_number' => '31501',
            'category' => '9M-WAY',
            'work_order' => 'WO-24116',
            'deadline' => '2026-04-18',
            'description' => 'Deferred autopilot trim re-calibration after test flight window.',
            'duration' => '02:30',
            'task_list_ref' => 'TL-4821',
            'previous_work_order' => 'WO-23874',
            'decision' => 'DEC-19',
            'comment' => 'Coordinate with line maintenance before next dispatch.',
            'removed' => false,
        ],
        [
            'object_type' => 'Functional Location',
            'object_ref' => '9M-WST',
            'item_code' => 'AW189',
            'serial_number' => '49021',
            'category' => '9M-WST',
            'work_order' => 'WO-24138',
            'deadline' => '2026-04-20',
            'description' => 'Cabin speaker replacement postponed pending material arrival.',
            'duration' => '01:45',
            'task_list_ref' => 'TL-4917',
            'previous_work_order' => 'WO-23982',
            'decision' => 'DEC-22',
            'comment' => 'Component tracked under warehouse transfer.',
            'removed' => false,
        ],
        [
            'object_type' => 'Equipment',
            'object_ref' => 'ENG-000041',
            'item_code' => 'PT6C-67C',
            'serial_number' => 'PCE-A1102',
            'category' => 'Engine',
            'work_order' => 'WO-24002',
            'deadline' => '2026-04-08',
            'description' => 'Engine trend review postponed until updated power assurance data received.',
            'duration' => '00:45',
            'task_list_ref' => 'TL-4704',
            'previous_work_order' => 'WO-23611',
            'decision' => 'DEC-07',
            'comment' => 'Removed from active package but visible for traceability.',
            'removed' => true,
        ],
    ];

    $componentIssuedRows = [
        [
            'item_code' => 'A139-24-114',
            'item_desc' => 'Autopilot Control Module',
            'qty' => '1.00',
            'object_type' => 'Functional Location',
            'object_ref' => '9M-WAY',
            'item_or_fl' => 'AW139',
            'serial_number' => '31501',
            'category' => '9M-WAY',
            'work_order' => 'WO-24116',
            'description' => 'Issue replacement control module for postponed rectification.',
            'previous_work_order' => 'WO-23874',
            'warehouse' => 'KL Line Store',
            'decision' => 'DEC-19',
        ],
        [
            'item_code' => 'A189-53-220',
            'item_desc' => 'Cabin Speaker Set',
            'qty' => '2.00',
            'object_type' => 'Functional Location',
            'object_ref' => '9M-WST',
            'item_or_fl' => 'AW189',
            'serial_number' => '49021',
            'category' => 'Cabin',
            'work_order' => 'WO-24138',
            'description' => 'Material waiting for counter release before issue.',
            'previous_work_order' => 'WO-23982',
            'warehouse' => 'Subang Main',
            'decision' => 'DEC-22',
        ],
    ];

    $componentReceivedRows = [
        [
            'item_code' => 'A139-32-018',
            'item_desc' => 'Brake Wear Sensor',
            'qty' => '1.00',
            'object_type' => 'Functional Location',
            'object_ref' => '9M-WAL',
            'item_or_fl' => 'AW139',
            'serial_number' => '31384',
            'category' => 'Landing Gear',
            'work_order' => 'WO-24088',
            'description' => 'Awaiting received confirmation from warehouse after removal.',
            'previous_work_order' => 'WO-23898',
            'warehouse' => 'KL Recovery',
            'decision' => 'DEC-14',
        ],
    ];

    $purchasingRows = [
        [
            'item_code' => 'A139-27-118',
            'item_desc' => 'Trim Actuator Assembly',
            'qty' => '1.00',
            'object_type' => 'Functional Location',
            'object_ref' => '9M-WAS',
            'item_or_fl' => 'AW139',
            'serial_number' => '31441',
            'category' => 'Flight Controls',
            'work_order' => 'WO-24145',
            'description' => 'Purchase request pending approval for postponed rectification kit.',
            'previous_work_order' => 'WO-24091',
        ],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            activeTab: 'operations',
            componentsTab: 'issued',
            operator: 'Weststar Aviation Services',
            owner: 'Weststar Aviation Services',
            functionalLocation: '9M-WAY',
            equipment: '',
            showRemoved: false,
            statusMessage: '',
            operationsRows: @js($operationsRows),
            componentIssuedRows: @js($componentIssuedRows),
            componentReceivedRows: @js($componentReceivedRows),
            purchasingRows: @js($purchasingRows),
            filteredOperations() {
                return this.operationsRows.filter((row) => this.showRemoved || !row.removed);
            },
            refreshWorkspace() {
                this.statusMessage = `Refreshed postponed operations for ${this.functionalLocation || 'current selection'}.`;
            },
            removeOperations() {
                this.statusMessage = `Prepared ${this.filteredOperations().length} postponed operation record(s) for removal review.`;
            },
            confirmSelection() {
                this.statusMessage = `Postponed operations workspace confirmed on ${this.activeTab} tab.`;
            },
            cancelSelection() {
                this.statusMessage = 'Postponed operations kept in preview mode.';
            },
        }"
    >
        <x-page-header
            title="List of Postponed Operations"
            description="Operational review workspace for postponed operations, component flows, and purchasing follow-up using the current ATP design system."
        />

        <section class="max-w-[1280px] space-y-5">
            <template x-if="statusMessage">
                <div class="flex items-center rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800" role="alert">
                    <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
                    <span x-text="statusMessage"></span>
                </div>
            </template>

            {{-- Filter --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_auto] xl:items-end">
                    <div class="space-y-3">
                        <div>
                            <label for="postponed_operator" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Operator</label>
                            <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                                <input id="postponed_operator" type="text" x-model="operator" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20" />
                                <button type="button" class="rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm text-gray-500 hover:bg-gray-50">...</button>
                            </div>
                        </div>
                        <div>
                            <label for="postponed_owner" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Owner</label>
                            <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                                <input id="postponed_owner" type="text" x-model="owner" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20" />
                                <button type="button" class="rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm text-gray-500 hover:bg-gray-50">...</button>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label for="postponed_fl" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Functional Location</label>
                            <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                                <input id="postponed_fl" type="text" x-model="functionalLocation" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20" />
                                <button type="button" class="rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm text-gray-500 hover:bg-gray-50">...</button>
                            </div>
                        </div>
                        <div>
                            <label for="postponed_equipment" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Equipment</label>
                            <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                                <input id="postponed_equipment" type="text" x-model="equipment" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20" />
                                <button type="button" class="rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm text-gray-500 hover:bg-gray-50">...</button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-end">
                        <button type="button" class="btn-secondary" @click="refreshWorkspace()">Refresh</button>
                    </div>
                </div>

                <div class="mt-4 border-t border-gray-100 pt-4">
                    <label class="inline-flex cursor-pointer items-center gap-3 text-sm text-gray-700">
                        <input type="checkbox" x-model="showRemoved" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                        <span>Display removed postponed operations</span>
                    </label>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="border-b border-gray-200">
                <ul class="-mb-px flex flex-wrap text-sm font-medium text-gray-500">
                    <li class="me-2">
                        <button type="button" class="inline-flex items-center gap-2 rounded-t-lg border-b-2 p-4 transition-colors" :class="activeTab === 'operations' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:border-gray-300 hover:text-gray-600'" @click="activeTab = 'operations'">
                            <x-icon name="adjustments-horizontal" class="h-4 w-4" />
                            Operations
                        </button>
                    </li>
                    <li class="me-2">
                        <button type="button" class="inline-flex items-center gap-2 rounded-t-lg border-b-2 p-4 transition-colors" :class="activeTab === 'components' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:border-gray-300 hover:text-gray-600'" @click="activeTab = 'components'">
                            <x-icon name="cube" class="h-4 w-4" />
                            Components
                        </button>
                    </li>
                    <li class="me-2">
                        <button type="button" class="inline-flex items-center gap-2 rounded-t-lg border-b-2 p-4 transition-colors" :class="activeTab === 'purchasing' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:border-gray-300 hover:text-gray-600'" @click="activeTab = 'purchasing'">
                            <x-icon name="briefcase" class="h-4 w-4" />
                            Purchasing
                        </button>
                    </li>
                </ul>
            </div>

            {{-- Operations tab --}}
            <div x-cloak x-show="activeTab === 'operations'" class="space-y-4">
                <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse min-w-[1480px]">
                            <thead class="border-b border-gray-200 bg-gray-50">
                                <tr>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Object Type</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Object Ref</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Item Code / FL</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Serial Number</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Categ. Part / Reg.</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Work Order</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Deadline</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Description</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Duration</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Task List Ref.</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Previous Work Order</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Decision #</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Comment</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <template x-for="(row, index) in filteredOperations()" :key="`${row.work_order}-${index}`">
                                    <tr class="transition-colors hover:bg-blue-50/60">
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.object_type"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 font-medium text-gray-900" x-text="row.object_ref"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.item_code"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.serial_number"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.category"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.work_order"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.deadline"></td>
                                        <td class="max-w-[280px] whitespace-normal px-3 py-2.5 text-gray-700" x-text="row.description"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.duration"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.task_list_ref"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.previous_work_order"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5">
                                            <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700" x-text="row.decision"></span>
                                        </td>
                                        <td class="max-w-[280px] whitespace-normal px-3 py-2.5 text-gray-700" x-text="row.comment"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="button" class="btn-secondary" @click="removeOperations()">Remove Operations</button>
                </div>
            </div>

            {{-- Components tab --}}
            <div x-cloak x-show="activeTab === 'components'" class="space-y-4">
                <div class="border-b border-gray-200">
                    <ul class="-mb-px flex flex-wrap text-sm font-medium text-gray-500">
                        <li class="me-2">
                            <button type="button" class="inline-flex items-center gap-2 rounded-t-lg border-b-2 p-4 transition-colors" :class="componentsTab === 'issued' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:border-gray-300 hover:text-gray-600'" @click="componentsTab = 'issued'">
                                <x-icon name="document-text" class="h-4 w-4" />
                                To be Issued
                            </button>
                        </li>
                        <li class="me-2">
                            <button type="button" class="inline-flex items-center gap-2 rounded-t-lg border-b-2 p-4 transition-colors" :class="componentsTab === 'received' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:border-gray-300 hover:text-gray-600'" @click="componentsTab = 'received'">
                                <x-icon name="check-circle" class="h-4 w-4" />
                                To be Received
                            </button>
                        </li>
                    </ul>
                </div>

                @php
                    $componentCols = ['Item Code', 'Item Desc.', 'Qty', 'Object Type', 'Object Ref', 'Item Code / FL', 'Serial Number', 'Categ. Part / Reg.', 'Work Order', 'Description', 'Previous Work Order', 'Warehouse', 'Decision #'];
                @endphp

                <div x-cloak x-show="componentsTab === 'issued'" class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse min-w-[1480px]">
                            <thead class="border-b border-gray-200 bg-gray-50">
                                <tr>
                                    @foreach ($componentCols as $col)
                                        <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">{{ $col }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <template x-for="(row, index) in componentIssuedRows" :key="`${row.work_order}-issued-${index}`">
                                    <tr class="transition-colors hover:bg-blue-50/60">
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.item_code"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.item_desc"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.qty"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.object_type"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 font-medium text-gray-900" x-text="row.object_ref"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.item_or_fl"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.serial_number"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.category"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.work_order"></td>
                                        <td class="max-w-[280px] whitespace-normal px-3 py-2.5 text-gray-700" x-text="row.description"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.previous_work_order"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.warehouse"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5">
                                            <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700" x-text="row.decision"></span>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div x-cloak x-show="componentsTab === 'received'" class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse min-w-[1480px]">
                            <thead class="border-b border-gray-200 bg-gray-50">
                                <tr>
                                    @foreach ($componentCols as $col)
                                        <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">{{ $col }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <template x-for="(row, index) in componentReceivedRows" :key="`${row.work_order}-received-${index}`">
                                    <tr class="transition-colors hover:bg-blue-50/60">
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.item_code"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.item_desc"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.qty"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.object_type"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 font-medium text-gray-900" x-text="row.object_ref"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.item_or_fl"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.serial_number"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.category"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.work_order"></td>
                                        <td class="max-w-[280px] whitespace-normal px-3 py-2.5 text-gray-700" x-text="row.description"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.previous_work_order"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.warehouse"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5">
                                            <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700" x-text="row.decision"></span>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Purchasing tab --}}
            <div x-cloak x-show="activeTab === 'purchasing'">
                <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse min-w-[1480px]">
                            <thead class="border-b border-gray-200 bg-gray-50">
                                <tr>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Item Code</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Item Desc.</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Qty</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Object Type</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Object Ref</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Item Code / FL</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Serial Number</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Categ. Part / Reg.</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Work Order</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Description</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Previous Work Order</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <template x-for="(row, index) in purchasingRows" :key="`${row.work_order}-purchasing-${index}`">
                                    <tr class="transition-colors hover:bg-blue-50/60">
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.item_code"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.item_desc"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.qty"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.object_type"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 font-medium text-gray-900" x-text="row.object_ref"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.item_or_fl"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.serial_number"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.category"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.work_order"></td>
                                        <td class="max-w-[280px] whitespace-normal px-3 py-2.5 text-gray-700" x-text="row.description"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.previous_work_order"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3 border-t border-gray-200 pt-5">
                <button type="button" class="btn-primary" @click="confirmSelection()">OK</button>
                <button type="button" class="btn-secondary" @click="cancelSelection()">Cancel</button>
            </div>
        </section>
    </div>
@endsection
