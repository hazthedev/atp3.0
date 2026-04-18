@php
    $equipmentFields = [
        ['label' => 'Equipment No.', 'key' => 'equipment_no'],
        ['label' => 'Serial Number', 'key' => 'serial_number'],
        ['label' => 'Item Code', 'key' => 'item_code'],
        ['label' => 'Part Description', 'key' => 'part_description'],
        ['label' => 'Engine Variant', 'key' => 'engine_variant'],
        ['label' => 'Category Part', 'key' => 'category_part'],
    ];

    $placeholderRows = range(1, 8);
@endphp

<div class="space-y-6">
    <x-page-header
        title="Historical Equipment Hierarchy"
        description="Choose equipment and load a historical hierarchy snapshot with related modifications, events, and counters."
    />

    <x-status-message :message="$statusMessage" :tone="$statusTone" />
    <section class="max-w-[1280px] space-y-5">
        {{-- Top: Equipment fields + Date / Time / View mode --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_300px]">
                {{-- Left: Equipment fields + search button --}}
                <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_auto] xl:items-start">
                    <div class="space-y-3">
                        @foreach ($equipmentFields as $field)
                            <div class="grid items-center gap-3 sm:grid-cols-[136px_minmax(0,1fr)]">
                                <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-gray-500 sm:mb-0">{{ $field['label'] }}</label>
                                <input
                                    type="text"
                                    value="{{ $equipment[$field['key']] ?? '' }}"
                                    readonly
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900"
                                />
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <button type="button" class="btn-secondary" wire:click="openSearchModal">Search Equipment</button>
                    </div>
                </div>

                {{-- Right: Date, Time, View mode, Result --}}
                <div class="space-y-4">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Date</label>
                            <input type="text" wire:model="reportDate" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-gray-500">Time</label>
                            <input type="text" wire:model="reportTime" class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20" />
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="inline-flex items-center gap-3 text-sm text-gray-700">
                            <input type="radio" wire:model="viewMode" value="all" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500" />
                            <span>View all hierarchy of equipments</span>
                        </label>

                        <label class="inline-flex items-center gap-3 text-sm text-gray-700">
                            <input type="radio" wire:model="viewMode" value="sons" class="h-4 w-4 border-gray-300 text-blue-600 focus:ring-blue-500" />
                            <span>View only son equipments</span>
                        </label>
                    </div>

                    <div>
                        <button type="button" class="btn-primary" wire:click="resultPreview">Result</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main: Hierarchy table + side panels --}}
        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
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
                                wire:key="hierarchy-row-{{ $row['id'] }}"
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

            <div class="flex flex-col gap-4">
                {{-- Applied modifications --}}
                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                    <p class="mb-3 text-sm font-semibold text-gray-900">List of applied modifications</p>
                    <div class="min-h-[120px] space-y-3 rounded-xl border border-gray-200 p-3">
                        @if ($appliedModifications !== [])
                            @foreach ($appliedModifications as $row)
                                <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5" wire:key="applied-modification-{{ md5($row['label'] . $row['meta']) }}">
                                    <p class="font-medium text-gray-900">{{ $row['label'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $row['meta'] }}</p>
                                </div>
                            @endforeach
                        @else
                            @foreach (range(1, 4) as $i)
                                <div class="h-12 rounded-lg border border-dashed border-gray-200 bg-gray-50"></div>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- Events --}}
                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                    <p class="mb-3 text-sm font-semibold text-gray-900">List of Events</p>
                    <div class="min-h-[120px] space-y-3 rounded-xl border border-gray-200 p-3">
                        @if ($eventRows !== [])
                            @foreach ($eventRows as $row)
                                <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5" wire:key="event-row-{{ md5($row['label'] . $row['meta']) }}">
                                    <p class="font-medium text-gray-900">{{ $row['label'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $row['meta'] }}</p>
                                </div>
                            @endforeach
                        @else
                            @foreach (range(1, 3) as $i)
                                <div class="h-12 rounded-lg border border-dashed border-gray-200 bg-gray-50"></div>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- Counters --}}
                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                    <p class="mb-3 text-sm font-semibold text-gray-900">Counters</p>
                    <div class="min-h-[120px] space-y-3 rounded-xl border border-gray-200 p-3">
                        @if ($counterRows !== [])
                            @foreach ($counterRows as $row)
                                <div class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5" wire:key="counter-row-{{ md5($row['label'] . $row['meta']) }}">
                                    <div class="flex items-center justify-between gap-3">
                                        <p class="font-medium text-gray-900">{{ $row['label'] }}</p>
                                        <p class="text-sm text-gray-600">{{ $row['meta'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @foreach (range(1, 3) as $i)
                                <div class="h-12 rounded-lg border border-dashed border-gray-200 bg-gray-50"></div>
                            @endforeach
                        @endif
                    </div>
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
                                <p class="mt-1 text-sm text-gray-500">Choose the root equipment to build the hierarchy snapshot.</p>
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
                                            name="historical_equipment_search"
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
                                                wire:key="historical-search-row-{{ $row['id'] }}"
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
