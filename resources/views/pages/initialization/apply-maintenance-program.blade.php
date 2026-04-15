@extends('layouts.app')

@section('title', 'Apply Maintenance Program')

@php
    $equipmentObject = [
        'equipment_no' => 'EQ-000184',
        'internal_sn' => 'MR-31324',
        'item_code' => 'A139-27-118',
        'item_description' => 'Main Rotor Assembly',
        'variant' => 'Baseline',
        'category_part' => 'Rotary Wing',
    ];

    $functionalLocationObject = [
        'code' => 'AW139-9M-WCM',
        'serial_number' => '31324',
        'registration' => '9M-WCM',
        'type' => 'AW139',
    ];

    $programOptions = [
        ['code' => 'MP-AW139-BASE', 'label' => 'AW139 Base Program', 'status' => 'Released'],
        ['code' => 'MP-AW139-HOURS', 'label' => 'AW139 Hours & Cycles', 'status' => 'Draft'],
        ['code' => 'MP-AW139-COMP', 'label' => 'AW139 Components Program', 'status' => 'Released'],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="{
            objectType: 'equipment',
            equipment: @js($equipmentObject),
            functionalLocation: @js($functionalLocationObject),
            programOptions: @js($programOptions),
            maintenanceProgram: 'MP-AW139-BASE',
            programStatus: 'Released',
            newObject: 'no',
            copyEffectivity: 'no',
            statusMessage: '',
            syncProgramStatus() {
                const program = this.programOptions.find((item) => item.code === this.maintenanceProgram);
                this.programStatus = program ? program.status : 'Unknown';
            },
            applyProgram() {
                const target = this.objectType === 'equipment'
                    ? this.equipment.equipment_no
                    : this.functionalLocation.code;

                this.syncProgramStatus();
                this.statusMessage = `Prepared ${this.maintenanceProgram} for ${target} (${this.objectType === 'equipment' ? 'Equipment' : 'Functional Location'}).`;
            },
            resetForm() {
                this.objectType = 'equipment';
                this.maintenanceProgram = 'MP-AW139-BASE';
                this.programStatus = 'Released';
                this.newObject = 'no';
                this.copyEffectivity = 'no';
                this.statusMessage = 'Assignment workspace reset to the default initialization state.';
            },
        }"
        x-init="syncProgramStatus()"
    >
        <x-page-header
            title="Apply Maintenance Program"
            description="Assign a maintenance program to an equipment or functional location during initialization using the ATP enterprise workspace."
        />

        <section class="max-w-[1120px] space-y-5">
            <template x-if="statusMessage">
                <div class="flex items-center rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800" role="alert">
                    <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
                    <span x-text="statusMessage"></span>
                </div>
            </template>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="space-y-5">
                    <div class="flex flex-wrap items-center gap-3">
                        <label
                            class="inline-flex cursor-pointer items-center gap-2 rounded-full border px-4 py-2 text-sm font-medium shadow-sm transition"
                            :class="objectType === 'equipment' ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50'"
                        >
                            <input type="radio" name="object_type" value="equipment" x-model="objectType" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500" />
                            <span>Equipment</span>
                        </label>

                        <label
                            class="inline-flex cursor-pointer items-center gap-2 rounded-full border px-4 py-2 text-sm font-medium shadow-sm transition"
                            :class="objectType === 'functional-location' ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50'"
                        >
                            <input type="radio" name="object_type" value="functional-location" x-model="objectType" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500" />
                            <span>Functional Location</span>
                        </label>
                    </div>

                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_400px]">
                        <div>
                            <div class="rounded-xl border border-gray-200 p-4 shadow-sm">
                                <h3 class="mb-4 text-sm font-semibold text-gray-900">Object Details</h3>

                                <div x-cloak x-show="objectType === 'equipment'" class="space-y-3">
                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="apply_mp_equipment_no" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Equipment No.</label>
                                        <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                                            <input id="apply_mp_equipment_no" type="text" x-model="equipment.equipment_no" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                            <button type="button" class="rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm text-gray-500 hover:bg-gray-50">...</button>
                                        </div>
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="apply_mp_internal_sn" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Internal S/N</label>
                                        <input id="apply_mp_internal_sn" type="text" x-model="equipment.internal_sn" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="apply_mp_item_code" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Item Code</label>
                                        <input id="apply_mp_item_code" type="text" x-model="equipment.item_code" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="apply_mp_item_description" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Item Description</label>
                                        <input id="apply_mp_item_description" type="text" x-model="equipment.item_description" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="apply_mp_variant" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Variant</label>
                                        <input id="apply_mp_variant" type="text" x-model="equipment.variant" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="apply_mp_category_part" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Category Part</label>
                                        <input id="apply_mp_category_part" type="text" x-model="equipment.category_part" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>
                                </div>

                                <div x-cloak x-show="objectType === 'functional-location'" class="space-y-3">
                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="apply_mp_fl_code" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Code</label>
                                        <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                                            <input id="apply_mp_fl_code" type="text" x-model="functionalLocation.code" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                            <button type="button" class="rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm text-gray-500 hover:bg-gray-50">...</button>
                                        </div>
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="apply_mp_fl_serial_number" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Serial Number</label>
                                        <input id="apply_mp_fl_serial_number" type="text" x-model="functionalLocation.serial_number" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="apply_mp_fl_registration" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Registration</label>
                                        <input id="apply_mp_fl_registration" type="text" x-model="functionalLocation.registration" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[132px_minmax(0,1fr)]">
                                        <label for="apply_mp_fl_type" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Type</label>
                                        <input id="apply_mp_fl_type" type="text" x-model="functionalLocation.type" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="rounded-xl border border-gray-200 p-4 shadow-sm">
                                <h3 class="mb-4 text-sm font-semibold text-gray-900">Program Assignment</h3>

                                <div class="space-y-3">
                                    <div>
                                        <label for="apply_mp_program" class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Maintenance Program</label>
                                        <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                                            <select
                                                id="apply_mp_program"
                                                x-model="maintenanceProgram"
                                                @change="syncProgramStatus()"
                                                class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                                            >
                                                @foreach ($programOptions as $option)
                                                    <option value="{{ $option['code'] }}">{{ $option['code'] }} - {{ $option['label'] }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm text-gray-500 hover:bg-gray-50" @click="syncProgramStatus()">...</button>
                                        </div>
                                    </div>

                                    <div class="grid items-center gap-x-3 sm:grid-cols-[64px_minmax(0,1fr)]">
                                        <label for="apply_mp_status" class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">Status</label>
                                        <input id="apply_mp_status" type="text" x-model="programStatus" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>
                                </div>

                                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-3.5">
                                        <h4 class="text-sm font-semibold text-gray-900">New Object</h4>
                                        <div class="mt-2.5 flex flex-col gap-2">
                                            <label
                                                class="inline-flex cursor-pointer items-center gap-3 rounded-lg border bg-white px-3 py-2 text-sm transition"
                                                :class="newObject === 'yes' ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-gray-200 text-gray-700 hover:border-blue-200 hover:bg-blue-50/50'"
                                            >
                                                <input type="radio" name="apply_mp_new_object" value="yes" x-model="newObject" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500" />
                                                <span>Yes</span>
                                            </label>

                                            <label
                                                class="inline-flex cursor-pointer items-center gap-3 rounded-lg border bg-white px-3 py-2 text-sm transition"
                                                :class="newObject === 'no' ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-gray-200 text-gray-700 hover:border-blue-200 hover:bg-blue-50/50'"
                                            >
                                                <input type="radio" name="apply_mp_new_object" value="no" x-model="newObject" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500" />
                                                <span>No</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-3.5">
                                        <h4 class="text-sm font-semibold text-gray-900">Copy Effectivity</h4>
                                        <div class="mt-2.5 flex flex-col gap-2">
                                            <label
                                                class="inline-flex cursor-pointer items-center gap-3 rounded-lg border bg-white px-3 py-2 text-sm transition"
                                                :class="copyEffectivity === 'yes' ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-gray-200 text-gray-700 hover:border-blue-200 hover:bg-blue-50/50'"
                                            >
                                                <input type="radio" name="apply_mp_copy_effectivity" value="yes" x-model="copyEffectivity" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500" />
                                                <span>Yes</span>
                                            </label>

                                            <label
                                                class="inline-flex cursor-pointer items-center gap-3 rounded-lg border bg-white px-3 py-2 text-sm transition"
                                                :class="copyEffectivity === 'no' ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-gray-200 text-gray-700 hover:border-blue-200 hover:bg-blue-50/50'"
                                            >
                                                <input type="radio" name="apply_mp_copy_effectivity" value="no" x-model="copyEffectivity" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500" />
                                                <span>No</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 border-t border-gray-200 pt-5">
                <button type="button" class="btn-secondary" @click="resetForm()">Cancel</button>
                <button type="button" class="btn-primary" @click="applyProgram()">Apply</button>
            </div>
        </section>
    </div>
@endsection
