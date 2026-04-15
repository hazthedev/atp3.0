@php
    $title = $title ?? 'Fleet Management Cockpit';
    $description = $description ?? 'Cockpit-style workspace for browsing fleet structure snapshots and related log messages.';

    $modeOptions = $modeOptions ?? [
        'functional-location' => 'Functional Location',
        'equipment' => 'Equipment',
        'registration' => 'Registration',
    ];

    $structureRows = $structureRows ?? [
        ['id' => 'fl-root', 'level' => 0, 'type' => 'Functional Location', 'code' => 'AW139-9M-WCM', 'info' => '9M-WCM / Weststar Aviation Services', 'status' => 'Tracked'],
        ['id' => 'eq-main', 'level' => 1, 'type' => 'Equipment', 'code' => 'EQ-000184', 'info' => 'Main Rotor Assembly / S/N MR-31324', 'status' => 'Installed'],
        ['id' => 'eq-tail', 'level' => 1, 'type' => 'Equipment', 'code' => 'EQ-000219', 'info' => 'Tail Rotor Assembly / S/N TR-88211', 'status' => 'Installed'],
        ['id' => 'eq-eng1', 'level' => 1, 'type' => 'Engine', 'code' => 'ENG-000041', 'info' => 'Engine 1 / PT6C-67C / S/N PCE-A1102', 'status' => 'Tracked'],
        ['id' => 'eq-eng2', 'level' => 1, 'type' => 'Engine', 'code' => 'ENG-000042', 'info' => 'Engine 2 / PT6C-67C / S/N PCE-A1120', 'status' => 'Tracked'],
        ['id' => 'eq-apu', 'level' => 1, 'type' => 'APU', 'code' => 'APU-000018', 'info' => 'APU Assembly / S/N APS-0178', 'status' => 'Watch'],
        ['id' => 'sub-avionics', 'level' => 2, 'type' => 'Sub Equipment', 'code' => 'AVIO-00218', 'info' => 'Avionics Rack / Communication stack', 'status' => 'Installed'],
        ['id' => 'sub-gear', 'level' => 2, 'type' => 'Sub Equipment', 'code' => 'GEAR-00093', 'info' => 'Landing Gear Set / Last cycle sync 06 Apr 2026', 'status' => 'Tracked'],
    ];

    $logRows = $logRows ?? [
        ['type' => 'Functional Location', 'code' => 'AW139-9M-WCM', 'info' => 'Tracking date adjusted to 06 Apr 2026', 'level' => 'Info', 'message' => 'Structure snapshot loaded successfully.'],
        ['type' => 'Engine', 'code' => 'ENG-000041', 'info' => 'Counter delta received from daily updates', 'level' => 'Info', 'message' => 'Hours and cycles aligned with latest tech log values.'],
        ['type' => 'APU', 'code' => 'APU-000018', 'info' => 'Counter threshold approaching', 'level' => 'Watch', 'message' => 'Review next maintenance planning window before dispatch.'],
        ['type' => 'Sub Equipment', 'code' => 'GEAR-00093', 'info' => 'Hierarchy child refreshed', 'level' => 'Info', 'message' => 'Landing gear counters inherited from parent structure.'],
    ];
@endphp

<div
    class="space-y-6"
    x-data="{
        activeTab: 'structure',
        mode: 'functional-location',
        code: 'AW139-9M-WCM',
        trackingDate: '2026-04-06',
        structureRows: @js($structureRows),
        logRows: @js($logRows),
        selectedStructureId: 'fl-root',
        statusMessage: '',
        setTab(tab) {
            this.activeTab = tab;
        },
        selectStructure(id) {
            this.selectedStructureId = id;
        },
        runLookup() {
            this.statusMessage = `Loaded ${this.code} in ${this.mode.replace('-', ' ')} mode for ${this.trackingDate}.`;
        },
        displayCounters() {
            const selected = this.structureRows.find((row) => row.id === this.selectedStructureId);

            if (!selected) {
                this.statusMessage = 'Select a structure row before displaying counters.';
                return;
            }

            this.statusMessage = `Counter panel prepared for ${selected.code} (${selected.type}).`;
        },
        confirmCockpit() {
            this.statusMessage = `Fleet cockpit snapshot confirmed for ${this.code}.`;
        },
    }"
>
    <x-page-header :title="$title" :description="$description" />

    <section class="max-w-[1280px] space-y-5">
        <template x-if="statusMessage">
            <div class="flex items-center rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800" role="alert">
                <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
                <span x-text="statusMessage"></span>
            </div>
        </template>

        {{-- Filter --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="grid gap-3 lg:max-w-[400px]">
                <div>
                    <label for="fleet_cockpit_mode" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Mode</label>
                    <select id="fleet_cockpit_mode" x-model="mode" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                        @foreach ($modeOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="fleet_cockpit_code" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Code</label>
                    <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                        <input id="fleet_cockpit_code" type="text" x-model="code" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20" />
                        <button type="button" class="rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm text-gray-500 hover:bg-gray-50" @click="runLookup()">...</button>
                    </div>
                </div>

                <div>
                    <label for="fleet_cockpit_tracking_date" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Tracking Date</label>
                    <x-date-picker id="fleet_cockpit_tracking_date" x-model="trackingDate" />
                </div>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="border-b border-gray-200">
            <ul class="-mb-px flex flex-wrap text-sm font-medium text-gray-500">
                <li class="me-2">
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-t-lg border-b-2 p-4 transition-colors"
                        :class="activeTab === 'structure' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:border-gray-300 hover:text-gray-600'"
                        @click="setTab('structure')"
                    >
                        <x-icon name="cube" class="h-4 w-4" />
                        Structure
                    </button>
                </li>
                <li class="me-2">
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-t-lg border-b-2 p-4 transition-colors"
                        :class="activeTab === 'log' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:border-gray-300 hover:text-gray-600'"
                        @click="setTab('log')"
                    >
                        <x-icon name="clipboard-document-list" class="h-4 w-4" />
                        Log
                    </button>
                </li>
            </ul>
        </div>

        {{-- Structure tab --}}
        <div x-cloak x-show="activeTab === 'structure'" class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="min-h-[420px] overflow-hidden rounded-xl border border-gray-200 bg-white">
                <template x-for="row in structureRows" :key="row.id">
                    <button
                        type="button"
                        class="flex w-full items-center justify-between gap-4 border-b border-gray-100 px-4 py-3 text-left transition-colors hover:bg-blue-50/60"
                        :class="{ 'bg-blue-50': selectedStructureId === row.id }"
                        @click="selectStructure(row.id)"
                    >
                        <span class="flex min-w-0 items-center gap-3" :style="`padding-left: ${row.level * 22}px`">
                            <span
                                class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full ring-1 ring-inset transition"
                                :class="row.level === 0
                                    ? 'bg-blue-600 text-white ring-blue-600'
                                    : 'bg-blue-50 text-blue-600 ring-blue-100'"
                            >
                                <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                            </span>
                            <span class="flex min-w-0 flex-col">
                                <span class="truncate text-sm font-semibold text-gray-900" x-text="row.code"></span>
                                <span class="truncate text-sm text-gray-500" x-text="`${row.type} â€¢ ${row.info}`"></span>
                            </span>
                        </span>

                        <span
                            class="inline-flex shrink-0 items-center rounded-full px-2.5 py-1 text-xs font-semibold"
                            :class="{
                                'bg-amber-100 text-amber-700': row.status === 'Watch',
                                'bg-blue-100 text-blue-700': row.status === 'Tracked',
                                'bg-emerald-100 text-emerald-700': row.status === 'Installed'
                            }"
                            x-text="row.status"
                        ></span>
                    </button>
                </template>
            </div>

            <div class="mt-4 flex justify-end">
                <button type="button" class="btn-secondary" @click="displayCounters()">Display Counters</button>
            </div>
        </div>

        {{-- Log tab --}}
        <div x-cloak x-show="activeTab === 'log'" class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
            <div class="min-h-[420px] overflow-auto rounded-xl border border-gray-200">
                <table class="pending-base-table">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                        <tr>
                            <th scope="col" class="px-3 py-3">Object Type</th>
                            <th scope="col" class="px-3 py-3">Object Code</th>
                            <th scope="col" class="px-3 py-3">ObjInfo</th>
                            <th scope="col" class="px-3 py-3">Level</th>
                            <th scope="col" class="px-3 py-3">Log Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(row, index) in logRows" :key="`${row.code}-${index}`">
                            <tr class="border-b border-gray-100 transition-colors hover:bg-blue-50/60">
                                <td class="px-3 py-2.5" x-text="row.type"></td>
                                <td class="px-3 py-2.5 font-medium text-gray-900" x-text="row.code"></td>
                                <td class="max-w-[220px] whitespace-normal px-3 py-2.5" x-text="row.info"></td>
                                <td class="px-3 py-2.5">
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold"
                                        :class="row.level === 'Watch' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700'"
                                        x-text="row.level"
                                    ></span>
                                </td>
                                <td class="max-w-[320px] whitespace-normal px-3 py-2.5" x-text="row.message"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex items-center justify-between border-t border-gray-200 pt-5">
            <button type="button" class="btn-primary" @click="confirmCockpit()">OK</button>
        </div>
    </section>
</div>
