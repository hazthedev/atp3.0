@extends('layouts.app')

@section('title', 'Logistic Cockpit')

@php
    $issuedRows = [
        ['item_code' => 'MAT-21014', 'description' => 'Hydraulic Seal Kit', 'expected' => 2, 'issued' => 1, 'flag' => '!', 'uom' => 'EA', 'in_stock' => 1, 'warehouse' => 'MRO Main', 'decision' => 'Partial', 'linked_op' => 'OP-120'],
        ['item_code' => 'MAT-31007', 'description' => 'Main Rotor Bolt Set', 'expected' => 8, 'issued' => 8, 'flag' => '', 'uom' => 'EA', 'in_stock' => 0, 'warehouse' => 'Fastener Store', 'decision' => 'Ready', 'linked_op' => 'OP-188'],
        ['item_code' => 'TOOL-4401', 'description' => 'Torque Wrench', 'expected' => 1, 'issued' => 1, 'flag' => '', 'uom' => 'EA', 'in_stock' => 0, 'warehouse' => 'Tool Crib', 'decision' => 'Issued', 'linked_op' => 'OP-211'],
    ];

    $receivedRows = [
        ['item_code' => 'MAT-11802', 'description' => 'Cabin Filter Pack', 'expected' => 4, 'received' => 2, 'flag' => '!', 'uom' => 'EA', 'warehouse' => 'Receiving Bay', 'decision' => 'Pending Receipt', 'linked_op' => 'OP-077'],
        ['item_code' => 'MAT-99110', 'description' => 'Hydraulic Hose Assembly', 'expected' => 1, 'received' => 1, 'flag' => '', 'uom' => 'EA', 'warehouse' => 'Receiving Bay', 'decision' => 'Received', 'linked_op' => 'OP-144'],
    ];

    $toolRows = [
        ['item_code' => 'TL-2001', 'description' => 'Borescope Unit', 'expected' => 1, 'issued' => 1, 'uom' => 'EA', 'warehouse' => 'Tool Crib', 'linked_op' => 'OP-088'],
        ['item_code' => 'TL-3011', 'description' => 'Pressure Test Bench', 'expected' => 1, 'issued' => 0, 'uom' => 'EA', 'warehouse' => 'Bench Bay', 'linked_op' => 'OP-203'],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            activeTab: 'issued',
            workOrder: 'SHOP0343',
            cancelGoodsMovement: false,
            selectedAll: false,
            lineSelected: 0,
            issuedRows: @js($issuedRows),
            receivedRows: @js($receivedRows),
            toolRows: @js($toolRows),
            statusMessage: '',
            activeRows() {
                const map = { issued: this.issuedRows, received: this.receivedRows, tools: this.toolRows };
                return map[this.activeTab] ?? [];
            },
            setTab(tab) {
                this.activeTab = tab;
                this.selectedAll = false;
                this.lineSelected = 0;
            },
            selectAll() {
                this.selectedAll = !this.selectedAll;
                this.lineSelected = this.selectedAll ? this.activeRows().length : 0;
                this.statusMessage = `${this.selectedAll ? 'Selected' : 'Cleared'} ${this.lineSelected} line(s) in the ${this.activeTab.replace('-', ' ')} tab.`;
            },
            performTransactions() {
                this.statusMessage = `Performed logistics transaction for work order ${this.workOrder}.`;
            },
            cancelWorkspace() {
                this.statusMessage = 'Logistic cockpit closed without committing further changes.';
            },
        }"
    >
        <x-page-header
            title="Logistic Cockpit"
            description="Review work-order material issue, warehouse receipt, and tool movement activity in the ATP MRO logistics workspace."
        />

        <section class="attach-workspace-shell max-w-[1480px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel class="space-y-5">
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="attach-field-label">Work Order</span>
                        <span class="text-amber-500">&rarr;</span>
                        <div class="attach-inline-control">
                            <input type="text" x-model="workOrder" class="input-field attach-input input-field-filled" />
                            <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
                    <div class="subtab-shell">
                        <ul class="subtab-list">
                            <li class="subtab-item"><button type="button" class="subtab-link" :class="activeTab === 'issued' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="setTab('issued')">To be issued</button></li>
                            <li class="subtab-item"><button type="button" class="subtab-link" :class="activeTab === 'received' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="setTab('received')">To be received</button></li>
                            <li class="subtab-item"><button type="button" class="subtab-link" :class="activeTab === 'tools' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="setTab('tools')">Tools</button></li>
                        </ul>
                    </div>
                </div>

                <div x-cloak x-show="activeTab === 'issued'" class="space-y-4">
                    <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1320px]" datatable>
                        <x-slot name="thead">
                            <tr>
                                <th>Item Code</th>
                                <th>Item Desc.</th>
                                <th>Expected</th>
                                <th>Issued</th>
                                <th>!</th>
                                <th>UoM</th>
                                <th>In Stock</th>
                                <th>From Warehouse</th>
                                <th>Decision</th>
                                <th>Linked Op</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            <template x-for="row in issuedRows" :key="`${row.item_code}-${row.linked_op}`">
                                <tr>
                                    <td x-text="row.item_code"></td>
                                    <td x-text="row.description"></td>
                                    <td x-text="row.expected"></td>
                                    <td x-text="row.issued"></td>
                                    <td><span class="inline-flex min-w-[20px] items-center justify-center text-sm font-semibold" :class="row.flag ? 'text-amber-600' : 'text-gray-300'" x-text="row.flag || ''"></span></td>
                                    <td x-text="row.uom"></td>
                                    <td x-text="row.in_stock"></td>
                                    <td x-text="row.warehouse"></td>
                                    <td x-text="row.decision"></td>
                                    <td x-text="row.linked_op"></td>
                                </tr>
                            </template>
                        </x-slot>
                    </x-enterprise.table-shell>
                </div>

                <div x-cloak x-show="activeTab === 'received'" class="space-y-4">
                    <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1320px]" datatable>
                        <x-slot name="thead">
                            <tr>
                                <th>Item Code</th>
                                <th>Item Desc.</th>
                                <th>Expected</th>
                                <th>Received</th>
                                <th>!</th>
                                <th>UoM</th>
                                <th>To Warehouse</th>
                                <th>Decision</th>
                                <th>Linked Op</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            <template x-for="row in receivedRows" :key="`${row.item_code}-${row.linked_op}`">
                                <tr>
                                    <td x-text="row.item_code"></td>
                                    <td x-text="row.description"></td>
                                    <td x-text="row.expected"></td>
                                    <td x-text="row.received"></td>
                                    <td><span class="inline-flex min-w-[20px] items-center justify-center text-sm font-semibold" :class="row.flag ? 'text-amber-600' : 'text-gray-300'" x-text="row.flag || ''"></span></td>
                                    <td x-text="row.uom"></td>
                                    <td x-text="row.warehouse"></td>
                                    <td x-text="row.decision"></td>
                                    <td x-text="row.linked_op"></td>
                                </tr>
                            </template>
                        </x-slot>
                    </x-enterprise.table-shell>
                </div>

                <div x-cloak x-show="activeTab === 'tools'" class="space-y-4">
                    <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1320px]" datatable>
                        <x-slot name="thead">
                            <tr>
                                <th>Item Code</th>
                                <th>Item Desc.</th>
                                <th>Expected</th>
                                <th>Issued</th>
                                <th>UoM</th>
                                <th>From Warehouse</th>
                                <th>Linked Op</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            <template x-for="row in toolRows" :key="`${row.item_code}-${row.linked_op}`">
                                <tr>
                                    <td x-text="row.item_code"></td>
                                    <td x-text="row.description"></td>
                                    <td x-text="row.expected"></td>
                                    <td x-text="row.issued"></td>
                                    <td x-text="row.uom"></td>
                                    <td x-text="row.warehouse"></td>
                                    <td x-text="row.linked_op"></td>
                                </tr>
                            </template>
                        </x-slot>
                    </x-enterprise.table-shell>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-4 border-t border-gray-100 pt-4">
                    <div class="flex flex-wrap items-center gap-4">
                        <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="selectAll()">Select/Unselect All</button>
                        <label class="attach-checkbox-inline">
                            <input type="checkbox" x-model="cancelGoodsMovement" />
                            <span>Cancel Goods movement</span>
                        </label>
                    </div>

                    <div class="attach-field-label">
                        Line selected :
                        <span class="inline-block min-w-[32px] rounded-md border border-gray-200 bg-gray-50 px-2 py-1 text-center text-sm text-gray-700" x-text="lineSelected"></span>
                    </div>
                </div>

                <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100" @click="performTransactions()">Perform Transactions</button>
                        <button type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100" @click="cancelWorkspace()">Cancel</button>
                    </div>
                </x-enterprise.action-bar>
            </x-enterprise.panel>
        </section>
    </div>
@endsection
