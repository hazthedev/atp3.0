@extends('layouts.app')

@section('title', 'My Alerts Subscription')

@php
    $standardAlerts = [
        ['code' => '-000001', 'label' => 'Activities due in 24-Hours', 'object_type' => 'Activities', 'active' => true],
        ['code' => '-000002', 'label' => 'Past Due Activities', 'object_type' => 'Activities', 'active' => false],
        ['code' => '-000003', 'label' => 'Proposed Activity', 'object_type' => 'Activities', 'active' => true],
        ['code' => '-000004', 'label' => 'Responded Status Activities', 'object_type' => 'Activities', 'active' => false],
        ['code' => '-000005', 'label' => 'On-Hold Status Activities', 'object_type' => 'Activities', 'active' => false],
    ];

    $personalizedAlerts = [
        ['code' => 'PAL-0101', 'label' => 'Critical customer support updates', 'object_type' => 'Contact Report', 'active' => true],
        ['code' => 'PAL-0102', 'label' => 'Scheduled visit rescheduling watch', 'object_type' => 'Scheduled Visit', 'active' => false],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            statusMessage: '',
            forUsersSet: false,
            selectedUser: 'acap',
            standardAlerts: @js($standardAlerts),
            personalizedAlerts: @js($personalizedAlerts),
            toggleAlert(listName, code) {
                this[listName] = this[listName].map((item) => item.code === code ? { ...item, active: !item.active } : item);
            },
            setAll(listName, value) {
                this[listName] = this[listName].map((item) => ({ ...item, active: value }));
            },
            addPersonalizedAlert() {
                const nextCode = `PAL-${String(this.personalizedAlerts.length + 103).padStart(4, '0')}`;
                this.personalizedAlerts = [
                    {
                        code: nextCode,
                        label: 'New personalized alert',
                        object_type: 'Custom',
                        active: true,
                    },
                    ...this.personalizedAlerts,
                ];
                this.statusMessage = `Personalized alert ${nextCode} created for ${this.selectedUser}.`;
            },
            confirmSubscription() {
                const totalActive = [...this.standardAlerts, ...this.personalizedAlerts].filter((item) => item.active).length;
                this.statusMessage = `Saved ${totalActive} active alert subscription(s) for ${this.selectedUser}.`;
            },
            cancelSubscription() {
                this.statusMessage = 'Alert subscription changes cancelled for this review session.';
            },
        }"
    >
        <x-page-header
            title="My Alerts Subscription"
            description="Manage standard and personalized service alerts for the current user or a selected user set in the ATP alert subscription workspace."
        />

        <section class="attach-workspace-shell max-w-[1180px] space-y-5">
            <template x-if="statusMessage">
                <div class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-700" x-text="statusMessage"></div>
            </template>

            <x-enterprise.panel class="space-y-4">
                <div>
                    <div class="text-sm font-semibold text-gray-900">Standard Alerts</div>
                    <p class="mt-1 text-sm text-gray-500">Core operational alerts that can be enabled per user subscription.</p>
                </div>

                <x-enterprise.table-shell table-class="pending-base-table min-w-full" :datatable="false">
                    <x-slot name="thead">
                        <tr>
                            <th>Alert Code</th>
                            <th>Alert Label</th>
                            <th>Object Type</th>
                            <th>Active</th>
                        </tr>
                    </x-slot>

                    <x-slot name="tbody">
                        <template x-for="row in standardAlerts" :key="row.code">
                            <tr>
                                <td>
                                    <button type="button" class="w-full text-left font-semibold text-gray-900 transition hover:text-blue-700" x-text="row.code"></button>
                                </td>
                                <td x-text="row.label"></td>
                                <td x-text="row.object_type"></td>
                                <td>
                                    <input
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                        :checked="row.active"
                                        @change="toggleAlert('standardAlerts', row.code)"
                                    />
                                </td>
                            </tr>
                        </template>
                    </x-slot>
                </x-enterprise.table-shell>

                <div class="flex flex-col gap-3 border-b border-gray-200 pb-4 md:flex-row md:items-center md:justify-between">
                    <label class="attach-checkbox-inline">
                        <input type="checkbox" x-model="forUsersSet" />
                        <span>For this Set of Users</span>
                    </label>

                    <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>

                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" class="btn-secondary" @click="setAll('standardAlerts', true)">Check All</button>
                        <button type="button" class="btn-secondary" @click="setAll('standardAlerts', false)">Uncheck All</button>
                    </div>
                </div>
            </x-enterprise.panel>

            <x-enterprise.panel class="space-y-4">
                <div>
                    <div class="text-sm font-semibold text-gray-900">Personalized Alerts</div>
                    <p class="mt-1 text-sm text-gray-500">User-specific alert definitions that complement the standard alert catalogue.</p>
                </div>

                <x-enterprise.table-shell table-class="pending-base-table min-w-full" :datatable="false">
                    <x-slot name="thead">
                        <tr>
                            <th>Alert Code</th>
                            <th>Alert Label</th>
                            <th>Object Type</th>
                            <th>Active</th>
                        </tr>
                    </x-slot>

                    <x-slot name="tbody">
                        <template x-if="personalizedAlerts.length === 0">
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">No personalized alerts are configured for this user.</td>
                            </tr>
                        </template>

                        <template x-for="row in personalizedAlerts" :key="row.code">
                            <tr>
                                <td>
                                    <button type="button" class="w-full text-left font-semibold text-gray-900 transition hover:text-blue-700" x-text="row.code"></button>
                                </td>
                                <td x-text="row.label"></td>
                                <td x-text="row.object_type"></td>
                                <td>
                                    <input
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                        :checked="row.active"
                                        @change="toggleAlert('personalizedAlerts', row.code)"
                                    />
                                </td>
                            </tr>
                        </template>
                    </x-slot>
                </x-enterprise.table-shell>

                <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_auto] xl:items-center">
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" class="btn-primary" @click="addPersonalizedAlert()">New personalized alert</button>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" class="btn-secondary" @click="setAll('personalizedAlerts', true)">Check All</button>
                        <button type="button" class="btn-secondary" @click="setAll('personalizedAlerts', false)">Uncheck All</button>
                    </div>
                </div>
            </x-enterprise.panel>

            <x-enterprise.action-bar justify="between" class="border-t border-gray-200 pt-5">
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="btn-primary" @click="confirmSubscription()">OK</button>
                    <button type="button" class="btn-secondary" @click="cancelSubscription()">Cancel</button>
                </div>

                <div class="grid items-center gap-3 sm:grid-cols-[auto_minmax(0,1fr)]">
                    <span class="attach-field-label">User</span>
                    <select x-model="selectedUser" class="input-field attach-input">
                        <option value="acap">acap</option>
                        <option value="nadiah">nadiah</option>
                        <option value="aina">aina</option>
                    </select>
                </div>
            </x-enterprise.action-bar>
        </section>
    </div>
@endsection
