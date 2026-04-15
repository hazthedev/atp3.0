@extends('layouts.app')

@section('title', 'Time Sheet')

@php
    $timeRows = [
        [
            'code_op' => '0010',
            'start_date' => '07.04.26',
            'start_time' => '',
            'end_date' => '07.04.26',
            'end_time' => '',
            'duration' => '',
            'performed' => '0:00',
            'na' => false,
            'close' => false,
            'check' => false,
            'confirm' => false,
            'comment' => '',
            'description' => 'RECERTIFICATION OF BAGGAGE',
        ],
        [
            'code_op' => '0020',
            'start_date' => '',
            'start_time' => '',
            'end_date' => '',
            'end_time' => '',
            'duration' => '',
            'performed' => '',
            'na' => false,
            'close' => false,
            'check' => false,
            'confirm' => false,
            'comment' => '',
            'description' => '',
        ],
        [
            'code_op' => '0030',
            'start_date' => '',
            'start_time' => '',
            'end_date' => '',
            'end_time' => '',
            'duration' => '',
            'performed' => '',
            'na' => false,
            'close' => false,
            'check' => false,
            'confirm' => false,
            'comment' => '',
            'description' => '',
        ],
    ];

    $inputClass = 'block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100';
    $lookupButtonClass = 'inline-flex h-11 w-11 items-center justify-center rounded-lg border border-slate-300 bg-white text-sm font-semibold text-slate-500 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100';
    $primaryButtonClass = 'inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100';
    $secondaryButtonClass = 'inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100';
    $checkboxClass = 'h-4 w-4 rounded border-slate-300 bg-slate-100 text-blue-600 focus:ring-2 focus:ring-blue-500';
    $headerCellClass = 'px-3 py-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500';
    $bodyCellClass = 'px-3 py-3 align-top text-sm text-slate-700';
    $tabButtonClass = 'inline-flex items-center border-b-2 px-1 pb-4 pt-2 text-sm font-medium transition';
    $activeTabClass = 'border-[#2f5bff] text-[#2f5bff]';
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            workOrder: 'SHOP0343',
            employeeCode: '76',
            employeeName: 'AB FAUZAN BIN AB KARIM',
            type: 'Repair Order',
            title: 'RECERTIFICATION OF BAGGAGE',
            rows: @js($timeRows),
            statusMessage: '',
            saveSheet() {
                this.statusMessage = `Time sheet saved for work order ${this.workOrder} and employee ${this.employeeCode}.`;
            },
            cancelSheet() {
                this.statusMessage = 'Time sheet closed without additional updates.';
            },
        }"
    >
        <x-page-header
            title="Time Sheet"
            description="Capture employee time-sheet entries against released MRO work-order operations and review closure and confirmation status."
        />

        <section class="w-full space-y-5">
            <template x-if="statusMessage">
                <div class="flex items-center rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800" role="alert">
                    <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
                    <span x-text="statusMessage"></span>
                </div>
            </template>

            <div class="space-y-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="grid gap-5 xl:grid-cols-[minmax(0,500px)_minmax(0,1fr)] xl:items-end">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-5">
                        <label class="mb-3 block text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Work Order</label>
                        <div class="grid gap-3 sm:grid-cols-[minmax(0,180px)_auto_44px_minmax(0,1fr)] sm:items-center">
                            <input type="text" x-model="workOrder" class="{{ $inputClass }} font-semibold tracking-wide" />
                            <div class="hidden items-center justify-center text-center text-lg leading-none text-amber-500 sm:flex">&rarr;</div>
                            <button type="button" class="{{ $lookupButtonClass }}">...</button>
                            <div class="text-sm text-slate-500">Active MRO work order context</div>
                        </div>
                    </div>

                    <div class="grid min-w-0 gap-4 lg:grid-cols-[220px_minmax(0,1fr)]">
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Type</label>
                            <input type="text" x-model="type" class="{{ $inputClass }}" />
                        </div>
                        <div class="min-w-0">
                            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Title</label>
                            <input type="text" x-model="title" class="{{ $inputClass }}" />
                        </div>
                    </div>
                </div>

                <div class="space-y-5 rounded-2xl border border-slate-200 bg-slate-50/40 p-5">
                    <div class="border-b border-slate-200">
                        <div class="-mb-px flex flex-wrap gap-x-6">
                            <button type="button" class="{{ $tabButtonClass }} {{ $activeTabClass }}">By Employee</button>
                        </div>
                    </div>

                    <div class="grid gap-4 xl:grid-cols-[180px_44px_minmax(0,1fr)] xl:items-end">
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Employee</label>
                            <input type="text" x-model="employeeCode" class="{{ $inputClass }}" />
                        </div>
                        <div class="xl:pt-6">
                            <button type="button" class="{{ $lookupButtonClass }}">...</button>
                        </div>
                        <div class="min-w-0">
                            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Employee Name</label>
                            <input type="text" x-model="employeeName" class="{{ $inputClass }}" />
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                        <div class="overflow-x-auto">
                            <table class="min-w-full border-collapse min-w-[1180px]">
                                <thead class="border-b border-slate-200 bg-slate-50">
                                    <tr>
                                        <th class="{{ $headerCellClass }}">Code OP</th>
                                        <th class="{{ $headerCellClass }}">Start Date</th>
                                        <th class="{{ $headerCellClass }}">Start Time</th>
                                        <th class="{{ $headerCellClass }}">End Date</th>
                                        <th class="{{ $headerCellClass }}">End Time</th>
                                        <th class="{{ $headerCellClass }}">Duration</th>
                                        <th class="{{ $headerCellClass }}">Performed</th>
                                        <th class="{{ $headerCellClass }}">N/A</th>
                                        <th class="{{ $headerCellClass }}">Close</th>
                                        <th class="{{ $headerCellClass }}">Check</th>
                                        <th class="{{ $headerCellClass }}">Confirm</th>
                                        <th class="{{ $headerCellClass }}">Comment</th>
                                        <th class="{{ $headerCellClass }}">Description</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <template x-for="(row, index) in rows" :key="`${row.code_op}-${index}`">
                                        <tr class="transition-colors hover:bg-blue-50/60">
                                            <td class="whitespace-nowrap {{ $bodyCellClass }} font-semibold text-slate-900" x-text="row.code_op"></td>
                                            <td class="whitespace-nowrap {{ $bodyCellClass }}" x-text="row.start_date || ''"></td>
                                            <td class="whitespace-nowrap {{ $bodyCellClass }}" x-text="row.start_time || ''"></td>
                                            <td class="whitespace-nowrap {{ $bodyCellClass }}" x-text="row.end_date || ''"></td>
                                            <td class="whitespace-nowrap {{ $bodyCellClass }}" x-text="row.end_time || ''"></td>
                                            <td class="whitespace-nowrap {{ $bodyCellClass }}" x-text="row.duration || ''"></td>
                                            <td class="whitespace-nowrap {{ $bodyCellClass }}" x-text="row.performed || ''"></td>
                                            <td class="w-16 px-3 py-3 text-center"><input type="checkbox" x-model="row.na" class="{{ $checkboxClass }}" /></td>
                                            <td class="w-16 px-3 py-3 text-center"><input type="checkbox" x-model="row.close" class="{{ $checkboxClass }}" /></td>
                                            <td class="w-16 px-3 py-3 text-center"><input type="checkbox" x-model="row.check" class="{{ $checkboxClass }}" /></td>
                                            <td class="w-16 px-3 py-3 text-center"><input type="checkbox" x-model="row.confirm" class="{{ $checkboxClass }}" /></td>
                                            <td class="min-w-[140px] max-w-[180px] whitespace-normal break-words {{ $bodyCellClass }}" x-text="row.comment || ''"></td>
                                            <td class="min-w-[260px] max-w-[360px] whitespace-normal break-words {{ $bodyCellClass }}" x-text="row.description || ''"></td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 border-t border-slate-200 pt-5">
                    <button type="button" class="{{ $primaryButtonClass }}" @click="saveSheet()">OK</button>
                    <button type="button" class="{{ $secondaryButtonClass }}" @click="cancelSheet()">Cancel</button>
                </div>
            </div>
        </section>
    </div>
@endsection
