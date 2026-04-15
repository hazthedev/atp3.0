@extends('layouts.app')

@section('title', 'List of Open Repairs')

@php
    $openRepairRows = [
        ['code' => '1', 'alert' => 'critical', 'intervention' => 'Maintenance', 'assignee' => 'manager', 'status' => 'Open', 'branch' => 'Main', 'date_in' => '01.01.17', 'due_date' => '31.12.17', 'object_type' => 'Customer', 'object_ref' => '300028', 'item_code' => 'Weststar', 'serial_number' => '', 'category' => '', 'op_code' => '300028', 'op_name' => 'Weststar', 'return_reason' => '', 'subject' => 'Line Maintenance 2017 : WO by Daily Flight Log'],
        ['code' => '15186', 'alert' => 'critical', 'intervention' => 'Maintenance', 'assignee' => 'manager', 'status' => 'Open', 'branch' => 'MYY', 'date_in' => '03.10.17', 'due_date' => '03.10.17', 'object_type' => 'Functional Location', 'object_ref' => '9M-WSS', 'item_code' => 'AW189', 'serial_number' => '49012', 'category' => '9M-WSS', 'op_code' => '300028', 'op_name' => 'Weststar', 'return_reason' => '', 'subject' => 'WASSB/49012/0041 - 25 Hrs Inspection'],
        ['code' => '15204', 'alert' => 'critical', 'intervention' => 'Maintenance', 'assignee' => 'manager', 'status' => 'Open', 'branch' => 'MYY', 'date_in' => '03.10.17', 'due_date' => '03.10.17', 'object_type' => 'Functional Location', 'object_ref' => '9M-WSS', 'item_code' => 'AW189', 'serial_number' => '49012', 'category' => '9M-WSS', 'op_code' => '300028', 'op_name' => 'Weststar', 'return_reason' => '', 'subject' => 'Information on repair'],
        ['code' => '16411', 'alert' => 'critical', 'intervention' => 'Maintenance', 'assignee' => 'manager', 'status' => 'Open', 'branch' => 'Main', 'date_in' => '30.10.17', 'due_date' => '30.10.18', 'object_type' => 'Functional Location', 'object_ref' => '9M-WAO', 'item_code' => 'AW139', 'serial_number' => '31419', 'category' => '9M-WAO', 'op_code' => '300028', 'op_name' => 'Weststar', 'return_reason' => '', 'subject' => 'WASSB/31419/002 - 300RHs + ENG30'],
        ['code' => '37926', 'alert' => 'good', 'intervention' => 'Maintenance', 'assignee' => 'manager', 'status' => 'Open', 'branch' => 'Main', 'date_in' => '01.01.19', 'due_date' => '31.12.19', 'object_type' => 'Customer', 'object_ref' => '300028', 'item_code' => '*WESTSTAR', 'serial_number' => '', 'category' => '', 'op_code' => '', 'op_name' => '', 'return_reason' => '', 'subject' => 'KTE - RETURN UNUSED SPARES AND TOOLS'],
        ['code' => '41651', 'alert' => 'good', 'intervention' => 'Workshop', 'assignee' => 'manager', 'status' => 'Open', 'branch' => 'Main', 'date_in' => '01.09.19', 'due_date' => '', 'object_type' => 'Customer', 'object_ref' => '300028', 'item_code' => '*WESTSTAR', 'serial_number' => '', 'category' => '', 'op_code' => '', 'op_name' => '', 'return_reason' => '', 'subject' => '**will be deleted soon. please contact IT'],
        ['code' => '108718', 'alert' => 'good', 'intervention' => 'Workshop', 'assignee' => 'manager', 'status' => 'Open', 'branch' => 'Main', 'date_in' => '01.01.24', 'due_date' => '', 'object_type' => 'Customer', 'object_ref' => '300028', 'item_code' => '*WESTSTAR', 'serial_number' => '', 'category' => '', 'op_code' => '', 'op_name' => '', 'return_reason' => '', 'subject' => 'WASSB/0007 WHEEL'],
        ['code' => '109628', 'alert' => 'good', 'intervention' => 'Workshop', 'assignee' => 'manager', 'status' => 'Open', 'branch' => 'Main', 'date_in' => '01.01.24', 'due_date' => '', 'object_type' => 'Customer', 'object_ref' => '300028', 'item_code' => '*WESTSTAR', 'serial_number' => '', 'category' => '', 'op_code' => '', 'op_name' => '', 'return_reason' => '', 'subject' => 'WASSB/0008 CANNIBALISATION'],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            rows: @js($openRepairRows),
            statusMessage: '',
            cancelView() {
                this.statusMessage = 'Open repairs queue closed.';
            },
        }"
    >
        <x-page-header
            title="List of Open Repairs"
            description="Review open repair events, operational ownership, and pending repair subjects in the ATP MRO workspace."
        />

        <section class="attach-workspace-shell max-w-[1560px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel class="space-y-4">
                <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1820px]" datatable datatable-selectable>
                    <x-slot name="thead">
                        <tr>
                            <th>Code</th>
                            <th data-sortable="false">!</th>
                            <th>Intervention ...</th>
                            <th>Assignee</th>
                            <th>Status</th>
                            <th>Branch</th>
                            <th>Date In</th>
                            <th>Due Date</th>
                            <th>Object Type</th>
                            <th>Object Ref</th>
                            <th>Item Code/FL...</th>
                            <th>Serial Number</th>
                            <th>Categ. Part/R...</th>
                            <th>Op. Code</th>
                            <th>Op. Name</th>
                            <th>Return Reason</th>
                            <th>Subject</th>
                        </tr>
                    </x-slot>

                    <x-slot name="tbody">
                        @foreach ($openRepairRows as $row)
                            <tr>
                                <td>{{ $row['code'] }}</td>
                                <td>
                                    <span class="inline-flex h-4 w-4 rounded-full {{ $row['alert'] === 'critical' ? 'bg-red-600 shadow-[0_0_0_2px_rgba(220,38,38,0.18)]' : 'bg-green-500 shadow-[0_0_0_2px_rgba(34,197,94,0.18)]' }}"></span>
                                </td>
                                <td>{{ $row['intervention'] }}</td>
                                <td>{{ $row['assignee'] }}</td>
                                <td>{{ $row['status'] }}</td>
                                <td>{{ $row['branch'] }}</td>
                                <td>{{ $row['date_in'] }}</td>
                                <td>{{ $row['due_date'] ?: '-' }}</td>
                                <td>{{ $row['object_type'] }}</td>
                                <td>{{ $row['object_ref'] }}</td>
                                <td>{{ $row['item_code'] }}</td>
                                <td>{{ $row['serial_number'] ?: '-' }}</td>
                                <td>{{ $row['category'] ?: '-' }}</td>
                                <td>{{ $row['op_code'] ?: '-' }}</td>
                                <td>{{ $row['op_name'] ?: '-' }}</td>
                                <td>{{ $row['return_reason'] ?: '-' }}</td>
                            <td class="max-w-[260px] whitespace-normal">{{ $row['subject'] }}</td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-enterprise.table-shell>

                <x-enterprise.action-bar class="border-t border-gray-200 pt-5">
                    <button type="button" class="btn-secondary" @click="cancelView()">Cancel</button>
                </x-enterprise.action-bar>
            </x-enterprise.panel>
        </section>
    </div>
@endsection
