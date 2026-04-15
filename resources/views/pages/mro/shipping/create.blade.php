@extends('layouts.app')

@section('title', 'Shipping')

@php
    $documentRows = [
        ['type' => 'Shipping Note', 'attachment' => 'shipping-note-2409.pdf', 'comments' => 'Prepared for outbound dispatch'],
        ['type' => 'Packing List', 'attachment' => 'shipping-pack-list-2409.xlsx', 'comments' => 'Grouped by package reference'],
        ['type' => 'Customs Form', 'attachment' => 'customs-form-2409.pdf', 'comments' => 'Provider return declaration'],
    ];

    $linkedDocuments = [
        'repair' => ['RIC-1882', 'RIC-1914'],
        'customer_delivery' => ['DEL-7721', 'DEL-7733'],
        'provider_return' => ['RET-8824'],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            activeTab: 'general',
            number: 'SHP-24091',
            businessPartnerCode: 'BP-001284',
            businessPartnerName: 'Weststar Aviation Services',
            contactPerson: 'Ahmad Shahrul',
            telephoneNo: '+60 12-884 9021',
            details: 'Outbound shipment prepared for work-order support, repair return, and customer delivery handling.',
            timeDate: '2026-04-07',
            timeValue: '11:39',
            priority: 'Normal',
            shippingReferences: 'SHP-REF-11882',
            assignedTo: 'asyraf',
            numberOfPackage: '3',
            packagesReferences: 'BOX-01, BOX-02, CRATE-01',
            packageType: 'Box',
            damaged: false,
            shippingType: 'customer-delivery',
            remarks: 'Documents matched to shipping package count. Awaiting final dispatch confirmation.',
            propertyNotes: 'No extra property conditions are attached to this shipment profile yet.',
            linkedDocuments: @js($linkedDocuments),
            documents: @js($documentRows),
            statusMessage: '',
            addShipping() {
                this.statusMessage = `Shipping ${this.number} prepared for dispatch.`;
            },
            cancelShipping() {
                this.statusMessage = 'Shipping entry cancelled for this draft session.';
            },
        }"
    >
        <x-page-header
            title="Shipping"
            description="Prepare outbound shipping details, supporting documents, and linked repair or customer-delivery references in the ATP MRO workspace."
        />

        <section class="attach-workspace-shell max-w-[1280px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel muted class="space-y-5">
                <div class="grid gap-5 xl:grid-cols-[520px_minmax(0,1fr)]">
                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Number" for="shipping_number" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                            <input id="shipping_number" type="text" x-model="number" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.lookup-row label="Business Partner Code" for="shipping_bp_code" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                            <div class="attach-inline-control">
                                <input id="shipping_bp_code" type="text" x-model="businessPartnerCode" class="input-field attach-input" />
                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>
                        </x-enterprise.lookup-row>

                        <x-enterprise.field-row label="Business Partner Name" for="shipping_bp_name" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                            <input id="shipping_bp_name" type="text" x-model="businessPartnerName" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Contact Person" for="shipping_contact_person" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                            <select id="shipping_contact_person" x-model="contactPerson" class="input-field attach-input">
                                <option>Ahmad Shahrul</option>
                                <option>Nadiah Rahman</option>
                                <option>Marco Bellini</option>
                            </select>
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Telephone No." for="shipping_telephone" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                            <input id="shipping_telephone" type="text" x-model="telephoneNo" class="input-field attach-input" />
                        </x-enterprise.field-row>
                    </div>

                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Details" for="shipping_details" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                            <textarea id="shipping_details" x-model="details" rows="3" class="input-field attach-textarea"></textarea>
                        </x-enterprise.field-row>
                    </div>
                </div>
            </x-enterprise.panel>

            <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
                <div class="subtab-shell">
                    <ul class="subtab-list">
                        @foreach (['general' => 'General', 'remarks' => 'Remarks', 'documents' => 'Documents Received', 'properties' => 'Properties', 'linked' => 'Linked Document'] as $key => $label)
                            <li class="subtab-item">
                                <button type="button" class="subtab-link" :class="activeTab === '{{ $key }}' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = '{{ $key }}'">{{ $label }}</button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div x-cloak x-show="activeTab === 'general'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
                        <x-enterprise.field-row label="Time" for="shipping_time_date" columns="sm:grid-cols-[72px_164px_92px_92px]">
                            <x-date-picker id="shipping_time_date" x-model="timeDate" />
                            <span class="attach-field-label">Time</span>
                            <input id="shipping_time_time" type="text" x-model="timeValue" class="input-field attach-input" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Priority" for="shipping_priority" columns="sm:grid-cols-[72px_164px]">
                            <select id="shipping_priority" x-model="priority" class="input-field attach-input">
                                <option>Normal</option>
                                <option>Urgent</option>
                                <option>Critical</option>
                            </select>
                        </x-enterprise.field-row>
                    </div>

                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
                        <x-enterprise.field-row label="Shipping References" for="shipping_references" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                            <input id="shipping_references" type="text" x-model="shippingReferences" class="input-field attach-input" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Assigned To" for="shipping_assigned_to" columns="sm:grid-cols-[96px_180px]">
                            <input id="shipping_assigned_to" type="text" x-model="assignedTo" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>
                    </div>

                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_280px]">
                        <div class="space-y-3">
                            <x-enterprise.field-row label="Number of package" for="shipping_package_count" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <input id="shipping_package_count" type="text" x-model="numberOfPackage" class="input-field attach-input" />
                            </x-enterprise.field-row>

                            <x-enterprise.field-row label="Packages References" for="shipping_package_references" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <input id="shipping_package_references" type="text" x-model="packagesReferences" class="input-field attach-input" />
                            </x-enterprise.field-row>

                            <x-enterprise.field-row label="Package type" for="shipping_package_type" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <select id="shipping_package_type" x-model="packageType" class="input-field attach-input">
                                    <option>Box</option>
                                    <option>Crate</option>
                                    <option>Envelope</option>
                                    <option>Pallet</option>
                                </select>
                            </x-enterprise.field-row>

                            <label class="attach-checkbox-inline">
                                <input type="checkbox" x-model="damaged" />
                                <span>Damaged ?</span>
                            </label>
                        </div>

                        <div class="space-y-3">
                            @foreach ([
                                ['value' => 'customer-delivery', 'label' => 'Customer Delivery'],
                                ['value' => 'purchase-return', 'label' => 'Purchase Return'],
                                ['value' => 'other', 'label' => 'Other'],
                            ] as $option)
                                <label class="attach-checkbox-inline">
                                    <input type="radio" name="shipping_type" value="{{ $option['value'] }}" x-model="shippingType" />
                                    <span>{{ $option['label'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'remarks'" class="space-y-5">
                <x-enterprise.panel class="space-y-4 min-h-[300px]">
                    <textarea x-model="remarks" rows="12" class="input-field attach-textarea min-h-[280px]"></textarea>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'documents'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <x-enterprise.table-shell table-class="min-w-full border-collapse min-w-[980px]" datatable>
                        <x-slot name="thead">
                            <tr>
                                <th>Document Type</th>
                                <th>Attachments</th>
                                <th>Comments</th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            <template x-for="row in documents" :key="row.type">
                                <tr>
                                    <td x-text="row.type"></td>
                                    <td x-text="row.attachment"></td>
                                    <td x-text="row.comments"></td>
                                </tr>
                            </template>
                        </x-slot>
                    </x-enterprise.table-shell>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'properties'" class="space-y-5">
                <x-enterprise.panel class="space-y-4 min-h-[300px]">
                    <textarea x-model="propertyNotes" rows="12" class="input-field attach-textarea min-h-[280px]"></textarea>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'linked'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="grid gap-5 xl:grid-cols-3 xl:grid-cols-3">
                        <x-enterprise.panel muted class="space-y-3">
                            <div class="text-sm font-semibold text-gray-900">Repair Information cockpit</div>
                            <div class="min-h-[140px] rounded-xl border border-gray-200 bg-white p-3">
                                <template x-for="item in linkedDocuments.repair" :key="item">
                                    <div class="border-b border-gray-100 py-2 text-sm text-gray-700 last:border-b-0" x-text="item"></div>
                                </template>
                            </div>
                        </x-enterprise.panel>

                        <x-enterprise.panel muted class="space-y-3">
                            <div class="text-sm font-semibold text-gray-900">Customer Delivery</div>
                            <div class="min-h-[140px] rounded-xl border border-gray-200 bg-white p-3">
                                <template x-for="item in linkedDocuments.customer_delivery" :key="item">
                                    <div class="border-b border-gray-100 py-2 text-sm text-gray-700 last:border-b-0" x-text="item"></div>
                                </template>
                            </div>
                        </x-enterprise.panel>

                        <x-enterprise.panel muted class="space-y-3">
                            <div class="text-sm font-semibold text-gray-900">Provider Return</div>
                            <div class="min-h-[140px] rounded-xl border border-gray-200 bg-white p-3">
                                <template x-for="item in linkedDocuments.provider_return" :key="item">
                                    <div class="border-b border-gray-100 py-2 text-sm text-gray-700 last:border-b-0" x-text="item"></div>
                                </template>
                            </div>
                        </x-enterprise.panel>
                    </div>
                </x-enterprise.panel>
            </div>

            <x-enterprise.action-bar class="border-t border-gray-200 pt-5">
                <button type="button" class="btn-primary" @click="addShipping()">Add</button>
                <button type="button" class="btn-secondary" @click="cancelShipping()">Cancel</button>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
