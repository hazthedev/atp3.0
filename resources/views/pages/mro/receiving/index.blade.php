@extends('layouts.app')

@section('title', 'Receiving List')

@php
    $receivingRows = [
        ['id' => 'RCV-24071', 'delivery_reference' => 'AWB-540018', 'date' => '2026-04-07', 'time' => '11:35', 'bp_code' => 'BP-001284', 'bp_name' => 'Weststar Aviation Services', 'receiving_type' => 'Customer Return', 'remarks' => 'Initial intake complete', 'shipping_id' => 'SHP-24031'],
        ['id' => 'RCV-24068', 'delivery_reference' => 'DN-11882', 'date' => '2026-04-06', 'time' => '09:10', 'bp_code' => 'BP-001110', 'bp_name' => 'Aero One Services', 'receiving_type' => 'Purchase', 'remarks' => 'Awaiting document verification', 'shipping_id' => ''],
        ['id' => 'RCV-24064', 'delivery_reference' => 'RET-7730', 'date' => '2026-04-05', 'time' => '16:22', 'bp_code' => 'BP-001992', 'bp_name' => 'Heli Support APAC', 'receiving_type' => 'Sub Contractor Return', 'remarks' => 'Warehouse review pending', 'shipping_id' => 'SHP-24028'],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            showOpenOnly: true,
            showMyOnly: false,
            rows: @js($receivingRows),
            statusMessage: '',
            cancelView() {
                this.statusMessage = 'Receiving list closed.';
            },
            createShipping() {
                this.statusMessage = 'Opening shipping creation from the selected receiving context.';
            },
        }"
    >
        <x-page-header
            title="Receiving List"
            description="Review inbound receiving transactions, filters, and linked shipping context in the ATP MRO workspace."
        />

        <section class="attach-workspace-shell max-w-[1380px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel muted class="space-y-5">
                <div class="flex flex-wrap items-center gap-8">
                    <label class="attach-checkbox-inline">
                        <input type="checkbox" x-model="showOpenOnly" />
                        <span>Show Only Open Receiving</span>
                    </label>

                    <label class="attach-checkbox-inline">
                        <input type="checkbox" x-model="showMyOnly" />
                        <span>Show Only My Receiving</span>
                    </label>
                </div>
            </x-enterprise.panel>

            <x-enterprise.panel class="space-y-4">
                <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[1180px]" datatable datatable-selectable>
                    <x-slot name="thead">
                        <tr>
                            <th>ID</th>
                            <th>Delivery reference</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>BP Code</th>
                            <th>BP Name</th>
                            <th>Receiving Type</th>
                            <th>Remarks</th>
                            <th>Shipping Id</th>
                        </tr>
                    </x-slot>

                    <x-slot name="tbody">
                        @foreach ($receivingRows as $row)
                            <tr>
                                <td>{{ $row['id'] }}</td>
                                <td>{{ $row['delivery_reference'] }}</td>
                                <td>{{ $row['date'] }}</td>
                                <td>{{ $row['time'] }}</td>
                                <td>{{ $row['bp_code'] }}</td>
                                <td>{{ $row['bp_name'] }}</td>
                                <td>{{ $row['receiving_type'] }}</td>
                                <td>{{ $row['remarks'] }}</td>
                                <td>{{ $row['shipping_id'] ?: '-' }}</td>
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

                        <a href="{{ route('mro.shipping.create') }}" class="btn-secondary" @click.prevent="createShipping(); window.location='{{ route('mro.shipping.create') }}'">Create Shipping</a>
                    </div>
                </x-enterprise.action-bar>
            </x-enterprise.panel>
        </section>
    </div>
@endsection
