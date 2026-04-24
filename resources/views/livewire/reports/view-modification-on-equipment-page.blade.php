@php
    $placeholderRows = range(1, 8);
@endphp

<div class="space-y-6">
    <x-page-header
        title="View Modification on Equipment"
        description="Choose equipment, inspect the hierarchy branch, and review embodied modifications on the selected equipment or its sub levels."
    />

    <x-status-message :message="$statusMessage" :tone="$statusTone" />
    <section class="max-w-[1280px] space-y-5">
        {{-- Top: Equipment lookup + sub-levels toggle --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                <div class="flex flex-wrap items-center gap-3">
                    <label class="text-xs font-semibold uppercase tracking-wider text-gray-500">Equipment No.</label>
                    <x-enterprise.input
                        variant="disabled"
                        :value="$equipment['equipment_no'] ?? ''"
                        readonly
                        class="max-w-[220px] bg-gray-50"
                    />
                    <button type="button" class="btn-secondary" wire:click="openSearchModal">Search Equipment</button>
                </div>

                <x-enterprise.checkbox
                    label="Include modification from sub levels"
                    labelClass="inline-flex items-center gap-3 text-sm text-gray-700"
                    wire:model.live="includeSubLevels"
                />
            </div>
        </div>

        {{-- Main: Hierarchy table + modifications panel --}}
        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_380px]">
            <x-enterprise.table-shell table-class="pending-base-table">
                <x-slot name="thead">
                    <tr>
                        <th>Designation</th>
                        <th>Item Code</th>
                        <th>Serial Number</th>
                    </tr>
                </x-slot>

                <x-slot name="tbody">
                    @if ($hierarchyRows !== [])
                        @foreach ($hierarchyRows as $row)
                            <tr
                                class="{{ $selectedHierarchyEquipmentId === $row['id'] ? 'is-selected' : '' }}"
                                wire:key="view-mod-hierarchy-row-{{ $row['id'] }}"
                                wire:click="selectHierarchyRow('{{ $row['id'] }}')"
                            >
                                <td>{{ $row['designation'] }}</td>
                                <td>{{ $row['item_code'] }}</td>
                                <td>{{ $row['serial_number'] }}</td>
                            </tr>
                        @endforeach
                    @else
                        @foreach ($placeholderRows as $row)
                            <tr>
                                <td class="text-transparent">&nbsp;</td>
                                <td class="text-transparent">&nbsp;</td>
                                <td class="text-transparent">&nbsp;</td>
                            </tr>
                        @endforeach
                    @endif
                </x-slot>
            </x-enterprise.table-shell>

            <div class="min-h-[420px] self-start rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <p class="mb-3 text-sm font-semibold text-gray-900">Modifications Embodied</p>
                <div class="min-h-[320px] space-y-3 rounded-xl border border-gray-200 p-3">
                    @if ($modificationRows !== [])
                        @foreach ($modificationRows as $row)
                            <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5" wire:key="modification-embodied-{{ md5($row['reference'] . $row['meta']) }}">
                                <p class="font-medium text-gray-900">{{ $row['reference'] }}</p>
                                <p class="text-sm text-gray-700">{{ $row['title'] }}</p>
                                <p class="text-xs text-gray-500">{{ $row['meta'] }}</p>
                            </div>
                        @endforeach
                    @else
                        @foreach (range(1, 5) as $i)
                            <div class="h-12 rounded-lg border border-dashed border-gray-200 bg-gray-50"></div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-gray-200 pt-5">
            <button type="button" class="btn-secondary" wire:click="cancelPreview">Cancel</button>
            <button type="button" class="btn-primary" wire:click="viewSelectedEquipment" @disabled($selectedHierarchyEquipmentId === null)>
                View selected equipment
            </button>
        </div>
    </section>

    {{-- Search modal --}}
    @if ($searchModalOpen)
        <div class="fixed inset-0 z-40 overflow-y-auto p-4">
            <div class="flex min-h-full items-center justify-center">
                <div class="relative w-full max-w-4xl">
                    <div class="relative flex max-h-[65vh] flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
                        <div class="flex items-start justify-between gap-4 border-b border-gray-200 px-5 py-4">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Search Equipment</h3>
                                <p class="mt-1 text-sm text-gray-500">Choose the root equipment for the modification embodiment report.</p>
                            </div>
                            <button type="button" class="btn-ghost px-3" wire:click="closeSearchModal" aria-label="Close modal">
                                <x-icon name="x-circle" />
                            </button>
                        </div>

                        <div class="flex-1 overflow-y-auto px-5 py-4">
                            <div class="space-y-5">
                                <div class="flex flex-wrap items-end gap-4">
                                    <div class="w-full max-w-sm">
                                        <x-form.input
                                            label="Search Equipment"
                                            name="view_modification_equipment_search"
                                            wire:model.live.debounce.250ms="equipmentSearch"
                                            placeholder="Search by ID, item code, serial number, or category..."
                                        />
                                    </div>
                                    <p class="pb-2 text-sm text-gray-500">
                                        Showing {{ $searchResults->count() }} result{{ $searchResults->count() === 1 ? '' : 's' }}.
                                    </p>
                                </div>

                                <x-enterprise.table-shell table-class="pending-base-table">
                                    <x-slot name="thead">
                                        <tr>
                                            <th>ID</th>
                                            <th>Item Code</th>
                                            <th>Part Description</th>
                                            <th>Serial Number</th>
                                            <th>Variant</th>
                                            <th>Status</th>
                                        </tr>
                                    </x-slot>

                                    <x-slot name="tbody">
                                        @forelse ($searchResults as $row)
                                            <tr
                                                class="{{ $pendingEquipmentId === $row['id'] ? 'is-selected' : '' }}"
                                                wire:key="view-mod-search-row-{{ $row['id'] }}"
                                                wire:click="selectSearchResult('{{ $row['id'] }}')"
                                            >
                                                <td>
                                                    <span class="inline-flex items-center gap-3 font-semibold text-gray-900">
                                                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">
                                                            <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                                        </span>
                                                        <span>{{ $row['id'] }}</span>
                                                    </span>
                                                </td>
                                                <td>{{ $row['item_no'] }}</td>
                                                <td>{{ $row['item_name'] }}</td>
                                                <td>{{ $row['serial_number'] }}</td>
                                                <td>{{ $row['variant'] }}</td>
                                                <td>{{ $row['status'] }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="py-12 text-center text-sm text-gray-500">
                                                    No equipment records match the current search.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </x-slot>
                                </x-enterprise.table-shell>

                                @if ($selectedSearchRecord)
                                    <div class="rounded-lg border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-700">
                                        Selected equipment {{ $selectedSearchRecord['id'] }} / {{ $selectedSearchRecord['item_no'] }} / {{ $selectedSearchRecord['serial_number'] !== '' ? $selectedSearchRecord['serial_number'] : 'No Serial' }}.
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-end gap-3 border-t border-gray-200 px-5 py-4">
                            <button type="button" class="btn-secondary" wire:click="closeSearchModal">Cancel</button>
                            <button type="button" class="btn-primary" wire:click="chooseSearchResult" @disabled($pendingEquipmentId === null)>Choose</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
