@extends('layouts.app')

@section('title', 'End work on Operation')

@php
    $activeRows = [
        [
            'work_order' => 'SHOP0343',
            'code_op' => '0010',
            'employee' => 'AB FAUZAN BIN AB KARIM',
            'start_date' => '07.04.26',
            'start_time' => '16:12',
            'description' => 'RECERTIFICATION OF BAGGAGE DOOR HANDLE ASSY',
            'closed' => false,
        ],
        [
            'work_order' => 'WO-36424',
            'code_op' => '0020',
            'employee' => 'AB FAUZAN BIN AB KARIM',
            'start_date' => '07.04.26',
            'start_time' => '14:05',
            'description' => 'RECTIFICATION CHECK',
            'closed' => false,
        ],
    ];

    $fieldLabelClass = 'mb-1.5 block text-xs font-semibold uppercase tracking-[0.18em] text-slate-500';
    $inputClass = 'block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100';
    $lookupButtonClass = 'inline-flex h-11 w-11 items-center justify-center rounded-lg border border-slate-300 bg-white text-sm font-semibold text-slate-500 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100';
    $checkboxClass = 'h-4 w-4 rounded border-slate-300 bg-slate-100 text-blue-600 focus:ring-2 focus:ring-blue-500';
    $headerCellClass = 'px-3 py-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500';
    $bodyCellClass = 'px-3 py-3 align-top text-sm text-slate-700';
    $primaryButtonClass = 'inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100';
    $secondaryButtonClass = 'inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100';
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            onlyMine: false,
            employeeCode: '76',
            employeeName: 'AB FAUZAN BIN AB KARIM',
            workOrder: '',
            type: '',
            operation: '',
            description: '',
            endDate: '07.04.26',
            endTime: '16:14',
            comment: '',
            close: false,
            check: false,
            confirm: false,
            rows: @js($activeRows),
            selectedRow: 0,
            statusMessage: '',
            visibleRows() {
                return this.onlyMine ? this.rows.filter((row) => row.employee === this.employeeName) : this.rows;
            },
            chooseRow(index) {
                this.selectedRow = index;
                const row = this.visibleRows()[index];
                if (!row) return;
                this.workOrder = row.work_order;
                this.operation = row.code_op;
                this.description = row.description;
                this.type = 'Repair Order';
            },
            finishOperation() {
                const row = this.visibleRows()[this.selectedRow];
                this.statusMessage = `Operation ${row ? row.code_op : ''} closed for work order ${row ? row.work_order : ''}.`;
            },
            cancelOperation() {
                this.statusMessage = 'End operation dialog closed without saving.';
            },
            cancelLine() {
                const row = this.visibleRows()[this.selectedRow];
                this.statusMessage = `Active line ${row ? row.code_op : ''} cancelled from the close-out queue.`;
            },
        }"
        x-init="chooseRow(0)"
    >
        <x-page-header
            title="End work on Operation"
            description="Close active MRO operation effort, review started work lines, and capture end time, comments, and confirmation flags."
        />

        <section class="w-full space-y-5">
            <template x-if="statusMessage">
                <div class="flex items-center rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800" role="alert">
                    <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
                    <span x-text="statusMessage"></span>
                </div>
            </template>

            <div class="space-y-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <label class="inline-flex items-center gap-3 text-sm text-slate-700">
                    <input type="checkbox" x-model="onlyMine" @change="chooseRow(0)" class="{{ $checkboxClass }}" />
                    <span>View only work started with my login</span>
                </label>

                <div class="grid gap-4 xl:grid-cols-[240px_minmax(0,1fr)_240px_240px] xl:items-end">
                    <div>
                        <label class="{{ $fieldLabelClass }}">Employee</label>
                        <div class="grid grid-cols-[1fr_44px] gap-3">
                            <input type="text" x-model="employeeCode" class="{{ $inputClass }}" />
                            <button type="button" class="{{ $lookupButtonClass }}">...</button>
                        </div>
                    </div>
                    <div class="min-w-0">
                        <label class="{{ $fieldLabelClass }}">Name</label>
                        <input type="text" x-model="employeeName" class="{{ $inputClass }}" />
                    </div>
                    <div>
                        <label class="{{ $fieldLabelClass }}">Work Order</label>
                        <div class="grid grid-cols-[1fr_44px] gap-3">
                            <input type="text" x-model="workOrder" class="{{ $inputClass }}" />
                            <button type="button" class="{{ $lookupButtonClass }}">...</button>
                        </div>
                    </div>
                    <div>
                        <label class="{{ $fieldLabelClass }}">Operation</label>
                        <div class="grid grid-cols-[1fr_44px] gap-3">
                            <input type="text" x-model="operation" class="{{ $inputClass }}" />
                            <button type="button" class="{{ $lookupButtonClass }}">...</button>
                        </div>
                    </div>
                </div>

                <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_240px]">
                    <div class="min-w-0">
                        <label class="{{ $fieldLabelClass }}">Description</label>
                        <input type="text" x-model="description" class="{{ $inputClass }}" />
                    </div>
                    <div>
                        <label class="{{ $fieldLabelClass }}">Type</label>
                        <input type="text" x-model="type" class="{{ $inputClass }}" />
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse min-w-[1080px]">
                            <thead class="border-b border-slate-200 bg-slate-50">
                                <tr>
                                    <th class="{{ $headerCellClass }}">Work Order</th>
                                    <th class="{{ $headerCellClass }}">Code OP</th>
                                    <th class="{{ $headerCellClass }}">Employee</th>
                                    <th class="{{ $headerCellClass }}">Start Date</th>
                                    <th class="{{ $headerCellClass }}">Start Time</th>
                                    <th class="{{ $headerCellClass }}">Description</th>
                                    <th class="{{ $headerCellClass }}">Closed</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <template x-for="(row, index) in visibleRows()" :key="`${row.work_order}-${row.code_op}`">
                                    <tr class="cursor-pointer transition-colors hover:bg-blue-50/60" :class="{ 'bg-blue-50/80': selectedRow === index }" @click="chooseRow(index)">
                                        <td class="whitespace-nowrap {{ $bodyCellClass }} font-semibold text-slate-900" x-text="row.work_order"></td>
                                        <td class="whitespace-nowrap {{ $bodyCellClass }}" x-text="row.code_op"></td>
                                        <td class="min-w-[220px] whitespace-nowrap {{ $bodyCellClass }}" x-text="row.employee"></td>
                                        <td class="whitespace-nowrap {{ $bodyCellClass }}" x-text="row.start_date"></td>
                                        <td class="whitespace-nowrap {{ $bodyCellClass }}" x-text="row.start_time"></td>
                                        <td class="min-w-[280px] whitespace-normal break-words {{ $bodyCellClass }}" x-text="row.description"></td>
                                        <td class="w-20 px-3 py-3 text-center"><input type="checkbox" x-model="row.closed" class="{{ $checkboxClass }}" /></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="grid gap-4 xl:grid-cols-[180px_180px_minmax(0,1fr)]">
                    <div>
                        <label class="{{ $fieldLabelClass }}">End Date</label>
                        <input type="text" x-model="endDate" class="{{ $inputClass }}" />
                    </div>
                    <div>
                        <label class="{{ $fieldLabelClass }}">End Time</label>
                        <input type="text" x-model="endTime" class="{{ $inputClass }}" />
                    </div>
                    <div class="min-w-0">
                        <label class="{{ $fieldLabelClass }}">Comment</label>
                        <input type="text" x-model="comment" class="{{ $inputClass }}" />
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-6">
                    <label class="inline-flex items-center gap-3 text-sm text-slate-700">
                        <input type="checkbox" x-model="close" class="{{ $checkboxClass }}" />
                        <span>Close</span>
                    </label>
                    <label class="inline-flex items-center gap-3 text-sm text-slate-700">
                        <input type="checkbox" x-model="check" class="{{ $checkboxClass }}" />
                        <span>Check</span>
                    </label>
                    <label class="inline-flex items-center gap-3 text-sm text-slate-700">
                        <input type="checkbox" x-model="confirm" class="{{ $checkboxClass }}" />
                        <span>Confirm</span>
                    </label>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-4 border-t border-slate-200 pt-5">
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" class="{{ $primaryButtonClass }}" @click="finishOperation()">End Operation</button>
                        <button type="button" class="{{ $secondaryButtonClass }}" @click="cancelOperation()">Cancel</button>
                    </div>

                    <button type="button" class="{{ $secondaryButtonClass }}" @click="cancelLine()">Cancel Line</button>
                </div>
            </div>
        </section>
    </div>
@endsection
