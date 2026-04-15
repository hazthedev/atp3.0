@extends('layouts.app')

@section('title', 'Scheduled Visit')

@php
    $personnelRequested = [
        ['role' => 'CAMO User', 'selected' => true],
        ['role' => 'ICT', 'selected' => false],
        ['role' => 'Manager', 'selected' => true],
        ['role' => 'Planner', 'selected' => true],
        ['role' => 'Purchasing', 'selected' => false],
        ['role' => 'Sales Employee', 'selected' => false],
        ['role' => 'Senior Planner', 'selected' => true],
        ['role' => 'Technician', 'selected' => false],
    ];

    $personnelRequested2 = [
        ['role' => 'CAMO User', 'selected' => false],
        ['role' => 'ICT', 'selected' => true],
        ['role' => 'Manager', 'selected' => false],
        ['role' => 'Planner', 'selected' => true],
        ['role' => 'Purchasing', 'selected' => false],
        ['role' => 'Sales Employee', 'selected' => true],
        ['role' => 'Senior Planner', 'selected' => false],
        ['role' => 'Technician', 'selected' => true],
    ];

    $attachments = [
        ['id' => 1, 'path' => 'service-visits/2026/briefing-note.pdf', 'file_name' => 'briefing-note.pdf', 'attachment_date' => '2026-04-06'],
        ['id' => 2, 'path' => 'service-visits/2026/customer-agenda.xlsx', 'file_name' => 'customer-agenda.xlsx', 'attachment_date' => '2026-04-05'],
    ];

    $properties = [
        ['label' => 'Visit Category', 'value' => 'Customer Support'],
        ['label' => 'Handling Mode', 'value' => 'On Site'],
        ['label' => 'Priority', 'value' => 'Normal'],
        ['label' => 'Linked Contact Report', 'value' => 'Not generated'],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            activeTab: 'general',
            createdBy: 'acap',
            department: 'Aero One Services',
            site: 'Kuala Lumpur',
            creationDate: '2026-04-06',
            scheduledVisitNumber: 'SV-24041',
            bpCode: 'BP-001284',
            bpName: 'Weststar Aviation Services',
            bpContactPerson: 'Ahmad Shahrul',
            telephoneNo: '+60 12-884 9021',
            remarks: 'Customer requested a structured site visit to review open service items, planning visibility, and follow-up expectations.',
            visitDate: '2026-04-06',
            visitWeek: '15',
            reprogrammedDate: '2026-04-09',
            businessAgent: 'Aero One Services',
            role: 'Customer Support',
            status: 'Planned',
            addressName: 'Weststar Aviation Services',
            country: 'Malaysia',
            state: 'Selangor',
            content: 'Prepare customer briefing notes, open follow-up list, pending component supply update, and field support attendance plan.',
            personnelRequested: @js($personnelRequested),
            personnelRequested2: @js($personnelRequested2),
            attachments: @js($attachments),
            properties: @js($properties),
            statusMessage: '',
            toggleRequested(group, index) {
                this[group][index].selected = !this[group][index].selected;
            },
            addVisit() {
                this.status = 'Ready';
                this.statusMessage = `Scheduled visit ${this.scheduledVisitNumber} prepared for coordination.`;
            },
            cancelVisit() {
                this.statusMessage = 'Scheduled visit editing cancelled for this draft session.';
            },
            generateContactReport() {
                this.statusMessage = `Contact report draft generated from scheduled visit ${this.scheduledVisitNumber}.`;
            },
            browseAttachment() {
                this.statusMessage = 'Attachment picker opened for scheduled visit files.';
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
                this.statusMessage = `${removed.file_name} removed from the visit draft.`;
            },
        }"
    >
        <x-page-header
            title="Scheduled Visit"
            description="Plan customer visits, assign support personnel, collect attachments, and prepare follow-up reporting in the ATP scheduled visit workspace."
        />

        <section class="attach-workspace-shell max-w-[1280px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel muted class="space-y-5">
                <div class="grid gap-5 xl:grid-cols-2">
                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Created By" for="scheduled_visit_created_by" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                            <input id="scheduled_visit_created_by" type="text" x-model="createdBy" readonly class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Department" for="scheduled_visit_department" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                            <input id="scheduled_visit_department" type="text" x-model="department" readonly class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Site" for="scheduled_visit_site" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                            <input id="scheduled_visit_site" type="text" x-model="site" readonly class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Creation Date" for="scheduled_visit_creation_date" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                            <input id="scheduled_visit_creation_date" type="text" x-model="creationDate" readonly class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>
                    </div>

                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Scheduled Visit Number" for="scheduled_visit_number" columns="sm:grid-cols-[168px_minmax(0,1fr)]">
                            <input id="scheduled_visit_number" type="text" x-model="scheduledVisitNumber" readonly class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.lookup-row label="BP Code" for="scheduled_visit_bp_code" columns="sm:grid-cols-[168px_minmax(0,1fr)]">
                            <div class="attach-inline-control">
                                <input id="scheduled_visit_bp_code" type="text" x-model="bpCode" class="input-field attach-input" />
                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>
                        </x-enterprise.lookup-row>

                        <x-enterprise.field-row label="BP Name" for="scheduled_visit_bp_name" columns="sm:grid-cols-[168px_minmax(0,1fr)]">
                            <select id="scheduled_visit_bp_name" x-model="bpName" class="input-field attach-input">
                                <option>Weststar Aviation Services</option>
                                <option>Aero One Services</option>
                                <option>Heli Support APAC</option>
                            </select>
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="BP Contact Person" for="scheduled_visit_bp_contact_person" columns="sm:grid-cols-[168px_minmax(0,1fr)]">
                            <select id="scheduled_visit_bp_contact_person" x-model="bpContactPerson" class="input-field attach-input">
                                <option>Ahmad Shahrul</option>
                                <option>Nadiah Rahman</option>
                                <option>Marco Bellini</option>
                            </select>
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Telephone No." for="scheduled_visit_telephone" columns="sm:grid-cols-[168px_minmax(0,1fr)]">
                            <input id="scheduled_visit_telephone" type="text" x-model="telephoneNo" class="input-field attach-input" />
                        </x-enterprise.field-row>
                    </div>
                </div>
            </x-enterprise.panel>

            <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
                <div class="subtab-shell">
                    <ul class="subtab-list">
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'general' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'general'; $nextTick(() => window.refreshFlowbiteTables?.())">General</button>
                        </li>
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'additional-personnel' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'additional-personnel'; $nextTick(() => window.refreshFlowbiteTables?.())">Additional Personnel Requested</button>
                        </li>
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'content' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'content'; $nextTick(() => window.refreshFlowbiteTables?.())">Content</button>
                        </li>
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'attachments' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'attachments'; $nextTick(() => window.refreshFlowbiteTables?.())">Attachments</button>
                        </li>
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'properties' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'properties'; $nextTick(() => window.refreshFlowbiteTables?.())">Properties</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div x-cloak x-show="activeTab === 'general'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <x-enterprise.field-row label="Remarks" for="scheduled_visit_remarks" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                        <textarea id="scheduled_visit_remarks" x-model="remarks" rows="3" class="input-field attach-textarea"></textarea>
                    </x-enterprise.field-row>

                    <div class="grid gap-4 xl:grid-cols-[296px_160px_320px]">
                        <x-enterprise.field-row label="Date of visit" for="scheduled_visit_date" columns="sm:grid-cols-[112px_164px]">
                            <x-date-picker id="scheduled_visit_date" x-model="visitDate" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Week" for="scheduled_visit_week" columns="sm:grid-cols-[52px_92px]">
                            <input id="scheduled_visit_week" type="text" x-model="visitWeek" class="input-field attach-input" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Reprogrammed Date" for="scheduled_visit_reprogrammed_date" columns="sm:grid-cols-[144px_164px]">
                            <x-date-picker id="scheduled_visit_reprogrammed_date" x-model="reprogrammedDate" />
                        </x-enterprise.field-row>
                    </div>

                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_300px]">
                        <div class="space-y-4">
                            <x-enterprise.panel muted class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Assignment</div>

                                <x-enterprise.lookup-row label="Business Agent" for="scheduled_visit_business_agent" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                    <div class="attach-inline-control">
                                        <input id="scheduled_visit_business_agent" type="text" x-model="businessAgent" class="input-field attach-input" />
                                        <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                    </div>
                                </x-enterprise.lookup-row>

                                <x-enterprise.field-row label="Role" for="scheduled_visit_role" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                    <input id="scheduled_visit_role" type="text" x-model="role" class="input-field attach-input" />
                                </x-enterprise.field-row>
                            </x-enterprise.panel>

                            <x-enterprise.panel muted class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Address</div>

                                <x-enterprise.lookup-row label="Name" for="scheduled_visit_address_name" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                                    <div class="attach-inline-control">
                                        <input id="scheduled_visit_address_name" type="text" x-model="addressName" class="input-field attach-input" />
                                        <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                    </div>
                                </x-enterprise.lookup-row>

                                <x-enterprise.field-row label="Country" for="scheduled_visit_country" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                                    <input id="scheduled_visit_country" type="text" x-model="country" class="input-field attach-input" />
                                </x-enterprise.field-row>

                                <x-enterprise.field-row label="State" for="scheduled_visit_state" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                                    <input id="scheduled_visit_state" type="text" x-model="state" class="input-field attach-input" />
                                </x-enterprise.field-row>
                            </x-enterprise.panel>
                        </div>

                        <div class="space-y-4">
                            <x-enterprise.panel muted class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Visit Status</div>

                                <x-enterprise.field-row label="Status" for="scheduled_visit_status" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                                    <select id="scheduled_visit_status" x-model="status" class="input-field attach-input">
                                        <option>Planned</option>
                                        <option>Ready</option>
                                        <option>Completed</option>
                                        <option>Cancelled</option>
                                    </select>
                                </x-enterprise.field-row>

                                <div class="pt-2">
                                    <button type="button" class="btn-secondary" @click="generateContactReport()">Generate Contact Report</button>
                                </div>
                            </x-enterprise.panel>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'additional-personnel'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <div class="grid gap-5 xl:grid-cols-2">
                        <div class="space-y-3">
                            <div class="text-sm font-semibold text-gray-900">Personnel Requested</div>
                            <x-enterprise.table-shell table-class="pending-base-table min-w-full">
                                <x-slot name="thead">
                                    <tr>
                                        <th>Role</th>
                                        <th class="w-16">Use</th>
                                    </tr>
                                </x-slot>

                                <x-slot name="tbody">
                                    <template x-for="(row, index) in personnelRequested" :key="`left-${row.role}`">
                                        <tr>
                                            <td x-text="row.role"></td>
                                            <td>
                                                <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" :checked="row.selected" @change="toggleRequested('personnelRequested', index)" />
                                            </td>
                                        </tr>
                                    </template>
                                </x-slot>
                            </x-enterprise.table-shell>
                        </div>

                        <div class="space-y-3">
                            <div class="text-sm font-semibold text-gray-900">Personnel Requested 2</div>
                            <x-enterprise.table-shell table-class="pending-base-table min-w-full">
                                <x-slot name="thead">
                                    <tr>
                                        <th>Role</th>
                                        <th class="w-16">Use</th>
                                    </tr>
                                </x-slot>

                                <x-slot name="tbody">
                                    <template x-for="(row, index) in personnelRequested2" :key="`right-${row.role}`">
                                        <tr>
                                            <td x-text="row.role"></td>
                                            <td>
                                                <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" :checked="row.selected" @change="toggleRequested('personnelRequested2', index)" />
                                            </td>
                                        </tr>
                                    </template>
                                </x-slot>
                            </x-enterprise.table-shell>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'content'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">Visit Content</div>
                    <textarea x-model="content" rows="14" class="input-field attach-textarea min-h-[320px]"></textarea>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'attachments'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_180px]">
                        <x-enterprise.table-shell table-class="min-w-full border-collapse" datatable datatable-selectable>
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
                                        <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">No attachments linked to this scheduled visit.</td>
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

            <div x-cloak x-show="activeTab === 'properties'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <div>
                        <div class="text-sm font-semibold text-gray-900">Properties</div>
                        <p class="mt-1 text-sm text-gray-500">Operational metadata and defaults attached to this scheduled visit.</p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                        <template x-for="item in properties" :key="item.label">
                            <div class="rounded-xl border border-gray-200 bg-gray-50/70 p-4">
                                <div class="attach-field-label" x-text="item.label"></div>
                                <div class="mt-2 text-sm font-semibold text-gray-900" x-text="item.value"></div>
                            </div>
                        </template>
                    </div>
                </x-enterprise.panel>
            </div>

            <x-enterprise.action-bar class="border-t border-gray-200 pt-5">
                <button type="button" class="btn-primary" @click="addVisit()">Add</button>
                <button type="button" class="btn-secondary" @click="cancelVisit()">Cancel</button>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
