@extends('layouts.app')

@section('title', 'List of Technical Logs')

@php
    $technicalLogs = [
        ['reference' => '00000034', 'description' => 'DATE: 01.05.19', 'status' => 'Released', 'deadline' => '', 'ata' => '', 'mel_item_ref' => '', 'mel_item_name' => '', 'fl_reference' => 'Airframe', 'object_type' => 'Functional Location', 'object_ref' => '9M-WAY', 'item_code_or_fl' => 'AW139', 'serial_number' => '31501', 'category_or_registration' => '9M-WAY', 'task_number' => '', 'severity' => 'watch'],
        ['reference' => '0000003E', 'description' => 'DATE: 02.05.19', 'status' => 'Released', 'deadline' => '', 'ata' => '', 'mel_item_ref' => '', 'mel_item_name' => '', 'fl_reference' => 'Airframe', 'object_type' => 'Functional Location', 'object_ref' => '9M-WAY', 'item_code_or_fl' => 'AW139', 'serial_number' => '31501', 'category_or_registration' => '9M-WAY', 'task_number' => '', 'severity' => 'watch'],
        ['reference' => '0000006G', 'description' => 'DATE: 13.05.19', 'status' => 'Released', 'deadline' => '', 'ata' => '', 'mel_item_ref' => '', 'mel_item_name' => '', 'fl_reference' => 'Airframe', 'object_type' => 'Functional Location', 'object_ref' => '9M-WAG', 'item_code_or_fl' => 'AW139', 'serial_number' => '31343', 'category_or_registration' => 'M104-03', 'task_number' => '', 'severity' => 'watch'],
        ['reference' => '0000006M', 'description' => 'DATE: 13.05.20', 'status' => 'Released', 'deadline' => '', 'ata' => '', 'mel_item_ref' => '', 'mel_item_name' => '', 'fl_reference' => 'Airframe', 'object_type' => 'Functional Location', 'object_ref' => '9M-WST', 'item_code_or_fl' => 'AW189', 'serial_number' => '49021', 'category_or_registration' => '9M-WST', 'task_number' => '', 'severity' => 'watch'],
        ['reference' => '0000009D', 'description' => 'DATE: 05.05.19', 'status' => 'Released', 'deadline' => '', 'ata' => '', 'mel_item_ref' => '', 'mel_item_name' => '', 'fl_reference' => 'Airframe', 'object_type' => 'Functional Location', 'object_ref' => '9M-WAL', 'item_code_or_fl' => 'AW139', 'serial_number' => '31384', 'category_or_registration' => 'M104-06', 'task_number' => '', 'severity' => 'watch'],
        ['reference' => '000000QG', 'description' => 'DATE: 20.06.19', 'status' => 'Released', 'deadline' => '', 'ata' => '', 'mel_item_ref' => '', 'mel_item_name' => '', 'fl_reference' => 'Airframe', 'object_type' => 'Functional Location', 'object_ref' => '9M-WST', 'item_code_or_fl' => 'AW189', 'serial_number' => '49021', 'category_or_registration' => '', 'task_number' => '', 'severity' => 'watch'],
        ['reference' => '000000R0', 'description' => 'DATE: 23.06.20', 'status' => 'Released', 'deadline' => '', 'ata' => '', 'mel_item_ref' => '', 'mel_item_name' => '', 'fl_reference' => 'Airframe', 'object_type' => 'Functional Location', 'object_ref' => '9M-WAE', 'item_code_or_fl' => 'AW139', 'serial_number' => '31340', 'category_or_registration' => '9M-WAE', 'task_number' => '', 'severity' => 'watch'],
        ['reference' => '000000SW', 'description' => 'DATE: 27.06.19', 'status' => 'Released', 'deadline' => '', 'ata' => '', 'mel_item_ref' => '', 'mel_item_name' => '', 'fl_reference' => 'Airframe', 'object_type' => 'Functional Location', 'object_ref' => '9M-WAX', 'item_code_or_fl' => 'AW139', 'serial_number' => '41383', 'category_or_registration' => '9M-WAX', 'task_number' => '', 'severity' => 'watch'],
        ['reference' => '000000UV', 'description' => 'PRE FLIGHT CHECK', 'status' => 'Released', 'deadline' => '', 'ata' => '05-10-00', 'mel_item_ref' => '', 'mel_item_name' => '', 'fl_reference' => '', 'object_type' => '', 'object_ref' => '', 'item_code_or_fl' => '', 'serial_number' => '', 'category_or_registration' => '', 'task_number' => 'PFC-019', 'severity' => 'watch'],
        ['reference' => '0000011Y', 'description' => 'DATE: 16.07.19', 'status' => 'Released', 'deadline' => '', 'ata' => '', 'mel_item_ref' => '', 'mel_item_name' => '', 'fl_reference' => 'Airframe', 'object_type' => 'Functional Location', 'object_ref' => '9M-WST', 'item_code_or_fl' => 'AW189', 'serial_number' => '49021', 'category_or_registration' => '', 'task_number' => '', 'severity' => 'watch'],
        ['reference' => '000001K6', 'description' => 'DATE: 25.08.19', 'status' => 'Released', 'deadline' => '', 'ata' => '', 'mel_item_ref' => '', 'mel_item_name' => '', 'fl_reference' => 'Airframe', 'object_type' => 'Functional Location', 'object_ref' => '9M-WAA', 'item_code_or_fl' => 'AW139', 'serial_number' => '31324', 'category_or_registration' => 'M104-04', 'task_number' => '', 'severity' => 'watch'],
        ['reference' => '0000025V', 'description' => 'DATE: 16.10.19', 'status' => 'Released', 'deadline' => '20.10.19', 'ata' => '27-21-00', 'mel_item_ref' => 'MEL-2710', 'mel_item_name' => 'Autopilot channel', 'fl_reference' => 'Airframe', 'object_type' => 'Functional Location', 'object_ref' => '9M-WAS', 'item_code_or_fl' => 'AW139', 'serial_number' => '31441', 'category_or_registration' => '9M-WAS', 'task_number' => 'TL-8744', 'severity' => 'watch'],
    ];
@endphp

@section('content')
    <div class="space-y-6" x-data="{ statusMessage: '' }">
        <x-page-header
            title="List of Technical Logs"
            description="Search and browse technical logs, then open the selected technical log reference to continue in the full subtab workspace."
        />

        <p class="text-sm text-gray-500">Browse {{ count($technicalLogs) }} technical logs with client-side search, sorting, and pagination.</p>

        <template x-if="statusMessage">
            <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
        </template>

        <x-data-table datatable :datatable-selectable="false" table-class="pending-base-table min-w-[1750px]">
            <x-slot name="thead">
                <tr>
                    <th class="w-10">!</th>
                    <th>Technical Log Ref.</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>DeadLine</th>
                    <th>ATA</th>
                    <th>MEL Item Ref...</th>
                    <th>MEL Item Name</th>
                    <th>FL Reference</th>
                    <th>Object Type</th>
                    <th>Object Ref</th>
                    <th>Item Code / FL...</th>
                    <th>Serial Number</th>
                    <th>Categ. Part/Reg.</th>
                    <th>Task Number</th>
                </tr>
            </x-slot>

            <x-slot name="tbody">
                @foreach ($technicalLogs as $row)
                    <tr class="hover:bg-neutral-secondary-soft cursor-pointer">
                        <td>
                            <span class="inline-flex h-4 w-4 rounded-full bg-amber-500 ring-2 ring-amber-200" aria-hidden="true"></span>
                        </td>
                        <td class="whitespace-nowrap">
                            <a
                                href="{{ route('system.technical-logs.show', ['log' => $row['reference']]) }}"
                                class="group inline-flex items-center gap-2 font-semibold text-slate-900 transition hover:text-[#2f5bff]"
                            >
                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-[#edf2ff] text-[#2f5bff] ring-1 ring-inset ring-[#d9e3ff] transition group-hover:bg-[#e2eaff]">
                                    <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                </span>
                                <span>{{ $row['reference'] }}</span>
                            </a>
                        </td>
                        <td class="whitespace-nowrap">{{ $row['description'] }}</td>
                        <td class="whitespace-nowrap">{{ $row['status'] }}</td>
                        <td class="whitespace-nowrap">{{ $row['deadline'] ?: '-' }}</td>
                        <td class="whitespace-nowrap">{{ $row['ata'] ?: '-' }}</td>
                        <td class="whitespace-nowrap">{{ $row['mel_item_ref'] ?: '-' }}</td>
                        <td class="whitespace-nowrap">{{ $row['mel_item_name'] ?: '-' }}</td>
                        <td class="whitespace-nowrap">{{ $row['fl_reference'] ?: '-' }}</td>
                        <td class="whitespace-nowrap">{{ $row['object_type'] ?: '-' }}</td>
                        <td class="whitespace-nowrap">{{ $row['object_ref'] ?: '-' }}</td>
                        <td class="whitespace-nowrap">{{ $row['item_code_or_fl'] ?: '-' }}</td>
                        <td class="whitespace-nowrap">{{ $row['serial_number'] ?: '-' }}</td>
                        <td class="whitespace-nowrap">{{ $row['category_or_registration'] ?: '-' }}</td>
                        <td class="whitespace-nowrap">{{ $row['task_number'] ?: '-' }}</td>
                    </tr>
                @endforeach
            </x-slot>
        </x-data-table>

        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-gray-200 pt-5">
            <div class="text-sm text-gray-600">
                Number of records found
                <span class="ml-2 inline-flex min-w-[52px] items-center justify-center rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1 text-sm font-semibold text-gray-900">{{ count($technicalLogs) }}</span>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <button type="button" class="btn-primary" @click="statusMessage = 'Technical log selection confirmed for preview.'">OK</button>
                <button type="button" class="btn-secondary" @click="statusMessage = 'Technical log list unchanged.'">Cancel</button>
            </div>
        </div>
    </div>
@endsection
