@extends('layouts.app')

@section('title', 'Search Work Order')

@php
    $fatherRows = [
        ['code' => 'WO-36424', 'status' => 'Released', 'type' => 'Work Order', 'title' => '3200HRS INSPECTION'],
        ['code' => 'WP-24011', 'status' => 'Open', 'type' => 'Workpackage', 'title' => 'Line Maintenance Package'],
        ['code' => 'DFL-1049', 'status' => 'Closed', 'type' => 'Daily Flight Log', 'title' => 'AW139 Daily Flight Log'],
    ];
    $taskRows = [
        ['ref' => 'AW189 95-06', 'type' => 'Type A', 'ata' => '95', 'desc' => 'Detailed inspection', 'action' => 'INSP', 'status' => 'Released', 'ext' => 'EXT-9506'],
        ['ref' => 'AW189 95-07', 'type' => 'Type B', 'ata' => '95', 'desc' => 'Detailed inspection', 'action' => 'INSP', 'status' => 'Released', 'ext' => 'EXT-9507'],
    ];
    $qualRows = [
        ['group' => 'B1.3', 'qualification' => 'Helicopter Maintenance'],
        ['group' => 'Avionic', 'qualification' => 'Electrical Systems'],
    ];
    $resultRows = [
        ['code' => '06477', 'type' => 'OOP Life Limit', 'op' => '0010', 'desc' => 'Detailed inspection', 'task' => 'AW189 95-06', 'obj_type' => 'Functional Location', 'obj_ref' => '9M-WSV', 'item' => 'AW189', 'sn' => '49051', 'cat' => '9M-WSV'],
        ['code' => '204352', 'type' => 'Repair Order', 'op' => '0010', 'desc' => 'EMERGENCY POW', 'task' => '', 'obj_type' => 'Customer', 'obj_ref' => '300028', 'item' => '*WESTSTAR', 'sn' => '', 'cat' => ''],
        ['code' => '300028', 'type' => 'Repair Order', 'op' => '0010', 'desc' => 'LH LIFERAFT IN', 'task' => '', 'obj_type' => 'Equipment', 'obj_ref' => '18333', 'item' => '3G256V000334', 'sn' => '109', 'cat' => 'H/T LLP'],
        ['code' => 'CW1282', 'type' => 'Repair Order', 'op' => '0010', 'desc' => 'HALO LIFEJACK', 'task' => '', 'obj_type' => 'Equipment', 'obj_ref' => '41556', 'item' => '00031010', 'sn' => '0003101001484', 'cat' => 'H/T LLP'],
    ];
    $workTypes = ['Inspection', 'Repair', 'Replacement', 'Calibration'];
    $tabButtonClass = 'inline-flex items-center border-b-2 px-1 pb-4 pt-2 text-sm font-medium transition';
    $activeTabClass = 'border-[#2f5bff] text-[#2f5bff]';
    $inactiveTabClass = 'border-transparent text-slate-500 hover:border-[#9fb2ff] hover:text-[#2f5bff]';
@endphp

@section('content')
    <div class="space-y-6" x-data="{ activeTab: 'general', fatherTab: 'work-order', statusMessage: '', resultRows: @js($resultRows), search(){ this.activeTab='result'; this.statusMessage=`Found ${this.resultRows.length} work order record(s).`; this.$nextTick(() => window.refreshFlowbiteTables?.()); }, reset(){ this.activeTab='general'; this.fatherTab='work-order'; this.statusMessage='Search Work Order filters reset.'; }, cancel(){ this.statusMessage=`Search session closed with ${this.activeTab==='result' ? this.resultRows.length : 0} result record(s).`; } }">
        <x-page-header title="Search Work Order" description="MRO work order search workspace with header, object, task list, and result filtering across released and repair-order records." />

        <section class="w-full space-y-5">
            <template x-if="statusMessage">
                <div class="flex items-center rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800" role="alert">
                    <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
                    <span x-text="statusMessage"></span>
                </div>
            </template>

            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 px-5 py-4">
                    <h3 class="text-sm font-semibold text-gray-900">Search Work Order</h3>
                    <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="reset()">Reset</button>
                </div>

                <div class="-mb-px flex flex-wrap gap-x-6 border-b border-slate-200 px-5 pt-4">
                    <button type="button" class="{{ $tabButtonClass }}" :class="activeTab === 'general' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="activeTab='general'; $nextTick(() => window.refreshFlowbiteTables?.())">General</button>
                    <button type="button" class="{{ $tabButtonClass }}" :class="activeTab === 'details' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="activeTab='details'; $nextTick(() => window.refreshFlowbiteTables?.())">Details</button>
                    <button type="button" class="{{ $tabButtonClass }}" :class="activeTab === 'task-list' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="activeTab='task-list'; $nextTick(() => window.refreshFlowbiteTables?.())">Task List</button>
                    <button type="button" class="{{ $tabButtonClass }}" :class="activeTab === 'properties' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="activeTab='properties'; $nextTick(() => window.refreshFlowbiteTables?.())">Properties</button>
                    <button type="button" class="{{ $tabButtonClass }}" :class="activeTab === 'result' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="activeTab='result'; $nextTick(() => window.refreshFlowbiteTables?.())">Result</button>
                </div>

                <div class="p-5">
                    <div x-show="activeTab==='general'" class="space-y-5">
                        <div class="grid gap-5 xl:grid-cols-[380px_minmax(0,1fr)]">
                            <div class="rounded-2xl border border-gray-200 p-4">
                                <h4 class="mb-4 text-xs font-semibold uppercase tracking-wider text-gray-500">Header</h4>
                                <div class="grid gap-3">
                                    @foreach (['Status', 'Type', 'Project name', 'Repair order'] as $label)
                                        <label class="flex items-center gap-3 text-sm text-gray-700">
                                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                            <span class="w-24">{{ $label }}</span>
                                            <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-lg border border-slate-300 bg-white text-sm font-semibold text-slate-500 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">...</button>
                                        </label>
                                    @endforeach
                                    <label class="inline-flex items-center gap-3 text-sm text-gray-600"><input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" /><span>Show active and inactive projects</span></label>
                                    <label class="inline-flex items-center gap-3 text-sm text-gray-600"><input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" /><span>Show all Repair orders</span></label>
                                    <div><label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Title</label><input type="text" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" /></div>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-gray-200 p-4">
                                <h4 class="mb-4 text-xs font-semibold uppercase tracking-wider text-gray-500">Main Object</h4>
                                <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                                    @foreach (['Customer', 'Functional Location', 'Part Number', 'Branch', 'Work Center'] as $label)
                                        <label class="flex items-center gap-3 text-sm text-gray-700">
                                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                            <span class="w-24">{{ $label }}</span>
                                            <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-lg border border-slate-300 bg-white text-sm font-semibold text-slate-500 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">...</button>
                                        </label>
                                    @endforeach
                                    <div><label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Serial number</label><input type="text" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" /></div>
                                </div>
                                <div class="mt-4"><label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Remarks</label><input type="text" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" /></div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-gray-200 p-4">
                            <div class="-mb-px flex flex-wrap gap-x-6 border-b border-slate-200">
                                <button type="button" class="{{ $tabButtonClass }}" :class="fatherTab === 'work-order' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="fatherTab='work-order'">Work Order</button>
                                <button type="button" class="{{ $tabButtonClass }}" :class="fatherTab === 'workpackage' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="fatherTab='workpackage'">Workpackage</button>
                                <button type="button" class="{{ $tabButtonClass }}" :class="fatherTab === 'daily-flight-log' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'" @click="fatherTab='daily-flight-log'">Daily Flight Log</button>
                            </div>
                            <x-enterprise.table-shell table-class="enterprise-static-table min-w-[760px]" datatable>
                                <x-slot name="thead"><tr><th>Code</th><th>Status</th><th>Type</th><th>Title</th></tr></x-slot>
                                <x-slot name="tbody">
                                    @foreach ($fatherRows as $row)
                                        <tr><td class="font-medium text-gray-900">{{ $row['code'] }}</td><td>{{ $row['status'] }}</td><td>{{ $row['type'] }}</td><td class="min-w-[280px]">{{ $row['title'] }}</td></tr>
                                    @endforeach
                                </x-slot>
                            </x-enterprise.table-shell>
                        </div>
                    </div>

                    <div x-show="activeTab==='details'" class="space-y-5">
                        <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_220px_240px]">
                            <div><label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Description</label><input type="text" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" /></div>
                            <label class="inline-flex items-center gap-3 pt-7 text-sm text-gray-700"><input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" /><span>Work Type</span></label>
                            <div class="pt-6"><button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-lg border border-slate-300 bg-white text-sm font-semibold text-slate-500 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">...</button></div>
                        </div>
                        <div class="grid gap-4 xl:grid-cols-[420px_minmax(0,1fr)]">
                            <div class="space-y-3">
                                <div><label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Validation</label><select class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100"><option>All</option><option>Validated</option><option>Pending</option></select></div>
                                <div class="grid gap-3 sm:grid-cols-[repeat(9,minmax(0,1fr))] sm:items-end">
                                    <div class="sm:col-span-9"><label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Chapter - Section - Subject - Sheet - Mark</label></div>
                                    @for ($i = 0; $i < 9; $i++) <input type="text" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100 sm:col-span-1" /> @endfor
                                </div>
                                @for ($i = 1; $i <= 5; $i++) <div><label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">User Field {{ $i }}</label><input type="text" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" /></div> @endfor
                                <div><label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Comment</label><input type="text" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" /></div>
                            </div>
                            <div class="space-y-4">
                                <div class="rounded-2xl border border-gray-200 p-4">
                                    <h4 class="mb-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Linked Objects</h4>
                                    @foreach (['Components', 'Tools', 'Purchasing'] as $label)
                                        <div class="mb-3 flex items-center justify-between gap-3">
                                            <label class="inline-flex items-center gap-3 text-sm text-gray-700"><input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" /><span>{{ $label }}</span></label>
                                            <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-lg border border-slate-300 bg-white text-sm font-semibold text-slate-500 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">...</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-gray-200 p-4">
                            <h4 class="mb-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Qualifications</h4>
                            <x-enterprise.table-shell table-class="enterprise-static-table min-w-[720px]" datatable>
                                <x-slot name="thead"><tr><th>Qualification Group</th><th>Qualification</th></tr></x-slot>
                                <x-slot name="tbody">
                                    @foreach ($qualRows as $row)
                                        <tr><td>{{ $row['group'] }}</td><td>{{ $row['qualification'] }}</td></tr>
                                    @endforeach
                                </x-slot>
                            </x-enterprise.table-shell>
                        </div>
                    </div>

                    <div x-show="activeTab==='task-list'" class="space-y-5">
                        <div class="rounded-2xl border border-gray-200 p-4">
                            <h4 class="mb-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Task List</h4>
                            <x-enterprise.table-shell table-class="enterprise-static-table min-w-[980px]" datatable>
                                <x-slot name="thead"><tr><th>Task Reference</th><th>Type</th><th>ATA Code</th><th>Short Description</th><th>Action Type</th><th>Status</th><th>External Ref</th></tr></x-slot>
                                <x-slot name="tbody">
                                    @foreach ($taskRows as $row)
                                        <tr><td class="font-medium text-gray-900">{{ $row['ref'] }}</td><td>{{ $row['type'] }}</td><td>{{ $row['ata'] }}</td><td>{{ $row['desc'] }}</td><td>{{ $row['action'] }}</td><td>{{ $row['status'] }}</td><td>{{ $row['ext'] }}</td></tr>
                                    @endforeach
                                </x-slot>
                            </x-enterprise.table-shell>
                        </div>
                        <div class="flex justify-end"><button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="statusMessage='Task list search lookup opened from Search Work Order.'">Search Task List</button></div>
                    </div>

                    <div x-show="activeTab==='properties'" class="rounded-2xl border border-dashed border-gray-300 p-5 text-sm text-gray-600">Choose only one work order type to see the properties.</div>

                    <div x-show="activeTab==='result'" class="space-y-5">
                        <div class="rounded-2xl border border-gray-200 p-4">
                            <h4 class="mb-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Result of Work Order search</h4>
                            <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable datatable-selectable>
                                <x-slot name="thead">
                                    <tr>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Op Code</th>
                                        <th>Description</th>
                                        <th>Task Ref</th>
                                        <th>Object Type</th>
                                        <th>Object Ref</th>
                                        <th>Item Code / FL Type</th>
                                        <th>SN</th>
                                        <th>Category Part / Registration</th>
                                    </tr>
                                </x-slot>
                                <x-slot name="tbody">
                                    @foreach ($resultRows as $row)
                                        <tr>
                                            <td>{{ $row['code'] }}</td>
                                            <td>{{ $row['type'] }}</td>
                                            <td>{{ $row['op'] }}</td>
                                            <td>{{ $row['desc'] }}</td>
                                            <td>{{ $row['task'] ?: '-' }}</td>
                                            <td>{{ $row['obj_type'] }}</td>
                                            <td>{{ $row['obj_ref'] }}</td>
                                            <td>{{ $row['item'] }}</td>
                                            <td>{{ $row['sn'] ?: '-' }}</td>
                                            <td>{{ $row['cat'] ?: '-' }}</td>
                                        </tr>
                                    @endforeach
                                </x-slot>
                            </x-enterprise.table-shell>
                        </div>
                        <div class="flex justify-end"><button type="button" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100" @click="statusMessage=`Selected ${resultRows.length ? resultRows[0].code : 'no'} work order from the result list.`">Choose</button></div>
                    </div>

                    <div class="mt-5 flex flex-wrap items-center justify-between gap-4 border-t border-gray-200 pt-5">
                        <div class="flex items-center gap-3">
                            <button type="button" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100" @click="search()">Search</button>
                            <div class="flex items-center gap-3">
                                <label class="text-xs font-semibold uppercase tracking-wider text-gray-500">Maximum number of records</label>
                                <input type="text" value="200" class="w-24 rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200" />
                            </div>
                        </div>
                        <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="cancel()">Cancel</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
