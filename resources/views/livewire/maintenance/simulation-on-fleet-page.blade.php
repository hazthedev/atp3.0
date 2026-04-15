@php
    $statusClasses = match ($statusTone) {
        'green' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
        'amber' => 'border-amber-200 bg-amber-50 text-amber-700',
        'red' => 'border-red-200 bg-red-50 text-red-700',
        default => 'border-blue-200 bg-blue-50 text-blue-700',
    };
@endphp

<div class="space-y-6">
    <x-page-header
        title="Simulation on Fleet"
        description="Choose report parameters, load the relevant functional locations and equipment, then start the fleet simulation preview."
    />

    @if ($statusMessage)
        <div class="flex items-center rounded-lg border p-4 text-sm {{ $statusClasses }}" role="alert">
            <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
            <span>{{ $statusMessage }}</span>
        </div>
    @endif

    <section class="max-w-[1280px] space-y-5">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            {{-- Days / Date --}}
            <div class="flex flex-wrap items-center gap-8">
                <div class="grid items-center gap-3" style="grid-template-columns: 56px auto">
                    <span class="attach-field-label">Days</span>
                    <input type="text" wire:model.live="days" class="input-field attach-input" style="width: 92px" />
                </div>

                <div class="grid items-center gap-3" style="grid-template-columns: 56px auto">
                    <span class="attach-field-label">Date</span>
                    <input type="text" wire:model.live="date" class="input-field attach-input" style="width: 128px" />
                </div>
            </div>

            {{-- Functional Location panel --}}
            <div class="mt-5 rounded-xl border border-gray-200 bg-white p-4">
                <div class="mb-4 flex flex-wrap items-center gap-4">
                    <div class="text-sm font-semibold text-gray-900">Functional Location</div>
                    <button type="button" class="btn-secondary" wire:click="loadFunctionalLocationList">Get Functional Location List</button>
                </div>

                <div class="min-h-[180px] overflow-hidden rounded-xl border border-gray-200 bg-white">
                    <table class="pending-base-table">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Code</th>
                                <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Type</th>
                                <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Serial Number</th>
                                <th class="border-b border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Registration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($functionalLocations as $row)
                                <tr>
                                    <td class="border-b border-r border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['code'] }}</td>
                                    <td class="border-b border-r border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['type'] }}</td>
                                    <td class="border-b border-r border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['serial_number'] }}</td>
                                    <td class="border-b border-r border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['registration'] }}</td>
                                </tr>
                            @empty
                                @foreach ($blankRows as $row)
                                    <tr>
                                        <td class="border-b border-r border-gray-200 px-3 py-2"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-3 py-2"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-3 py-2"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-3 py-2"><span class="invisible">placeholder</span></td>
                                    </tr>
                                @endforeach
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Equipment panel --}}
            <div class="mt-5 rounded-xl border border-gray-200 bg-white p-4">
                <div class="mb-4 flex flex-wrap items-center gap-4">
                    <div class="text-sm font-semibold text-gray-900">Equipment</div>
                    <button type="button" class="btn-secondary" wire:click="loadEquipmentList">Get Equipment List</button>
                </div>

                <div class="min-h-[180px] overflow-hidden rounded-xl border border-gray-200 bg-white">
                    <table class="pending-base-table">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Code</th>
                                <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Part Number</th>
                                <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Part Number Name</th>
                                <th class="border-b border-r border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Serial Number</th>
                                <th class="border-b border-gray-200 px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Variant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($equipments as $row)
                                <tr>
                                    <td class="border-b border-r border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['code'] }}</td>
                                    <td class="border-b border-r border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['part_number'] }}</td>
                                    <td class="border-b border-r border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['part_number_name'] }}</td>
                                    <td class="border-b border-r border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['serial_number'] }}</td>
                                    <td class="border-b border-r border-gray-200 px-3 py-2 text-sm text-gray-700">{{ $row['variant'] }}</td>
                                </tr>
                            @empty
                                @foreach ($blankRows as $row)
                                    <tr>
                                        <td class="border-b border-r border-gray-200 px-3 py-2"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-3 py-2"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-3 py-2"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-3 py-2"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-3 py-2"><span class="invisible">placeholder</span></td>
                                    </tr>
                                @endforeach
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Options + Group By --}}
            <div class="mt-5 grid gap-6 xl:grid-cols-[minmax(0,1fr)_280px]">
                <div class="space-y-2">
                    <label class="attach-checkbox-row">
                        <input type="checkbox" wire:model.live="includeSubEquipmentWithMaintenancePlan" />
                        <span>Include sub equipment with maintenance plan</span>
                    </label>

                    <label class="attach-checkbox-row">
                        <input type="checkbox" wire:model.live="includeTaskList" />
                        <span>Include task list</span>
                    </label>

                    <label class="attach-checkbox-row">
                        <input type="checkbox" wire:model.live="includeCountersWithPotential" />
                        <span>Include counters with potential</span>
                    </label>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-4">
                    <div class="mb-3 text-sm font-semibold text-gray-900">Group By</div>

                    <div class="space-y-2">
                        <label class="mel-radio-option">
                            <input type="radio" value="chapter" wire:model.live="groupBy" />
                            <span>Chapter</span>
                        </label>

                        <label class="mel-radio-option">
                            <input type="radio" value="chapter-section" wire:model.live="groupBy" />
                            <span>Chapter - Section</span>
                        </label>

                        <label class="mel-radio-option">
                            <input type="radio" value="none" wire:model.live="groupBy" />
                            <span>None</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-5 flex flex-wrap items-center gap-3 border-t border-gray-200 pt-5">
                <button type="button" class="btn-primary" wire:click="startSimulation">Start</button>
                <button type="button" class="btn-secondary" wire:click="cancelSimulation">Cancel</button>
            </div>
        </div>
    </section>
</div>
