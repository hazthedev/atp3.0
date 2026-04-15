@extends('layouts.app')

@section('title', 'Personalized Alerts Management')

@section('content')
    <div
        class="space-y-6"
        x-data="{
            code: 'PAL-0103',
            objectType: 'Activities',
            name: 'Delayed customer response follow-up',
            status: 'Draft',
            user: 'acap',
            active: true,
            description: 'Escalate follow-up communication when customer-facing activities remain unanswered beyond the configured period.',
            businessPartner: 'Weststar Aviation Services',
            bpProperties: 'Operator / Active customer',
            bpBranch: 'Subang Engineering',
            perception: 'Attention Needed',
            priorityFilter: 'High',
            allBpsForUser: false,
            sendingInternal: true,
            sendingEmail: false,
            priority: 'Normal',
            alertTextType: 'html',
            subject: 'Pending customer response requires follow-up',
            body: '<p>A customer-facing activity has not received a response within the configured timeframe.</p><p>Please review the latest activity status and update the customer accordingly.</p>',
            updateDate: '2026-04-06',
            updatedBy: 'acap',
            statusMessage: '',
            findAlert() {
                this.statusMessage = `Loaded personalized alert ${this.code}.`;
            },
            cancelEdit() {
                this.statusMessage = 'Personalized alert editing cancelled for this session.';
            },
            showSummary() {
                this.statusMessage = `Summary prepared for ${this.code} (${this.objectType}).`;
            },
            viewDynamicFields() {
                this.statusMessage = 'Dynamic field helper opened for alert body templating.';
            },
            testSubjectAndBody() {
                this.statusMessage = `Test payload prepared for ${this.user} using ${this.alertTextType.toUpperCase()} content.`;
            },
        }"
    >
        <x-page-header
            title="Personalized Alerts Management"
            description="Configure personalized alert definitions, recipient scope, and message delivery rules in the ATP alert management workspace."
        />

        <section class="attach-workspace-shell max-w-[1280px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel muted class="space-y-5">
                <div class="grid gap-5 xl:grid-cols-2">
                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Code" for="personalized_alert_code" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                            <input id="personalized_alert_code" type="text" x-model="code" class="input-field attach-input" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Name" for="personalized_alert_name" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                            <input id="personalized_alert_name" type="text" x-model="name" class="input-field attach-input" />
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="User" for="personalized_alert_user" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                            <select id="personalized_alert_user" x-model="user" class="input-field attach-input">
                                <option value="acap">acap</option>
                                <option value="nadiah">nadiah</option>
                                <option value="aina">aina</option>
                            </select>
                        </x-enterprise.field-row>
                    </div>

                    <div class="space-y-2.5">
                        <x-enterprise.field-row label="Object Type" for="personalized_alert_object_type" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                            <select id="personalized_alert_object_type" x-model="objectType" class="input-field attach-input">
                                <option>Activities</option>
                                <option>Contact Report</option>
                                <option>Scheduled Visit</option>
                                <option>Observation</option>
                            </select>
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Status" for="personalized_alert_status" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                            <select id="personalized_alert_status" x-model="status" class="input-field attach-input">
                                <option>Draft</option>
                                <option>Released</option>
                                <option>Inactive</option>
                            </select>
                        </x-enterprise.field-row>

                        <div class="flex items-center gap-3">
                            <span class="attach-field-label">Active</span>
                            <label class="attach-checkbox-inline">
                                <input type="checkbox" x-model="active" />
                                <span>Enabled</span>
                            </label>
                        </div>
                    </div>
                </div>

                <x-enterprise.field-row label="Description" for="personalized_alert_description" columns="sm:grid-cols-[112px_minmax(0,1fr)]">
                    <input id="personalized_alert_description" type="text" x-model="description" class="input-field attach-input" />
                </x-enterprise.field-row>
            </x-enterprise.panel>

            <div class="grid gap-5 xl:grid-cols-2">
                <x-enterprise.panel class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">Recipient Scope</div>

                    <div class="space-y-2.5">
                        <x-enterprise.lookup-row label="Business Partner" for="personalized_alert_bp" columns="sm:grid-cols-[136px_minmax(0,1fr)]">
                            <div class="attach-inline-control">
                                <input id="personalized_alert_bp" type="text" x-model="businessPartner" class="input-field attach-input" />
                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>
                        </x-enterprise.lookup-row>

                        <x-enterprise.lookup-row label="BP Properties (AND relation)" for="personalized_alert_bp_properties" columns="sm:grid-cols-[136px_minmax(0,1fr)]">
                            <div class="attach-inline-control">
                                <input id="personalized_alert_bp_properties" type="text" x-model="bpProperties" class="input-field attach-input" />
                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>
                        </x-enterprise.lookup-row>

                        <x-enterprise.lookup-row label="BP Branch" for="personalized_alert_bp_branch" columns="sm:grid-cols-[136px_minmax(0,1fr)]">
                            <div class="attach-inline-control">
                                <input id="personalized_alert_bp_branch" type="text" x-model="bpBranch" class="input-field attach-input" />
                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>
                        </x-enterprise.lookup-row>

                        <x-enterprise.field-row label="Perception" for="personalized_alert_perception" columns="sm:grid-cols-[136px_minmax(0,1fr)]">
                            <select id="personalized_alert_perception" x-model="perception" class="input-field attach-input">
                                <option>Positive</option>
                                <option>Neutral</option>
                                <option>Attention Needed</option>
                            </select>
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Priority" for="personalized_alert_priority_filter" columns="sm:grid-cols-[136px_minmax(0,1fr)]">
                            <select id="personalized_alert_priority_filter" x-model="priorityFilter" class="input-field attach-input">
                                <option>High</option>
                                <option>Normal</option>
                                <option>Low</option>
                            </select>
                        </x-enterprise.field-row>
                    </div>

                    <label class="attach-checkbox-inline pt-2">
                        <input type="checkbox" x-model="allBpsForUser" />
                        <span>All BPs for which User is BA</span>
                    </label>
                </x-enterprise.panel>

                <x-enterprise.panel class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">Delivery & Content</div>

                    <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_180px]">
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="attach-field-label">Sending Type</span>
                            <label class="attach-checkbox-inline">
                                <input type="checkbox" x-model="sendingInternal" />
                                <span>Internal</span>
                            </label>
                            <label class="attach-checkbox-inline">
                                <input type="checkbox" x-model="sendingEmail" />
                                <span>Email</span>
                            </label>
                        </div>

                        <x-enterprise.field-row label="Priority" for="personalized_alert_priority" columns="sm:grid-cols-[72px_180px]">
                            <select id="personalized_alert_priority" x-model="priority" class="input-field attach-input">
                                <option>Normal</option>
                                <option>High</option>
                                <option>Low</option>
                            </select>
                        </x-enterprise.field-row>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <span class="attach-field-label">Alert's Text</span>
                        <label class="attach-checkbox-inline">
                            <input type="radio" name="personalized_alert_text_type" value="html" x-model="alertTextType" />
                            <span>Html</span>
                        </label>
                        <label class="attach-checkbox-inline">
                            <input type="radio" name="personalized_alert_text_type" value="text" x-model="alertTextType" />
                            <span>Text</span>
                        </label>
                    </div>

                    <x-enterprise.field-row label="Subject" for="personalized_alert_subject" columns="sm:grid-cols-[72px_minmax(0,1fr)]">
                        <input id="personalized_alert_subject" type="text" x-model="subject" class="input-field attach-input" />
                    </x-enterprise.field-row>

                    <x-enterprise.field-row label="Body" for="personalized_alert_body" columns="sm:grid-cols-[72px_minmax(0,1fr)]">
                        <textarea id="personalized_alert_body" x-model="body" rows="14" class="input-field attach-textarea min-h-[320px]"></textarea>
                    </x-enterprise.field-row>

                    <div class="space-y-1 text-sm text-gray-500">
                        <p>Use dynamic fields to obtain information from object.</p>
                        <p>Example: <code>[BusinessPartner]</code> will inject the Business Partner name.</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" class="btn-secondary" @click="showSummary()">Summary</button>
                        <button type="button" class="btn-secondary" @click="viewDynamicFields()">View dynamic fields</button>
                        <button type="button" class="btn-secondary" @click="testSubjectAndBody()">Test subject and body</button>
                    </div>
                </x-enterprise.panel>
            </div>

            <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="btn-primary" @click="findAlert()">Find</button>
                    <button type="button" class="btn-secondary" @click="cancelEdit()">Cancel</button>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <div class="grid gap-2">
                        <span class="attach-field-label">Update Date</span>
                        <input type="text" x-model="updateDate" readonly class="input-field attach-input input-field-filled" />
                    </div>
                    <div class="grid gap-2">
                        <span class="attach-field-label">Updated By</span>
                        <input type="text" x-model="updatedBy" readonly class="input-field attach-input input-field-filled" />
                    </div>
                </div>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
