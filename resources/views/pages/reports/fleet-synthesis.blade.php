@extends('layouts.app')

@section('title', 'Fleet Synthesis')

@php
    // Real aircraft list from SAP @MRO_OUTM (Utilization Model headers — one per A/C).
    // Variant (AW139/AW189) is inferred from the registration prefix until we
    // join against a dedicated A/C master in a later phase.
    $aircraftOptions = App\Models\UtilizationModel::orderBy('registration')
        ->get(['code', 'registration'])
        ->map(function ($m) {
            $reg = $m->registration;
            // Cheap registration-to-variant heuristic matching the seeded fleet.
            // Real mapping lives in SAP FL master (not in this dump).
            $type = match (true) {
                str_starts_with($reg, '9M-WS') => 'AW189',
                default => 'AW139',
            };
            return ['type' => $type, 'sn' => $m->code, 'reg' => $reg];
        })
        ->all();

    $predefinedFilters = [
        ['id' => 1, 'name' => 'AW139 - Applicable', 'is_default' => true],
        ['id' => 2, 'name' => 'AW139 - Non Applicable', 'is_default' => false],
        ['id' => 3, 'name' => 'Red alarms only', 'is_default' => false],
    ];
@endphp

@section('content')
    <div
        class="space-y-6"
        x-data="fleetSynthesisFilters({
            aircraft: @js($aircraftOptions),
            predefined: @js($predefinedFilters),
        })"
    >
        <x-page-header
            title="Fleet Synthesis"
            description="Filter the fleet, then open the colored Dashboard or the detailed task list."
        />

        <section class="rounded-2xl border border-gray-200 bg-white shadow-sm">
            <header class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <h3 class="text-lg font-semibold text-blue-700">Filters</h3>
                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        class="rounded-full p-2 text-gray-500 transition hover:bg-gray-100 hover:text-blue-600"
                        title="Predefined filters"
                        @click="openPredefined = true"
                    >
                        <x-icon name="cog-6-tooth" class="h-5 w-5" />
                    </button>
                    <button
                        type="button"
                        class="rounded-full p-2 text-gray-500 transition hover:bg-gray-100 hover:text-blue-600"
                        title="Reset filters"
                        @click="resetFilters()"
                    >
                        <x-icon name="arrow-path" class="h-5 w-5" />
                    </button>
                </div>
            </header>

            <div class="grid gap-5 p-6 md:grid-cols-2 xl:grid-cols-4">
                <div class="xl:col-span-4">
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">A/C Registration</label>
                    <div class="relative" @click.outside="acOpen = false">
                        <button
                            type="button"
                            class="input-field flex min-h-[44px] flex-wrap items-center gap-1.5 text-left"
                            @click="acOpen = !acOpen"
                        >
                            <template x-if="selectedAc.length === 0">
                                <span class="text-gray-400">Select aircraft…</span>
                            </template>
                            <template x-for="reg in selectedAc" :key="reg">
                                <span class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-2 py-0.5 text-xs font-medium text-blue-700">
                                    <span x-text="reg"></span>
                                    <button type="button" class="text-blue-400 hover:text-blue-700" @click.stop="toggleAc(reg)">&times;</button>
                                </span>
                            </template>
                            <span class="ml-auto text-gray-400">&#9662;</span>
                        </button>

                        <div
                            x-cloak
                            x-show="acOpen"
                            x-transition
                            class="absolute z-20 mt-1 w-full overflow-hidden rounded-lg border border-gray-200 bg-white shadow-lg"
                        >
                            <template x-for="ac in aircraft" :key="ac.reg">
                                <label class="flex cursor-pointer items-center gap-2 px-3 py-2 text-sm hover:bg-blue-50">
                                    <input type="checkbox" :value="ac.reg" :checked="selectedAc.includes(ac.reg)" @change="toggleAc(ac.reg)" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                    <span class="font-medium text-gray-700" x-text="ac.reg"></span>
                                    <span class="text-xs text-gray-400" x-text="ac.type + ' · SN ' + ac.sn"></span>
                                </label>
                            </template>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Visits / Tasks Status</label>
                    <select class="input-field" x-model="status">
                        <option>Applied</option>
                        <option>Applicable</option>
                        <option>Non Applicable</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Remaining Hours</label>
                    <input type="number" class="input-field" placeholder="e.g. 30" x-model="remainingHours" />
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Remaining Cycles</label>
                    <input type="number" class="input-field" placeholder="e.g. 30" x-model="remainingCycles" />
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Remaining Months</label>
                    <input type="number" class="input-field" placeholder="e.g. 1" x-model="remainingMonths" />
                </div>
            </div>

            <footer class="flex items-center justify-end gap-2 border-t border-gray-100 px-6 py-4">
                <a href="{{ route('reports.fleet-synthesis.dashboard') }}" class="btn-secondary">Dashboard</a>
                <a href="{{ route('reports.fleet-synthesis.details') }}" class="btn-primary">Details</a>
            </footer>
        </section>

        {{-- Predefined filters modal --}}
        <div
            x-cloak
            x-show="openPredefined"
            x-transition.opacity
            class="fixed inset-0 z-40 flex items-center justify-center bg-gray-900/40 px-4"
            @click.self="openPredefined = false"
        >
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
                <div class="mb-4 flex items-center justify-between">
                    <h4 class="text-lg font-semibold text-gray-900">Predefined filters</h4>
                    <button class="text-gray-400 hover:text-gray-700" @click="openPredefined = false">&times;</button>
                </div>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-xs uppercase tracking-wider text-gray-500">
                            <th class="py-2">Name</th>
                            <th class="py-2 text-center">Default</th>
                            <th class="py-2 text-right">Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="filter in predefined" :key="filter.id">
                            <tr class="border-b border-gray-100" :class="selectedPredefinedId === filter.id && 'bg-blue-50'">
                                <td class="py-2.5">
                                    <label class="flex cursor-pointer items-center gap-2">
                                        <input type="radio" :value="filter.id" x-model.number="selectedPredefinedId" class="text-blue-600 focus:ring-blue-500" />
                                        <span x-text="filter.name"></span>
                                    </label>
                                </td>
                                <td class="py-2.5 text-center">
                                    <input type="checkbox" :checked="filter.is_default" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                </td>
                                <td class="py-2.5 text-right text-xs text-gray-400">
                                    <button class="text-blue-600 hover:text-blue-800" @click="applyPredefined(filter)">Apply</button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <div class="mt-5 flex flex-wrap items-center justify-between gap-2">
                    <div class="flex items-center gap-2 text-xs">
                        <button class="rounded px-2 py-1 text-gray-500 hover:bg-gray-100" @click="deletePredefined()" :disabled="!selectedPredefinedId">Delete</button>
                        <button class="rounded px-2 py-1 text-gray-500 hover:bg-gray-100" @click="alert('Rename flow — mockup only')" :disabled="!selectedPredefinedId">Update</button>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="btn-ghost" @click="openPredefined = false">Cancel</button>
                        <button class="btn-secondary" @click="openSaveCurrent = true; openPredefined = false">Save Current Filter</button>
                        <button class="btn-primary" @click="confirmSelectPredefined()" :disabled="!selectedPredefinedId">Select</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Save current filter modal --}}
        <div
            x-cloak
            x-show="openSaveCurrent"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 px-4"
            @click.self="openSaveCurrent = false"
        >
            <div class="w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl">
                <h4 class="mb-4 text-lg font-semibold text-gray-900">Save current filter</h4>
                <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Name</label>
                <input type="text" class="input-field" placeholder="e.g. AW139 critical" x-model="newFilterName" />
                <div class="mt-5 flex justify-end gap-2">
                    <button class="btn-ghost" @click="openSaveCurrent = false">Cancel</button>
                    <button class="btn-primary" @click="saveCurrentFilter()" :disabled="!newFilterName">Validate</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fleetSynthesisFilters(config) {
            return {
                aircraft: config.aircraft,
                predefined: config.predefined,
                selectedAc: [],
                acOpen: false,
                status: 'Applicable',
                remainingHours: '',
                remainingCycles: '',
                remainingMonths: '',
                openPredefined: false,
                openSaveCurrent: false,
                selectedPredefinedId: null,
                newFilterName: '',
                toggleAc(reg) {
                    const i = this.selectedAc.indexOf(reg);
                    i === -1 ? this.selectedAc.push(reg) : this.selectedAc.splice(i, 1);
                },
                resetFilters() {
                    this.selectedAc = [];
                    this.status = 'Applicable';
                    this.remainingHours = this.remainingCycles = this.remainingMonths = '';
                },
                applyPredefined(filter) {
                    this.selectedPredefinedId = filter.id;
                },
                confirmSelectPredefined() {
                    const f = this.predefined.find(p => p.id === this.selectedPredefinedId);
                    if (!f) return;
                    if (f.name.includes('Applicable')) this.status = 'Applicable';
                    if (f.name.includes('Non Applicable')) this.status = 'Non Applicable';
                    this.remainingHours = 30;
                    this.remainingCycles = 30;
                    this.remainingMonths = 1;
                    this.openPredefined = false;
                },
                deletePredefined() {
                    this.predefined = this.predefined.filter(p => p.id !== this.selectedPredefinedId);
                    this.selectedPredefinedId = null;
                },
                saveCurrentFilter() {
                    this.predefined.push({
                        id: Date.now(),
                        name: this.newFilterName,
                        is_default: false,
                    });
                    this.newFilterName = '';
                    this.openSaveCurrent = false;
                },
            };
        }
    </script>
@endsection
