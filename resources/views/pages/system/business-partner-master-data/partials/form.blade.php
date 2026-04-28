@php
    $mode = $mode ?? 'create';
    $isEdit = $mode !== 'create';
    $startEditing = $mode === 'edit';
    $recordId = (int) ($recordId ?? request()->route('id') ?? 300028);

    $defaults = [
        'code' => $isEdit ? (string) $recordId : 'BP-DRAFT-260408',
        'name' => $isEdit ? '*WESTSTARr' : '',
        'foreign_name' => $isEdit ? 'Weststar Aviation Services Sdn. Bhd.' : '',
        'group' => 'Trade Debtor',
        'currency' => 'MYR',
        'bp_currency_mode' => 'BP Currency',
        'federal_tax_id' => $isEdit ? 'MY-441120-X' : '',
        'orders' => $isEdit ? '8' : '0',
        'opportunities' => $isEdit ? '3' : '0',
        'tel1' => $isEdit ? '+60 3-2771 8800' : '',
        'tel2' => $isEdit ? '+60 3-2771 8822' : '',
        'mobile_phone' => $isEdit ? '+60 12-884 9021' : '',
        'fax' => $isEdit ? '+60 3-2771 8899' : '',
        'email' => $isEdit ? 'ops@weststar.com.my' : '',
        'website' => $isEdit ? 'https://www.weststar.com.my' : '',
        'shipping_type' => 'Delivery by vendor',
        'password' => '',
        'factoring_indicator' => 'Standard',
        'bp_project' => $isEdit ? 'AW139 GOV' : '',
        'industry' => 'Aviation Services',
        'business_partner_type' => 'Company',
        'fleet_size' => $isEdit ? 'Large' : 'Medium',
        'alias_name' => $isEdit ? 'Weststar Aviation' : '',
        'contact_person' => $isEdit ? 'Ahmad Shahrul' : '',
        'id_no_2' => $isEdit ? 'OLD-778821' : '',
        'unified_federal_tax_id' => $isEdit ? 'MY-UNIFIED-9921' : '',
        'general_remarks' => $isEdit ? 'Priority support account with coordinated finance and service handling.' : '',
        'bp_channel_code' => $isEdit ? 'GOV-SVC' : '',
        'territory' => 'Malaysia',
        'branch_code' => $isEdit ? 'KUL-01' : '',
        'gln' => $isEdit ? '9556001234567' : '',
        'block_marketing_content' => $isEdit,
        'lifecycle_status' => 'active',
        'payment_terms' => '30 Days Net',
        'interest_on_arrears' => '0.0000',
        'price_list' => $isEdit ? 'Corporate Support' : '',
        'total_discount' => '0.0000',
        'credit_limit' => $isEdit ? '2500000.0000' : '0.0000',
        'commitment_limit' => '0.0000',
        'dunning_term' => 'Standard',
        'automatic_posting' => 'On Posting',
        'effective_discount_group' => $isEdit ? 'Lowest Discount' : '',
        'effective_price' => $isEdit ? 'Default Priority' : '',
        'credit_card_type' => $isEdit ? 'Corporate' : '',
        'credit_card_no' => $isEdit ? '**** 1044' : '',
        'expiration_date' => $isEdit ? '12/28' : '',
        'id_number' => $isEdit ? 'CC-88921' : '',
        'average_delay' => $isEdit ? '0' : '',
        'priority' => $isEdit ? 'High' : '',
        'default_iban' => $isEdit ? 'MY880120000514088219901' : '',
        'holidays' => 'Malaysia',
        'payment_dates' => $isEdit ? 'Month End' : '',
        'allow_partial_delivery_sales_order' => $isEdit,
        'allow_partial_delivery_per_row' => $isEdit,
        'do_not_apply_discount_groups' => false,
        'endorseable_checks_from_this_bp' => false,
        'accepts_endorsed_checks' => $isEdit,
        'bank_country' => 'Malaysia',
        'bank_name' => $isEdit ? 'Maybank Islamic' : '',
        'bank_code' => $isEdit ? 'MBBE' : '',
        'account' => $isEdit ? '514088219901' : '',
        'bic_swift_code' => $isEdit ? 'MBBEMYKL' : '',
        'bank_account_name' => $isEdit ? 'Weststar Aviation Services' : '',
        'branch' => $isEdit ? 'Kuala Lumpur Main' : '',
        'ctrl_int_id' => $isEdit ? 'CTRL-11' : '',
        'iban' => $isEdit ? 'MY880120000514088219901' : '',
        'mandate_id' => $isEdit ? 'MDT-440028' : '',
        'date_of_signature' => $isEdit ? '2026-01-10' : '',
        'house_bank_country' => 'Malaysia',
        'house_bank_bank' => $isEdit ? 'Maybank' : '',
        'house_bank_account' => $isEdit ? 'Primary MYR' : '',
        'house_bank_branch' => $isEdit ? 'KL Main' : '',
        'house_bank_iban' => $isEdit ? 'MY880120000514088219901' : '',
        'house_bank_bic_swift' => $isEdit ? 'MBBEMYKL' : '',
        'house_bank_control_no' => $isEdit ? 'HB-8890' : '',
        'reference_details' => $isEdit ? 'Service contract milestone billing' : '',
        'payment_block' => false,
        'single_payment' => false,
        'collection_authorization' => $isEdit,
        'bank_charges_allocation_code' => $isEdit ? 'SHA' : '',
        'consolidating_bp' => $isEdit ? 'WEST-HQ' : '',
        'payment_consolidation' => $isEdit,
        'delivery_consolidation' => false,
        'accounts_receivable' => $isEdit ? 'AR-100200' : '',
        'down_payment_clearing' => $isEdit ? 'DP-220110' : '',
        'down_payment_interim' => $isEdit ? 'DPI-220114' : '',
        'planning_group' => $isEdit ? 'Rotorcraft Support' : '',
        'affiliate' => $isEdit,
        'tax_status' => 'Liable',
        'tax_group' => $isEdit ? 'SR-6' : '',
        'deferred_tax' => false,
        'remarks' => $isEdit ? 'Business partner remarks remain visible for commercial, support, and finance coordination.' : '',
    ];

    $partner = $defaults;
    $humanResources = $isEdit
        ? [
            ['row' => 1, 'employee_no' => '76', 'first_name' => 'AB FAUZAN', 'last_name' => 'BIN AB KARIM', 'role' => 'Primary Contact'],
            ['row' => 2, 'employee_no' => '114', 'first_name' => 'AINA', 'last_name' => 'MOHD NOOR', 'role' => 'Finance'],
        ]
        : [['row' => 1, 'employee_no' => '', 'first_name' => '', 'last_name' => '', 'role' => 'Primary Contact']];
    $bpLinks = $isEdit
        ? [
            ['code' => 'BP-00912', 'name' => 'Northport Rotary Leasing', 'type' => 'Linked Vendor'],
            ['code' => 'BP-00418', 'name' => 'Weststar Shared Services', 'type' => 'Consolidating BP'],
        ]
        : [['code' => '', 'name' => '', 'type' => 'Linked Vendor']];

    $pageTitle = match ($mode) {
        'edit'  => 'Edit Business Partner Master Data',
        'show'  => 'Business Partner Master Data',
        default => 'Create Business Partner Master Data',
    };
    $pageDescription = match ($mode) {
        'edit'  => 'Maintain the legacy business partner master-data structure using the same modern enterprise workspace pattern already used in newer ATP modules.',
        'show'  => 'Read-only detail card for the selected business partner. Click Edit Record to make changes.',
        default => 'Create a new business partner master-data record using the established modern enterprise form design already used elsewhere in ATP 3.0.',
    };
    $saveMessage = $isEdit ? 'Business partner master data preview updated.' : 'Business partner master data draft prepared.';
    $cancelMessage = $isEdit ? 'Preview changes cancelled for this business partner.' : 'Draft changes cleared for this preview session.';
    $inputClass = 'input-field attach-input';
    $readOnlyClass = 'input-field attach-input input-field-filled';
    $lookupButtonClass = 'inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-500 shadow-sm transition hover:border-[#9fb2ff] hover:text-[#2f5bff] focus:outline-none focus:ring-4 focus:ring-[#2f5bff]/10';
@endphp

@if ($isEdit)
<div x-data="editMode({{ $startEditing ? 'true' : 'false' }})" data-edit-scope x-bind:data-editing="editing ? 'true' : 'false'">
@endif
<div
    class="space-y-6"
    x-data="{
        activeTab: 'general',
        accountingTab: 'general',
        statusMessage: '',
        partner: @js($partner),
        humanResources: @js($humanResources),
        bpLinks: @js($bpLinks),
        saveMessage: @js($saveMessage),
        cancelMessage: @js($cancelMessage),
        savePartner() { this.statusMessage = this.saveMessage; },
        cancelPartner() { this.statusMessage = this.cancelMessage; },
    }"
>
    <x-page-header :title="$pageTitle" :description="$pageDescription">
        <x-slot name="actions">
            <a href="{{ route('system.business-partner-master-data.index') }}" class="btn-secondary">
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
            @endif
        </x-slot>
    </x-page-header>

    <section class="attach-workspace-shell max-w-[1380px] space-y-5">
        <template x-if="statusMessage">
            <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
        </template>

        <x-enterprise.panel muted class="space-y-5">
            <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
                <div class="grid gap-3">
                    <x-enterprise.field-row label="Code" for="bp_code" class="grid-cols-[156px_minmax(0,1fr)]"><input id="bp_code" type="text" x-model="partner.code" class="{{ $readOnlyClass }}" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="Name" for="bp_name" class="grid-cols-[156px_minmax(0,1fr)]"><input id="bp_name" type="text" x-model="partner.name" class="{{ $inputClass }}" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="Foreign Name" for="bp_foreign_name" class="grid-cols-[156px_minmax(0,1fr)]"><input id="bp_foreign_name" type="text" x-model="partner.foreign_name" class="{{ $inputClass }}" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="Group" for="bp_group" class="grid-cols-[156px_minmax(0,1fr)]"><select id="bp_group" x-model="partner.group" class="{{ $inputClass }}"><option>Trade Debtor</option><option>Trade Creditor</option><option>Lead</option></select></x-enterprise.field-row>
                    <x-enterprise.field-row label="Currency" for="bp_currency" class="grid-cols-[156px_minmax(0,1fr)]"><select id="bp_currency" x-model="partner.currency" class="{{ $inputClass }}"><option>MYR</option><option>USD</option><option>EUR</option><option>SGD</option></select></x-enterprise.field-row>
                    <x-enterprise.field-row label="Federal Tax ID" for="bp_federal_tax_id" class="grid-cols-[156px_minmax(0,1fr)]"><input id="bp_federal_tax_id" type="text" x-model="partner.federal_tax_id" class="{{ $inputClass }}" /></x-enterprise.field-row>
                </div>

                <div class="space-y-3">
                    <x-enterprise.field-row label="BP Currency" for="bp_currency_mode" class="grid-cols-[124px_minmax(0,1fr)]"><select id="bp_currency_mode" x-model="partner.bp_currency_mode" class="{{ $inputClass }}"><option>BP Currency</option><option>Local Currency</option><option>System Currency</option></select></x-enterprise.field-row>
                    <x-enterprise.field-row label="Orders" for="bp_orders" class="grid-cols-[124px_minmax(0,1fr)]"><input id="bp_orders" type="text" x-model="partner.orders" class="{{ $readOnlyClass }}" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="Opportunities" for="bp_opportunities" class="grid-cols-[124px_minmax(0,1fr)]"><input id="bp_opportunities" type="text" x-model="partner.opportunities" class="{{ $readOnlyClass }}" /></x-enterprise.field-row>
                </div>
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

        <div x-cloak x-show="activeTab === 'general'">
            <x-enterprise.panel class="space-y-6">
                <div class="grid gap-6 xl:grid-cols-2">
                    <div class="space-y-3">
                        <x-enterprise.field-row label="Tel 1" for="bp_tel1" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_tel1" type="text" x-model="partner.tel1" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Tel 2" for="bp_tel2" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_tel2" type="text" x-model="partner.tel2" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Mobile Phone" for="bp_mobile_phone" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_mobile_phone" type="text" x-model="partner.mobile_phone" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Fax" for="bp_fax" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_fax" type="text" x-model="partner.fax" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="E-Mail" for="bp_email" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_email" type="email" x-model="partner.email" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Web Site" for="bp_website" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_website" type="text" x-model="partner.website" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Shipping Type" for="bp_shipping_type" class="grid-cols-[176px_minmax(0,1fr)]"><select id="bp_shipping_type" x-model="partner.shipping_type" class="{{ $inputClass }}"><option>Delivery by vendor</option><option>Air Freight</option><option>Sea Freight</option><option>Self Collection</option></select></x-enterprise.field-row>
                        <x-enterprise.field-row label="Password" for="bp_password" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_password" type="password" x-model="partner.password" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Factoring Indicator" for="bp_factoring_indicator" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_factoring_indicator" type="text" x-model="partner.factoring_indicator" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="BP Project" for="bp_project" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_project" type="text" x-model="partner.bp_project" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Industry" for="bp_industry" class="grid-cols-[176px_minmax(0,1fr)]"><select id="bp_industry" x-model="partner.industry" class="{{ $inputClass }}"><option>Aviation Services</option><option>Government Operations</option><option>Logistics</option></select></x-enterprise.field-row>
                        <x-enterprise.field-row label="Business Partner Type" for="bp_business_partner_type" class="grid-cols-[176px_minmax(0,1fr)]"><select id="bp_business_partner_type" x-model="partner.business_partner_type" class="{{ $inputClass }}"><option>Company</option><option>Private</option><option>Employee</option></select></x-enterprise.field-row>
                        <x-enterprise.field-row label="Fleet size" for="bp_fleet_size" class="grid-cols-[176px_minmax(0,1fr)]"><select id="bp_fleet_size" x-model="partner.fleet_size" class="{{ $inputClass }}"><option>Small</option><option>Medium</option><option>Large</option></select></x-enterprise.field-row>
                    </div>

                    <div class="space-y-3">
                        <x-enterprise.field-row label="Contact Person" for="bp_contact_person" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_contact_person" type="text" x-model="partner.contact_person" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="ID No. 2" for="bp_id_no_2" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_id_no_2" type="text" x-model="partner.id_no_2" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Unified Federal Tax ID" for="bp_unified_federal_tax_id" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_unified_federal_tax_id" type="text" x-model="partner.unified_federal_tax_id" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Remarks" for="bp_general_remarks" class="grid-cols-[176px_minmax(0,1fr)]"><textarea id="bp_general_remarks" x-model="partner.general_remarks" rows="4" class="input-field attach-textarea min-h-[116px]"></textarea></x-enterprise.field-row>
                        <x-enterprise.field-row label="BP Channel Code" for="bp_channel_code" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_channel_code" type="text" x-model="partner.bp_channel_code" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Territory" for="bp_territory" class="grid-cols-[176px_minmax(0,1fr)]"><select id="bp_territory" x-model="partner.territory" class="{{ $inputClass }}"><option>Malaysia</option><option>Singapore</option><option>Australia</option></select></x-enterprise.field-row>
                        <x-enterprise.field-row label="Branch code" for="bp_branch_code" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_branch_code" type="text" x-model="partner.branch_code" class="{{ $inputClass }}" /></x-enterprise.field-row>
                    </div>
                </div>

                <div class="grid gap-6 xl:grid-cols-2">
                    <x-enterprise.field-row label="Alias Name" for="bp_alias_name" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_alias_name" type="text" x-model="partner.alias_name" class="{{ $inputClass }}" /></x-enterprise.field-row>
                    <x-enterprise.field-row label="GLN" for="bp_gln" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_gln" type="text" x-model="partner.gln" class="{{ $inputClass }}" /></x-enterprise.field-row>
                </div>

                <div class="grid gap-6 xl:grid-cols-[220px_minmax(0,1fr)]">
                    <div class="space-y-3 rounded-xl border border-gray-200 bg-gray-50/70 p-4">
                        <div class="attach-field-label">Status</div>
                        <label class="attach-checkbox-inline"><input type="radio" value="active" x-model="partner.lifecycle_status" /><span>Active</span></label>
                        <label class="attach-checkbox-inline"><input type="radio" value="inactive" x-model="partner.lifecycle_status" /><span>Inactive</span></label>
                        <label class="attach-checkbox-inline"><input type="radio" value="advanced" x-model="partner.lifecycle_status" /><span>Advanced</span></label>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-gray-50/70 p-4">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <label class="attach-checkbox-inline">
                                <input type="checkbox" x-model="partner.block_marketing_content" />
                                <span>Block Sending Marketing Content</span>
                            </label>
                            <button type="button" class="{{ $lookupButtonClass }}">...</button>
                        </div>
                    </div>
                </div>
            </x-enterprise.panel>
        </div>

        <div x-cloak x-show="activeTab === 'ba-bp'">
            <x-enterprise.panel class="space-y-5">
                <div class="grid gap-5 xl:grid-cols-2">
                    <div class="space-y-3">
                        <div class="text-sm font-semibold text-gray-900">Human Resources</div>
                        <x-enterprise.table-shell table-class="pending-base-table min-w-full" :datatable="false">
                            <x-slot name="thead">
                                <tr>
                                    <th>#</th>
                                    <th>Empl. No.</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Role</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                <template x-for="row in humanResources" :key="row.row">
                                    <tr>
                                        <td x-text="row.row"></td>
                                        <td x-text="row.employee_no || '-'"></td>
                                        <td x-text="row.first_name || '-'"></td>
                                        <td x-text="row.last_name || '-'"></td>
                                        <td x-text="row.role || '-'"></td>
                                    </tr>
                                </template>
                            </x-slot>
                        </x-enterprise.table-shell>
                    </div>

                    <div class="space-y-3">
                        <div class="text-sm font-semibold text-gray-900">BP Links</div>
                        <x-enterprise.table-shell table-class="pending-base-table min-w-full" :datatable="false">
                            <x-slot name="thead">
                                <tr>
                                    <th>BP Code</th>
                                    <th>BP Name</th>
                                    <th>Link Type</th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                <template x-for="row in bpLinks" :key="`${row.code}-${row.type}`">
                                    <tr>
                                        <td x-text="row.code || '-'"></td>
                                        <td x-text="row.name || '-'"></td>
                                        <td x-text="row.type || '-'"></td>
                                    </tr>
                                </template>
                            </x-slot>
                        </x-enterprise.table-shell>
                    </div>
                </div>
            </x-enterprise.panel>
        </div>

        <div x-cloak x-show="activeTab === 'payment-terms'">
            <x-enterprise.panel class="space-y-6">
                <div class="grid gap-6 xl:grid-cols-2">
                    <div class="space-y-3">
                        <x-enterprise.field-row label="Payment Terms" for="bp_payment_terms" class="grid-cols-[176px_minmax(0,1fr)]"><select id="bp_payment_terms" x-model="partner.payment_terms" class="{{ $inputClass }}"><option>30 Days Net</option><option>45 Days Net</option><option>Advance Payment</option></select></x-enterprise.field-row>
                        <x-enterprise.field-row label="Interest on Arrears %" for="bp_interest_on_arrears" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_interest_on_arrears" type="text" x-model="partner.interest_on_arrears" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Price List" for="bp_price_list" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_price_list" type="text" x-model="partner.price_list" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Total Discount %" for="bp_total_discount" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_total_discount" type="text" x-model="partner.total_discount" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Credit Limit" for="bp_credit_limit" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_credit_limit" type="text" x-model="partner.credit_limit" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Commitment Limit" for="bp_commitment_limit" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_commitment_limit" type="text" x-model="partner.commitment_limit" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Dunning Term" for="bp_dunning_term" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_dunning_term" type="text" x-model="partner.dunning_term" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Automatic Posting" for="bp_automatic_posting" class="grid-cols-[176px_minmax(0,1fr)]"><div class="flex items-center gap-2"><input id="bp_automatic_posting" type="text" x-model="partner.automatic_posting" class="{{ $inputClass }} flex-1" /><button type="button" class="{{ $lookupButtonClass }}">...</button></div></x-enterprise.field-row>
                        <x-enterprise.field-row label="Effective Discount Groups" for="bp_effective_discount_group" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_effective_discount_group" type="text" x-model="partner.effective_discount_group" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Effective Price" for="bp_effective_price" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_effective_price" type="text" x-model="partner.effective_price" class="{{ $inputClass }}" /></x-enterprise.field-row>
                    </div>

                    <div class="space-y-3">
                        <x-enterprise.field-row label="Credit Card Type" for="bp_credit_card_type" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_credit_card_type" type="text" x-model="partner.credit_card_type" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Credit Card No." for="bp_credit_card_no" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_credit_card_no" type="text" x-model="partner.credit_card_no" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Expiration Date" for="bp_expiration_date" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_expiration_date" type="text" x-model="partner.expiration_date" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="ID Number" for="bp_id_number" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_id_number" type="text" x-model="partner.id_number" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Average Delay" for="bp_average_delay" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_average_delay" type="text" x-model="partner.average_delay" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Priority" for="bp_priority" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_priority" type="text" x-model="partner.priority" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Default IBAN" for="bp_default_iban" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_default_iban" type="text" x-model="partner.default_iban" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Holidays" for="bp_holidays" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_holidays" type="text" x-model="partner.holidays" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Payment Dates" for="bp_payment_dates" class="grid-cols-[176px_minmax(0,1fr)]"><div class="flex items-center gap-2"><input id="bp_payment_dates" type="text" x-model="partner.payment_dates" class="{{ $inputClass }} flex-1" /><button type="button" class="{{ $lookupButtonClass }}">...</button></div></x-enterprise.field-row>
                    </div>
                </div>

                <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
                    <div class="space-y-3">
                        <div class="text-sm font-semibold text-gray-900">Business Partner Bank</div>
                        <x-enterprise.field-row label="Bank Country" for="bp_bank_country" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_bank_country" type="text" x-model="partner.bank_country" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Bank Name" for="bp_bank_name" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_bank_name" type="text" x-model="partner.bank_name" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Bank Code" for="bp_bank_code" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_bank_code" type="text" x-model="partner.bank_code" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Account" for="bp_account" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_account" type="text" x-model="partner.account" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="BIC/SWIFT Code" for="bp_bic_swift_code" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_bic_swift_code" type="text" x-model="partner.bic_swift_code" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Bank Account Name" for="bp_bank_account_name" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_bank_account_name" type="text" x-model="partner.bank_account_name" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Branch" for="bp_branch" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_branch" type="text" x-model="partner.branch" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Ctrl Int. ID" for="bp_ctrl_int_id" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_ctrl_int_id" type="text" x-model="partner.ctrl_int_id" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="IBAN" for="bp_iban" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_iban" type="text" x-model="partner.iban" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Mandate ID" for="bp_mandate_id" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_mandate_id" type="text" x-model="partner.mandate_id" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Date of Signature" for="bp_date_of_signature" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_date_of_signature" type="text" x-model="partner.date_of_signature" class="{{ $inputClass }}" /></x-enterprise.field-row>
                    </div>

                    <div class="space-y-3 rounded-xl border border-gray-200 bg-gray-50/70 p-4">
                        <div class="text-sm font-semibold text-gray-900">Controls</div>
                        <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.allow_partial_delivery_sales_order" /><span>Allow Partial Delivery of Sales Order</span></label>
                        <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.allow_partial_delivery_per_row" /><span>Allow Partial Delivery per Row</span></label>
                        <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.do_not_apply_discount_groups" /><span>Do Not Apply Discount Groups</span></label>
                        <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.endorseable_checks_from_this_bp" /><span>Endorsable Checks from This BP</span></label>
                        <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.accepts_endorsed_checks" /><span>This BP Accepts Endorsed Checks</span></label>
                    </div>
                </div>
            </x-enterprise.panel>
        </div>

        <div x-cloak x-show="activeTab === 'payment-run'">
            <x-enterprise.panel class="space-y-6">
                <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
                    <div class="space-y-3">
                        <div class="text-sm font-semibold text-gray-900">House Bank</div>
                        <x-enterprise.field-row label="Country" for="bp_house_bank_country" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_house_bank_country" type="text" x-model="partner.house_bank_country" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Bank" for="bp_house_bank_bank" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_house_bank_bank" type="text" x-model="partner.house_bank_bank" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Account" for="bp_house_bank_account" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_house_bank_account" type="text" x-model="partner.house_bank_account" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Branch" for="bp_house_bank_branch" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_house_bank_branch" type="text" x-model="partner.house_bank_branch" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="IBAN" for="bp_house_bank_iban" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_house_bank_iban" type="text" x-model="partner.house_bank_iban" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="BIC/SWIFT Code" for="bp_house_bank_bic_swift" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_house_bank_bic_swift" type="text" x-model="partner.house_bank_bic_swift" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Control No." for="bp_house_bank_control_no" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_house_bank_control_no" type="text" x-model="partner.house_bank_control_no" class="{{ $inputClass }}" /></x-enterprise.field-row>
                    </div>

                    <div class="space-y-3 rounded-xl border border-gray-200 bg-gray-50/70 p-4">
                        <div class="text-sm font-semibold text-gray-900">Reference Details</div>
                        <input type="text" x-model="partner.reference_details" class="{{ $inputClass }}" />
                        <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.payment_block" /><span>Payment Block</span></label>
                        <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.single_payment" /><span>Single Payment</span></label>
                        <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.collection_authorization" /><span>Collection Authorization</span></label>
                        <x-enterprise.field-row label="Bank Charges Allocation Code" for="bp_bank_charges_allocation_code" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_bank_charges_allocation_code" type="text" x-model="partner.bank_charges_allocation_code" class="{{ $inputClass }}" /></x-enterprise.field-row>
                    </div>
                </div>
            </x-enterprise.panel>
        </div>

        <div x-cloak x-show="activeTab === 'accounting'">
            <x-enterprise.panel class="space-y-5">
                <div class="subtab-shell">
                    <ul class="subtab-list">
                        <li class="subtab-item"><button type="button" class="subtab-link" :class="accountingTab === 'general' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="accountingTab = 'general'">General</button></li>
                        <li class="subtab-item"><button type="button" class="subtab-link" :class="accountingTab === 'tax' ? 'subtab-link-active' : 'subtab-link-inactive'" @click="accountingTab = 'tax'">Tax</button></li>
                    </ul>
                </div>

                <div x-cloak x-show="accountingTab === 'general'" class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
                    <div class="space-y-3">
                        <x-enterprise.field-row label="Consolidating BP" for="bp_consolidating_bp" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_consolidating_bp" type="text" x-model="partner.consolidating_bp" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Accounts Receivable" for="bp_accounts_receivable" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_accounts_receivable" type="text" x-model="partner.accounts_receivable" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Down Payment Clearing Account" for="bp_down_payment_clearing" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_down_payment_clearing" type="text" x-model="partner.down_payment_clearing" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Down Payment Interim Account" for="bp_down_payment_interim" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_down_payment_interim" type="text" x-model="partner.down_payment_interim" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Planning Group" for="bp_planning_group" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_planning_group" type="text" x-model="partner.planning_group" class="{{ $inputClass }}" /></x-enterprise.field-row>
                    </div>

                    <div class="space-y-3 rounded-xl border border-gray-200 bg-gray-50/70 p-4">
                        <div class="text-sm font-semibold text-gray-900">Consolidation</div>
                        <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.payment_consolidation" /><span>Payment Consolidation</span></label>
                        <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.delivery_consolidation" /><span>Delivery Consolidation</span></label>
                        <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.affiliate" /><span>Affiliate</span></label>
                    </div>
                </div>

                <div x-cloak x-show="accountingTab === 'tax'" class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
                    <div class="space-y-3">
                        <x-enterprise.field-row label="Tax Status" for="bp_tax_status" class="grid-cols-[176px_minmax(0,1fr)]"><select id="bp_tax_status" x-model="partner.tax_status" class="{{ $inputClass }}"><option>Liable</option><option>Exempt</option></select></x-enterprise.field-row>
                        <x-enterprise.field-row label="Tax Group" for="bp_tax_group" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_tax_group" type="text" x-model="partner.tax_group" class="{{ $inputClass }}" /></x-enterprise.field-row>
                        <x-enterprise.field-row label="Unified Federal Tax ID" for="bp_tax_unified_federal_tax_id" class="grid-cols-[176px_minmax(0,1fr)]"><input id="bp_tax_unified_federal_tax_id" type="text" x-model="partner.unified_federal_tax_id" class="{{ $inputClass }}" /></x-enterprise.field-row>
                    </div>

                    <div class="space-y-3 rounded-xl border border-gray-200 bg-gray-50/70 p-4">
                        <div class="text-sm font-semibold text-gray-900">Tax Controls</div>
                        <label class="attach-checkbox-inline"><input type="checkbox" x-model="partner.deferred_tax" /><span>Deferred Tax</span></label>
                    </div>
                </div>
            </x-enterprise.panel>
        </div>

        <div x-cloak x-show="activeTab === 'remarks'">
            <x-enterprise.panel class="space-y-4">
                <div class="text-sm font-semibold text-gray-900">Remarks</div>
                <textarea x-model="partner.remarks" rows="14" class="input-field attach-textarea min-h-[360px]"></textarea>
            </x-enterprise.panel>
        </div>

        <x-enterprise.action-bar class="border-t border-gray-200 pt-5">
            <button type="button" class="btn-primary" @click="savePartner()">{{ $isEdit ? 'Update Preview' : 'Create Preview' }}</button>
            <button type="button" class="btn-secondary" @click="cancelPartner()">Cancel</button>
        </x-enterprise.action-bar>
    </section>
</div>
@if ($isEdit)
</div>
@endif
