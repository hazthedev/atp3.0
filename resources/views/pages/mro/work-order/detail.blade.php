@extends('layouts.app')

@section('title', 'Work Order')

@php
    $operations = [
        ['code' => '0010', 'desc' => '3200HRS INSPECTION', 'performed' => '120:00', 'duration' => '140:00'],
        ['code' => '0020', 'desc' => 'RECTIFICATION CHECK', 'performed' => '16:00', 'duration' => '24:00'],
    ];
    $qualifications = [
        ['group' => 'B1.3', 'qualification' => 'Helicopter Maintenance', 'linked' => '0010'],
        ['group' => 'Avionic', 'qualification' => 'Electrical Systems', 'linked' => '0020'],
    ];
    $tools = [
        ['item' => 'TL-0098', 'desc' => 'Torque Wrench', 'uom' => 'EA', 'qty' => '1', 'issued' => '1', 'warehouse' => 'KUL-TOOL', 'warehouse_type' => 'Tool Crib', 'linked' => '0010'],
        ['item' => 'TL-0191', 'desc' => 'Hydraulic Jack', 'uom' => 'EA', 'qty' => '2', 'issued' => '2', 'warehouse' => 'KUL-TOOL', 'warehouse_type' => 'Tool Crib', 'linked' => '0020'],
    ];
    $summaryCost = [
        'man_hour' => '0.0000',
        'component' => '0.0000',
        'other' => '0.0000',
        'total' => '0.0000',
    ];

    $tabButtonClass = 'inline-flex items-center border-b-2 px-1 pb-4 pt-2 text-sm font-medium transition';
    $activeTabClass = 'border-[#2f5bff] text-[#2f5bff]';
    $inactiveTabClass = 'border-transparent text-slate-500 hover:border-[#9fb2ff] hover:text-[#2f5bff]';
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            activeTab: 'general',
            detailTab: 'operations',
            stockTab: 'to-be-issued',
            summaryTab: 'cost',
            salesTab: 'quotations',
            purchasingTab: 'purchase-requests',
            statusMessage: '',
            action(message) { this.statusMessage = message; },
        }"
    >
        <x-page-header
            title="Work Order"
            description="MRO work order cockpit for execution data, linked objects, actions, and commercial summary tracking."
        />

        <section class="w-full space-y-5">
            <template x-if="statusMessage">
                <div class="flex items-center rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800" role="alert">
                    <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
                    <span x-text="statusMessage"></span>
                </div>
            </template>

            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="-mb-px flex flex-wrap gap-x-6 border-b border-slate-200 px-5 pt-4">
                    <button type="button" class="{{ $tabButtonClass }}" :class="activeTab === 'general' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="activeTab='general'">General</button>
                    <button type="button" class="{{ $tabButtonClass }}" :class="activeTab === 'details' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="activeTab='details'">Details</button>
                    <button type="button" class="{{ $tabButtonClass }}" :class="activeTab === 'properties' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="activeTab='properties'">Properties</button>
                    <button type="button" class="{{ $tabButtonClass }}" :class="activeTab === 'remark' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="activeTab='remark'">Remark</button>
                    <button type="button" class="{{ $tabButtonClass }}" :class="activeTab === 'reference' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="activeTab='reference'">Reference</button>
                    <button type="button" class="{{ $tabButtonClass }}" :class="activeTab === 'action' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="activeTab='action'">Action</button>
                    <button type="button" class="{{ $tabButtonClass }}" :class="activeTab === 'summary' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="activeTab='summary'">Summary</button>
                </div>

                <div class="p-5">
                    <div x-show="activeTab==='general'" class="space-y-5">
                        <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
                            <div class="space-y-4">
                                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-[220px_160px_1fr]">
                                    <div>
                                        <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Code</label>
                                        <input type="text" value="WO-36424" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" />
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Type</label>
                                        <select class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100">
                                            <option>Repair Order</option>
                                            <option>Check</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Title</label>
                                        <input type="text" value="EMERGENCY POWER UNIT INVESTIGATION" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" />
                                    </div>
                                </div>

                                <div class="grid gap-4 lg:grid-cols-2">
                                    <div class="space-y-3">
                                        @foreach ([
                                            ['Equipment No.', '9M-WSV'],
                                            ['Internal S/N', '49051'],
                                            ['Item Code', 'AW139'],
                                            ['Item Description', 'AIRFRAME'],
                                            ['Variant', 'AW139'],
                                            ['Category Part', '9M-WSV'],
                                            ['Item Code Out', 'AW139-OUT'],
                                            ['Customer', '300028'],
                                            ['Name', '*WESTSTAR'],
                                        ] as [$label, $value])
                                            <div>
                                                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">{{ $label }}</label>
                                                <input type="text" value="{{ $value }}" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" />
                                            </div>
                                        @endforeach

                                        <div>
                                            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Intervention Type</label>
                                            <select class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100">
                                                <option>Maintenance</option>
                                                <option>Repair</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Comment</label>
                                            <input type="text" value="Carry out released repair action." class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" />
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Status</label>
                                            <select class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100">
                                                <option>Released</option>
                                                <option>Planned</option>
                                            </select>
                                        </div>
                                        @foreach ([
                                            ['Project Name', 'AV139 Cabin Campaign'],
                                            ['Repair Order', 'RO-20384'],
                                            ['Create Date', '2026-04-07'],
                                            ['Estimate Start Date', '2026-04-09'],
                                            ['Start Date', '2026-04-10'],
                                            ['Expected Man Hour', '140:00'],
                                            ['Total Duration (Day(s))', '12'],
                                            ['Due Date', '2026-04-25'],
                                            ['Date Out', ''],
                                            ['Close Date', ''],
                                            ['Created By', 'asyraf'],
                                            ['Closed By', ''],
                                            ['Branch', 'Main'],
                                            ['Work Center', 'Mechanical'],
                                            ['Father Object', 'WO-ROOT-118'],
                                            ['External Ref.', 'EXT-WO-36424'],
                                            ['Ref. Origin', 'RLS-2407'],
                                        ] as [$label, $value])
                                            <div>
                                                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">{{ $label }}</label>
                                                <input type="text" value="{{ $value }}" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3 rounded-2xl border border-gray-200 p-4">
                                <label class="inline-flex items-center gap-3 text-sm text-gray-700">
                                    <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                    <span>Allocate Part</span>
                                </label>
                                <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100 w-full" @click="action('Follow up opened for work order WO-36424.')">Follow Up</button>
                                <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100 w-full" @click="action('Counter reading opened for work order WO-36424.')">Counter Reading</button>
                                <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100 w-full" @click="action('Technical log lookup opened from Work Order.')">Technical Log</button>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-4 border-t border-gray-200 pt-5">
                            <div class="flex flex-wrap gap-3">
                                <button type="button" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100" @click="action('Find work order dialog opened.')">Find</button>
                                <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Work order edit cancelled.')">Cancel</button>
                            </div>

                            <div class="grid gap-3 sm:grid-cols-2">
                                <div>
                                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Updated By</label>
                                    <input type="text" value="asyraf" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" />
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Update Date</label>
                                    <input type="text" value="2026-04-07" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTab==='details'" class="space-y-5">
                        <div class="-mb-px flex flex-wrap gap-x-6 border-b border-slate-200">
                            <button type="button" class="{{ $tabButtonClass }}" :class="detailTab === 'operations' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="detailTab='operations'">Operations</button>
                            <button type="button" class="{{ $tabButtonClass }}" :class="detailTab === 'qualifications' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="detailTab='qualifications'">Qualifications</button>
                            <button type="button" class="{{ $tabButtonClass }}" :class="detailTab === 'components' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="detailTab='components'">Components</button>
                            <button type="button" class="{{ $tabButtonClass }}" :class="detailTab === 'tools' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="detailTab='tools'">Tools</button>
                            <button type="button" class="{{ $tabButtonClass }}" :class="detailTab === 'purchasing' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="detailTab='purchasing'">Purchasing</button>
                            <button type="button" class="{{ $tabButtonClass }}" :class="detailTab === 'measurement-points' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="detailTab='measurement-points'">Measurement Points</button>
                            <button type="button" class="{{ $tabButtonClass }}" :class="detailTab === 'attachments' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="detailTab='attachments'">Attachments</button>
                        </div>

                        <div x-show="detailTab==='operations'" class="space-y-4">
                            <x-enterprise.table-shell table-class="enterprise-static-table min-w-[980px]" datatable>
                                <x-slot name="thead">
                                    <tr>
                                        <th>Op Code</th>
                                        <th>Description</th>
                                        <th>Performed</th>
                                        <th>Duration</th>
                                    </tr>
                                </x-slot>
                                <x-slot name="tbody">
                                    @foreach ($operations as $row)
                                        <tr>
                                            <td class="font-medium text-gray-900">{{ $row['code'] }}</td>
                                            <td class="min-w-[320px]">{{ $row['desc'] }}</td>
                                            <td>{{ $row['performed'] }}</td>
                                            <td>{{ $row['duration'] }}</td>
                                        </tr>
                                    @endforeach
                                </x-slot>
                            </x-enterprise.table-shell>

                            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-[160px_160px_160px_160px_auto]">
                                <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Operation deleted from work order.')">Delete</button>
                                <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Postponed operations opened for work order.')">Postponed Operations</button>
                                <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Task list opened from work order.')">Task List</button>
                                <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Time sheet opened for work order.')">Time Sheet</button>
                                <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100 justify-self-start" @click="action('Assign employees flow opened.')">Assign Employees</button>
                            </div>
                        </div>

                        <x-enterprise.table-shell x-show="detailTab==='qualifications'" table-class="enterprise-static-table min-w-[980px]" datatable>
                            <x-slot name="thead">
                                <tr>
                                    <th>Qualification Group</th>
                                    <th>Qualification</th>
                                    <th>Linked Op</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                @foreach ($qualifications as $row)
                                    <tr>
                                        <td>{{ $row['group'] }}</td>
                                        <td>{{ $row['qualification'] }}</td>
                                        <td>{{ $row['linked'] }}</td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-enterprise.table-shell>

                        <div x-show="detailTab==='components'" class="space-y-4">
                            <div class="-mb-px flex flex-wrap gap-x-6 border-b border-slate-200">
                                <button type="button" class="{{ $tabButtonClass }}" :class="stockTab === 'to-be-issued' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="stockTab='to-be-issued'">To Be Issued</button>
                                <button type="button" class="{{ $tabButtonClass }}" :class="stockTab === 'to-be-received' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="stockTab='to-be-received'">To Be Received</button>
                            </div>
                            <div class="rounded-xl border border-gray-200 p-6 text-sm text-gray-500">Component movements for <span x-text="stockTab === 'to-be-issued' ? 'issue' : 'receipt'"></span> are displayed here.</div>
                            <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Component line deleted from work order.')">Delete</button>
                        </div>

                        <x-enterprise.table-shell x-show="detailTab==='tools'" table-class="enterprise-static-table min-w-[1100px]" datatable>
                            <x-slot name="thead">
                                <tr>
                                    <th>Item Code</th>
                                    <th>Item Desc</th>
                                    <th>UoM</th>
                                    <th>Qty</th>
                                    <th>Issued</th>
                                    <th>Warehouse</th>
                                    <th>Warehouse Type</th>
                                    <th>Linked Op</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                @foreach ($tools as $row)
                                    <tr>
                                        <td>{{ $row['item'] }}</td>
                                        <td>{{ $row['desc'] }}</td>
                                        <td>{{ $row['uom'] }}</td>
                                        <td>{{ $row['qty'] }}</td>
                                        <td>{{ $row['issued'] }}</td>
                                        <td>{{ $row['warehouse'] }}</td>
                                        <td>{{ $row['warehouse_type'] }}</td>
                                        <td>{{ $row['linked'] }}</td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-enterprise.table-shell>

                        <div x-show="detailTab==='purchasing'" class="rounded-xl border border-gray-200 p-6 text-sm text-gray-500">
                            Purchasing lines linked to the work order are displayed in this workspace.
                        </div>

                        <div x-show="detailTab==='measurement-points'" class="space-y-4 rounded-xl border border-gray-200 p-6">
                            <div class="min-h-[260px] text-sm text-gray-500">Measurement point records appear here.</div>
                            <div class="flex justify-between">
                                <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Measurement point recording opened.')">Recording</button>
                                <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Measurement point edit opened.')">Edit</button>
                            </div>
                        </div>

                        <div x-show="detailTab==='attachments'" class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_180px]">
                            <div class="min-h-[320px] rounded-xl border border-gray-200 bg-gray-50"></div>
                            <div class="flex flex-col gap-3">
                                <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Attachment browser opened.')">Browse</button>
                                <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Attachment display opened.')">Display</button>
                                <div class="grow"></div>
                                <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Attachment deleted from work order.')">Delete</button>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTab==='properties'" class="rounded-2xl border border-gray-200 p-6 text-sm text-gray-500 min-h-[320px]">
                        Work order properties are displayed here.
                    </div>

                    <div x-show="activeTab==='remark'" class="rounded-2xl border border-gray-200 bg-amber-50 p-6 min-h-[320px]">
                        <textarea class="h-[260px] w-full rounded-xl border border-amber-200 bg-transparent p-4 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">Repair order remarks and workshop comments.</textarea>
                    </div>

                    <div x-show="activeTab==='reference'" class="rounded-2xl border border-gray-200 bg-amber-50 p-6 min-h-[320px]">
                        <textarea class="h-[260px] w-full rounded-xl border border-amber-200 bg-transparent p-4 text-sm text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">External and origin references for the work order.</textarea>
                    </div>

                    <div x-show="activeTab==='action'" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                        <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Receiving inventory action opened.')">Receiving Inventory</button>
                        <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Attach equipment action opened.')">Attach Equipment</button>
                        <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Generate sales documents action opened.')">Generate Sales Documents</button>
                        <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Update installed base action opened.')">Update Installed base</button>
                        <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Detach equipment action opened.')">Detach Equipment</button>
                        <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Apply modification action opened.')">Apply modification</button>
                        <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Inspection action opened.')">Inspection</button>
                        <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Update counters action opened.')">Update counters</button>
                        <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Reference evolution action opened.')">Reference evolution</button>
                        <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('After work update action opened.')">After Work Update</button>
                        <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Swap equipment action opened.')">Swap Equipment</button>
                        <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="action('Fleet Management Cockpit opened from work order.')">Fleet Mngt Cockpit</button>
                    </div>

                    <div x-show="activeTab==='summary'" class="space-y-5">
                        <div class="-mb-px flex flex-wrap gap-x-6 border-b border-slate-200">
                            <button type="button" class="{{ $tabButtonClass }}" :class="summaryTab === 'cost' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="summaryTab='cost'">Cost</button>
                            <button type="button" class="{{ $tabButtonClass }}" :class="summaryTab === 'sales' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="summaryTab='sales'">Sales</button>
                            <button type="button" class="{{ $tabButtonClass }}" :class="summaryTab === 'purchasing' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="summaryTab='purchasing'">Purchasing</button>
                        </div>

                        <div x-show="summaryTab==='cost'" class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                            <div>
                                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Man Hour Cost</label>
                                <input type="text" value="{{ $summaryCost['man_hour'] }}" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" />
                            </div>
                            <div>
                                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Component Cost</label>
                                <input type="text" value="{{ $summaryCost['component'] }}" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" />
                            </div>
                            <div>
                                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Other Cost / Services</label>
                                <input type="text" value="{{ $summaryCost['other'] }}" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" />
                            </div>
                            <div>
                                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Total Cost</label>
                                <input type="text" value="{{ $summaryCost['total'] }}" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" />
                            </div>
                        </div>

                        <div x-show="summaryTab==='sales'" class="space-y-4">
                            <div class="-mb-px flex flex-wrap gap-x-6 border-b border-slate-200">
                                <button type="button" class="{{ $tabButtonClass }}" :class="salesTab === 'quotations' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="salesTab='quotations'">Quotations</button>
                                <button type="button" class="{{ $tabButtonClass }}" :class="salesTab === 'sales-orders' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="salesTab='sales-orders'">Sales Orders</button>
                                <button type="button" class="{{ $tabButtonClass }}" :class="salesTab === 'invoices' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="salesTab='invoices'">Invoices</button>
                            </div>
                            <div class="min-h-[320px] rounded-xl border border-gray-200 bg-gray-50"></div>
                        </div>

                        <div x-show="summaryTab==='purchasing'" class="space-y-4">
                            <div class="-mb-px flex flex-wrap gap-x-6 border-b border-slate-200">
                                <button type="button" class="{{ $tabButtonClass }}" :class="purchasingTab === 'purchase-requests' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="purchasingTab='purchase-requests'">Purchase requests</button>
                                <button type="button" class="{{ $tabButtonClass }}" :class="purchasingTab === 'purchase-orders' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="purchasingTab='purchase-orders'">Purchase orders</button>
                                <button type="button" class="{{ $tabButtonClass }}" :class="purchasingTab === 'goods-receipts-po' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="purchasingTab='goods-receipts-po'">Goods receipts PO</button>
                                <button type="button" class="{{ $tabButtonClass }}" :class="purchasingTab === 'ap-invoices' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="purchasingTab='ap-invoices'">A/P Invoices</button>
                            </div>
                            <div class="min-h-[320px] rounded-xl border border-gray-200 bg-gray-50"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
