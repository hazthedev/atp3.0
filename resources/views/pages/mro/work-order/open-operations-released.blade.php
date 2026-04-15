@extends('layouts.app')

@section('title', 'List of Open Operations for Released Work Order')

@php
    $operationRows = [
        [
            'work_order' => 'WO-36424',
            'work_order_type' => 'Check',
            'code_operation' => '0010',
            'description' => '3200HRS INSPECTION',
            'work_center' => '',
            'performed' => '8981:30',
            'duration' => '0:00',
            'employees' => '1.00',
            'elapsed_time' => '0:00',
            'item_number' => '0',
            'equipment_code' => '0',
            'functional_location' => '9M-WSV',
            'item_number_operation' => '',
            'equipment_counter' => '0',
            'chapter' => '',
            'section' => '',
            'subject' => '',
            'sheet' => '',
            'sheet_version' => '',
            'mark' => '',
            'mark_version' => '',
            'field_1' => '',
            'field_2' => '',
            'field_3' => '',
            'field_4' => '',
            'field_5' => '',
        ],
        [
            'work_order' => 'WO-81647',
            'work_order_type' => 'others',
            'code_operation' => '0010',
            'description' => 'TO PERFORM RECORD UPDATE',
            'work_center' => '',
            'performed' => '1:00',
            'duration' => '0:00',
            'employees' => '1.00',
            'elapsed_time' => '0:00',
            'item_number' => '0',
            'equipment_code' => '0',
            'functional_location' => '9M-WAE',
            'item_number_operation' => '',
            'equipment_counter' => '0',
            'chapter' => '',
            'section' => '',
            'subject' => '',
            'sheet' => '',
            'sheet_version' => '',
            'mark' => '',
            'mark_version' => '',
            'field_1' => '',
            'field_2' => '',
            'field_3' => '',
            'field_4' => '',
            'field_5' => '',
        ],
        [
            'work_order' => 'WO-05924',
            'work_order_type' => 'Found During Check',
            'code_operation' => '0010',
            'description' => 'test kj kj kj kjhjk',
            'work_center' => '',
            'performed' => '0:00',
            'duration' => '0:00',
            'employees' => '1.00',
            'elapsed_time' => '0:00',
            'item_number' => '0',
            'equipment_code' => '0',
            'functional_location' => '9M-WAB',
            'item_number_operation' => '00009M-03',
            'equipment_counter' => '0',
            'chapter' => '',
            'section' => '',
            'subject' => '',
            'sheet' => '',
            'sheet_version' => '',
            'mark' => '',
            'mark_version' => '',
            'field_1' => '',
            'field_2' => '',
            'field_3' => '',
            'field_4' => '',
            'field_5' => '',
        ],
        [
            'work_order' => 'WO-40031',
            'work_order_type' => 'Hard Time Comp',
            'code_operation' => '0010',
            'description' => 'AAA alkaline batt',
            'work_center' => '',
            'performed' => '0:30',
            'duration' => '0:00',
            'employees' => '1.00',
            'elapsed_time' => '0:00',
            'item_number' => '0',
            'equipment_code' => '0',
            'functional_location' => '9M-WAW',
            'item_number_operation' => '',
            'equipment_counter' => '32060',
            'chapter' => '',
            'section' => '',
            'subject' => '',
            'sheet' => '',
            'sheet_version' => '',
            'mark' => '',
            'mark_version' => '',
            'field_1' => '',
            'field_2' => '',
            'field_3' => '',
            'field_4' => '',
            'field_5' => '',
        ],
        [
            'work_order' => 'WO-05908',
            'work_order_type' => 'Hard Time Comp',
            'code_operation' => '0010',
            'description' => 'MAIN ROTOR ACT',
            'work_center' => '',
            'performed' => '10:00',
            'duration' => '0:00',
            'employees' => '1.00',
            'elapsed_time' => '0:00',
            'item_number' => '0',
            'equipment_code' => '0',
            'functional_location' => '9M-WAV',
            'item_number_operation' => '',
            'equipment_counter' => '9813',
            'chapter' => '',
            'section' => '',
            'subject' => '',
            'sheet' => '',
            'sheet_version' => '',
            'mark' => '',
            'mark_version' => '',
            'field_1' => '',
            'field_2' => '',
            'field_3' => '',
            'field_4' => '',
            'field_5' => '',
        ],
        [
            'work_order' => 'SHOP0060',
            'work_order_type' => 'Repair Order',
            'code_operation' => '0010',
            'description' => 'FOR CAPACITY',
            'work_center' => 'Battery',
            'performed' => '0:00',
            'duration' => '0:00',
            'employees' => '1.00',
            'elapsed_time' => '0:00',
            'item_number' => '0',
            'equipment_code' => '0',
            'functional_location' => '',
            'item_number_operation' => '',
            'equipment_counter' => '9556',
            'chapter' => '',
            'section' => '',
            'subject' => '',
            'sheet' => '',
            'sheet_version' => '',
            'mark' => '',
            'mark_version' => '',
            'field_1' => '',
            'field_2' => '',
            'field_3' => '',
            'field_4' => '',
            'field_5' => '',
        ],
        [
            'work_order' => 'WO-07541',
            'work_order_type' => 'Hard Time Comp',
            'code_operation' => '0010',
            'description' => 'Crew Life Jackets',
            'work_center' => '',
            'performed' => '1:00',
            'duration' => '0:00',
            'employees' => '1.00',
            'elapsed_time' => '0:00',
            'item_number' => '0',
            'equipment_code' => '0',
            'functional_location' => '9M-WSU',
            'item_number_operation' => '',
            'equipment_counter' => '12843',
            'chapter' => '',
            'section' => '',
            'subject' => '',
            'sheet' => '',
            'sheet_version' => '',
            'mark' => '',
            'mark_version' => '',
            'field_1' => '',
            'field_2' => '',
            'field_3' => '',
            'field_4' => '',
            'field_5' => '',
        ],
        [
            'work_order' => 'WO-7332',
            'work_order_type' => 'Hard Time Comp',
            'code_operation' => '0010',
            'description' => 'CABIN DOORS E',
            'work_center' => '',
            'performed' => '208:00',
            'duration' => '0:00',
            'employees' => '1.00',
            'elapsed_time' => '0:00',
            'item_number' => '0',
            'equipment_code' => '0',
            'functional_location' => '9M-WSU',
            'item_number_operation' => '',
            'equipment_counter' => '0',
            'chapter' => '',
            'section' => '',
            'subject' => '',
            'sheet' => '',
            'sheet_version' => '',
            'mark' => '',
            'mark_version' => '',
            'field_1' => '',
            'field_2' => '',
            'field_3' => '',
            'field_4' => '',
            'field_5' => '',
        ],
        [
            'work_order' => 'SHOP0046',
            'work_order_type' => 'Repair Order',
            'code_operation' => '0010',
            'description' => 'FOR CAPACITY',
            'work_center' => 'Battery',
            'performed' => '0:00',
            'duration' => '0:00',
            'employees' => '1.00',
            'elapsed_time' => '0:00',
            'item_number' => '0',
            'equipment_code' => '0',
            'functional_location' => '',
            'item_number_operation' => '',
            'equipment_counter' => '13505',
            'chapter' => '',
            'section' => '',
            'subject' => '',
            'sheet' => '',
            'sheet_version' => '',
            'mark' => '',
            'mark_version' => '',
            'field_1' => '',
            'field_2' => '',
            'field_3' => '',
            'field_4' => '',
            'field_5' => '',
        ],
        [
            'work_order' => 'WO-06999',
            'work_order_type' => 'others',
            'code_operation' => '0010',
            'description' => '01 QTY PASSENGER',
            'work_center' => '',
            'performed' => '10:00',
            'duration' => '0:00',
            'employees' => '1.00',
            'elapsed_time' => '0:00',
            'item_number' => '0',
            'equipment_code' => '0',
            'functional_location' => '9M-WST',
            'item_number_operation' => '',
            'equipment_counter' => '0',
            'chapter' => '',
            'section' => '',
            'subject' => '',
            'sheet' => '',
            'sheet_version' => '',
            'mark' => '',
            'mark_version' => '',
            'field_1' => '',
            'field_2' => '',
            'field_3' => '',
            'field_4' => '',
            'field_5' => '',
        ],
    ];

    $workOrderTypes = ['Check', 'others', 'Found During Check', 'AD/SB', 'Hard Time Comp', 'Repair Order'];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            workCenter: '',
            workOrderType: '',
            statusMessage: '',
            rows: @js($operationRows),
            visibleRows() {
                return this.rows.filter((row) => {
                    const centerMatch = !this.workCenter || row.work_center.toLowerCase().includes(this.workCenter.toLowerCase());
                    const typeMatch = !this.workOrderType || row.work_order_type === this.workOrderType;
                    return centerMatch && typeMatch;
                });
            },
            refreshRows() {
                this.statusMessage = `Loaded ${this.visibleRows().length} open operation record(s) for released work orders.`;
            },
            closeQueue() {
                this.statusMessage = `Open operations review closed with ${this.visibleRows().length} visible record(s).`;
            },
        }"
    >
        <x-page-header
            title="List of Open Operations for Released Work Order"
            description="MRO execution queue for released work order operations, filtered by work center and work order type with the full operational reference view."
        />

        <section class="max-w-[1400px] space-y-5">
            <template x-if="statusMessage">
                <div class="flex items-center rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800" role="alert">
                    <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
                    <span x-text="statusMessage"></span>
                </div>
            </template>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="grid gap-4 xl:grid-cols-[260px_260px_auto]">
                    <div>
                        <label for="mro_open_operations_work_center" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Work Center</label>
                        <input
                            id="mro_open_operations_work_center"
                            type="text"
                            x-model="workCenter"
                            class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100"
                            placeholder="Filter work center"
                        />
                    </div>

                    <div>
                        <label for="mro_open_operations_work_order_type" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Work Order Type</label>
                        <select id="mro_open_operations_work_order_type" x-model="workOrderType" class="block w-full rounded-lg border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100">
                            <option value="">All work order types</option>
                            @foreach ($workOrderTypes as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end justify-start xl:justify-end">
                        <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="refreshRows()">Refresh</button>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="enterprise-static-table w-full min-w-[2400px] text-left text-sm">
                        <thead class="border-b border-gray-200 bg-gray-50">
                            <tr>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Work Order</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Work Order Type</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Code Operation</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Description</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Work Center</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Performed</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Duration</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Nb employees</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Elapsed Time</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Item No.</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Equipment Code</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Functional Location</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Item No. Ope.</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Equipment Counter</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Chapter</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Section</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Subject</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Sheet</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Sheet Version</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Mark</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Mark Version</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Field 1</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Field 2</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Field 3</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Field 4</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Field 5</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <template x-for="(row, index) in visibleRows()" :key="`${row.work_order}-${index}`">
                                <tr class="transition-colors hover:bg-blue-50/60">
                                    <td class="whitespace-nowrap px-3 py-2.5 font-medium text-gray-900" x-text="row.work_order"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.work_order_type"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.code_operation"></td>
                                    <td class="min-w-[220px] whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.description"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.work_center || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.performed"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.duration"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.employees"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.elapsed_time"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.item_number"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.equipment_code"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 font-medium text-gray-900" x-text="row.functional_location || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.item_number_operation || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.equipment_counter"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.chapter || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.section || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.subject || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.sheet || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.sheet_version || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.mark || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.mark_version || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.field_1 || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.field_2 || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.field_3 || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.field_4 || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.field_5 || '-'"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex items-center justify-start border-t border-gray-200 pt-5">
                <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="closeQueue()">Cancel</button>
            </div>
        </section>
    </div>
@endsection
