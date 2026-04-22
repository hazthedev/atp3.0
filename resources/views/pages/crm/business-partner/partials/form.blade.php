@php
    $mode = $mode ?? 'create';
    $isEdit = $mode === 'edit';
    $recordId = (int) ($recordId ?? request()->route('id') ?? 0);
    $displayId = $recordId > 0 ? $recordId : 1284;

    $partner = $isEdit
        ? [
            'record_id' => $displayId,
            'code' => 'BP-' . str_pad((string) $displayId, 6, '0', STR_PAD_LEFT),
            'name' => 'Weststar Aviation Services',
            'foreign_name' => 'Weststar Aviation Services Sdn. Bhd.',
            'primary_type' => 'Customer',
            'bp_group' => 'Trade Debtor',
            'currency' => 'MYR',
            'bp_currency_mode' => 'Local Currency',
            'federal_tax_id' => 'TAX-MY-44328',
            'account_balance' => '1,240,550.00',
            'deliveries' => '17',
            'orders' => '8',
            'opportunities' => '3',
            'is_active' => true,
            'lifecycle_status' => 'active',
            'tel1' => '+60 3-2771 8800',
            'tel2' => '+60 3-2771 8822',
            'mobile_phone' => '+60 12-884 9021',
            'fax' => '+60 3-2771 8899',
            'email' => 'ahmad.shahrul@weststar.com.my',
            'website' => 'https://www.weststar.com.my',
            'shipping_type' => 'Delivery by vendor',
            'bp_project' => 'PRJ-88014',
            'industry' => 'Aviation Services',
            'business_partner_type' => 'Company',
            'fleet_size' => 'Large',
            'alias_name' => 'Weststar Aviation',
            'contact_person' => 'Ahmad Shahrul',
            'unified_federal_tax_id' => 'MY-UNIFIED-9921',
            'channel_code' => 'GOV-SVC',
            'territory' => 'Malaysia',
            'sales_employee' => 'Nur Izzati',
            'default_language' => 'English',
            'service_level' => 'Premium Support',
            'business_agent' => 'Customer Support',
            'payment_terms' => '30 Days Net',
            'credit_limit' => '2,500,000.00',
            'statement_cycle' => 'Monthly',
            'payment_method' => 'Bank Transfer',
            'invoice_delivery' => 'E-Mail PDF',
            'dunning_level' => 'Standard',
            'payment_block' => false,
            'single_payment' => false,
            'collection_authorization' => true,
            'auto_calc_bank_charge' => true,
            'bank_country' => 'Malaysia',
            'bank_name' => 'Maybank Islamic',
            'bank_account' => '5140 8821 9901',
            'bank_branch' => 'Kuala Lumpur Main',
            'iban' => 'MY880120000514088219901',
            'bic_swift' => 'MBBEMYKL',
            'reference_details' => 'Service contract milestone billing',
            'accounts_receivable' => 'AR-100200',
            'down_payment_clearing' => 'DP-220110',
            'down_payment_interim' => 'DPI-220114',
            'connected_vendor' => 'Northport Rotary Leasing',
            'planning_group' => 'Rotorcraft Support',
            'tax_status' => 'Liable',
            'tax_group' => 'SR-6',
            'deferred_tax' => false,
            'affiliate' => true,
            'remarks' => 'Customer requires structured monthly service review, escalation routing, and campaign-planning visibility.',
            'internal_notes' => 'Keep finance and service desk aligned before contract revision 04 review.',
            'next_review_date' => '2026-04-22',
            'review_owner' => 'Customer Support Lead',
            'last_updated_by' => 'acap',
            'last_updated_at' => '2026-04-08 10:30',
        ]
        : [
            'record_id' => null,
            'code' => 'BP-DRAFT-260408',
            'name' => '',
            'foreign_name' => '',
            'primary_type' => 'Customer',
            'bp_group' => 'Trade Debtor',
            'currency' => 'MYR',
            'bp_currency_mode' => 'Local Currency',
            'federal_tax_id' => '',
            'account_balance' => '0.00',
            'deliveries' => '0',
            'orders' => '0',
            'opportunities' => '1',
            'is_active' => true,
            'lifecycle_status' => 'active',
            'tel1' => '',
            'tel2' => '',
            'mobile_phone' => '',
            'fax' => '',
            'email' => '',
            'website' => '',
            'shipping_type' => 'Delivery by vendor',
            'bp_project' => '',
            'industry' => 'Aviation Services',
            'business_partner_type' => 'Company',
            'fleet_size' => 'Medium',
            'alias_name' => '',
            'contact_person' => '',
            'unified_federal_tax_id' => '',
            'channel_code' => '',
            'territory' => 'Malaysia',
            'sales_employee' => '',
            'default_language' => 'English',
            'service_level' => 'Standard',
            'business_agent' => 'Commercial',
            'payment_terms' => '30 Days Net',
            'credit_limit' => '0.00',
            'statement_cycle' => 'Monthly',
            'payment_method' => 'Bank Transfer',
            'invoice_delivery' => 'E-Mail PDF',
            'dunning_level' => 'Standard',
            'payment_block' => false,
            'single_payment' => false,
            'collection_authorization' => false,
            'auto_calc_bank_charge' => false,
            'bank_country' => 'Malaysia',
            'bank_name' => '',
            'bank_account' => '',
            'bank_branch' => '',
            'iban' => '',
            'bic_swift' => '',
            'reference_details' => '',
            'accounts_receivable' => '',
            'down_payment_clearing' => '',
            'down_payment_interim' => '',
            'connected_vendor' => '',
            'planning_group' => '',
            'tax_status' => 'Liable',
            'tax_group' => '',
            'deferred_tax' => false,
            'affiliate' => false,
            'remarks' => '',
            'internal_notes' => '',
            'next_review_date' => now()->addWeeks(2)->format('Y-m-d'),
            'review_owner' => 'Commercial Lead',
            'last_updated_by' => 'acap',
            'last_updated_at' => now()->format('Y-m-d H:i'),
        ];

    $relationshipContacts = $isEdit
        ? [
            ['id' => 'CNT-01', 'role' => 'Primary Contact', 'name' => 'Ahmad Shahrul', 'email' => 'ahmad.shahrul@weststar.com.my', 'phone' => '+60 12-884 9021', 'preferred' => true],
            ['id' => 'CNT-02', 'role' => 'Finance', 'name' => 'Nadiah Rahman', 'email' => 'nadiah.finance@weststar.com.my', 'phone' => '+60 19-772 4012', 'preferred' => false],
            ['id' => 'CNT-03', 'role' => 'Planning', 'name' => 'Aina Mohd Noor', 'email' => 'aina.planning@weststar.com.my', 'phone' => '+60 17-833 2900', 'preferred' => false],
        ]
        : [
            ['id' => 'CNT-01', 'role' => 'Primary Contact', 'name' => '', 'email' => '', 'phone' => '', 'preferred' => true],
        ];

    $recentActivities = $isEdit
        ? [
            ['id' => 'ACT-240418', 'entry' => 'Scheduled service review completed', 'owner' => 'Customer Support', 'date' => '2026-04-08'],
            ['id' => 'ACT-240409', 'entry' => 'Contract revision shared with finance lead', 'owner' => 'Commercial', 'date' => '2026-04-05'],
            ['id' => 'ACT-240398', 'entry' => 'Fleet support escalation closed', 'owner' => 'Service Desk', 'date' => '2026-04-01'],
        ]
        : [
            ['id' => 'ACT-DRAFT', 'entry' => 'Initial account qualification in progress', 'owner' => 'Commercial', 'date' => now()->format('Y-m-d')],
        ];

    $documentChecklist = [
        ['id' => 'DOC-01', 'label' => 'Customer registration form', 'complete' => $isEdit],
        ['id' => 'DOC-02', 'label' => 'Tax / company validation', 'complete' => $isEdit],
        ['id' => 'DOC-03', 'label' => 'Banking verification', 'complete' => false],
        ['id' => 'DOC-04', 'label' => 'Signed service terms', 'complete' => $isEdit],
    ];

    $pageTitle = $isEdit ? 'Edit Business Partner' : 'Create Business Partner';
    $pageDescription = $isEdit
        ? 'Rebuilt from the legacy business-partner master layout using the current Blade, Alpine, and enterprise-panel design pattern in this codebase.'
        : 'Create a new business partner using the modernized CRM workspace while preserving the legacy business-partner sections and data expectations.';
    $saveMessage = $isEdit ? 'Business partner preview updated.' : 'Business partner draft prepared.';
    $cancelMessage = $isEdit ? 'Business partner changes cancelled for this preview session.' : 'Business partner draft discarded for this preview session.';
@endphp

@if ($isEdit)
<div x-data="editMode(false)" data-edit-scope x-bind:data-editing="editing ? 'true' : 'false'">
@endif
<div
    class="space-y-6"
    x-data="{
        activeTab: 'general',
        statusMessage: '',
        partner: @js($partner),
        contacts: @js($relationshipContacts),
        activities: @js($recentActivities),
        documents: @js($documentChecklist),
        saveMessage: @js($saveMessage),
        cancelMessage: @js($cancelMessage),
        savePartner() {
            this.statusMessage = this.saveMessage;
        },
        cancelPartner() {
            this.statusMessage = this.cancelMessage;
        },
        addContact() {
            const next = this.contacts.length + 1;
            this.contacts = [...this.contacts, { id: `CNT-NEW-${next}`, role: 'Additional Contact', name: '', email: '', phone: '', preferred: false }];
            this.statusMessage = 'Relationship contact row added to the workspace.';
        },
        removeContact(id) {
            this.contacts = this.contacts.filter((row) => row.id !== id);
            this.statusMessage = 'Relationship contact removed from the workspace.';
        },
    }"
>
    <x-page-header :title="$pageTitle" :description="$pageDescription">
        <x-slot name="actions">
            <a href="{{ route('crm.business-partner.index') }}" class="btn-secondary">
                <x-icon name="chevron-right" class="h-4 w-4 rotate-180" />
                Back to List
            </a>
            @if ($isEdit)
                <template x-if="!editing">
                    <button type="button" class="btn-primary" @click="enter()">Edit Record</button>
                </template>
                <template x-if="editing">
                    <button type="button" class="btn-secondary" @click="cancel()">Cancel</button>
                </template>
                <template x-if="editing">
                    <button type="button" class="btn-primary" @click="savePartner(); toggle()">Save</button>
                </template>
            @else
                <button type="button" class="btn-primary" @click="savePartner()">
                    <x-icon name="document-text" class="h-4 w-4" />
                    Save Preview
                </button>
            @endif
        </x-slot>
    </x-page-header>

    <section class="attach-workspace-shell max-w-[1380px] space-y-5">
        <template x-if="statusMessage">
            <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
        </template>

        <x-enterprise.panel muted class="space-y-5">
            <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
                <div class="grid gap-5 xl:grid-cols-2">
                    <div class="space-y-3">
                        <x-enterprise.field-row label="Code" for="crm_bp_code" class="grid-cols-[152px_minmax(0,1fr)]">
                            <input id="crm_bp_code" type="text" x-model="partner.code" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Name" for="crm_bp_name" class="grid-cols-[152px_minmax(0,1fr)]">
                            <input id="crm_bp_name" type="text" x-model="partner.name" class="input-field attach-input" placeholder="Business partner name" />
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Foreign Name" for="crm_bp_foreign_name" class="grid-cols-[152px_minmax(0,1fr)]">
                            <input id="crm_bp_foreign_name" type="text" x-model="partner.foreign_name" class="input-field attach-input" placeholder="Optional legal or foreign name" />
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Primary Type" for="crm_bp_primary_type" class="grid-cols-[152px_minmax(0,1fr)]">
                            <select id="crm_bp_primary_type" x-model="partner.primary_type" class="input-field attach-input">
                                <option>Customer</option>
                                <option>Vendor</option>
                                <option>Lead</option>
                            </select>
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Group" for="crm_bp_group" class="grid-cols-[152px_minmax(0,1fr)]">
                            <select id="crm_bp_group" x-model="partner.bp_group" class="input-field attach-input">
                                <option>Trade Debtor</option>
                                <option>Trade Creditor</option>
                                <option>Intercompany (Debtor)</option>
                                <option>Intercompany (Vendor)</option>
                                <option>Others Debtor</option>
                            </select>
                        </x-enterprise.field-row>
                    </div>

                    <div class="space-y-3">
                        <x-enterprise.field-row label="Currency" for="crm_bp_currency" class="grid-cols-[152px_minmax(0,1fr)]">
                            <select id="crm_bp_currency" x-model="partner.currency" class="input-field attach-input">
                                <option>MYR</option>
                                <option>USD</option>
                                <option>SGD</option>
                                <option>AUD</option>
                                <option>EUR</option>
                            </select>
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="BP Currency" for="crm_bp_currency_mode" class="grid-cols-[152px_minmax(0,1fr)]">
                            <select id="crm_bp_currency_mode" x-model="partner.bp_currency_mode" class="input-field attach-input">
                                <option>Local Currency</option>
                                <option>System Currency</option>
                                <option>BP Currency</option>
                            </select>
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Federal Tax ID" for="crm_bp_federal_tax_id" class="grid-cols-[152px_minmax(0,1fr)]">
                            <input id="crm_bp_federal_tax_id" type="text" x-model="partner.federal_tax_id" class="input-field attach-input" />
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Review Owner" for="crm_bp_review_owner" class="grid-cols-[152px_minmax(0,1fr)]">
                            <input id="crm_bp_review_owner" type="text" x-model="partner.review_owner" class="input-field attach-input input-field-filled" />
                        </x-enterprise.field-row>
                        <label class="attach-checkbox-inline pt-2">
                            <input type="checkbox" x-model="partner.is_active" />
                            <span>Account is active and visible in the CRM workspace</span>
                        </label>
                    </div>
                </div>

                <x-enterprise.panel class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">Portfolio Pulse</div>
                    <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-1">
                        <div class="flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50/70 px-4 py-3"><span class="attach-field-label">Account Balance</span><span class="font-semibold text-gray-900" x-text="partner.account_balance"></span></div>
                        <div class="flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50/70 px-4 py-3"><span class="attach-field-label">Deliveries</span><span class="font-semibold text-gray-900" x-text="partner.deliveries"></span></div>
                        <div class="flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50/70 px-4 py-3"><span class="attach-field-label">Orders</span><span class="font-semibold text-gray-900" x-text="partner.orders"></span></div>
                        <div class="flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50/70 px-4 py-3"><span class="attach-field-label">Opportunities</span><span class="font-semibold text-gray-900" x-text="partner.opportunities"></span></div>
                    </div>
                    <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-4 text-sm text-blue-700">
                        <div class="font-semibold">Current rebuild pattern</div>
                        <p class="mt-1">Legacy business-partner sections are preserved, but the page now uses shared Laravel layout, Alpine state, and enterprise panels instead of the old raw admin markup.</p>
                    </div>
                </x-enterprise.panel>
            </div>
        </x-enterprise.panel>

        <div class="rounded-xl border border-gray-200 bg-white px-5 pt-4 shadow-sm">
            <div class="subtab-shell">
                <ul class="subtab-list">
                    <li class="subtab-item"><button type="button" class="subtab-link" :class="activeTab === 'general' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'general'">General</button></li>
                    <li class="subtab-item"><button type="button" class="subtab-link" :class="activeTab === 'ba-bp' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'ba-bp'">BA / BP</button></li>
                    <li class="subtab-item"><button type="button" class="subtab-link" :class="activeTab === 'payment-terms' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'payment-terms'">Payment Terms</button></li>
                    <li class="subtab-item"><button type="button" class="subtab-link" :class="activeTab === 'payment-run' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'payment-run'">Payment Run</button></li>
                    <li class="subtab-item"><button type="button" class="subtab-link" :class="activeTab === 'accounting' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'accounting'">Accounting</button></li>
                    <li class="subtab-item"><button type="button" class="subtab-link" :class="activeTab === 'remarks' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="activeTab = 'remarks'">Remarks</button></li>
                </ul>
            </div>
        </div>

        <div x-cloak x-show="activeTab === 'general'" class="space-y-5">
            <div class="grid gap-5 xl:grid-cols-2">
                <x-enterprise.panel class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">Communication</div>
                    <div class="space-y-3">
                        <x-enterprise.field-row label="Tel 1" for="crm_bp_tel1" class="grid-cols-[160px_minmax(0,1fr)]"><input id="crm_bp_tel1" type="text" x-model="partner.tel1" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Tel 2" for="crm_bp_tel2" class="grid-cols-[160px_minmax(0,1fr)]"><input id="crm_bp_tel2" type="text" x-model="partner.tel2" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Mobile Phone" for="crm_bp_mobile_phone" class="grid-cols-[160px_minmax(0,1fr)]"><input id="crm_bp_mobile_phone" type="text" x-model="partner.mobile_phone" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Fax" for="crm_bp_fax" class="grid-cols-[160px_minmax(0,1fr)]"><input id="crm_bp_fax" type="text" x-model="partner.fax" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="E-Mail" for="crm_bp_email" class="grid-cols-[160px_minmax(0,1fr)]"><input id="crm_bp_email" type="email" x-model="partner.email" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Website" for="crm_bp_website" class="grid-cols-[160px_minmax(0,1fr)]"><input id="crm_bp_website" type="text" x-model="partner.website" class="input-field attach-input" /></x-enterprise.field-row>
                    </div>
                </x-enterprise.panel>

                <x-enterprise.panel class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">Profile</div>
                    <div class="space-y-3">
                        <x-enterprise.field-row label="Contact Person" for="crm_bp_contact_person" class="grid-cols-[176px_minmax(0,1fr)]"><input id="crm_bp_contact_person" type="text" x-model="partner.contact_person" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Industry" for="crm_bp_industry" class="grid-cols-[176px_minmax(0,1fr)]">
                            <select id="crm_bp_industry" x-model="partner.industry" class="input-field attach-input">
                                <option>Aviation Services</option>
                                <option>Government Operations</option>
                                <option>Leasing</option>
                                <option>MRO</option>
                            </select>
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="BP Type" for="crm_bp_business_partner_type" class="grid-cols-[176px_minmax(0,1fr)]">
                            <select id="crm_bp_business_partner_type" x-model="partner.business_partner_type" class="input-field attach-input">
                                <option>Company</option>
                                <option>Private</option>
                                <option>Employee</option>
                            </select>
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Fleet Size" for="crm_bp_fleet_size" class="grid-cols-[176px_minmax(0,1fr)]">
                            <select id="crm_bp_fleet_size" x-model="partner.fleet_size" class="input-field attach-input">
                                <option>Small</option>
                                <option>Medium</option>
                                <option>Large</option>
                            </select>
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Shipping Type" for="crm_bp_shipping_type" class="grid-cols-[176px_minmax(0,1fr)]">
                            <select id="crm_bp_shipping_type" x-model="partner.shipping_type" class="input-field attach-input">
                                <option>Delivery by vendor</option>
                                <option>Air Freight</option>
                                <option>Sea Freight</option>
                                <option>Self Collection</option>
                            </select>
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Alias Name" for="crm_bp_alias_name" class="grid-cols-[176px_minmax(0,1fr)]"><input id="crm_bp_alias_name" type="text" x-model="partner.alias_name" class="input-field attach-input" /></x-enterprise.field-row>
                    </div>
                </x-enterprise.panel>
            </div>

            <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
                <x-enterprise.panel class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">Lifecycle Status</div>
                    <div class="inline-flex flex-wrap gap-2 rounded-xl bg-gray-100 p-1">
                        <button type="button" class="segmented-option" :class="partner.lifecycle_status === 'active' ? 'segmented-option-active' : ''" @click="partner.lifecycle_status = 'active'">Active</button>
                        <button type="button" class="segmented-option" :class="partner.lifecycle_status === 'inactive' ? 'segmented-option-active' : ''" @click="partner.lifecycle_status = 'inactive'">Inactive</button>
                        <button type="button" class="segmented-option" :class="partner.lifecycle_status === 'advanced' ? 'segmented-option-active' : ''" @click="partner.lifecycle_status = 'advanced'">Advanced</button>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-xl border border-gray-200 bg-gray-50/70 p-4">
                            <div class="attach-field-label">Review Date</div>
                            <input type="date" x-model="partner.next_review_date" class="input-field attach-input mt-2" />
                        </div>
                        <div class="rounded-xl border border-gray-200 bg-gray-50/70 p-4">
                            <div class="attach-field-label">Review Owner</div>
                            <input type="text" x-model="partner.review_owner" class="input-field attach-input mt-2" />
                        </div>
                    </div>
                </x-enterprise.panel>

                <x-enterprise.panel class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">Audit Preview</div>
                    <div class="rounded-xl border border-gray-200 bg-gray-50/70 p-4">
                        <div class="attach-field-label">Last Updated By</div>
                        <div class="mt-2 font-semibold text-gray-900" x-text="partner.last_updated_by"></div>
                    </div>
                    <div class="rounded-xl border border-gray-200 bg-gray-50/70 p-4">
                        <div class="attach-field-label">Last Updated At</div>
                        <div class="mt-2 font-semibold text-gray-900" x-text="partner.last_updated_at"></div>
                    </div>
                </x-enterprise.panel>
            </div>
        </div>

        <div x-cloak x-show="activeTab === 'ba-bp'" class="space-y-5">
            <div class="grid gap-5 xl:grid-cols-[360px_minmax(0,1fr)]">
                <x-enterprise.panel class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">Relationship Ownership</div>
                    <div class="space-y-3">
                        <x-enterprise.field-row label="Territory" for="crm_bp_territory" class="grid-cols-[144px_minmax(0,1fr)]">
                            <select id="crm_bp_territory" x-model="partner.territory" class="input-field attach-input">
                                <option>Malaysia</option>
                                <option>Singapore</option>
                                <option>Indonesia</option>
                                <option>Australia</option>
                            </select>
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Sales Employee" for="crm_bp_sales_employee" class="grid-cols-[144px_minmax(0,1fr)]"><input id="crm_bp_sales_employee" type="text" x-model="partner.sales_employee" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Channel Code" for="crm_bp_channel_code" class="grid-cols-[144px_minmax(0,1fr)]"><input id="crm_bp_channel_code" type="text" x-model="partner.channel_code" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="BP Project" for="crm_bp_project" class="grid-cols-[144px_minmax(0,1fr)]"><input id="crm_bp_project" type="text" x-model="partner.bp_project" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Language" for="crm_bp_default_language" class="grid-cols-[144px_minmax(0,1fr)]">
                            <select id="crm_bp_default_language" x-model="partner.default_language" class="input-field attach-input">
                                <option>English</option>
                                <option>Bahasa Malaysia</option>
                                <option>Mandarin</option>
                            </select>
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Service Level" for="crm_bp_service_level" class="grid-cols-[144px_minmax(0,1fr)]">
                            <select id="crm_bp_service_level" x-model="partner.service_level" class="input-field attach-input">
                                <option>Standard</option>
                                <option>Premium Support</option>
                                <option>Mission Critical</option>
                                <option>Proposal Stage</option>
                            </select>
                        </x-enterprise.field-row>
                        <x-enterprise.field-row label="Business Agent" for="crm_bp_business_agent" class="grid-cols-[144px_minmax(0,1fr)]"><input id="crm_bp_business_agent" type="text" x-model="partner.business_agent" class="input-field attach-input" /></x-enterprise.field-row>
                    </div>
                </x-enterprise.panel>

                <x-enterprise.panel class="space-y-4">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Relationship Contacts</div>
                            <p class="mt-1 text-sm text-gray-500">Legacy contact context retained, but rendered as a structured enterprise table.</p>
                        </div>
                        <button type="button" class="btn-secondary px-3 py-1.5" @click="addContact()">Add Contact</button>
                    </div>

                    <x-enterprise.table-shell table-class="pending-base-table min-w-full" :datatable="false">
                        <x-slot name="thead">
                            <tr>
                                <th>Role</th>
                                <th>Name</th>
                                <th>E-Mail</th>
                                <th>Phone</th>
                                <th>Preferred</th>
                                <th></th>
                            </tr>
                        </x-slot>
                        <x-slot name="tbody">
                            <template x-for="row in contacts" :key="row.id">
                                <tr>
                                    <td><input type="text" x-model="row.role" class="input-field attach-input min-w-[150px]" /></td>
                                    <td><input type="text" x-model="row.name" class="input-field attach-input min-w-[180px]" /></td>
                                    <td><input type="email" x-model="row.email" class="input-field attach-input min-w-[220px]" /></td>
                                    <td><input type="text" x-model="row.phone" class="input-field attach-input min-w-[160px]" /></td>
                                    <td class="text-center"><input type="checkbox" x-model="row.preferred" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" /></td>
                                    <td><button type="button" class="btn-ghost px-3 py-1.5" @click="removeContact(row.id)">Remove</button></td>
                                </tr>
                            </template>
                        </x-slot>
                    </x-enterprise.table-shell>
                </x-enterprise.panel>
            </div>
        </div>

        <div x-cloak x-show="activeTab === 'payment-terms'" class="space-y-5">
            <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
                <x-enterprise.panel class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">Settlement Terms</div>

                    <div class="grid gap-4 xl:grid-cols-2">
                        <div class="space-y-3">
                            <x-enterprise.field-row label="Payment Terms" for="crm_bp_payment_terms" class="grid-cols-[160px_minmax(0,1fr)]">
                                <select id="crm_bp_payment_terms" x-model="partner.payment_terms" class="input-field attach-input">
                                    <option>30 Days Net</option>
                                    <option>45 Days Net</option>
                                    <option>60 Days Net</option>
                                    <option>Advance Payment</option>
                                </select>
                            </x-enterprise.field-row>
                            <x-enterprise.field-row label="Credit Limit" for="crm_bp_credit_limit" class="grid-cols-[160px_minmax(0,1fr)]"><input id="crm_bp_credit_limit" type="text" x-model="partner.credit_limit" class="input-field attach-input" /></x-enterprise.field-row>
                            <x-enterprise.field-row label="Statement Cycle" for="crm_bp_statement_cycle" class="grid-cols-[160px_minmax(0,1fr)]">
                                <select id="crm_bp_statement_cycle" x-model="partner.statement_cycle" class="input-field attach-input">
                                    <option>Monthly</option>
                                    <option>Bi-Weekly</option>
                                    <option>Quarterly</option>
                                </select>
                            </x-enterprise.field-row>
                        </div>

                        <div class="space-y-3">
                            <x-enterprise.field-row label="Payment Method" for="crm_bp_payment_method" class="grid-cols-[160px_minmax(0,1fr)]">
                                <select id="crm_bp_payment_method" x-model="partner.payment_method" class="input-field attach-input">
                                    <option>Bank Transfer</option>
                                    <option>Direct Debit</option>
                                    <option>Cheque</option>
                                </select>
                            </x-enterprise.field-row>
                            <x-enterprise.field-row label="Invoice Delivery" for="crm_bp_invoice_delivery" class="grid-cols-[160px_minmax(0,1fr)]">
                                <select id="crm_bp_invoice_delivery" x-model="partner.invoice_delivery" class="input-field attach-input">
                                    <option>E-Mail PDF</option>
                                    <option>Portal Upload</option>
                                    <option>Courier</option>
                                </select>
                            </x-enterprise.field-row>
                            <x-enterprise.field-row label="Dunning Level" for="crm_bp_dunning_level" class="grid-cols-[160px_minmax(0,1fr)]">
                                <select id="crm_bp_dunning_level" x-model="partner.dunning_level" class="input-field attach-input">
                                    <option>Standard</option>
                                    <option>Escalated</option>
                                    <option>Strict</option>
                                </select>
                            </x-enterprise.field-row>
                        </div>
                    </div>
                </x-enterprise.panel>

                <x-enterprise.panel muted class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">Controls</div>
                    <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.collection_authorization" /><span>Collection authorization available</span></label>
                    <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.payment_block" /><span>Payment block enabled</span></label>
                    <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.single_payment" /><span>Single payment only</span></label>
                    <div class="rounded-xl border border-gray-200 bg-white px-4 py-4 text-sm text-gray-600">Keep commercial payment terms in CRM aligned with the deeper accounting and bank execution setup carried over from the legacy master-data form.</div>
                </x-enterprise.panel>
            </div>
        </div>

        <div x-cloak x-show="activeTab === 'payment-run'" class="space-y-5">
            <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
                <x-enterprise.panel class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">Banking Details</div>

                    <div class="grid gap-4 xl:grid-cols-2">
                        <div class="space-y-3">
                            <x-enterprise.field-row label="Country" for="crm_bp_bank_country" class="grid-cols-[144px_minmax(0,1fr)]">
                                <select id="crm_bp_bank_country" x-model="partner.bank_country" class="input-field attach-input">
                                    <option>Malaysia</option>
                                    <option>Singapore</option>
                                    <option>Australia</option>
                                    <option>United States</option>
                                </select>
                            </x-enterprise.field-row>
                            <x-enterprise.field-row label="Bank" for="crm_bp_bank_name" class="grid-cols-[144px_minmax(0,1fr)]"><input id="crm_bp_bank_name" type="text" x-model="partner.bank_name" class="input-field attach-input" /></x-enterprise.field-row>
                            <x-enterprise.field-row label="Account No." for="crm_bp_bank_account" class="grid-cols-[144px_minmax(0,1fr)]"><input id="crm_bp_bank_account" type="text" x-model="partner.bank_account" class="input-field attach-input" /></x-enterprise.field-row>
                        </div>

                        <div class="space-y-3">
                            <x-enterprise.field-row label="Branch" for="crm_bp_bank_branch" class="grid-cols-[144px_minmax(0,1fr)]"><input id="crm_bp_bank_branch" type="text" x-model="partner.bank_branch" class="input-field attach-input" /></x-enterprise.field-row>
                            <x-enterprise.field-row label="IBAN" for="crm_bp_iban" class="grid-cols-[144px_minmax(0,1fr)]"><input id="crm_bp_iban" type="text" x-model="partner.iban" class="input-field attach-input" /></x-enterprise.field-row>
                            <x-enterprise.field-row label="BIC / SWIFT" for="crm_bp_bic_swift" class="grid-cols-[144px_minmax(0,1fr)]"><input id="crm_bp_bic_swift" type="text" x-model="partner.bic_swift" class="input-field attach-input" /></x-enterprise.field-row>
                        </div>
                    </div>

                    <x-enterprise.field-row label="Reference Details" for="crm_bp_reference_details" class="grid-cols-[144px_minmax(0,1fr)]"><input id="crm_bp_reference_details" type="text" x-model="partner.reference_details" class="input-field attach-input" /></x-enterprise.field-row>
                </x-enterprise.panel>

                <x-enterprise.panel muted class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">Execution Controls</div>
                    <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.payment_block" /><span>Payment block</span></label>
                    <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.single_payment" /><span>Single payment</span></label>
                    <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.collection_authorization" /><span>Collection authorization</span></label>
                    <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.auto_calc_bank_charge" /><span>Auto-calculate bank charge</span></label>
                </x-enterprise.panel>
            </div>
        </div>

        <div x-cloak x-show="activeTab === 'accounting'" class="space-y-5">
            <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
                <x-enterprise.panel class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">Accounting References</div>
                    <div class="space-y-3">
                        <x-enterprise.field-row label="Accounts Receivable" for="crm_bp_accounts_receivable" class="grid-cols-[208px_minmax(0,1fr)]"><input id="crm_bp_accounts_receivable" type="text" x-model="partner.accounts_receivable" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Down Payment Clearing" for="crm_bp_down_payment_clearing" class="grid-cols-[208px_minmax(0,1fr)]"><input id="crm_bp_down_payment_clearing" type="text" x-model="partner.down_payment_clearing" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Down Payment Interim" for="crm_bp_down_payment_interim" class="grid-cols-[208px_minmax(0,1fr)]"><input id="crm_bp_down_payment_interim" type="text" x-model="partner.down_payment_interim" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Connected Vendor" for="crm_bp_connected_vendor" class="grid-cols-[208px_minmax(0,1fr)]"><input id="crm_bp_connected_vendor" type="text" x-model="partner.connected_vendor" class="input-field attach-input" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Planning Group" for="crm_bp_planning_group" class="grid-cols-[208px_minmax(0,1fr)]"><input id="crm_bp_planning_group" type="text" x-model="partner.planning_group" class="input-field attach-input" /></x-enterprise.field-row>
                    </div>
                </x-enterprise.panel>

                <x-enterprise.panel muted class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">Tax & Consolidation</div>
                    <x-enterprise.field-row label="Tax Status" for="crm_bp_tax_status" class="grid-cols-[112px_minmax(0,1fr)]">
                        <select id="crm_bp_tax_status" x-model="partner.tax_status" class="input-field attach-input">
                            <option>Liable</option>
                            <option>Exempt</option>
                        </select>
                    </x-enterprise.field-row>
                    <x-enterprise.field-row label="Tax Group" for="crm_bp_tax_group" class="grid-cols-[112px_minmax(0,1fr)]"><input id="crm_bp_tax_group" type="text" x-model="partner.tax_group" class="input-field attach-input" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="Unified Tax ID" for="crm_bp_unified_federal_tax_id" class="grid-cols-[112px_minmax(0,1fr)]"><input id="crm_bp_unified_federal_tax_id" type="text" x-model="partner.unified_federal_tax_id" class="input-field attach-input" /></x-enterprise.field-row>
                    <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.deferred_tax" /><span>Deferred tax</span></label>
                    <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.affiliate" /><span>Affiliate account</span></label>
                </x-enterprise.panel>
            </div>
        </div>

        <div x-cloak x-show="activeTab === 'remarks'" class="space-y-5">
            <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_360px]">
                <div class="space-y-5">
                    <x-enterprise.panel class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Customer-Facing Remarks</div>
                        <textarea x-model="partner.remarks" rows="8" class="input-field attach-textarea min-h-[220px]"></textarea>
                    </x-enterprise.panel>
                    <x-enterprise.panel class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Internal Notes</div>
                        <textarea x-model="partner.internal_notes" rows="8" class="input-field attach-textarea min-h-[220px]"></textarea>
                    </x-enterprise.panel>
                </div>

                <div class="space-y-5">
                    <x-enterprise.panel class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Document Checklist</div>
                        <template x-for="row in documents" :key="row.id">
                            <label class="attach-checkbox-inline justify-between rounded-xl border border-gray-200 bg-gray-50/70 px-4 py-3">
                                <span x-text="row.label"></span>
                                <input type="checkbox" x-model="row.complete" />
                            </label>
                        </template>
                    </x-enterprise.panel>

                    <x-enterprise.panel class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Recent Activity</div>
                        <x-enterprise.table-shell table-class="pending-base-table min-w-full" :datatable="false">
                            <x-slot name="thead">
                                <tr>
                                    <th>Activity</th>
                                    <th>Owner</th>
                                    <th>Date</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                <template x-for="row in activities" :key="row.id">
                                    <tr>
                                        <td x-text="row.entry"></td>
                                        <td x-text="row.owner"></td>
                                        <td x-text="row.date"></td>
                                    </tr>
                                </template>
                            </x-slot>
                        </x-enterprise.table-shell>
                    </x-enterprise.panel>
                </div>
            </div>
        </div>

        <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
            <div class="flex flex-wrap items-center gap-3">
                <button type="button" class="btn-primary" @click="savePartner()">{{ $isEdit ? 'Update Preview' : 'Create Preview' }}</button>
                <button type="button" class="btn-secondary" @click="cancelPartner()">Cancel</button>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <span class="attach-field-label">Preview Route</span>
                <span class="font-semibold text-gray-900">{{ $isEdit ? route('crm.business-partner.edit', ['id' => $displayId]) : route('crm.business-partner.create') }}</span>
            </div>
        </x-enterprise.action-bar>
    </section>
</div>
@if ($isEdit)
</div>
@endif
