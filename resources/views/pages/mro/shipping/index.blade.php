@extends('layouts.app')

@section('title', 'Shipping List')

@php
    $shippingRows = [
        ['id' => 'SHP-24091', 'shipping_references' => 'SHP-REF-11882', 'date' => '2026-04-07', 'time' => '11:39', 'bp_code' => 'BP-001284', 'bp_name' => 'Weststar Aviation Services', 'shipping_type' => 'Customer Delivery', 'remarks' => 'Awaiting courier release'],
        ['id' => 'SHP-24088', 'shipping_references' => 'RET-8824', 'date' => '2026-04-06', 'time' => '15:04', 'bp_code' => 'BP-001110', 'bp_name' => 'Aero One Services', 'shipping_type' => 'Purchase Return', 'remarks' => 'Documents matched and boxed'],
        ['id' => 'SHP-24084', 'shipping_references' => 'CUS-11890', 'date' => '2026-04-05', 'time' => '08:27', 'bp_code' => 'BP-001992', 'bp_name' => 'Heli Support APAC', 'shipping_type' => 'Other', 'remarks' => 'Pending outbound transport slot'],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            showOpenOnly: true,
            showMyOnly: false,
            rows: @js($shippingRows),
            statusMessage: '',
            cancelView() {
                this.statusMessage = 'Shipping list closed.';
            },
        }"
    >
        <x-page-header
            title="Shipping List"
            description="Review outbound shipping transactions, ownership filters, and dispatch readiness in the ATP MRO workspace."
        />

        <section class="attach-workspace-shell max-w-[1380px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel muted class="space-y-5">
                <div class="flex flex-wrap items-center gap-8">
                    <label class="attach-checkbox-inline">
                        <input type="checkbox" x-model="showOpenOnly" />
                        <span>Show Only Open Shipping</span>
                    </label>

                    <label class="attach-checkbox-inline">
                        <input type="checkbox" x-model="showMyOnly" />
                        <span>Show Only My Shipping</span>
                    </label>
                </div>
            </x-enterprise.panel>

            <x-enterprise.panel class="space-y-4">
                <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1180px]" datatable datatable-selectable>
                    <x-slot name="thead">
                        <tr>
                            <th>ID</th>
                            <th>Shipping references</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>BP Code</th>
                            <th>BP Name</th>
                            <th>Shipping Type</th>
                            <th>Remarks</th>
                        </tr>
                    </x-slot>

                    <x-slot name="tbody">
                        @foreach ($shippingRows as $row)
                            <tr>
                                <td>{{ $row['id'] }}</td>
                                <td>{{ $row['shipping_references'] }}</td>
                                <td>{{ $row['date'] }}</td>
                                <td>{{ $row['time'] }}</td>
                                <td>{{ $row['bp_code'] }}</td>
                                <td>{{ $row['bp_name'] }}</td>
                                <td>{{ $row['shipping_type'] }}</td>
                                <td>{{ $row['remarks'] }}</td>
                            </tr>
                        @endforeach
                    </x-slot>
                </x-enterprise.table-shell>

                <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" class="btn-secondary" @click="cancelView()">Cancel</button>
                    </div>

                    <div class="flex flex-wrap items-center gap-4">
                        <div class="grid gap-2">
                            <span class="attach-field-label">Number of records found</span>
                            <input type="text" :value="rows.length" readonly class="input-field attach-input input-field-filled" />
                        </div>
                    </div>
                </x-enterprise.action-bar>
            </x-enterprise.panel>
        </section>
    </div>
@endsection
