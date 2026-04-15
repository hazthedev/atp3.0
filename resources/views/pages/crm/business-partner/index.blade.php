@extends('layouts.app')

@section('title', 'Business Partner')

@php
    $partners = [
        ['id' => 1284, 'code' => 'BP-001284', 'name' => 'Weststar Aviation Services', 'bp_group' => 'Trade Debtor', 'contact_person' => 'Ahmad Shahrul', 'telephone' => '+60 12-884 9021', 'email' => 'ahmad.shahrul@weststar.com.my', 'type' => 'Customer', 'status' => 'Active', 'territory' => 'Malaysia', 'currency' => 'MYR', 'owner' => 'Customer Support', 'payment_terms' => '30 Days Net', 'receivable_balance' => 'MYR 1.24M', 'credit_limit' => 'MYR 2.50M', 'open_activities' => 4, 'active_contracts' => 3, 'last_touch' => '2026-04-07', 'service_level' => 'Premium Support', 'next_review' => '2026-04-22', 'summary' => 'Primary rotorcraft service account covering contract support, logistics follow-up, and reliability review.', 'edit_url' => route('crm.business-partner.edit', ['id' => 1284])],
        ['id' => 1321, 'code' => 'BP-001321', 'name' => 'MHS Aviation Berhad', 'bp_group' => 'Trade Debtor', 'contact_person' => 'Siti Aisyah Omar', 'telephone' => '+60 19-611 4082', 'email' => 'siti.aisyah@mhsaviation.com', 'type' => 'Customer', 'status' => 'Active', 'territory' => 'Malaysia', 'currency' => 'MYR', 'owner' => 'Regional Sales', 'payment_terms' => '45 Days Net', 'receivable_balance' => 'MYR 860K', 'credit_limit' => 'MYR 1.80M', 'open_activities' => 2, 'active_contracts' => 2, 'last_touch' => '2026-04-06', 'service_level' => 'Line Support', 'next_review' => '2026-04-18', 'summary' => 'Domestic operator account with active line-support scope and recurring planning coordination.', 'edit_url' => route('crm.business-partner.edit', ['id' => 1321])],
        ['id' => 1155, 'code' => 'BP-001155', 'name' => 'Aero One Services Pte. Ltd.', 'bp_group' => 'Trade Creditor', 'contact_person' => 'Nadiah Rahman', 'telephone' => '+65 8122 4088', 'email' => 'nadiah.rahman@aeroone.com', 'type' => 'Vendor', 'status' => 'Onboarding', 'territory' => 'Singapore', 'currency' => 'USD', 'owner' => 'Supply Chain', 'payment_terms' => '30 Days Net', 'receivable_balance' => 'N/A', 'credit_limit' => 'Vendor Managed', 'open_activities' => 2, 'active_contracts' => 1, 'last_touch' => '2026-04-05', 'service_level' => 'Component Exchange', 'next_review' => '2026-04-15', 'summary' => 'Regional component vendor under onboarding review for AW139 and AW189 exchange support.', 'edit_url' => route('crm.business-partner.edit', ['id' => 1155])],
        ['id' => 882, 'code' => 'BP-000882', 'name' => 'Heli Support APAC', 'bp_group' => 'Prospect', 'contact_person' => 'Marco Bellini', 'telephone' => '+61 412 884 201', 'email' => 'marco.bellini@helisupport-apac.com', 'type' => 'Lead', 'status' => 'Prospect', 'territory' => 'Australia', 'currency' => 'AUD', 'owner' => 'Sales', 'payment_terms' => 'To Be Agreed', 'receivable_balance' => 'N/A', 'credit_limit' => 'Pending Qualification', 'open_activities' => 5, 'active_contracts' => 0, 'last_touch' => '2026-04-04', 'service_level' => 'Proposal Stage', 'next_review' => '2026-04-12', 'summary' => 'Prospective service account evaluating campaign support, line maintenance, and MRO escalation coverage.', 'edit_url' => route('crm.business-partner.edit', ['id' => 882])],
        ['id' => 1541, 'code' => 'BP-001541', 'name' => 'SkyReach Government Division', 'bp_group' => 'Government Account', 'contact_person' => 'Lt. Col. Faiz Hassan', 'telephone' => '+60 17-220 9014', 'email' => 'faiz.hassan@skyreach.gov.my', 'type' => 'Customer', 'status' => 'Active', 'territory' => 'Malaysia', 'currency' => 'MYR', 'owner' => 'Government Programs', 'payment_terms' => '60 Days Net', 'receivable_balance' => 'MYR 3.10M', 'credit_limit' => 'MYR 5.00M', 'open_activities' => 7, 'active_contracts' => 2, 'last_touch' => '2026-04-08', 'service_level' => 'Mission Critical', 'next_review' => '2026-04-10', 'summary' => 'High-priority government operator with active fleet readiness commitments and elevated escalation handling.', 'edit_url' => route('crm.business-partner.edit', ['id' => 1541])],
        ['id' => 1663, 'code' => 'BP-001663', 'name' => 'Northport Rotary Leasing', 'bp_group' => 'Leasing Partner', 'contact_person' => 'Aina Mohd Noor', 'telephone' => '+62 811 4800 225', 'email' => 'aina.noor@northportrotary.com', 'type' => 'Vendor', 'status' => 'Active', 'territory' => 'Indonesia', 'currency' => 'USD', 'owner' => 'Commercial', 'payment_terms' => 'Advance Payment', 'receivable_balance' => 'N/A', 'credit_limit' => 'Leasing Schedule', 'open_activities' => 1, 'active_contracts' => 2, 'last_touch' => '2026-04-02', 'service_level' => 'Lease Support', 'next_review' => '2026-04-26', 'summary' => 'Leasing partner supporting standby aircraft swaps and short-term fleet availability planning.', 'edit_url' => route('crm.business-partner.edit', ['id' => 1663])],
    ];

    $activeCount = collect($partners)->where('status', 'Active')->count();
    $reviewCount = collect($partners)->whereIn('status', ['Onboarding', 'Prospect'])->count();
    $contractCount = collect($partners)->sum('active_contracts');
    $activityCount = collect($partners)->sum('open_activities');
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            statusMessage: '',
            query: '',
            type: '',
            status: '',
            selectedId: {{ $partners[0]['id'] }},
            rows: @js($partners),
            filteredRows() {
                const query = this.query.trim().toLowerCase();
                return this.rows.filter((row) => {
                    const matchesQuery = !query || [row.code, row.name, row.bp_group, row.contact_person, row.email, row.owner, row.territory, row.payment_terms].join(' ').toLowerCase().includes(query);
                    const matchesType = !this.type || row.type === this.type;
                    const matchesStatus = !this.status || row.status === this.status;
                    return matchesQuery && matchesType && matchesStatus;
                });
            },
            selectedPartner() {
                const rows = this.filteredRows();
                if (!rows.length) return null;
                return rows.find((row) => row.id === this.selectedId) || rows[0];
            },
            selectPartner(id) {
                this.selectedId = id;
            },
            refreshRows() {
                this.statusMessage = `Loaded ${this.filteredRows().length} business partner record(s).`;
            },
            clearFilters() {
                this.query = '';
                this.type = '';
                this.status = '';
                this.statusMessage = 'Business partner filters reset.';
            },
        }"
    >
        <x-page-header title="Business Partner" description="Review customers, vendors, and prospective accounts using the current ATP CRM workspace pattern, while carrying forward the legacy business-partner portfolio structure.">
            <x-slot name="actions">
                <a href="{{ route('crm.business-partner.create') }}" class="btn-primary">
                    <x-icon name="plus" class="h-4 w-4" />
                    New Business Partner
                </a>
                <a href="{{ route('system.business-partner-master-data.index') }}" class="btn-secondary">
                    <x-icon name="document-text" class="h-4 w-4" />
                    Master Data
                </a>
            </x-slot>
        </x-page-header>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <x-stat-card label="Portfolio Accounts" :value="count($partners)" trend="CRM portfolio in current scope" icon="briefcase" />
            <x-stat-card label="Active Relationships" :value="$activeCount" trend="Operationally engaged partners" icon="check-circle" />
            <x-stat-card label="Open Activities" :value="$activityCount" trend="Service and commercial follow-up" icon="clock" trend-color="text-amber-600" />
            <x-stat-card label="Active Contracts" :value="$contractCount" trend="Linked contract records in preview" icon="clipboard-document-list" />
        </div>

        <section class="attach-workspace-shell space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_340px]">
                <div class="space-y-5">
                    <x-enterprise.panel muted class="space-y-4">
                        <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_180px_180px_auto] xl:items-end">
                            <x-enterprise.control-row label="Search" for="crm_bp_search" columns="xl:grid-cols-[72px_minmax(0,1fr)]">
                                <input id="crm_bp_search" type="search" x-model="query" class="input-field attach-input" placeholder="Search code, partner, contact, group, or terms" />
                            </x-enterprise.control-row>
                            <x-enterprise.control-row label="Type" for="crm_bp_type" columns="xl:grid-cols-[56px_minmax(0,1fr)]">
                                <select id="crm_bp_type" x-model="type" class="input-field attach-input">
                                    <option value="">All Types</option>
                                    <option value="Customer">Customer</option>
                                    <option value="Vendor">Vendor</option>
                                    <option value="Lead">Lead</option>
                                </select>
                            </x-enterprise.control-row>
                            <x-enterprise.control-row label="Status" for="crm_bp_status" columns="xl:grid-cols-[64px_minmax(0,1fr)]">
                                <select id="crm_bp_status" x-model="status" class="input-field attach-input">
                                    <option value="">All Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Onboarding">Onboarding</option>
                                    <option value="Prospect">Prospect</option>
                                </select>
                            </x-enterprise.control-row>
                            <div class="flex flex-wrap items-center gap-3 xl:justify-end">
                                <button type="button" class="btn-secondary" @click="refreshRows()">Refresh</button>
                                <button type="button" class="btn-ghost" @click="clearFilters()">Clear</button>
                            </div>
                        </div>
                    </x-enterprise.panel>

                    <x-enterprise.panel class="space-y-4">
                        <div class="flex flex-col gap-3 border-b border-gray-200 pb-4 md:flex-row md:items-center md:justify-between">
                            <div>
                                <div class="text-sm font-semibold text-gray-900">Relationship Portfolio</div>
                                <p class="mt-1 text-sm text-gray-500">Legacy business-partner records re-framed into the current CRM list and review workspace.</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="attach-field-label">Records Found</span>
                                <span class="text-lg font-semibold text-gray-900" x-text="filteredRows().length"></span>
                            </div>
                        </div>

                        <x-enterprise.table-shell table-class="pending-base-table min-w-[1180px]" :datatable="false">
                            <x-slot name="thead">
                                <tr>
                                    <th>BP Code</th>
                                    <th>Business Partner</th>
                                    <th>BP Group</th>
                                    <th>Type</th>
                                    <th>Territory</th>
                                    <th>Payment Terms</th>
                                    <th>Status</th>
                                    <th>Next Review</th>
                                    <th>Action</th>
                                </tr>
                            </x-slot>

                            <x-slot name="tbody">
                                <template x-if="filteredRows().length === 0">
                                    <tr>
                                        <td colspan="9" class="px-4 py-10 text-center text-sm text-gray-500">No business partners match the current search and filter combination.</td>
                                    </tr>
                                </template>
                                <template x-for="row in filteredRows()" :key="row.id">
                                    <tr :class="{ 'is-selected': selectedPartner() && selectedPartner().id === row.id }" @click="selectPartner(row.id)">
                                        <td><a :href="row.edit_url" class="font-semibold text-gray-900 transition hover:text-blue-700" @click.stop x-text="row.code"></a></td>
                                        <td>
                                            <div class="space-y-1">
                                                <div class="font-semibold text-gray-900" x-text="row.name"></div>
                                                <div class="text-xs text-gray-500">
                                                    <span x-text="row.contact_person"></span>
                                                    <span class="mx-1 text-gray-300">/</span>
                                                    <span x-text="row.telephone"></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="space-y-1">
                                                <div class="font-medium text-gray-900" x-text="row.bp_group"></div>
                                                <div class="text-xs text-gray-500" x-text="row.owner"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold" :class="{ 'bg-blue-100 text-blue-700': row.type === 'Customer', 'bg-amber-100 text-amber-700': row.type === 'Vendor', 'bg-violet-100 text-violet-700': row.type === 'Lead' }" x-text="row.type"></span>
                                        </td>
                                        <td><div class="space-y-1"><div x-text="row.territory"></div><div class="text-xs text-gray-500" x-text="row.currency"></div></div></td>
                                        <td>
                                            <div class="space-y-1">
                                                <div class="font-medium text-gray-900" x-text="row.payment_terms"></div>
                                                <div class="text-xs text-gray-500" x-text="row.service_level"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-sm font-semibold ring-1 ring-inset" :class="{ 'bg-emerald-50 text-emerald-700 ring-emerald-100': row.status === 'Active', 'bg-amber-50 text-amber-700 ring-amber-100': row.status === 'Onboarding', 'bg-slate-100 text-slate-700 ring-slate-200': row.status === 'Prospect' }">
                                                <span class="h-2.5 w-2.5 rounded-full" :class="{ 'bg-emerald-500': row.status === 'Active', 'bg-amber-500': row.status === 'Onboarding', 'bg-slate-400': row.status === 'Prospect' }"></span>
                                                <span x-text="row.status"></span>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="space-y-1">
                                                <div class="font-medium text-gray-900" x-text="row.next_review"></div>
                                                <div class="text-xs text-gray-500">Updated <span x-text="row.last_touch"></span></div>
                                            </div>
                                        </td>
                                        <td><a :href="row.edit_url" class="btn-secondary px-3 py-1.5" @click.stop>Open</a></td>
                                    </tr>
                                </template>
                            </x-slot>
                        </x-enterprise.table-shell>
                    </x-enterprise.panel>
                </div>

                <div class="space-y-5">
                    <x-enterprise.panel class="space-y-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="text-sm font-semibold text-gray-900">Selected Partner</div>
                            <template x-if="selectedPartner()">
                                <a :href="selectedPartner().edit_url" class="btn-secondary px-3 py-1.5">Edit</a>
                            </template>
                        </div>

                        <template x-if="selectedPartner()">
                            <div class="space-y-4">
                                <div class="space-y-2 border-b border-gray-200 pb-4">
                                    <div class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-500" x-text="selectedPartner().code"></div>
                                    <div class="text-xl font-semibold text-gray-900" x-text="selectedPartner().name"></div>
                                    <p class="text-sm text-gray-500" x-text="selectedPartner().summary"></p>
                                </div>

                                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-1">
                                    <div class="rounded-xl border border-gray-200 bg-gray-50/70 p-4">
                                        <div class="attach-field-label">Primary Contact</div>
                                        <div class="mt-2 font-semibold text-gray-900" x-text="selectedPartner().contact_person"></div>
                                        <div class="mt-1 text-sm text-gray-500">
                                            <span x-text="selectedPartner().telephone"></span>
                                            <span class="mx-1 text-gray-300">/</span>
                                            <span x-text="selectedPartner().email"></span>
                                        </div>
                                    </div>
                                    <div class="rounded-xl border border-gray-200 bg-gray-50/70 p-4">
                                        <div class="attach-field-label">Commercial Terms</div>
                                        <div class="mt-2 font-semibold text-gray-900" x-text="selectedPartner().payment_terms"></div>
                                        <div class="mt-1 text-sm text-gray-500">
                                            <span x-text="selectedPartner().bp_group"></span>
                                            <span class="mx-1 text-gray-300">/</span>
                                            <span x-text="selectedPartner().service_level"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-1">
                                    <div class="flex items-center justify-between rounded-xl border border-gray-200 bg-white px-4 py-3"><span class="attach-field-label">Receivable Balance</span><span class="text-base font-semibold text-gray-900" x-text="selectedPartner().receivable_balance"></span></div>
                                    <div class="flex items-center justify-between rounded-xl border border-gray-200 bg-white px-4 py-3"><span class="attach-field-label">Credit Limit</span><span class="text-base font-semibold text-gray-900" x-text="selectedPartner().credit_limit"></span></div>
                                    <div class="flex items-center justify-between rounded-xl border border-gray-200 bg-white px-4 py-3"><span class="attach-field-label">Open Activities</span><span class="text-lg font-semibold text-gray-900" x-text="selectedPartner().open_activities"></span></div>
                                    <div class="flex items-center justify-between rounded-xl border border-gray-200 bg-white px-4 py-3"><span class="attach-field-label">Active Contracts</span><span class="text-lg font-semibold text-gray-900" x-text="selectedPartner().active_contracts"></span></div>
                                </div>
                            </div>
                        </template>

                        <template x-if="!selectedPartner()">
                            <div class="rounded-xl border border-dashed border-gray-300 px-4 py-8 text-center text-sm text-gray-500">Select a business partner to review its portfolio summary.</div>
                        </template>
                    </x-enterprise.panel>

                    <x-enterprise.panel muted class="space-y-4">
                        <div class="text-sm font-semibold text-gray-900">Review Queue</div>
                        <div class="space-y-3 text-sm text-gray-600">
                            <div class="flex items-center justify-between gap-3 rounded-xl border border-gray-200 bg-white px-4 py-3"><span>Active portfolio</span><span class="font-semibold text-gray-900">{{ $activeCount }}</span></div>
                            <div class="flex items-center justify-between gap-3 rounded-xl border border-gray-200 bg-white px-4 py-3"><span>Review + pipeline</span><span class="font-semibold text-gray-900">{{ $reviewCount }}</span></div>
                            <div class="flex items-center justify-between gap-3 rounded-xl border border-gray-200 bg-white px-4 py-3"><span>Cross-functional open actions</span><span class="font-semibold text-gray-900">{{ $activityCount }}</span></div>
                        </div>

                        <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-4 text-sm text-blue-700">
                            Use the CRM workspace for relationship review and route into <strong>Master Data</strong> when the account structure, banking setup, or accounting profile needs deeper maintenance.
                        </div>
                    </x-enterprise.panel>
                </div>
            </div>

            <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('crm.business-partner.create') }}" class="btn-primary">Create Account</a>
                    <a href="{{ route('system.business-partner-master-data.index') }}" class="btn-secondary">Open Master Data</a>
                </div>
                <div class="flex items-center gap-3">
                    <span class="attach-field-label">Displayed Records</span>
                    <span class="text-lg font-semibold text-gray-900" x-text="filteredRows().length"></span>
                </div>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
