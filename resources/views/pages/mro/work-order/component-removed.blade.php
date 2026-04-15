@extends('layouts.app')

@section('title', 'Components Removed: To be received in Warehouse')

@php
    $removedComponents = [
        [
            'call_id' => 'CALL-1482',
            'ata_chapter' => '27-10',
            'item' => 'A139-27-118',
            'sn' => 'TRM-91277',
            'item_desc' => 'Trim Actuator Assembly',
            'scheduled' => true,
            'removal_reason' => 'Deferred rectification',
            'removal_date' => '2026-03-07',
            'object_type' => 'Functional Location',
            'registration' => '9M-WAY',
            'serial_number' => '31501',
            'fl_type' => 'AW139',
            'eq_tsn' => '5,441:21',
            'eq_csn' => '3,104',
            'ric' => 'RIC-1184',
            'work_order' => 'WO-24116',
            'installation_date' => '2025-11-12',
            'maintenance_ref_1' => 'MNT-23874',
            'maintenance_ref_2' => 'SB-A139-27118',
            'goods_receipt' => 'Pending',
            'warehouse' => 'KL Line Store',
            'purchase_request' => 'PR-11082',
            'purchase_order' => '',
        ],
        [
            'call_id' => 'CALL-1498',
            'ata_chapter' => '53-20',
            'item' => 'A189-53-220',
            'sn' => 'SPK-44191',
            'item_desc' => 'Cabin Speaker Set',
            'scheduled' => false,
            'removal_reason' => 'Fault isolation',
            'removal_date' => '2026-03-18',
            'object_type' => 'Functional Location',
            'registration' => '9M-WST',
            'serial_number' => '49021',
            'fl_type' => 'AW189',
            'eq_tsn' => '2,846:15',
            'eq_csn' => '1,894',
            'ric' => 'RIC-1191',
            'work_order' => 'WO-24138',
            'installation_date' => '2025-09-04',
            'maintenance_ref_1' => 'MNT-23982',
            'maintenance_ref_2' => 'TL-4917',
            'goods_receipt' => 'Received',
            'warehouse' => 'Subang Main',
            'purchase_request' => '',
            'purchase_order' => '',
        ],
        [
            'call_id' => 'CALL-1503',
            'ata_chapter' => '32-40',
            'item' => 'A139-32-018',
            'sn' => 'BRK-20377',
            'item_desc' => 'Brake Wear Sensor',
            'scheduled' => true,
            'removal_reason' => 'Wear limit reached',
            'removal_date' => '2026-04-01',
            'object_type' => 'Functional Location',
            'registration' => '9M-WAL',
            'serial_number' => '31384',
            'fl_type' => 'AW139',
            'eq_tsn' => '4,117:02',
            'eq_csn' => '2,901',
            'ric' => 'RIC-1204',
            'work_order' => 'WO-24088',
            'installation_date' => '2025-12-22',
            'maintenance_ref_1' => 'MNT-23898',
            'maintenance_ref_2' => 'INSP-32018',
            'goods_receipt' => 'Pending',
            'warehouse' => 'KL Recovery',
            'purchase_request' => 'PR-11120',
            'purchase_order' => 'PO-78111',
        ],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            fromDate: '2026-03-07',
            toDate: '2026-04-07',
            statusMessage: '',
            rows: @js($removedComponents),
            filteredRows() {
                return this.rows.filter((row) => row.removal_date >= this.fromDate && row.removal_date <= this.toDate);
            },
            searchRows() {
                this.statusMessage = `Found ${this.filteredRows().length} removed component record(s) between ${this.fromDate} and ${this.toDate}.`;
            },
            createGoodsReceipt() {
                this.statusMessage = `Prepared ${this.filteredRows().filter((row) => row.goods_receipt === 'Pending').length} record(s) for goods receipt creation.`;
            },
            createPurchaseRequest() {
                this.statusMessage = `Purchase request flow opened for ${this.filteredRows().length} visible record(s).`;
            },
            createPurchaseOrder() {
                this.statusMessage = `Purchase order flow opened for ${this.filteredRows().length} visible record(s).`;
            },
            confirmSelection() {
                this.statusMessage = `Warehouse receipt review confirmed for ${this.filteredRows().length} removed component record(s).`;
            },
        }"
    >
        <x-page-header
            title="Components Removed: To be received in Warehouse"
            description="MRO work order intake workspace for reviewing removed components, filtering by removal date, and preparing warehouse and purchasing follow-up actions."
        />

        <section class="max-w-[1320px] space-y-5">
            <template x-if="statusMessage">
                <div class="flex items-center rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800" role="alert">
                    <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
                    <span x-text="statusMessage"></span>
                </div>
            </template>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div class="grid min-w-0 flex-1 gap-4 xl:grid-cols-[220px_220px_auto]">
                        <div>
                            <label for="mro_component_removed_from" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">From</label>
                            <x-date-picker id="mro_component_removed_from" x-model="fromDate" />
                        </div>

                        <div>
                            <label for="mro_component_removed_to" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">To</label>
                            <x-date-picker id="mro_component_removed_to" x-model="toDate" />
                        </div>
                    </div>

                    <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="searchRows()">Search</button>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="enterprise-static-table w-full min-w-[2200px] text-left text-sm">
                        <thead class="border-b border-gray-200 bg-gray-50">
                            <tr>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Call Id</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">ATA Chapter</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Item</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">SN</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Item Desc.</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Scheduled</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Removal Reason</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Removal Date</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Object Type</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Registration</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Serial Number</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">FL Type / Item</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">EQ TSN</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">EQ CSN</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">RIC</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Work Order</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Installation Date</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Maintenance Ref. 1</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Maintenance Ref. 2</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Goods Receipt</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Warehouse</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Purchase Request</th>
                                <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Purchase Order</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <template x-for="(row, index) in filteredRows()" :key="`${row.call_id}-${index}`">
                                <tr class="transition-colors hover:bg-blue-50/60">
                                    <td class="whitespace-nowrap px-3 py-2.5 font-medium text-gray-900" x-text="row.call_id"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.ata_chapter"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.item"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.sn"></td>
                                    <td class="max-w-[200px] whitespace-normal px-3 py-2.5 text-gray-700" x-text="row.item_desc"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5">
                                        <span
                                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold"
                                            :class="row.scheduled ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600'"
                                            x-text="row.scheduled ? 'Yes' : 'No'"
                                        ></span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.removal_reason"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.removal_date"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.object_type"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 font-medium text-gray-900" x-text="row.registration"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.serial_number"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.fl_type"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.eq_tsn"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.eq_csn"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.ric"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.work_order"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.installation_date"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.maintenance_ref_1"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.maintenance_ref_2"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5">
                                        <span
                                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold"
                                            :class="row.goods_receipt === 'Received' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700'"
                                            x-text="row.goods_receipt"
                                        ></span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.warehouse"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.purchase_request || '-'"></td>
                                    <td class="whitespace-nowrap px-3 py-2.5 text-gray-700" x-text="row.purchase_order || '-'"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 border-t border-gray-200 pt-5">
                <button type="button" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100" @click="confirmSelection()">OK</button>

                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="createGoodsReceipt()">Create Goods Receipt</button>
                    <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="createPurchaseRequest()">Create Purchase Request</button>
                    <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="createPurchaseOrder()">Create Purchase Order</button>
                </div>
            </div>
        </section>
    </div>
@endsection
