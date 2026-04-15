@extends('layouts.app')

@section('title', 'List of Technical Logs')

@php
    $technicalLogs = [
        [
            'id' => '00000034',
            'description' => 'DATE: 01.05.19',
            'status' => 'Released',
            'deadline' => '',
            'ata' => '',
            'mel_item_ref' => '',
            'mel_item_name' => '',
            'fl_reference' => 'Airframe',
            'object_type' => 'Functional Location',
            'object_ref' => '9M-WAY',
            'item_code' => 'AW139',
            'serial_number' => '31501',
            'category_or_registration' => '9M-WAY',
            'task_number' => '',
            'closed' => true,
            'severity' => 'released',
        ],
        [
            'id' => '0000003E',
            'description' => 'DATE: 02.05.19',
            'status' => 'Released',
            'deadline' => '',
            'ata' => '',
            'mel_item_ref' => '',
            'mel_item_name' => '',
            'fl_reference' => 'Airframe',
            'object_type' => 'Functional Location',
            'object_ref' => '9M-WAY',
            'item_code' => 'AW139',
            'serial_number' => '31501',
            'category_or_registration' => '9M-WAY',
            'task_number' => '',
            'closed' => true,
            'severity' => 'released',
        ],
        [
            'id' => '0000006G',
            'description' => 'DATE: 13.05.19',
            'status' => 'Released',
            'deadline' => '',
            'ata' => '',
            'mel_item_ref' => '',
            'mel_item_name' => '',
            'fl_reference' => 'Airframe',
            'object_type' => 'Functional Location',
            'object_ref' => '9M-WAG',
            'item_code' => 'AW139',
            'serial_number' => '31343',
            'category_or_registration' => 'M104-03',
            'task_number' => '',
            'closed' => true,
            'severity' => 'released',
        ],
        [
            'id' => '0000006M',
            'description' => 'DATE: 13.05.20',
            'status' => 'Released',
            'deadline' => '',
            'ata' => '',
            'mel_item_ref' => '',
            'mel_item_name' => '',
            'fl_reference' => 'Airframe',
            'object_type' => 'Functional Location',
            'object_ref' => '9M-WST',
            'item_code' => 'AW189',
            'serial_number' => '49021',
            'category_or_registration' => '9M-WST',
            'task_number' => '',
            'closed' => true,
            'severity' => 'released',
        ],
        [
            'id' => '0000009D',
            'description' => 'DATE: 05.05.19',
            'status' => 'Released',
            'deadline' => '',
            'ata' => '',
            'mel_item_ref' => '',
            'mel_item_name' => '',
            'fl_reference' => 'Airframe',
            'object_type' => 'Functional Location',
            'object_ref' => '9M-WAL',
            'item_code' => 'AW139',
            'serial_number' => '31384',
            'category_or_registration' => 'M104-06',
            'task_number' => '',
            'closed' => true,
            'severity' => 'released',
        ],
        [
            'id' => '000000QG',
            'description' => 'DATE: 20.06.19',
            'status' => 'Released',
            'deadline' => '',
            'ata' => '',
            'mel_item_ref' => '',
            'mel_item_name' => '',
            'fl_reference' => 'Airframe',
            'object_type' => 'Functional Location',
            'object_ref' => '9M-WST',
            'item_code' => 'AW189',
            'serial_number' => '49021',
            'category_or_registration' => '',
            'task_number' => '',
            'closed' => true,
            'severity' => 'released',
        ],
        [
            'id' => '000000R0',
            'description' => 'DATE: 23.06.20',
            'status' => 'Released',
            'deadline' => '',
            'ata' => '',
            'mel_item_ref' => '',
            'mel_item_name' => '',
            'fl_reference' => 'Airframe',
            'object_type' => 'Functional Location',
            'object_ref' => '9M-WAE',
            'item_code' => 'AW139',
            'serial_number' => '31340',
            'category_or_registration' => '9M-WAE',
            'task_number' => '',
            'closed' => true,
            'severity' => 'released',
        ],
        [
            'id' => '000000SW',
            'description' => 'DATE: 27.06.19',
            'status' => 'Released',
            'deadline' => '',
            'ata' => '',
            'mel_item_ref' => '',
            'mel_item_name' => '',
            'fl_reference' => '',
            'object_type' => '',
            'object_ref' => '9M-WAX',
            'item_code' => 'AW139',
            'serial_number' => '41383',
            'category_or_registration' => '9M-WAX',
            'task_number' => '',
            'closed' => false,
            'severity' => 'open',
        ],
        [
            'id' => '000000UV',
            'description' => 'PRE FLIGHT CHECK',
            'status' => 'Released',
            'deadline' => '',
            'ata' => '05-10-00',
            'mel_item_ref' => '',
            'mel_item_name' => '',
            'fl_reference' => '',
            'object_type' => '',
            'object_ref' => '',
            'item_code' => '',
            'serial_number' => '',
            'category_or_registration' => '',
            'task_number' => 'PFC-019',
            'closed' => false,
            'severity' => 'watch',
        ],
        [
            'id' => '0000011Y',
            'description' => 'DATE: 16.07.19',
            'status' => 'Released',
            'deadline' => '',
            'ata' => '',
            'mel_item_ref' => '',
            'mel_item_name' => '',
            'fl_reference' => 'Airframe',
            'object_type' => 'Functional Location',
            'object_ref' => '9M-WST',
            'item_code' => 'AW189',
            'serial_number' => '49021',
            'category_or_registration' => '',
            'task_number' => '',
            'closed' => true,
            'severity' => 'released',
        ],
        [
            'id' => '000001K6',
            'description' => 'DATE: 25.08.19',
            'status' => 'Released',
            'deadline' => '',
            'ata' => '',
            'mel_item_ref' => '',
            'mel_item_name' => '',
            'fl_reference' => 'Airframe',
            'object_type' => 'Functional Location',
            'object_ref' => '9M-WAA',
            'item_code' => 'AW139',
            'serial_number' => '31324',
            'category_or_registration' => 'M104-04',
            'task_number' => '',
            'closed' => true,
            'severity' => 'released',
        ],
        [
            'id' => '0000025V',
            'description' => 'DATE: 16.10.19',
            'status' => 'Released',
            'deadline' => '20.10.19',
            'ata' => '27-21-00',
            'mel_item_ref' => 'MEL-2710',
            'mel_item_name' => 'Autopilot channel',
            'fl_reference' => 'Airframe',
            'object_type' => 'Functional Location',
            'object_ref' => '9M-WAS',
            'item_code' => 'AW139',
            'serial_number' => '31441',
            'category_or_registration' => '9M-WAS',
            'task_number' => 'TL-8744',
            'closed' => false,
            'severity' => 'watch',
        ],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            showClosedOnly: false,
            statusMessage: '',
            detailUrlBase: '{{ url('/mro/work-order/technical-logs') }}',
            rows: @js($technicalLogs),
            filteredRows() {
                return this.rows.filter((row) => !this.showClosedOnly || row.closed);
            },
            openObject(row) {
                this.statusMessage = `Opening ${row.object_type || 'object'} ${row.object_ref || row.item_code || row.id}.`;
            },
            closeList() {
                this.statusMessage = 'Technical-log list kept in preview mode.';
            },
        }"
    >
        <x-page-header
            title="List of Technical Logs"
            description="Modern ATP list view for browsing operational technical logs, filtering closed records, and drilling into related fleet references."
        />

        <section class="max-w-[1280px] space-y-5">
            <template x-if="statusMessage">
                <div class="flex items-center rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800" role="alert">
                    <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
                    <span x-text="statusMessage"></span>
                </div>
            </template>

            {{-- Toolbar --}}
            <div class="flex flex-col gap-3 rounded-2xl border border-gray-200 bg-white px-5 py-4 shadow-sm md:flex-row md:items-center md:justify-between">
                <label class="inline-flex cursor-pointer items-center gap-3 text-sm text-gray-700">
                    <input type="checkbox" x-model="showClosedOnly" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                    <span>Display only closed technical logs</span>
                </label>

                <div class="flex items-center gap-3 self-end md:self-auto">
                    <span class="text-sm text-gray-500">Records found</span>
                    <span class="inline-flex min-w-[56px] justify-center rounded-lg border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm font-semibold text-gray-900" x-text="filteredRows().length"></span>
                </div>
            </div>

            {{-- Table --}}
            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse min-w-[1500px]">
                        <thead class="border-b border-gray-200 bg-gray-50">
                            <tr>
                                <th class="w-10 px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">State</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Log Number</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Description</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Deadline</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">ATA</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">MEL Item Ref.</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">MEL Item Name</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">FL Reference</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Object Type</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Object Ref</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Item Code / FL</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Serial Number</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Category / Reg.</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Task Number</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <template x-for="row in filteredRows()" :key="row.id">
                                <tr class="transition-colors hover:bg-blue-50/60">
                                    <td class="px-3 py-2.5">
                                        <span
                                            class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide"
                                            :class="{
                                                'bg-emerald-100 text-emerald-700': row.severity === 'released',
                                                'bg-blue-100 text-blue-700': row.severity === 'open',
                                                'bg-amber-100 text-amber-700': row.severity === 'watch'
                                            }"
                                            x-text="row.severity"
                                        ></span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-2.5">
                                        <a class="group/drill inline-flex items-center gap-2 font-semibold text-gray-900 transition hover:text-blue-700" :href="`${detailUrlBase}/${row.id}`">
                                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100 transition group-hover/drill:bg-blue-100">
                                                <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                            </span>
                                            <span x-text="row.id"></span>
                                        </a>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.description"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5">
                                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700" x-text="row.status"></span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.deadline || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.ata || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.mel_item_ref || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.mel_item_name || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.fl_reference || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.object_type || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5">
                                        <template x-if="row.object_ref">
                                            <button type="button" class="group/drill inline-flex items-center gap-2 font-semibold text-gray-900 transition hover:text-blue-700" @click="openObject(row)">
                                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100 transition group-hover/drill:bg-blue-100">
                                                    <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                                </span>
                                                <span x-text="row.object_ref"></span>
                                            </button>
                                        </template>
                                        <template x-if="!row.object_ref">
                                            <span class="text-gray-700">-</span>
                                        </template>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.item_code || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.serial_number || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.category_or_registration || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.task_number || '-'"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3 border-t border-gray-200 pt-5">
                <button type="button" class="btn-primary" @click="statusMessage = `Selected ${filteredRows().length} technical log record(s).`">OK</button>
                <button type="button" class="btn-secondary" @click="closeList()">Cancel</button>
            </div>
        </section>
    </div>
@endsection
