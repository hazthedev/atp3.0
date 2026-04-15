@extends('layouts.app')

@section('title', 'Measurement Points - Recording')

@php
    $operations = [
        [
            'flag' => '!',
            'operation_code' => '0010',
            'description' => '3200HRS INSPECTION',
            'work_order_code' => 'WO-36424',
            'type' => 'Check',
            'status' => 'Released',
            'repair_order' => 'RO-20384',
        ],
        [
            'flag' => '',
            'operation_code' => '0020',
            'description' => 'RECTIFICATION CHECK',
            'work_order_code' => 'WO-36424',
            'type' => 'Repair Order',
            'status' => 'In Progress',
            'repair_order' => 'RO-20384',
        ],
        [
            'flag' => '',
            'operation_code' => '0030',
            'description' => 'POST MAINT TEST',
            'work_order_code' => 'WO-36424',
            'type' => 'Repair Order',
            'status' => 'Planned',
            'repair_order' => 'RO-20384',
        ],
    ];

    $measurementPoints = [
        [
            'name' => 'Main Rotor Vibration',
            'value' => '0.21 IPS',
            'description' => 'Record the current main rotor vibration value after operation completion.',
            'additional' => 'Use the stabilized ground-run reading and compare against previous trend history.',
        ],
        [
            'name' => 'Hydraulic Pressure',
            'value' => '2850 PSI',
            'description' => 'Capture the hydraulic pressure observed during the maintenance run.',
            'additional' => 'Confirm pressure is within release limits before completing the work order.',
        ],
        [
            'name' => 'Engine 1 TOT Margin',
            'value' => '48 C',
            'description' => 'Enter the measured TOT margin for Engine 1 after task execution.',
            'additional' => 'If the margin drops below the threshold, raise a follow-up engineering review.',
        ],
    ];

    $recordedValues = [
        ['time' => '10:14', 'value' => '0.21 IPS', 'recorded_by' => 'asyraf'],
        ['time' => '10:32', 'value' => '2850 PSI', 'recorded_by' => 'asyraf'],
        ['time' => '10:48', 'value' => '48 C', 'recorded_by' => 'asyraf'],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            onlyMeasurementPoints: true,
            employeeCode: 'EMP-204',
            employeeName: 'Mohd Amirul Bakri',
            operations: @js($operations),
            measurementPoints: @js($measurementPoints),
            recordedValues: @js($recordedValues),
            selectedOperation: 0,
            selectedPoint: 0,
            statusMessage: '',
            chooseOperation(index) {
                this.selectedOperation = index;
            },
            choosePoint(index) {
                this.selectedPoint = index;
            },
            saveRecording() {
                const point = this.measurementPoints[this.selectedPoint];
                this.statusMessage = `Measurement point ${point.name} confirmed for ${this.operations[this.selectedOperation].operation_code}.`;
            },
            cancelRecording() {
                this.statusMessage = 'Measurement point recording closed without additional updates.';
            },
        }"
    >
        <x-page-header
            title="Measurement Points - Recording"
            description="Capture operation-linked measurement points, recorded values, and descriptive notes for the active MRO work order."
        />

        <section class="max-w-[1280px] space-y-5">
            <template x-if="statusMessage">
                <div class="flex items-center rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800" role="alert">
                    <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
                    <span x-text="statusMessage"></span>
                </div>
            </template>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm space-y-5">
                <div class="grid gap-5 xl:grid-cols-[320px_minmax(0,1fr)]">
                    <div class="space-y-4">
                        <div class="space-y-3">
                            <label class="inline-flex items-center gap-3 text-sm text-gray-700">
                                <input type="radio" x-model="onlyMeasurementPoints" :value="true" class="border-gray-300 text-blue-600 focus:ring-blue-500" />
                                <span>Only with Measurement Points</span>
                            </label>
                            <label class="inline-flex items-center gap-3 text-sm text-gray-700">
                                <input type="radio" x-model="onlyMeasurementPoints" :value="false" class="border-gray-300 text-blue-600 focus:ring-blue-500" />
                                <span>All Operations</span>
                            </label>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-[120px_140px_minmax(0,1fr)] sm:items-end">
                            <div class="sm:col-span-3">
                                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Employee</label>
                            </div>
                            <input type="text" x-model="employeeCode" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100 sm:col-span-1" />
                            <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-lg border border-slate-300 bg-white text-sm font-semibold text-slate-500 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100 sm:justify-self-start">...</button>
                            <input type="text" x-model="employeeName" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100 sm:col-span-1" />
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Work Order Code</label>
                            <input type="text" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" :value="operations[selectedOperation].work_order_code" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Type</label>
                            <input type="text" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" :value="operations[selectedOperation].type" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Status</label>
                            <input type="text" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" :value="operations[selectedOperation].status" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Repair Order</label>
                            <input type="text" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" :value="operations[selectedOperation].repair_order" />
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="mb-3 text-sm font-semibold text-gray-900">Operations of Work Order</h3>
                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="enterprise-static-table w-full min-w-[760px] text-left text-sm">
                            <thead class="border-b border-gray-200 bg-gray-50">
                                <tr>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">!</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Operation Code</th>
                                    <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Descr</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <template x-for="(row, index) in operations" :key="`${row.operation_code}-${index}`">
                                    <tr class="cursor-pointer transition-colors hover:bg-blue-50/60" :class="{ 'bg-blue-50/80': selectedOperation === index }" @click="chooseOperation(index)">
                                        <td class="whitespace-nowrap px-3 py-2.5 font-medium text-amber-500" x-text="row.flag || ''"></td>
                                        <td class="whitespace-nowrap px-3 py-2.5 font-medium text-gray-900" x-text="row.operation_code"></td>
                                        <td class="min-w-[320px] whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.description"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_260px]">
                    <div class="space-y-4">
                        <div>
                            <h3 class="mb-3 text-sm font-semibold text-gray-900">Measurement Points</h3>
                            <div class="rounded-xl border border-gray-200">
                                <div class="divide-y divide-gray-100">
                                    <template x-for="(point, index) in measurementPoints" :key="`${point.name}-${index}`">
                                        <button
                                            type="button"
                                            class="flex w-full items-start justify-between gap-4 px-4 py-3 text-left transition-colors hover:bg-blue-50/60"
                                            :class="{ 'bg-blue-50/80': selectedPoint === index }"
                                            @click="choosePoint(index)"
                                        >
                                            <span class="font-medium text-gray-900" x-text="point.name"></span>
                                            <span class="text-sm text-gray-500" x-text="point.value"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="rounded-xl border border-gray-200">
                                <div class="divide-y divide-gray-100">
                                    <template x-for="(row, index) in recordedValues" :key="`${row.time}-${index}`">
                                        <div class="grid gap-3 px-4 py-3 text-sm text-gray-700 sm:grid-cols-[100px_140px_minmax(0,1fr)]">
                                            <span class="font-medium text-gray-900" x-text="row.time"></span>
                                            <span x-text="row.value"></span>
                                            <span x-text="row.recorded_by"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h3 class="mb-3 text-sm font-semibold text-gray-900">Description</h3>
                            <div class="min-h-[220px] rounded-xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700" x-text="measurementPoints[selectedPoint].description"></div>
                        </div>

                        <div>
                            <h3 class="mb-3 text-sm font-semibold text-gray-900">Additional Description</h3>
                            <div class="min-h-[180px] rounded-xl border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700" x-text="measurementPoints[selectedPoint].additional"></div>
                        </div>

                        <div class="grid gap-4">
                            <div>
                                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Update Date</label>
                                <input type="text" value="2026-04-07" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" />
                            </div>
                            <div>
                                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Updated By</label>
                                <input type="text" value="asyraf" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 border-t border-gray-200 pt-5">
                    <button type="button" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100" @click="saveRecording()">OK</button>
                    <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="cancelRecording()">Cancel</button>
                </div>
            </div>
        </section>
    </div>
@endsection
