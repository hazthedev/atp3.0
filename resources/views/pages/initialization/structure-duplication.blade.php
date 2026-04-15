@extends('layouts.app')

@section('title', 'Structure Duplication')

@php
    $equipmentFrom = [
        'equipment_no' => 'EQ-000184',
        'internal_sn' => 'MR-31324',
        'item_code' => 'A139-27-118',
        'item_description' => 'Main Rotor Assembly',
        'variant' => 'Baseline',
        'category_part' => 'Rotary Wing',
    ];

    $equipmentTo = [
        'equipment_no' => 'EQ-000245',
        'internal_sn' => 'MR-31888',
        'item_code' => 'A139-27-118',
        'item_description' => 'Main Rotor Assembly',
        'variant' => 'Baseline',
        'category_part' => 'Rotary Wing',
    ];

    $functionalLocationFrom = [
        'code' => 'AW139-9M-WCM',
        'serial_number' => '31324',
        'registration' => '9M-WCM',
        'type' => 'AW139',
    ];

    $functionalLocationTo = [
        'code' => 'AW139-9M-WAY',
        'serial_number' => '31501',
        'registration' => '9M-WAY',
        'type' => 'AW139',
        'tsn' => '5,441:21',
        'csn' => '3,104',
        'start' => '2,846:15',
    ];

    $equipmentDetails = [
        ['id' => 'eq-main-1', 'selected' => true, 'position' => '01-01', 'type' => 'Equipment', 'code' => 'EQ-010112', 'description' => 'Upper Swashplate Assembly', 'target' => 'Install on target equipment'],
        ['id' => 'eq-main-2', 'selected' => true, 'position' => '01-02', 'type' => 'Equipment', 'code' => 'EQ-010118', 'description' => 'Pitch Link Set', 'target' => 'Install on target equipment'],
        ['id' => 'eq-main-3', 'selected' => false, 'position' => '02-01', 'type' => 'Component', 'code' => 'CMP-218841', 'description' => 'Tracking Sensor Harness', 'target' => 'Optional duplication'],
        ['id' => 'eq-main-4', 'selected' => true, 'position' => '03-01', 'type' => 'Document', 'code' => 'REF-MR-118', 'description' => 'Configuration Reference Package', 'target' => 'Link to copied hierarchy'],
    ];

    $functionalLocationDetails = [
        ['id' => 'fl-1', 'selected' => true, 'position' => 'ROOT', 'type' => 'Functional Location', 'code' => 'AW139-9M-WCM', 'description' => 'Aircraft structure root', 'target' => 'Copy full hierarchy'],
        ['id' => 'fl-2', 'selected' => true, 'position' => 'ENG1', 'type' => 'Engine', 'code' => 'ENG-000041', 'description' => 'Engine 1 structure branch', 'target' => 'Bind to target counters'],
        ['id' => 'fl-3', 'selected' => true, 'position' => 'ENG2', 'type' => 'Engine', 'code' => 'ENG-000042', 'description' => 'Engine 2 structure branch', 'target' => 'Bind to target counters'],
        ['id' => 'fl-4', 'selected' => false, 'position' => 'APU', 'type' => 'APU', 'code' => 'APU-000018', 'description' => 'Auxiliary power unit subtree', 'target' => 'Optional structure copy'],
    ];

    $logEntries = [
        ['time' => '2026-04-06 09:14', 'level' => 'Info', 'message' => 'Structure duplication workspace opened for initialization review.'],
        ['time' => '2026-04-06 09:18', 'level' => 'Info', 'message' => 'Copy-from hierarchy resolved successfully.'],
        ['time' => '2026-04-06 09:22', 'level' => 'Watch', 'message' => 'One optional node is currently excluded from the duplication list.'],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            activeTab: 'structure',
            objectType: 'equipment',
            installationDate: '2026-04-06',
            equipmentFrom: @js($equipmentFrom),
            equipmentTo: @js($equipmentTo),
            functionalLocationFrom: @js($functionalLocationFrom),
            functionalLocationTo: @js($functionalLocationTo),
            equipmentDetails: @js($equipmentDetails),
            functionalLocationDetails: @js($functionalLocationDetails),
            selectedDetailIds: @js(collect($equipmentDetails)->where('selected', true)->pluck('id')->values()),
            logEntries: @js($logEntries),
            statusMessage: '',
            currentDetails() {
                return this.objectType === 'equipment' ? this.equipmentDetails : this.functionalLocationDetails;
            },
            toggleSelection(id) {
                if (this.selectedDetailIds.includes(id)) {
                    this.selectedDetailIds = this.selectedDetailIds.filter((item) => item !== id);
                    return;
                }

                this.selectedDetailIds = [...this.selectedDetailIds, id];
            },
            resetSelectionForMode() {
                const activeDefaults = this.currentDetails()
                    .filter((item) => item.selected)
                    .map((item) => item.id);

                this.selectedDetailIds = activeDefaults;
            },
            setObjectType(type) {
                this.objectType = type;
                this.resetSelectionForMode();
            },
            applySelection() {
                this.statusMessage = `Prepared ${this.selectedDetailIds.length} structure item(s) for installation on ${this.installationDate}.`;
            },
            allSelected() {
                return this.currentDetails().length === this.selectedDetailIds.length;
            },
            toggleAllDetails() {
                if (this.allSelected()) {
                    this.selectedDetailIds = [];
                } else {
                    this.selectedDetailIds = this.currentDetails().map((item) => item.id);
                }
            },
            closeWorkspace() {
                this.statusMessage = 'Structure duplication workspace closed without generating a package.';
            },
            generatePackage() {
                this.statusMessage = `Generated a duplication package with ${this.selectedDetailIds.length} selected item(s).`;
                this.activeTab = 'log';
                this.logEntries = [
                    {
                        time: '2026-04-06 09:28',
                        level: 'Info',
                        message: `Duplication package created for ${this.objectType === 'equipment' ? this.equipmentTo.equipment_no : this.functionalLocationTo.code}.`,
                    },
                    ...this.logEntries,
                ];
            },
        }"
        x-init="resetSelectionForMode()"
    >
        <x-page-header
            title="Structure Duplication"
            description="Initialize copied hierarchy structures between source and target objects using the ATP enterprise workspace."
        />

        <section class="max-w-[1280px] space-y-5">
            <template x-if="statusMessage">
                <div class="flex items-center rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800" role="alert">
                    <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
                    <span x-text="statusMessage"></span>
                </div>
            </template>

            {{-- Tab bar --}}
            <div class="border-b border-gray-200">
                <ul class="-mb-px flex flex-wrap text-center text-sm font-medium text-gray-500">
                    <li class="me-2">
                        <button
                            type="button"
                            class="inline-flex items-center gap-2 rounded-t-lg border-b-2 p-4 transition-colors"
                            :class="activeTab === 'structure' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:border-gray-300 hover:text-gray-600'"
                            @click="activeTab = 'structure'"
                        >
                            <x-icon name="cube" class="h-4 w-4" />
                            Structure Duplication
                        </button>
                    </li>
                    <li class="me-2">
                        <button
                            type="button"
                            class="inline-flex items-center gap-2 rounded-t-lg border-b-2 p-4 transition-colors"
                            :class="activeTab === 'log' ? 'border-blue-600 text-blue-600' : 'border-transparent hover:border-gray-300 hover:text-gray-600'"
                            @click="activeTab = 'log'"
                        >
                            <x-icon name="clipboard-document-list" class="h-4 w-4" />
                            Log
                        </button>
                    </li>
                </ul>
            </div>

            {{-- Structure Duplication tab --}}
            <div x-cloak x-show="activeTab === 'structure'" class="space-y-5">
                <div class="rounded-2xl border border-gray-200 bg-gray-50/80 p-5 shadow-sm">
                    <div class="space-y-5">
                        <div class="flex flex-wrap items-center gap-3">
                            <label
                                class="inline-flex cursor-pointer items-center gap-2 rounded-full border px-4 py-2 text-sm font-medium shadow-sm transition"
                                :class="objectType === 'equipment' ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50'"
                            >
                                <input type="radio" name="structure_duplication_type" value="equipment" :checked="objectType === 'equipment'" @change="setObjectType('equipment')" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500" />
                                <span>Equipment</span>
                            </label>

                            <label
                                class="inline-flex cursor-pointer items-center gap-2 rounded-full border px-4 py-2 text-sm font-medium shadow-sm transition"
                                :class="objectType === 'functional-location' ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50'"
                            >
                                <input type="radio" name="structure_duplication_type" value="functional-location" :checked="objectType === 'functional-location'" @change="setObjectType('functional-location')" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500" />
                                <span>Functional Location</span>
                            </label>
                        </div>

                        <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_auto_minmax(0,1fr)]">
                            {{-- Copy From panel --}}
                            <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                                <h3 class="mb-4 text-sm font-semibold text-gray-900">Copy From</h3>

                                <div x-cloak x-show="objectType === 'equipment'" class="space-y-3">
                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="dup_from_equipment_no" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Equipment No.</label>
                                        <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                                            <input id="dup_from_equipment_no" type="text" x-model="equipmentFrom.equipment_no" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                            <button type="button" class="rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm text-gray-500 hover:bg-gray-50">...</button>
                                        </div>
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="dup_from_internal_sn" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Internal S/N</label>
                                        <input id="dup_from_internal_sn" type="text" x-model="equipmentFrom.internal_sn" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="dup_from_item_code" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Item Code</label>
                                        <input id="dup_from_item_code" type="text" x-model="equipmentFrom.item_code" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="dup_from_item_description" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Item Description</label>
                                        <input id="dup_from_item_description" type="text" x-model="equipmentFrom.item_description" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="dup_from_variant" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Variant</label>
                                        <input id="dup_from_variant" type="text" x-model="equipmentFrom.variant" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="dup_from_category_part" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Category Part</label>
                                        <input id="dup_from_category_part" type="text" x-model="equipmentFrom.category_part" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>
                                </div>

                                <div x-cloak x-show="objectType === 'functional-location'" class="space-y-3">
                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="dup_from_fl_code" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Code</label>
                                        <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                                            <input id="dup_from_fl_code" type="text" x-model="functionalLocationFrom.code" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                            <button type="button" class="rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm text-gray-500 hover:bg-gray-50">...</button>
                                        </div>
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="dup_from_fl_serial_number" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Serial Number</label>
                                        <input id="dup_from_fl_serial_number" type="text" x-model="functionalLocationFrom.serial_number" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="dup_from_fl_registration" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Registration</label>
                                        <input id="dup_from_fl_registration" type="text" x-model="functionalLocationFrom.registration" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="dup_from_fl_type" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Type</label>
                                        <input id="dup_from_fl_type" type="text" x-model="functionalLocationFrom.type" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>
                                </div>
                            </div>

                            {{-- Arrow divider --}}
                            <div class="hidden items-center justify-center xl:flex">
                                <svg class="h-6 w-6 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </div>

                            {{-- Copy To panel --}}
                            <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                                <h3 class="mb-4 text-sm font-semibold text-gray-900">Copy To</h3>

                                <div x-cloak x-show="objectType === 'equipment'" class="space-y-3">
                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="dup_to_equipment_no" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Equipment No.</label>
                                        <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                                            <input id="dup_to_equipment_no" type="text" x-model="equipmentTo.equipment_no" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                            <button type="button" class="rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm text-gray-500 hover:bg-gray-50">...</button>
                                        </div>
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="dup_to_internal_sn" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Internal S/N</label>
                                        <input id="dup_to_internal_sn" type="text" x-model="equipmentTo.internal_sn" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="dup_to_item_code" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Item Code</label>
                                        <input id="dup_to_item_code" type="text" x-model="equipmentTo.item_code" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="dup_to_item_description" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Item Description</label>
                                        <input id="dup_to_item_description" type="text" x-model="equipmentTo.item_description" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="dup_to_variant" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Variant</label>
                                        <input id="dup_to_variant" type="text" x-model="equipmentTo.variant" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="dup_to_category_part" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Category Part</label>
                                        <input id="dup_to_category_part" type="text" x-model="equipmentTo.category_part" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>
                                </div>

                                <div x-cloak x-show="objectType === 'functional-location'">
                                    <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_180px]">
                                        <div class="space-y-3">
                                            <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                                <label for="dup_to_fl_code" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Code</label>
                                                <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                                                    <input id="dup_to_fl_code" type="text" x-model="functionalLocationTo.code" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                                    <button type="button" class="rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm text-gray-500 hover:bg-gray-50">...</button>
                                                </div>
                                            </div>

                                            <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                                <label for="dup_to_fl_serial_number" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Serial Number</label>
                                                <input id="dup_to_fl_serial_number" type="text" x-model="functionalLocationTo.serial_number" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                            </div>

                                            <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                                <label for="dup_to_fl_registration" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Registration</label>
                                                <input id="dup_to_fl_registration" type="text" x-model="functionalLocationTo.registration" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                            </div>

                                            <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                                <label for="dup_to_fl_type" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Type</label>
                                                <input id="dup_to_fl_type" type="text" x-model="functionalLocationTo.type" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                            </div>
                                        </div>

                                        <div class="space-y-3">
                                            <div class="grid items-center gap-x-3 sm:grid-cols-[56px_minmax(0,1fr)]">
                                                <label for="dup_to_fl_tsn" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">TSN</label>
                                                <input id="dup_to_fl_tsn" type="text" x-model="functionalLocationTo.tsn" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                            </div>

                                            <div class="grid items-center gap-x-3 sm:grid-cols-[56px_minmax(0,1fr)]">
                                                <label for="dup_to_fl_csn" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">CSN</label>
                                                <input id="dup_to_fl_csn" type="text" x-model="functionalLocationTo.csn" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                            </div>

                                            <div class="grid items-center gap-x-3 sm:grid-cols-[56px_minmax(0,1fr)]">
                                                <label for="dup_to_fl_start" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">START</label>
                                                <input id="dup_to_fl_start" type="text" x-model="functionalLocationTo.start" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 border-t border-gray-200 pt-4 md:flex-row md:items-end md:justify-between">
                            <div class="grid items-center gap-x-3 sm:grid-cols-[132px_156px]">
                                <label for="dup_installation_date" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Installation Date</label>
                                <x-date-picker id="dup_installation_date" x-model="installationDate" />
                            </div>

                            <button type="button" class="btn-primary" @click="applySelection()">Apply</button>
                        </div>
                    </div>
                </div>

                {{-- Installation Details --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">Installation Details</h3>
                            <p class="mt-1 text-sm text-gray-500">Select the hierarchy rows that should be included in the generated duplication package.</p>
                        </div>

                        <button type="button" class="btn-secondary" @click="toggleAllDetails()">
                            <span x-text="allSelected() ? 'Unselect All' : 'Select All'"></span>
                        </button>
                    </div>

                    <div class="mt-4 overflow-auto rounded-lg border border-gray-200">
                        <table class="pending-base-table">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                                <tr>
                                    <th scope="col" class="w-12 px-3 py-3">Use</th>
                                    <th scope="col" class="px-3 py-3">Position</th>
                                    <th scope="col" class="px-3 py-3">Object Type</th>
                                    <th scope="col" class="px-3 py-3">Object Code</th>
                                    <th scope="col" class="px-3 py-3">Description</th>
                                    <th scope="col" class="px-3 py-3">Target Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="row in currentDetails()" :key="row.id">
                                    <tr
                                        class="border-b border-gray-100 transition-colors hover:bg-blue-50/60"
                                        :class="{ 'bg-blue-50': selectedDetailIds.includes(row.id) }"
                                    >
                                        <td class="px-3 py-2.5">
                                            <label class="inline-flex items-center">
                                                <input
                                                    type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500"
                                                    :checked="selectedDetailIds.includes(row.id)"
                                                    @change="toggleSelection(row.id)"
                                                />
                                            </label>
                                        </td>
                                        <td class="px-3 py-2.5 font-medium text-gray-900" x-text="row.position"></td>
                                        <td class="px-3 py-2.5" x-text="row.type"></td>
                                        <td class="px-3 py-2.5" x-text="row.code"></td>
                                        <td class="max-w-[320px] whitespace-normal px-3 py-2.5" x-text="row.description"></td>
                                        <td class="max-w-[320px] whitespace-normal px-3 py-2.5" x-text="row.target"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Log tab --}}
            <div x-cloak x-show="activeTab === 'log'" class="space-y-5">
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">Duplication Log</h3>
                        <p class="mt-1 text-sm text-gray-500">Recent initialization events for the current duplication workspace.</p>
                    </div>

                    <div class="mt-4 overflow-auto rounded-lg border border-gray-200">
                        <table class="pending-base-table">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                                <tr>
                                    <th scope="col" class="px-3 py-3">Time</th>
                                    <th scope="col" class="px-3 py-3">Level</th>
                                    <th scope="col" class="px-3 py-3">Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(entry, index) in logEntries" :key="`${entry.time}-${index}`">
                                    <tr class="border-b border-gray-100 transition-colors hover:bg-gray-50">
                                        <td class="whitespace-nowrap px-3 py-2.5 text-gray-900" x-text="entry.time"></td>
                                        <td class="px-3 py-2.5">
                                            <span
                                                class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                                                :class="entry.level === 'Watch' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800'"
                                                x-text="entry.level"
                                            ></span>
                                        </td>
                                        <td class="max-w-[480px] whitespace-normal px-3 py-2.5" x-text="entry.message"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 border-t border-gray-200 pt-5">
                <button type="button" class="btn-secondary" @click="closeWorkspace()">Close</button>
                <button type="button" class="btn-primary" @click="generatePackage()">Generate</button>
            </div>
        </section>
    </div>
@endsection
