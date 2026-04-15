@extends('layouts.app')

@section('title', 'Tools Status')

@php
    $toolRows = [
        ['alert' => '!', 'equipment_code' => 'TOL-10021', 'item_code' => 'TL-DRL-001', 'description' => 'Torque Drill Kit', 'serial_number' => 'DRK-44812', 'warehouse' => 'MRO Main', 'work_order' => 'WO-240118', 'operation' => 'Inspection', 'task' => 'TSK-032', 'status_work' => 'Allocated', 'last_calibration' => '2026-02-10', 'next_calibration' => '2026-08-10'],
        ['alert' => '', 'equipment_code' => 'TOL-10054', 'item_code' => 'TL-TST-014', 'description' => 'Hydraulic Test Bench', 'serial_number' => 'HTB-30944', 'warehouse' => 'Bench Bay', 'work_order' => 'WO-240124', 'operation' => 'Leak Check', 'task' => 'TSK-144', 'status_work' => 'In Use', 'last_calibration' => '2026-01-22', 'next_calibration' => '2026-07-22'],
        ['alert' => '!', 'equipment_code' => 'TOL-10102', 'item_code' => 'TL-MEA-009', 'description' => 'Pressure Gauge Set', 'serial_number' => 'PGS-22140', 'warehouse' => 'Calibration Room', 'work_order' => 'WO-240131', 'operation' => 'Bench Test', 'task' => 'TSK-211', 'status_work' => 'Calibration Due', 'last_calibration' => '2025-10-04', 'next_calibration' => '2026-04-04'],
        ['alert' => '', 'equipment_code' => 'TOL-10133', 'item_code' => 'TL-BOR-003', 'description' => 'Borescope Unit', 'serial_number' => 'BOR-88741', 'warehouse' => 'Tool Crib', 'work_order' => 'WO-240137', 'operation' => 'Engine Review', 'task' => 'TSK-288', 'status_work' => 'Available', 'last_calibration' => '2026-03-18', 'next_calibration' => '2026-09-18'],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            rows: @js($toolRows),
            statusMessage: '',
            refreshTools() {
                this.statusMessage = `Tools status refreshed for ${this.rows.length} tracked tool record(s).`;
            },
            closeToolsStatus() {
                this.statusMessage = 'Tools status review closed.';
            },
        }"
    >
        <x-page-header
            title="Tools Status"
            description="Review tool assignment, calibration readiness, and work-order allocation across the MRO workspace."
        >
            <x-slot name="actions">
                <button type="button" class="btn-secondary" @click="refreshTools()">Refresh</button>
            </x-slot>
        </x-page-header>

        <section class="attach-workspace-shell max-w-[1480px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel class="space-y-4">
                <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1520px]" datatable datatable-selectable>
                    <x-slot name="thead">
                        <tr>
                            <th data-sortable="false">!</th>
                            <th>Equipment Code</th>
                            <th>Item Code</th>
                            <th>Item Desc.</th>
                            <th>Serial Number</th>
                            <th>Warehouse</th>
                            <th>Work Order</th>
                            <th>Work Order Operation</th>
                            <th>Work Order Task</th>
                            <th>Status Work Order</th>
                            <th>Last Calibration</th>
                            <th>Next Calibration</th>
                        </tr>
                    </x-slot>

                    <x-slot name="tbody">
                        @foreach ($toolRows as $row)
                            <tr>
                                <td>
                                    <span class="inline-flex min-w-[20px] items-center justify-center text-sm font-semibold {{ $row['alert'] ? 'text-amber-600' : 'text-gray-300' }}">
                                        {{ $row['alert'] ?: '-' }}
                                    </span>
                                </td>
                                <td>{{ $row['equipment_code'] }}</td>
                                <td>{{ $row['item_code'] }}</td>
                                <td>{{ $row['description'] }}</td>
                                <td>{{ $row['serial_number'] }}</td>
                                <td>{{ $row['warehouse'] }}</td>
                                <td>{{ $row['work_order'] }}</td>
                                <td>{{ $row['operation'] }}</td>
                                <td>{{ $row['task'] }}</td>
                                <td>{{ $row['status_work'] }}</td>
                                <td>{{ $row['last_calibration'] }}</td>
                                <td>{{ $row['next_calibration'] }}</td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-enterprise.table-shell>
            </x-enterprise.panel>

            <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="btn-primary" @click="closeToolsStatus()">OK</button>
                    <button type="button" class="btn-secondary" @click="closeToolsStatus()">Cancel</button>
                </div>

                <a href="{{ route('mro.work-order.logistic-cockpit') }}" class="btn-secondary">Logistic Cockpit</a>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
