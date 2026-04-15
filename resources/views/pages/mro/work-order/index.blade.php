@extends('layouts.app')

@section('title', 'List of Open Work Order')

@php
    $openWorkOrders = [
        [
            'code' => '204352',
            'type' => 'Repair Order',
            'status' => 'Planned',
            'branch' => 'Main',
            'work_center' => '',
            'object_type' => 'Customer',
            'object_ref' => '300028',
            'item_code' => '*WESTSTAR',
            'serial_number' => '',
            'category_part' => '',
            'repair_event' => '120043',
            'start_date' => '',
            'title' => 'EMERGENCY POWER UNIT INVESTIGATION',
        ],
        [
            'code' => '265HPO19',
            'type' => 'Repair Order',
            'status' => 'Planned',
            'branch' => 'KTE',
            'work_center' => 'Avionic',
            'object_type' => 'Customer',
            'object_ref' => '300028',
            'item_code' => '*WESTSTAR',
            'serial_number' => '',
            'category_part' => '',
            'repair_event' => '41651',
            'start_date' => '',
            'title' => 'RECERTIFICATION SUPPORT PACKAGE',
        ],
        [
            'code' => '300028',
            'type' => 'Repair Order',
            'status' => 'Planned',
            'branch' => 'KBR',
            'work_center' => '',
            'object_type' => 'Equipment',
            'object_ref' => '18333',
            'item_code' => '3G256V000334',
            'serial_number' => '109',
            'category_part' => 'H/T LLP',
            'repair_event' => '109628',
            'start_date' => '',
            'title' => 'OPS REQ PARTS INSPECTION',
        ],
        [
            'code' => '32761',
            'type' => 'Repair Order',
            'status' => 'Planned',
            'branch' => 'Main',
            'work_center' => '',
            'object_type' => 'Customer',
            'object_ref' => '300028',
            'item_code' => '*WESTSTAR',
            'serial_number' => '',
            'category_part' => '',
            'repair_event' => '40071',
            'start_date' => '',
            'title' => 'RECERTIFICATION TRACKING',
        ],
        [
            'code' => 'AJL03586',
            'type' => 'Repair Order',
            'status' => 'Planned',
            'branch' => 'KTE',
            'work_center' => 'Mechanical',
            'object_type' => 'Customer',
            'object_ref' => '300028',
            'item_code' => '*WESTSTAR',
            'serial_number' => '',
            'category_part' => '',
            'repair_event' => '41651',
            'start_date' => '',
            'title' => 'ROBBERY PLB BATTERY REPLACEMENT',
        ],
        [
            'code' => 'CC-1188',
            'type' => 'Repair Order',
            'status' => 'Planned',
            'branch' => 'KTE',
            'work_center' => 'Avionic',
            'object_type' => 'Customer',
            'object_ref' => '300028',
            'item_code' => '*WESTSTAR',
            'serial_number' => '',
            'category_part' => '',
            'repair_event' => '37926',
            'start_date' => '',
            'title' => 'DISPLAY UNIT ROTATION',
        ],
        [
            'code' => 'CW1282',
            'type' => 'Repair Order',
            'status' => 'Planned',
            'branch' => 'KTE',
            'work_center' => '',
            'object_type' => 'Equipment',
            'object_ref' => '41556',
            'item_code' => '00031010',
            'serial_number' => '0003101001484',
            'category_part' => 'H/T LLP',
            'repair_event' => '109628',
            'start_date' => '03.05.25',
            'title' => 'CANNIBALISATION REVIEW',
        ],
        [
            'code' => 'CW1284',
            'type' => 'Repair Order',
            'status' => 'Planned',
            'branch' => 'Main',
            'work_center' => '',
            'object_type' => 'Item Code',
            'object_ref' => '00031010',
            'item_code' => '1.000000',
            'serial_number' => '',
            'category_part' => 'HALO LIFEJACKET PAX',
            'repair_event' => '109628',
            'start_date' => '',
            'title' => 'CERTIFICATION CONTROL',
        ],
        [
            'code' => 'CW1285',
            'type' => 'Repair Order',
            'status' => 'Planned',
            'branch' => 'KTE',
            'work_center' => 'Safety',
            'object_type' => 'Item Code',
            'object_ref' => '00031010',
            'item_code' => '4.000000',
            'serial_number' => '',
            'category_part' => 'HALO LIFEJACKET PAX',
            'repair_event' => '109628',
            'start_date' => '06.05.25',
            'title' => 'CERTIFICATION CONTROL',
        ],
        [
            'code' => 'CW1289',
            'type' => 'Repair Order',
            'status' => 'Planned',
            'branch' => 'KTE',
            'work_center' => '',
            'object_type' => 'Item Code',
            'object_ref' => '00031010',
            'item_code' => '3.000000',
            'serial_number' => '',
            'category_part' => 'HALO LIFEJACKET PAX',
            'repair_event' => '109628',
            'start_date' => '07.06.25',
            'title' => 'CERTIFICATION CONTROL',
        ],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            showAll: false,
            statusMessage: '',
            rows: @js($openWorkOrders),
            visibleRows() {
                return this.showAll ? this.rows : this.rows.filter((row) => row.status === 'Planned');
            },
            cancelQueue() {
                this.statusMessage = `Open work order review closed with ${this.visibleRows().length} visible record(s).`;
            },
        }"
    >
        <x-page-header
            title="List of Open Work Order"
            description="MRO work order queue for reviewing open repair orders, object references, repair events, and execution planning details."
        />

        <section class="w-full space-y-5">
            <template x-if="statusMessage">
                <div class="flex items-center rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800" role="alert">
                    <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
                    <span x-text="statusMessage"></span>
                </div>
            </template>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <label class="inline-flex items-center gap-3 text-sm font-medium text-gray-700">
                    <input type="checkbox" x-model="showAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                    <span>Show all work order</span>
                </label>
            </div>

            <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable datatable-selectable>
                <x-slot name="thead">
                    <tr>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Branch</th>
                        <th>Work Center</th>
                        <th>Object Type</th>
                        <th>Object Ref</th>
                        <th>Item Code / FL Type / Qty</th>
                        <th>Serial Number</th>
                        <th>Categ. Part / Registration</th>
                        <th>Repair Event</th>
                        <th>Start Date</th>
                        <th>Title</th>
                    </tr>
                </x-slot>
                <x-slot name="tbody">
                    @foreach ($openWorkOrders as $row)
                        <tr>
                            <td>{{ $row['code'] }}</td>
                            <td>{{ $row['type'] }}</td>
                            <td><span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-semibold text-blue-700">{{ $row['status'] }}</span></td>
                            <td>{{ $row['branch'] }}</td>
                            <td>{{ $row['work_center'] ?: '-' }}</td>
                            <td>{{ $row['object_type'] }}</td>
                            <td>{{ $row['object_ref'] }}</td>
                            <td>{{ $row['item_code'] }}</td>
                            <td>{{ $row['serial_number'] ?: '-' }}</td>
                            <td>{{ $row['category_part'] ?: '-' }}</td>
                            <td>{{ $row['repair_event'] }}</td>
                            <td>{{ $row['start_date'] ?: '-' }}</td>
                            <td>{{ $row['title'] }}</td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-enterprise.table-shell>

            <div class="flex items-center justify-start border-t border-gray-200 pt-5">
                <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="cancelQueue()">Cancel</button>
            </div>
        </section>
    </div>
@endsection
