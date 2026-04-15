@extends('layouts.app')

@section('title', 'Daily Updates')

@php
    $fromOperations = [
        ['id' => 'ac-hours', 'label' => 'Aircraft total hours', 'value' => '2,846:15'],
        ['id' => 'ac-cycles', 'label' => 'Aircraft total cycles', 'value' => '1,894'],
        ['id' => 'eng1-hours', 'label' => 'Engine 1 hours', 'value' => '4,521:08'],
        ['id' => 'eng2-hours', 'label' => 'Engine 2 hours', 'value' => '4,488:54'],
        ['id' => 'apu-hours', 'label' => 'APU hours', 'value' => '891:34'],
        ['id' => 'landing-cycles', 'label' => 'Landing gear cycles', 'value' => '1,894'],
    ];

    $recordedValues = [
        ['id' => 'rotor-hours', 'label' => 'Main rotor hours', 'value' => '6,128:42'],
        ['id' => 'tail-hours', 'label' => 'Tail rotor hours', 'value' => '5,904:17'],
    ];

    $penaltyList = [
        ['id' => 'mel-27-10-01', 'label' => 'MEL 27-10-01', 'value' => 'Autopilot channel 2 deferred'],
        ['id' => 'mel-32-20-00', 'label' => 'MEL 32-20-00', 'value' => 'Wheel brake wear monitoring'],
        ['id' => 'ops-remark', 'label' => 'Operational remark', 'value' => 'Recheck vibration trend after next flight'],
    ];

    $penaltyCounters = [
        ['id' => 'flt-hours', 'label' => 'Flight Hours', 'value' => '2,846:15'],
        ['id' => 'flt-cycles', 'label' => 'Flight Cycles', 'value' => '1,894'],
        ['id' => 'eng1-counter', 'label' => 'Engine 1 Hours', 'value' => '4,521:08'],
        ['id' => 'eng2-counter', 'label' => 'Engine 2 Hours', 'value' => '4,488:54'],
    ];

    $aircraft = [
        'fl_code' => 'AW139-9M-WCM',
        'serial_number' => '31324',
        'registration' => '9M-WCM',
        'type' => 'AW139',
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            ftrNumber: 'FTR-240418',
            techLogIds: 'TL-10492, TL-10495',
            updateDate: '2026-04-06',
            aircraft: @js($aircraft),
            fromOperations: @js($fromOperations),
            recordedValues: @js($recordedValues),
            penaltyList: @js($penaltyList),
            penaltyCounters: @js($penaltyCounters),
            selectedFromIds: [],
            selectedPenaltyCounterIds: [],
            statusMessage: '',
            initialState: {
                fromOperations: @js($fromOperations),
                recordedValues: @js($recordedValues),
                selectedPenaltyCounterIds: [],
            },
            isSelected(list, id) {
                return list.includes(id);
            },
            toggleSelection(listName, id) {
                if (this[listName].includes(id)) {
                    this[listName] = this[listName].filter((item) => item !== id);
                    return;
                }

                this[listName] = [...this[listName], id];
            },
            moveSelectedToRecorded() {
                if (this.selectedFromIds.length === 0) {
                    this.statusMessage = 'Select one or more values from Operations before recording them.';
                    return;
                }

                const selectedItems = this.fromOperations.filter((item) => this.selectedFromIds.includes(item.id));

                this.recordedValues = [...this.recordedValues, ...selectedItems];
                this.fromOperations = this.fromOperations.filter((item) => !this.selectedFromIds.includes(item.id));
                this.statusMessage = `${selectedItems.length} value(s) prepared for update.`;
                this.selectedFromIds = [];
            },
            allPenaltySelected() {
                return this.penaltyCounters.length > 0 && this.selectedPenaltyCounterIds.length === this.penaltyCounters.length;
            },
            toggleAllPenaltyCounters() {
                if (this.allPenaltySelected()) {
                    this.selectedPenaltyCounterIds = [];
                } else {
                    this.selectedPenaltyCounterIds = this.penaltyCounters.map((item) => item.id);
                }
            },
            runFind() {
                this.statusMessage = `Loaded ${this.techLogIds} for ${this.aircraft.registration}.`;
            },
            resetWorkspace() {
                this.fromOperations = JSON.parse(JSON.stringify(this.initialState.fromOperations));
                this.recordedValues = JSON.parse(JSON.stringify(this.initialState.recordedValues));
                this.selectedFromIds = [];
                this.selectedPenaltyCounterIds = [];
                this.statusMessage = 'Daily update workspace reset to the current snapshot.';
            },
            updateCounters() {
                if (this.recordedValues.length === 0) {
                    this.statusMessage = 'No recorded values are ready to update.';
                    return;
                }

                this.statusMessage = `Prepared ${this.recordedValues.length} recorded value(s) and ${this.selectedPenaltyCounterIds.length} penalty counter(s) for update.`;
            },
        }"
    >
        <x-page-header
            title="Daily Updates"
            description="Operational counter handover workspace that preserves the legacy daily update flow while using the ATP enterprise layout."
        />

        <section class="max-w-[1080px] space-y-5">
            <template x-if="statusMessage">
                <div class="flex items-center rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800" role="alert">
                    <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
                    <span x-text="statusMessage"></span>
                </div>
            </template>

            {{-- Filter header --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_200px] xl:items-end">
                    <div>
                        <label for="daily_ftr_number" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">FTR Number</label>
                        <input
                            id="daily_ftr_number"
                            type="text"
                            x-model="ftrNumber"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        />
                    </div>

                    <div>
                        <label for="daily_techlog_ids" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">List of TechLog IDs</label>
                        <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                            <input
                                id="daily_techlog_ids"
                                type="text"
                                x-model="techLogIds"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                            />
                            <button type="button" class="rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm text-gray-500 hover:bg-gray-50" @click="runFind()">...</button>
                        </div>
                    </div>

                    <div>
                        <label for="daily_update_date" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Date</label>
                        <x-date-picker id="daily_update_date" x-model="updateDate" />
                    </div>
                </div>
            </div>

            {{-- Aircraft --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm xl:max-w-[520px]">
                <h3 class="mb-4 text-sm font-semibold text-gray-900">Aircraft</h3>

                <div class="space-y-3">
                    <div class="grid items-center gap-x-3 sm:grid-cols-[100px_minmax(0,1fr)]">
                        <label for="daily_fl_code" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">FL Code</label>
                        <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                            <input id="daily_fl_code" type="text" x-model="aircraft.fl_code" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900" />
                            <button type="button" class="rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm text-gray-500 hover:bg-gray-50">...</button>
                        </div>
                    </div>

                    <div class="grid items-center gap-x-3 sm:grid-cols-[100px_minmax(0,1fr)]">
                        <label for="daily_serial_number" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Serial Number</label>
                        <input id="daily_serial_number" type="text" x-model="aircraft.serial_number" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900" />
                    </div>

                    <div class="grid items-center gap-x-3 sm:grid-cols-[100px_minmax(0,1fr)]">
                        <label for="daily_registration" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Registration</label>
                        <input id="daily_registration" type="text" x-model="aircraft.registration" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900" />
                    </div>

                    <div class="grid items-center gap-x-3 sm:grid-cols-[100px_minmax(0,1fr)]">
                        <label for="daily_type" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Type</label>
                        <input id="daily_type" type="text" x-model="aircraft.type" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900" />
                    </div>
                </div>
            </div>

            {{-- Counter transfer --}}
            <div class="grid gap-3 xl:grid-cols-[minmax(0,1fr)_56px_minmax(0,1fr)]">
                <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-2 border-b border-gray-200 bg-gray-50/80 px-4 py-3 md:flex-row md:items-start md:justify-between">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">From Operations</h3>
                            <p class="mt-1 text-sm text-gray-500">Select operational counters to bring into this daily update.</p>
                        </div>
                        <span class="inline-flex items-center rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-blue-700" x-text="`${fromOperations.length} items`"></span>
                    </div>

                    <div class="max-h-[228px] min-h-[228px] overflow-y-auto bg-white" role="listbox" aria-label="From Operations" aria-multiselectable="true">
                        <template x-for="item in fromOperations" :key="item.id">
                            <button
                                type="button"
                                class="flex w-full items-start border-b border-gray-100 px-4 py-2.5 text-left transition-colors hover:bg-blue-50/60"
                                :class="{ 'bg-blue-50': isSelected(selectedFromIds, item.id) }"
                                @click="toggleSelection('selectedFromIds', item.id)"
                            >
                                <span class="flex w-full items-start justify-between gap-4">
                                    <span class="text-sm font-medium text-gray-700" x-text="item.label"></span>
                                    <span class="shrink-0 font-semibold text-gray-900" x-text="item.value"></span>
                                </span>
                            </button>
                        </template>

                        <div x-show="fromOperations.length === 0" class="flex min-h-[228px] items-center justify-center px-6 text-center text-sm text-gray-500">
                            No pending values remain in Operations.
                        </div>
                    </div>
                </section>

                <div class="flex items-center justify-center">
                    <button type="button" class="btn-primary h-12 w-12 rounded-xl px-0 py-0 shadow-md" @click="moveSelectedToRecorded()" title="Move selected to Recorded">
                        <x-icon name="chevron-right" class="h-5 w-5" />
                    </button>
                </div>

                <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-2 border-b border-gray-200 bg-gray-50/80 px-4 py-3 md:flex-row md:items-start md:justify-between">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">Recorded Values</h3>
                            <p class="mt-1 text-sm text-gray-500">Values ready to be written back to counters and follow-up records.</p>
                        </div>
                        <span class="inline-flex items-center rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-blue-700" x-text="`${recordedValues.length} items`"></span>
                    </div>

                    <div class="max-h-[228px] min-h-[228px] overflow-y-auto bg-white" role="list" aria-label="Recorded Values">
                        <template x-for="item in recordedValues" :key="item.id">
                            <div class="flex w-full cursor-default items-start border-b border-gray-100 px-4 py-2.5 text-left transition-colors hover:bg-white">
                                <span class="flex w-full items-start justify-between gap-4">
                                    <span class="text-sm font-medium text-gray-700" x-text="item.label"></span>
                                    <span class="shrink-0 font-semibold text-gray-900" x-text="item.value"></span>
                                </span>
                            </div>
                        </template>
                    </div>
                </section>
            </div>

            {{-- Penalty panels --}}
            <div class="grid gap-3 xl:grid-cols-2">
                <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-2 border-b border-gray-200 bg-gray-50/80 px-4 py-3 md:flex-row md:items-start md:justify-between">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">Penalty List</h3>
                            <p class="mt-1 text-sm text-gray-500">Active penalties and remarks carried with the selected tech logs.</p>
                        </div>
                    </div>

                    <div class="max-h-[228px] min-h-[228px] overflow-y-auto bg-white" role="list" aria-label="Penalty List">
                        <template x-for="item in penaltyList" :key="item.id">
                            <div class="flex w-full cursor-default items-start border-b border-gray-100 px-4 py-2.5 text-left transition-colors hover:bg-white">
                                <span class="flex w-full items-start justify-between gap-4">
                                    <span class="text-sm font-medium text-gray-700" x-text="item.label"></span>
                                    <span class="shrink-0 font-semibold text-gray-900" x-text="item.value"></span>
                                </span>
                            </div>
                        </template>
                    </div>
                </section>

                <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-2 border-b border-gray-200 bg-gray-50/80 px-4 py-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">Penalty Counter List</h3>
                            <p class="mt-1 text-sm text-gray-500">Select the counters that should be included in the update run.</p>
                        </div>

                        <button type="button" class="btn-secondary shrink-0" @click="toggleAllPenaltyCounters()">
                            <span x-text="allPenaltySelected() ? 'Unselect All' : 'Select All'"></span>
                        </button>
                    </div>

                    <div class="max-h-[228px] min-h-[228px] overflow-y-auto bg-white" role="listbox" aria-label="Penalty Counter List" aria-multiselectable="true">
                        <template x-for="item in penaltyCounters" :key="item.id">
                            <button
                                type="button"
                                class="flex w-full items-start border-b border-gray-100 px-4 py-2.5 text-left transition-colors hover:bg-blue-50/60"
                                :class="{ 'bg-blue-50': isSelected(selectedPenaltyCounterIds, item.id) }"
                                @click="toggleSelection('selectedPenaltyCounterIds', item.id)"
                            >
                                <span class="flex w-full items-start justify-between gap-4">
                                    <span class="text-sm font-medium text-gray-700" x-text="item.label"></span>
                                    <span class="shrink-0 font-semibold text-gray-900" x-text="item.value"></span>
                                </span>
                            </button>
                        </template>
                    </div>
                </section>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 border-t border-gray-200 pt-5">
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" class="btn-primary" @click="runFind()">Find</button>
                    <button type="button" class="btn-secondary" @click="resetWorkspace()">Cancel</button>
                </div>

                <button type="button" class="btn-secondary" @click="updateCounters()">Update Counters</button>
            </div>
        </section>
    </div>
@endsection
