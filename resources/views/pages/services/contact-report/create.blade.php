@extends('layouts.app')

@section('title', 'Create Contact Report')

@php
    $observations = [
        ['id' => 'obs-001', 'title' => 'Customer requested rotor tracking review before next base visit.', 'owner' => 'Aero One Services', 'status' => 'Open'],
        ['id' => 'obs-002', 'title' => 'Cabin speaker replacement to be aligned with upcoming scheduled visit.', 'owner' => 'Support Team', 'status' => 'Planned'],
    ];

    $properties = [
        ['label' => 'Record Source', 'value' => 'Service Visit'],
        ['label' => 'Linked Alert', 'value' => 'None'],
        ['label' => 'Visibility', 'value' => 'Internal'],
        ['label' => 'Follow-up Owner', 'value' => 'Aero One Services'],
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
            updatedBy: 'acap',
            updateDate: '2026-04-06',
            contactReportNumber: 'CR-2026-0418',
            status: 'Draft',
            bpCode: 'BP-001284',
            bpName: 'Weststar Aviation Services',
            bpContactPerson: 'Ahmad Shahrul',
            telephoneNo: '+60 12-884 9021',
            remarks: 'Operational review with customer support team regarding upcoming scheduled visit and open service concerns.',
            visitDate: '2026-04-06',
            visitWeek: '15',
            oemPresent: 'yes',
            oemBpCode: 'OEM-AGW-02',
            oemBpName: 'Leonardo Helicopters',
            oemContactPerson: 'Marco Bellini',
            addressName: 'Weststar Aviation Services',
            country: 'Malaysia',
            state: 'Selangor',
            county: 'Petaling',
            branch: 'Subang Engineering',
            origin: 'Scheduled Visit',
            bpIssueLevel: 'GREEN',
            meetingLocation: 'Subang Hangar 2',
            scheduledVisit: 'SV-24041',
            perceptionLevel: 'Positive',
            perceptionComment: 'Customer feedback was constructive. Main concern is better visibility on pending component delivery timing.',
            observations: @js($observations),
            newObservation: '',
            properties: @js($properties),
            statusMessage: '',
            addObservation() {
                const value = this.newObservation.trim();
                if (!value) {
                    this.statusMessage = 'Write an observation before adding it to the contact report.';
                    return;
                }

                this.observations = [
                    {
                        id: `obs-${Date.now()}`,
                        title: value,
                        owner: this.createdBy,
                        status: 'New',
                    },
                    ...this.observations,
                ];

                this.newObservation = '';
                this.activeTab = 'observations';
                this.statusMessage = 'Observation added to the contact report draft.';
            },
            saveReport() {
                this.status = 'Ready for review';
                this.statusMessage = `Contact report ${this.contactReportNumber} prepared for review.`;
            },
            cancelReport() {
                this.statusMessage = 'Contact report editing cancelled for this draft session.';
            },
            addComment() {
                this.statusMessage = 'Comment panel opened for the current contact report.';
            },
        }"
    >
        <x-page-header
            title="Create Contact Report"
            description="Capture service visit outcomes, business-partner perception, and follow-up observations in the ATP contact report workspace."
        />

        <section class="attach-workspace-shell max-w-[1280px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel muted class="space-y-5">
                <div class="grid gap-5 xl:grid-cols-2">
                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Created By" for="contact_created_by" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                            <input id="contact_created_by" type="text" x-model="createdBy" readonly class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Department" for="contact_department" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                            <input id="contact_department" type="text" x-model="department" readonly class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Site" for="contact_site" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                            <input id="contact_site" type="text" x-model="site" readonly class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Creation Date" for="contact_creation_date" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                            <input id="contact_creation_date" type="text" x-model="creationDate" readonly class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Updated By" for="contact_updated_by" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                            <input id="contact_updated_by" type="text" x-model="updatedBy" readonly class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Update Date" for="contact_update_date" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                            <input id="contact_update_date" type="text" x-model="updateDate" readonly class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>
                    </div>

                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Contact Report Number" for="contact_report_number" columns="sm:grid-cols-[168px_minmax(0,1fr)]">
                            <input id="contact_report_number" type="text" x-model="contactReportNumber" readonly class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Status" for="contact_status" columns="sm:grid-cols-[168px_minmax(0,1fr)]">
                            <input id="contact_status" type="text" x-model="status" readonly class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>

                        <x-enterprise.lookup-row label="BP Code" for="contact_bp_code" columns="sm:grid-cols-[168px_minmax(0,1fr)]">
                            <div class="attach-inline-control">
                                <input id="contact_bp_code" type="text" x-model="bpCode" class="input-field attach-input" />
                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>
                        </x-enterprise.lookup-row>

                        <x-enterprise.field-row label="BP Name" for="contact_bp_name" columns="sm:grid-cols-[168px_minmax(0,1fr)]">
                            <input id="contact_bp_name" type="text" x-model="bpName" class="input-field attach-input" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="BP Contact Person" for="contact_bp_contact_person" columns="sm:grid-cols-[168px_minmax(0,1fr)]">
                            <input id="contact_bp_contact_person" type="text" x-model="bpContactPerson" class="input-field attach-input" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Telephone No." for="contact_telephone" columns="sm:grid-cols-[168px_minmax(0,1fr)]">
                            <input id="contact_telephone" type="text" x-model="telephoneNo" class="input-field attach-input" />
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
                            <button type="button" class="subtab-link" :class="activeTab === 'bp-perception' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'bp-perception'">BP perception</button>
                        </li>
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'observations' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'observations'">Observations</button>
                        </li>
                        <li class="subtab-item">
                            <button type="button" class="subtab-link" :class="activeTab === 'properties' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'properties'">Properties</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div x-cloak x-show="activeTab === 'general'" class="space-y-5">
                <x-enterprise.panel class="space-y-5">
                    <div class="space-y-4">
                        <x-enterprise.field-row label="Remarks" for="contact_remarks" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                            <textarea id="contact_remarks" x-model="remarks" rows="3" class="input-field attach-textarea"></textarea>
                        </x-enterprise.field-row>

                        <div class="grid gap-4 lg:grid-cols-[296px_160px]">
                            <x-enterprise.field-row label="Date of visit" for="contact_visit_date" columns="sm:grid-cols-[112px_164px]">
                                <x-date-picker id="contact_visit_date" x-model="visitDate" />
                            </x-enterprise.field-row>

                            <x-enterprise.field-row label="Week" for="contact_visit_week" columns="sm:grid-cols-[52px_92px]">
                                <input id="contact_visit_week" type="text" x-model="visitWeek" class="input-field attach-input" />
                            </x-enterprise.field-row>
                        </div>
                    </div>

                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_360px]">
                        <div class="space-y-4">
                            <x-enterprise.panel muted class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Partner Presence</div>

                                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                    <span class="attach-field-label">OEM Personnel Present</span>
                                    <div class="flex flex-wrap gap-2">
                                        <label
                                            class="inline-flex cursor-pointer items-center gap-2 rounded-full border px-4 py-2 text-sm font-medium shadow-sm transition"
                                            :class="oemPresent === 'yes' ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50'"
                                        >
                                            <input type="radio" name="contact_oem_present" value="yes" x-model="oemPresent" />
                                            <span>Yes</span>
                                        </label>
                                        <label
                                            class="inline-flex cursor-pointer items-center gap-2 rounded-full border px-4 py-2 text-sm font-medium shadow-sm transition"
                                            :class="oemPresent === 'no' ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50'"
                                        >
                                            <input type="radio" name="contact_oem_present" value="no" x-model="oemPresent" />
                                            <span>No</span>
                                        </label>
                                    </div>
                                </div>

                                <x-enterprise.lookup-row label="OEM BP Code" for="contact_oem_bp_code" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                    <div class="attach-inline-control">
                                        <input id="contact_oem_bp_code" type="text" x-model="oemBpCode" class="input-field attach-input" />
                                        <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                    </div>
                                </x-enterprise.lookup-row>

                                <x-enterprise.field-row label="OEM BP Name" for="contact_oem_bp_name" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                    <input id="contact_oem_bp_name" type="text" x-model="oemBpName" class="input-field attach-input" />
                                </x-enterprise.field-row>

                                <x-enterprise.field-row label="OEM Contact Person" for="contact_oem_contact_person" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                    <input id="contact_oem_contact_person" type="text" x-model="oemContactPerson" class="input-field attach-input" />
                                </x-enterprise.field-row>
                            </x-enterprise.panel>

                            <x-enterprise.panel muted class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Address</div>

                                <x-enterprise.lookup-row label="Name" for="contact_address_name" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                                    <div class="attach-inline-control">
                                        <input id="contact_address_name" type="text" x-model="addressName" class="input-field attach-input" />
                                        <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                                    </div>
                                </x-enterprise.lookup-row>

                                <x-enterprise.field-row label="Country" for="contact_country" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                                    <input id="contact_country" type="text" x-model="country" class="input-field attach-input" />
                                </x-enterprise.field-row>

                                <x-enterprise.field-row label="State" for="contact_state" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                                    <input id="contact_state" type="text" x-model="state" class="input-field attach-input" />
                                </x-enterprise.field-row>

                                <x-enterprise.field-row label="County" for="contact_county" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                                    <input id="contact_county" type="text" x-model="county" class="input-field attach-input" />
                                </x-enterprise.field-row>

                                <x-enterprise.field-row label="Branch" for="contact_branch" columns="sm:grid-cols-[96px_minmax(0,1fr)]">
                                    <input id="contact_branch" type="text" x-model="branch" class="input-field attach-input" />
                                </x-enterprise.field-row>
                            </x-enterprise.panel>
                        </div>

                        <div class="space-y-4">
                            <x-enterprise.panel muted class="space-y-4">
                                <div class="text-sm font-semibold text-gray-900">Visit Context</div>

                                <x-enterprise.field-row label="Origin" for="contact_origin" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                    <input id="contact_origin" type="text" x-model="origin" class="input-field attach-input" />
                                </x-enterprise.field-row>

                                <x-enterprise.field-row label="BP Issue Level" for="contact_issue_level" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                    <input id="contact_issue_level" type="text" x-model="bpIssueLevel" class="input-field attach-input input-field-filled" />
                                </x-enterprise.field-row>

                                <x-enterprise.field-row label="Meeting Location" for="contact_meeting_location" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                    <input id="contact_meeting_location" type="text" x-model="meetingLocation" class="input-field attach-input" />
                                </x-enterprise.field-row>

                                <x-enterprise.field-row label="Scheduled Visit" for="contact_scheduled_visit" columns="sm:grid-cols-[132px_minmax(0,1fr)]">
                                    <input id="contact_scheduled_visit" type="text" x-model="scheduledVisit" class="input-field attach-input" />
                                </x-enterprise.field-row>
                            </x-enterprise.panel>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'bp-perception'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <x-enterprise.field-row label="Level" for="contact_perception_level" columns="sm:grid-cols-[112px_180px]">
                        <select id="contact_perception_level" x-model="perceptionLevel" class="input-field attach-input">
                            <option>Positive</option>
                            <option>Neutral</option>
                            <option>Attention Needed</option>
                        </select>
                    </x-enterprise.field-row>

                    <x-enterprise.field-row label="Comment" for="contact_perception_comment" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                        <textarea id="contact_perception_comment" x-model="perceptionComment" rows="10" class="input-field attach-textarea min-h-[260px]"></textarea>
                    </x-enterprise.field-row>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'observations'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <div>
                        <div class="text-sm font-semibold text-gray-900">Observations</div>
                        <p class="mt-1 text-sm text-gray-500">Capture visit findings and follow-up items linked to this contact report.</p>
                    </div>

                    <x-enterprise.table-shell table-class="pending-base-table min-w-full">
                        <x-slot name="thead">
                            <tr>
                                <th>Observation</th>
                                <th>Owner</th>
                                <th>Status</th>
                            </tr>
                        </x-slot>

                        <x-slot name="tbody">
                            <template x-for="row in observations" :key="row.id">
                                <tr>
                                    <td class="max-w-[560px] whitespace-normal" x-text="row.title"></td>
                                    <td x-text="row.owner"></td>
                                    <td>
                                        <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700" x-text="row.status"></span>
                                    </td>
                                </tr>
                            </template>
                        </x-slot>
                    </x-enterprise.table-shell>

                    <div class="grid gap-3 lg:grid-cols-[180px_minmax(0,1fr)] lg:items-center">
                        <span class="attach-field-label">Create New Observation</span>
                        <div class="grid gap-3 lg:grid-cols-[minmax(0,1fr)_auto]">
                            <input type="text" x-model="newObservation" class="input-field attach-input" placeholder="Capture a new service observation" />
                            <button type="button" class="btn-primary" @click="addObservation()">Add</button>
                        </div>
                    </div>
                </x-enterprise.panel>
            </div>

            <div x-cloak x-show="activeTab === 'properties'" class="space-y-5">
                <x-enterprise.panel class="space-y-4">
                    <div>
                        <div class="text-sm font-semibold text-gray-900">Properties</div>
                        <p class="mt-1 text-sm text-gray-500">Operational metadata and handling details associated with this record.</p>
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

            <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="btn-primary" @click="saveReport()">OK</button>
                    <button type="button" class="btn-secondary" @click="cancelReport()">Cancel</button>
                </div>

                <button type="button" class="btn-secondary" @click="addComment()">Comment</button>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
