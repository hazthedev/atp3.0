@extends('layouts.app')

@section('title', 'Start work on Operation')

@php
    $historyRows = [
        [
            'start_date' => '06.04.26',
            'start_time' => '15:20',
            'end_date' => '06.04.26',
            'end_time' => '17:10',
            'duration' => '1:50',
            'employee' => 'AB FAUZAN BIN AB KARIM',
            'close_date' => '',
            'closed_by' => '',
            'comment' => 'Pre-inspection preparation',
        ],
        [
            'start_date' => '07.04.26',
            'start_time' => '08:40',
            'end_date' => '07.04.26',
            'end_time' => '10:00',
            'duration' => '1:20',
            'employee' => 'AB FAUZAN BIN AB KARIM',
            'close_date' => '',
            'closed_by' => '',
            'comment' => 'Panels opened and checked',
        ],
    ];

    $componentRows = [
        ['code' => '001', 'item_code' => '00031010', 'item_desc' => 'Baggage Door Handle Assy', 'qty' => '0.00', 'issued' => '0.00', 'warehouse' => 'MRO Main'],
        ['code' => '002', 'item_code' => '00031011', 'item_desc' => 'Handle Fastener Kit', 'qty' => '0.00', 'issued' => '0.00', 'warehouse' => 'MRO Main'],
    ];

    $panelClass = 'space-y-4 rounded-2xl border border-slate-200 bg-slate-50/40 p-5';
    $fieldLabelClass = 'mb-1.5 block text-xs font-semibold uppercase tracking-[0.18em] text-slate-500';
    $inputClass = 'block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100';
    $lookupButtonClass = 'inline-flex h-11 w-11 items-center justify-center rounded-lg border border-slate-300 bg-white text-sm font-semibold text-slate-500 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100';
    $tabButtonClass = 'inline-flex items-center border-b-2 px-1 pb-4 pt-2 text-sm font-medium transition';
    $activeTabClass = 'border-[#2f5bff] text-[#2f5bff]';
    $inactiveTabClass = 'border-transparent text-slate-500 hover:border-[#9fb2ff] hover:text-[#2f5bff]';
    $headerCellClass = 'px-3 py-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500';
    $bodyCellClass = 'px-3 py-3 align-top text-sm text-slate-700';
    $primaryButtonClass = 'inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100';
    $secondaryButtonClass = 'inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100';
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            activeTab: 'history',
            statusMessage: '',
            startOperation() {
                this.statusMessage = 'Work started on operation 0010.';
            },
            cancelOperation() {
                this.statusMessage = 'Start operation dialog closed without changes.';
            },
        }"
    >
        <x-page-header
            title="Start work on Operation"
            description="Open an active work session for an MRO operation, review previous history, and inspect linked component requirements before starting."
        />

        <section class="w-full space-y-5">
            <template x-if="statusMessage">
                <div class="flex items-center rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800" role="alert">
                    <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
                    <span x-text="statusMessage"></span>
                </div>
            </template>

            <div class="space-y-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="{{ $panelClass }}">
                    <h3 class="text-base font-semibold text-slate-900">Employee</h3>
                    <div class="grid gap-4 xl:grid-cols-[180px_44px_minmax(0,1fr)_minmax(0,1fr)] xl:items-end">
                        <div>
                            <label class="{{ $fieldLabelClass }}">Code</label>
                            <input type="text" value="76" class="{{ $inputClass }}" />
                        </div>
                        <div class="xl:pb-px">
                            <button type="button" class="{{ $lookupButtonClass }}">...</button>
                        </div>
                        <div class="min-w-0">
                            <label class="{{ $fieldLabelClass }}">First Name</label>
                            <input type="text" value="AB FAUZAN BIN AB" class="{{ $inputClass }}" />
                        </div>
                        <div class="min-w-0">
                            <label class="{{ $fieldLabelClass }}">Last Name</label>
                            <input type="text" value="AB FAUZAN BIN AB KARIM" class="{{ $inputClass }}" />
                        </div>
                    </div>
                </div>

                <div class="{{ $panelClass }}">
                    <h3 class="text-base font-semibold text-slate-900">Work Order</h3>
                    <div class="grid gap-4 xl:grid-cols-[180px_44px_220px_minmax(0,1fr)] xl:items-end">
                        <div>
                            <label class="{{ $fieldLabelClass }}">Code</label>
                            <input type="text" value="SHOP0343" class="{{ $inputClass }}" />
                        </div>
                        <div class="xl:pb-px">
                            <button type="button" class="{{ $lookupButtonClass }}">...</button>
                        </div>
                        <div>
                            <label class="{{ $fieldLabelClass }}">Type</label>
                            <input type="text" value="Repair Order" class="{{ $inputClass }}" />
                        </div>
                        <div class="min-w-0">
                            <label class="{{ $fieldLabelClass }}">Project Name</label>
                            <input type="text" value="" class="{{ $inputClass }}" />
                        </div>
                    </div>

                    <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_240px]">
                        <div class="min-w-0">
                            <label class="{{ $fieldLabelClass }}">Title</label>
                            <input type="text" value="RECERTIFICATION OF BAGGAGE DOOR HANDLE ASSY" class="{{ $inputClass }}" />
                        </div>
                        <div>
                            <label class="{{ $fieldLabelClass }}">Repair Event</label>
                            <input type="text" value="40071" class="{{ $inputClass }}" />
                        </div>
                    </div>
                </div>

                <div class="{{ $panelClass }}">
                    <h3 class="text-base font-semibold text-slate-900">Operation</h3>
                    <div class="grid gap-4 xl:grid-cols-[180px_44px_minmax(0,1fr)_minmax(0,280px)] xl:items-end">
                        <div>
                            <label class="{{ $fieldLabelClass }}">Code</label>
                            <input type="text" value="0010" class="{{ $inputClass }}" />
                        </div>
                        <div class="xl:pb-px">
                            <button type="button" class="{{ $lookupButtonClass }}">...</button>
                        </div>
                        <div>
                            <label class="{{ $fieldLabelClass }}">Start Date</label>
                            <input type="text" value="" class="{{ $inputClass }}" />
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="{{ $fieldLabelClass }}">Duration</label>
                                <input type="text" value="0:00" class="{{ $inputClass }}" />
                            </div>
                            <div>
                                <label class="{{ $fieldLabelClass }}">Performed</label>
                                <input type="text" value="0:00" class="{{ $inputClass }}" />
                            </div>
                        </div>
                    </div>

                    <div class="min-w-0">
                        <label class="{{ $fieldLabelClass }}">Description</label>
                        <input type="text" value="RECERTIFICATION OF BAGGAGE DOOR HANDLE ASSY. ITEM NOT..." class="{{ $inputClass }}" />
                    </div>
                </div>

                <div class="{{ $panelClass }}">
                    <h3 class="text-base font-semibold text-slate-900">Start Time</h3>
                    <div class="grid gap-4 sm:grid-cols-2 xl:max-w-[520px]">
                        <div>
                            <label class="{{ $fieldLabelClass }}">Date</label>
                            <input type="text" value="07.04.26" class="{{ $inputClass }}" />
                        </div>
                        <div>
                            <label class="{{ $fieldLabelClass }}">Time</label>
                            <input type="text" value="16:12" class="{{ $inputClass }}" />
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="border-b border-slate-200">
                        <div class="-mb-px flex flex-wrap gap-x-6">
                        <button
                            type="button"
                            class="{{ $tabButtonClass }}"
                            :class="activeTab === 'history' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'"
                            @click="activeTab='history'; $nextTick(() => window.refreshFlowbiteTables?.())"
                        >
                            History on this operation
                        </button>
                        <button
                            type="button"
                            class="{{ $tabButtonClass }}"
                            :class="activeTab === 'components' ? '{{ $activeTabClass }}' : '{{ $inactiveTabClass }}'"
                            @click="activeTab='components'; $nextTick(() => window.refreshFlowbiteTables?.())"
                        >
                            Components
                        </button>
                        </div>
                    </div>

                    <x-enterprise.table-shell x-show="activeTab==='history'" table-class="min-w-full border-collapse min-w-[1080px]" datatable>
                        <x-slot name="thead">
                            <tr>
                                <th>Start Date</th>
                                <th>Start Time</th>
                                <th>End Date</th>
                                <th>End Time</th>
                                <th>Duration</th>
                                <th>Employee</th>
                                <th>Close Date</th>
                                <th>Closed By</th>
                                <th>Comment</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            @foreach ($historyRows as $row)
                                <tr>
                                    <td>{{ $row['start_date'] }}</td>
                                    <td>{{ $row['start_time'] }}</td>
                                    <td>{{ $row['end_date'] }}</td>
                                    <td>{{ $row['end_time'] }}</td>
                                    <td>{{ $row['duration'] }}</td>
                                    <td class="min-w-[220px]">{{ $row['employee'] }}</td>
                                    <td>{{ $row['close_date'] }}</td>
                                    <td>{{ $row['closed_by'] }}</td>
                                    <td class="min-w-[220px] whitespace-normal break-words">{{ $row['comment'] }}</td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-enterprise.table-shell>

                    <x-enterprise.table-shell x-show="activeTab==='components'" table-class="min-w-full border-collapse min-w-[900px]" datatable>
                        <x-slot name="thead">
                            <tr>
                                <th>Code</th>
                                <th>Item Code</th>
                                <th>Item Desc</th>
                                <th>Qty</th>
                                <th>Issued</th>
                                <th>Warehouse</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            @foreach ($componentRows as $row)
                                <tr>
                                    <td>{{ $row['code'] }}</td>
                                    <td>{{ $row['item_code'] }}</td>
                                    <td class="min-w-[220px] whitespace-normal break-words">{{ $row['item_desc'] }}</td>
                                    <td>{{ $row['qty'] }}</td>
                                    <td>{{ $row['issued'] }}</td>
                                    <td>{{ $row['warehouse'] }}</td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-enterprise.table-shell>
                </div>

                <div class="flex flex-wrap items-center gap-3 border-t border-slate-200 pt-5">
                    <button type="button" class="{{ $primaryButtonClass }}" @click="startOperation()">Start Operation</button>
                    <button type="button" class="{{ $secondaryButtonClass }}" @click="cancelOperation()">Cancel</button>
                </div>
            </div>
        </section>
    </div>
@endsection
