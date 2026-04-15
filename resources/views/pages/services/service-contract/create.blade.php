@extends('layouts.app')

@section('title', 'Business Partner Service Contract')

@php
    $flRows = [
        ['code' => 'FL-9M-WCM', 'registration' => '9M-WCM', 'type' => 'AW139', 'start_date' => '2026-01-01', 'end_date' => '2026-12-31', 'termination_date' => '-'],
        ['code' => 'FL-9M-WST', 'registration' => '9M-WST', 'type' => 'AW189', 'start_date' => '2026-02-15', 'end_date' => '2026-12-31', 'termination_date' => '-'],
    ];

    $itemRows = [
        ['item_no' => 'A139-27-118', 'description' => 'Trim Actuator Assembly', 'equipment_no' => 'EQ-001842', 'serial_number' => 'TRM-91277', 'start_date' => '2026-01-01', 'end_date' => '2026-12-31', 'termination_date' => '-'],
        ['item_no' => 'A189-53-220', 'description' => 'Cabin Speaker Set', 'equipment_no' => 'EQ-001955', 'serial_number' => 'SPK-44191', 'start_date' => '2026-03-10', 'end_date' => '2026-12-31', 'termination_date' => '-'],
    ];

    $attachments = [
        ['id' => 1, 'path' => 'service-contracts/2026/contract-summary.pdf', 'file_name' => 'contract-summary.pdf', 'attachment_date' => '2026-04-06'],
        ['id' => 2, 'path' => 'service-contracts/2026/coverage-matrix.xlsx', 'file_name' => 'coverage-matrix.xlsx', 'attachment_date' => '2026-04-04'],
    ];

    $coverageDays = [
        ['day' => 'Monday', 'start' => '08:00', 'end' => '18:00'],
        ['day' => 'Tuesday', 'start' => '08:00', 'end' => '18:00'],
        ['day' => 'Wednesday', 'start' => '08:00', 'end' => '18:00'],
        ['day' => 'Thursday', 'start' => '08:00', 'end' => '18:00'],
        ['day' => 'Friday', 'start' => '08:00', 'end' => '18:00'],
        ['day' => 'Saturday', 'start' => '09:00', 'end' => '13:00'],
        ['day' => 'Sunday', 'start' => '', 'end' => ''],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            activeTab: 'general',
            activeFlTab: 'fl',
            statusMessage: '',
            businessPartnerCode: 'BP-001284',
            businessPartnerName: 'Weststar Aviation Services',
            contactPerson: 'Ahmad Shahrul',
            telephoneNo: '+60 12-884 9021',
            description: 'Customer service contract covering support commitments, response targets, and scope for active fleet support.',
            contractId: 'SC-2026-014',
            startDate: '2026-01-01',
            endDate: '2026-12-31',
            terminationDate: '',
            contractCategory: 'Premium Support',
            serviceType: 'Fleet Service',
            contractType: 'Annual',
            responseTime: '4',
            resolutionTime: '24',
            statementRate: 'MYR 1,200',
            status: 'Active',
            owner: 'Customer Support',
            contractNumber: 'CN-24014',
            revisionNumber: '03',
            projectNumber: 'PRJ-88014',
            bpContractNumber: 'BP-CN-4421',
            remarks: 'Service contract includes customer coordination, planning support, and material escalation follow-up across the covered assets.',
            revisionComment: 'Revision 03 adds AW189 support scope and aligns working-hour coverage with the latest service desk arrangement.',
            includeParts: true,
            includeLabor: true,
            includeTravel: false,
            includingHolidays: false,
            flRows: @js($flRows),
            itemRows: @js($itemRows),
            attachments: @js($attachments),
            coverageDays: @js($coverageDays),
            findContract() {
                this.statusMessage = `Loaded service contract ${this.contractId} for ${this.businessPartnerName}.`;
            },
            cancelContract() {
                this.statusMessage = 'Service contract review cancelled for this session.';
            },
            browseAttachment() {
                this.statusMessage = 'Attachment picker opened for the service contract.';
            },
            displayAttachment() {
                if (this.attachments.length === 0) {
                    this.statusMessage = 'There is no attachment available to display.';
                    return;
                }

                this.statusMessage = `Displaying ${this.attachments[0].file_name}.`;
            },
            deleteAttachment() {
                if (this.attachments.length === 0) {
                    this.statusMessage = 'There is no attachment available to delete.';
                    return;
                }

                const removed = this.attachments.shift();
                this.statusMessage = `${removed.file_name} removed from the current contract view.`;
            },
        }"
    >
        <x-page-header
            title="Business Partner Service Contract"
            description="Review service contract scope, fleet coverage, attachments, and contractual commitments for a business partner in the ATP services workspace."
        />

        <section class="attach-workspace-shell max-w-[1320px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel muted class="space-y-5">
                <div class="grid gap-5 xl:grid-cols-2">
                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Business Partner Code" for="service_contract_bp_code" columns="sm:grid-cols-[168px_minmax(0,1fr)]">
                            <input id="service_contract_bp_code" type="text" x-model="businessPartnerCode" class="input-field attach-input" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Business Partner Name" for="service_contract_bp_name" columns="sm:grid-cols-[168px_minmax(0,1fr)]">
                            <input id="service_contract_bp_name" type="text" x-model="businessPartnerName" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Contact person" for="service_contract_contact_person" columns="sm:grid-cols-[168px_minmax(0,1fr)]">
                            <input id="service_contract_contact_person" type="text" x-model="contactPerson" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Telephone No." for="service_contract_telephone" columns="sm:grid-cols-[168px_minmax(0,1fr)]">
                            <input id="service_contract_telephone" type="text" x-model="telephoneNo" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Description" for="service_contract_description" columns="sm:grid-cols-[168px_minmax(0,1fr)]">
                            <input id="service_contract_description" type="text" x-model="description" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>
                    </div>

                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Contract Id." for="service_contract_id" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                            <input id="service_contract_id" type="text" x-model="contractId" class="input-field attach-input" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Start Date" for="service_contract_start_date" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                            <x-date-picker id="service_contract_start_date" x-model="startDate" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="End Date" for="service_contract_end_date" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                            <x-date-picker id="service_contract_end_date" x-model="endDate" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Termination Date" for="service_contract_termination_date" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                            <x-date-picker id="service_contract_termination_date" x-model="terminationDate" />
                        </x-enterprise.field-row>
                    </div>
                </div>
            </x-enterprise.panel>

            <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
                <div class="subtab-shell">
                    <ul class="subtab-list">
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'general' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'general'">General</button>
                        </li>
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'fl-items' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'fl-items'">FL/Items</button>
                        </li>
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'coverage' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'coverage'">Coverage</button>
                        </li>
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'attachments' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'attachments'">Attachments</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div x-cloak x-show="activeTab === 'general'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="grid gap-5 xl:grid-cols-2">
                        <div class="space-y-2.5">
                            <x-enterprise.field-row label="Contract Category" for="service_contract_category" columns="sm:grid-cols-[152px_minmax(0,1fr)]">
                                <input id="service_contract_category" type="text" x-model="contractCategory" class="input-field attach-input input-field-filled" />
                            </x-enterprise.field-row>

                            <x-enterprise.field-row label="Service Type" for="service_contract_service_type" columns="sm:grid-cols-[152px_minmax(0,1fr)]">
                                <input id="service_contract_service_type" type="text" x-model="serviceType" class="input-field attach-input input-field-filled" />
                            </x-enterprise.field-row>

                            <x-enterprise.field-row label="Contract Type" for="service_contract_type" columns="sm:grid-cols-[152px_minmax(0,1fr)]">
                                <input id="service_contract_type" type="text" x-model="contractType" class="input-field attach-input input-field-filled" />
                            </x-enterprise.field-row>

                            <x-enterprise.field-row label="Response Time" for="service_contract_response_time" columns="sm:grid-cols-[152px_96px]">
                                <input id="service_contract_response_time" type="text" x-model="responseTime" class="input-field attach-input input-field-filled" />
                            </x-enterprise.field-row>

                            <x-enterprise.field-row label="Resolution Time" for="service_contract_resolution_time" columns="sm:grid-cols-[152px_96px]">
                                <input id="service_contract_resolution_time" type="text" x-model="resolutionTime" class="input-field attach-input input-field-filled" />
                            </x-enterprise.field-row>

                            <x-enterprise.field-row label="Statement rate" for="service_contract_statement_rate" columns="sm:grid-cols-[152px_96px]">
                                <input id="service_contract_statement_rate" type="text" x-model="statementRate" class="input-field attach-input input-field-filled" />
                            </x-enterprise.field-row>
                        </div>

                        <div class="space-y-2.5">
                            <x-enterprise.field-row label="Status" for="service_contract_status" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <input id="service_contract_status" type="text" x-model="status" class="input-field attach-input input-field-filled" />
                            </x-enterprise.field-row>

                            <x-enterprise.field-row label="Owner" for="service_contract_owner" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <input id="service_contract_owner" type="text" x-model="owner" class="input-field attach-input input-field-filled" />
                            </x-enterprise.field-row>

                            <x-enterprise.field-row label="Contract Number" for="service_contract_number" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <input id="service_contract_number" type="text" x-model="contractNumber" class="input-field attach-input" />
                            </x-enterprise.field-row>

                            <x-enterprise.field-row label="Revision Number" for="service_contract_revision_number" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <input id="service_contract_revision_number" type="text" x-model="revisionNumber" class="input-field attach-input" />
                            </x-enterprise.field-row>

                            <x-enterprise.field-row label="Project Number" for="service_contract_project_number" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <input id="service_contract_project_number" type="text" x-model="projectNumber" class="input-field attach-input input-field-filled" />
                            </x-enterprise.field-row>

                            <x-enterprise.field-row label="BP Contract Number" for="service_contract_bp_contract_number" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                <input id="service_contract_bp_contract_number" type="text" x-model="bpContractNumber" class="input-field attach-input input-field-filled" />
                            </x-enterprise.field-row>
                        </div>
                    </div>

                    <div class="grid gap-5 xl:grid-cols-2">
                        <div class="space-y-3">
                            <div class="text-sm font-semibold text-gray-900">Remarks</div>
                            <textarea x-model="remarks" rows="7" class="input-field attach-textarea min-h-[180px]"></textarea>
                        </div>

                        <div class="space-y-3">
                            <div class="text-sm font-semibold text-gray-900">Revision Comment</div>
                            <textarea x-model="revisionComment" rows="7" class="input-field attach-textarea min-h-[180px]"></textarea>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'fl-items'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="rounded-xl border border-gray-200 bg-white px-4 pt-3 shadow-sm">
                        <div class="subtab-shell">
                            <ul class="subtab-list">
                                <li class="subtab-item">
                                    <button type="button" class="subtab-link" :class="activeFlTab === 'fl' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeFlTab = 'fl'">FL</button>
                                </li>
                                <li class="subtab-item">
                                    <button type="button" class="subtab-link" :class="activeFlTab === 'items' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeFlTab = 'items'">Items</button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div x-cloak x-show="activeFlTab === 'fl'">
                        <x-enterprise.table-shell table-class="pending-base-table min-w-[920px]">
                            <x-slot name="thead">
                                <tr>
                                    <th>FL Code</th>
                                    <th>FL Registration</th>
                                    <th>FL Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Termination Date</th>
                                </tr>
                            </x-slot>

                            <x-slot name="tbody">
                                <template x-for="row in flRows" :key="row.code">
                                    <tr>
                                        <td x-text="row.code"></td>
                                        <td x-text="row.registration"></td>
                                        <td x-text="row.type"></td>
                                        <td x-text="row.start_date"></td>
                                        <td x-text="row.end_date"></td>
                                        <td x-text="row.termination_date"></td>
                                    </tr>
                                </template>
                            </x-slot>
                        </x-enterprise.table-shell>
                    </div>

                    <div x-cloak x-show="activeFlTab === 'items'">
                        <x-enterprise.table-shell table-class="pending-base-table min-w-[1080px]">
                            <x-slot name="thead">
                                <tr>
                                    <th>Item No.</th>
                                    <th>Item Description</th>
                                    <th>Equipment No.</th>
                                    <th>Serial Number</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Termination Date</th>
                                </tr>
                            </x-slot>

                            <x-slot name="tbody">
                                <template x-for="row in itemRows" :key="row.item_no">
                                    <tr>
                                        <td x-text="row.item_no"></td>
                                        <td x-text="row.description"></td>
                                        <td x-text="row.equipment_no"></td>
                                        <td x-text="row.serial_number"></td>
                                        <td x-text="row.start_date"></td>
                                        <td x-text="row.end_date"></td>
                                        <td x-text="row.termination_date"></td>
                                    </tr>
                                </template>
                            </x-slot>
                        </x-enterprise.table-shell>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'coverage'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_260px]">
                        <div class="space-y-4">
                            <div class="grid grid-cols-[96px_120px_120px] items-center gap-3">
                                <span></span>
                                <span class="attach-field-label">Start Time</span>
                                <span class="attach-field-label">End Time</span>
                            </div>

                            <template x-for="(row, index) in coverageDays" :key="row.day">
                                <div class="grid grid-cols-[96px_120px_120px] items-center gap-3">
                                    <span class="attach-field-label" x-text="row.day"></span>
                                    <input type="text" class="input-field attach-input w-full" x-model="coverageDays[index].start" />
                                    <input type="text" class="input-field attach-input w-full" x-model="coverageDays[index].end" />
                                </div>
                            </template>
                        </div>

                        <div class="space-y-4">
                            <x-enterprise.panel muted class="space-y-3 max-w-[220px]">
                                <div class="text-sm font-semibold text-gray-900">Include</div>

                                <label class="attach-checkbox-inline">
                                    <input type="checkbox" x-model="includeParts" />
                                    <span>Parts</span>
                                </label>

                                <label class="attach-checkbox-inline">
                                    <input type="checkbox" x-model="includeLabor" />
                                    <span>Labor</span>
                                </label>

                                <label class="attach-checkbox-inline">
                                    <input type="checkbox" x-model="includeTravel" />
                                    <span>Travel</span>
                                </label>
                            </x-enterprise.panel>

                            <label class="attach-checkbox-inline">
                                <input type="checkbox" x-model="includingHolidays" />
                                <span>Including holidays</span>
                            </label>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'attachments'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_160px]">
                        <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable>
                            <x-slot name="thead">
                                <tr>
                                    <th>#</th>
                                    <th>Path</th>
                                    <th>File Name</th>
                                    <th>Attachment Date</th>
                                </tr>
                            </x-slot>

                            <x-slot name="tbody">
                                <template x-if="attachments.length === 0">
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">No attachments linked to this contract.</td>
                                    </tr>
                                </template>

                                <template x-for="(row, index) in attachments" :key="row.id">
                                    <tr>
                                        <td x-text="index + 1"></td>
                                        <td x-text="row.path"></td>
                                        <td x-text="row.file_name"></td>
                                        <td x-text="row.attachment_date"></td>
                                    </tr>
                                </template>
                            </x-slot>
                        </x-enterprise.table-shell>

                        <div class="flex flex-col gap-3">
                            <button type="button" class="btn-secondary" @click="browseAttachment()">Browse</button>
                            <button type="button" class="btn-secondary" @click="displayAttachment()">Display</button>
                            <button type="button" class="btn-secondary" @click="deleteAttachment()">Delete</button>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <x-enterprise.action-bar class="border-t border-gray-200 pt-5">
                <button type="button" class="btn-primary" @click="findContract()">Find</button>
                <button type="button" class="btn-secondary" @click="cancelContract()">Cancel</button>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
