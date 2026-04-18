@php
    $lookupHeading = $scope === 'functional-location' ? 'Search Functional Locations' : 'Search Equipments';
    $lookupDescription = $scope === 'functional-location'
        ? 'Choose the functional location to apply visits and task lists against.'
        : 'Choose the equipment to apply visits and task lists against.';

    $objectFields = $scope === 'functional-location'
        ? [
            ['label' => 'Code', 'value' => $selectedRecord['code'] ?? ''],
            ['label' => 'Serial Number', 'value' => $selectedRecord['serial_no'] ?? ''],
            ['label' => 'Registration', 'value' => $selectedRecord['registration'] ?? ''],
            ['label' => 'Type', 'value' => $selectedRecord['type'] ?? ''],
        ]
        : [
            ['label' => 'Equipment No.', 'value' => $selectedRecord['equipment_no'] ?? $selectedRecord['id'] ?? ''],
            ['label' => 'Internal S/N', 'value' => $selectedRecord['serial_number'] ?? ''],
            ['label' => 'Item Code', 'value' => $selectedRecord['item_no'] ?? ''],
            ['label' => 'Item Description', 'value' => $selectedRecord['item_description'] ?? $selectedRecord['item_name'] ?? ''],
            ['label' => 'Variant', 'value' => $selectedRecord['variant'] ?? ''],
            ['label' => 'Category Part', 'value' => $selectedRecord['category_part'] ?? ''],
        ];

    $counterRows = range(1, 8);
    $resultRows = range(1, 11);
@endphp

<div class="space-y-6">
    <x-page-header
        title="Apply Visits and Task Lists"
        description="Apply visits or task lists to the selected equipment or functional location using the current ATP maintenance workspace."
    />

    <x-status-message :message="$statusMessage" :tone="$statusTone" />
    <section class="max-w-[1280px] space-y-5">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            {{-- Two-column top layout --}}
            <div class="grid gap-6 xl:grid-cols-[280px_minmax(0,1fr)]">
                {{-- Left: scope + object fields --}}
                <div class="space-y-4">
                    <div class="flex flex-wrap items-center gap-6">
                        <label class="mel-radio-option">
                            <input type="radio" value="equipment" wire:model.live="scope" />
                            <span>Equipment</span>
                        </label>
                        <label class="mel-radio-option">
                            <input type="radio" value="functional-location" wire:model.live="scope" />
                            <span>Functional location</span>
                        </label>
                    </div>

                    <div class="space-y-2">
                        @foreach ($objectFields as $index => $field)
                            <div class="grid items-center gap-3" style="grid-template-columns: 104px minmax(0, 1fr)">
                                <span class="attach-field-label">{{ $field['label'] }}</span>

                                @if ($index === 0)
                                    <div class="grid items-center gap-2" style="grid-template-columns: minmax(0,1fr) 40px">
                                        <input
                                            type="text"
                                            readonly
                                            value="{{ $field['value'] }}"
                                            class="input-field attach-input {{ filled($field['value']) ? 'input-field-filled' : '' }}"
                                        />
                                        <button
                                            type="button"
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-white text-xs font-semibold tracking-wider text-gray-500 shadow-sm transition hover:text-gray-700"
                                            wire:click="openLookupModal"
                                            aria-label="Open lookup"
                                        >...</button>
                                    </div>
                                @else
                                    <input
                                        type="text"
                                        readonly
                                        value="{{ $field['value'] }}"
                                        class="input-field attach-input {{ filled($field['value']) ? 'input-field-filled' : '' }}"
                                    />
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-2 pt-2">
                        <div class="grid items-center gap-3" style="grid-template-columns: 104px minmax(0, 1fr)">
                            <span class="attach-field-label">Maintenance Plan</span>
                            <input type="text" readonly value="{{ $maintenancePlan }}" class="input-field attach-input {{ filled($maintenancePlan) ? 'input-field-filled' : '' }}" />
                        </div>
                        <div class="grid items-center gap-3" style="grid-template-columns: 104px minmax(0, 1fr)">
                            <span class="attach-field-label">Operational</span>
                            <input type="text" readonly value="{{ $operational }}" class="input-field attach-input {{ filled($operational) ? 'input-field-filled' : '' }}" />
                        </div>
                        <div class="grid items-center gap-3" style="grid-template-columns: 104px minmax(0, 1fr)">
                            <span class="attach-field-label">Mode :</span>
                            <input type="text" readonly value="{{ $mode }}" class="input-field attach-input {{ filled($mode) ? 'input-field-filled' : '' }}" />
                        </div>
                    </div>
                </div>

                {{-- Right: Application date + counters --}}
                <div class="space-y-4">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div class="grid items-center gap-3" style="grid-template-columns: 112px 160px">
                            <span class="attach-field-label">Application Date</span>
                            <input type="text" wire:model.live="applicationDate" class="input-field attach-input" />
                        </div>
                        <button type="button" class="btn-secondary" wire:click="getCurrentValues">Get current values</button>
                    </div>

                    <div class="space-y-2">
                        <div class="mb-3 text-sm font-semibold text-gray-900">Enter counter values at application date :</div>

                        <div class="min-h-[188px] overflow-hidden rounded-xl border border-gray-200 bg-white">
                            <table class="pending-base-table">
                                <tbody>
                                    @foreach ($counterRows as $row)
                                        <tr>
                                            <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                            <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                            <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabs + Results --}}
            <div class="mt-5 rounded-xl border border-gray-200 bg-white p-4">
                <div class="subtab-shell">
                    <div class="subtab-list">
                        @foreach ([['id' => 'visit', 'label' => 'Visit'], ['id' => 'task-list', 'label' => 'Task List']] as $tab)
                            <div class="subtab-item">
                                <button
                                    type="button"
                                    wire:click="$set('activeTab', '{{ $tab['id'] }}')"
                                    class="subtab-link {{ $activeTab === $tab['id'] ? 'subtab-link-active' : 'subtab-link-inactive' }}"
                                >
                                    {{ $tab['label'] }}
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 space-y-4">
                    <div class="min-h-[250px] overflow-hidden rounded-xl border border-gray-200 bg-white">
                        <table class="pending-base-table">
                            <tbody>
                                @foreach ($resultRows as $row)
                                    <tr>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-wrap items-center justify-end gap-3">
                        <button type="button" class="btn-secondary" wire:click="applyAll">Apply All</button>

                        @if ($activeTab === 'visit')
                            <button type="button" class="btn-secondary" wire:click="addVisit">Add Visit</button>
                        @else
                            <button type="button" class="btn-secondary" wire:click="addTaskList">Add Task List</button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-5 flex flex-wrap items-center gap-3 border-t border-gray-200 pt-5">
                <button type="button" class="btn-primary" wire:click="submitApply">Apply</button>
                <button type="button" class="btn-secondary" wire:click="cancelPreview">Cancel</button>
            </div>
        </div>
    </section>

    @if ($lookupModalOpen)
        <div class="fixed inset-0 z-40 overflow-y-auto p-4">
            <div class="flex min-h-full items-center justify-center">
                <div class="relative w-full max-w-3xl">
                    <div class="relative flex max-h-[62vh] flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
                        <div class="flex items-start justify-between gap-4 border-b border-gray-200 px-5 py-4">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">{{ $lookupHeading }}</h3>
                                <p class="mt-1 text-sm text-gray-500">{{ $lookupDescription }}</p>
                            </div>
                            <button type="button" class="btn-ghost px-3" wire:click="closeLookupModal" aria-label="Close modal">
                                <x-icon name="x-circle" />
                            </button>
                        </div>

                        <div class="flex-1 overflow-y-auto px-5 py-4">
                            <div class="space-y-5">
                                <div class="w-full max-w-sm">
                                    <x-form.input
                                        label="Find"
                                        name="apply_visit_task_lookup_search"
                                        wire:model.live.debounce.250ms="search"
                                        placeholder="{{ $scope === 'functional-location' ? 'Search by code, serial number, registration, or type...' : 'Search by equipment no., serial number, item code, or description...' }}"
                                    />
                                </div>

                                <x-enterprise.table-shell table-class="pending-base-table">
                                    <x-slot name="thead">
                                        @if ($scope === 'functional-location')
                                            <tr>
                                                <th>Code</th>
                                                <th>Serial Number</th>
                                                <th>Registration</th>
                                                <th>Type</th>
                                            </tr>
                                        @else
                                            <tr>
                                                <th>Equipment No.</th>
                                                <th>Internal S/N</th>
                                                <th>Item Code</th>
                                                <th>Item Description</th>
                                                <th>Variant</th>
                                                <th>Category Part</th>
                                            </tr>
                                        @endif
                                    </x-slot>

                                    <x-slot name="tbody">
                                        @forelse ($lookupRows as $row)
                                            <tr
                                                class="cursor-pointer transition-colors {{ $pendingSelectionId === (string) $row['id'] ? 'bg-blue-50/70' : '' }}"
                                                wire:key="apply-visit-task-lookup-{{ $scope }}-{{ $row['id'] }}"
                                                wire:click="selectLookupRow('{{ $row['id'] }}')"
                                            >
                                                @if ($scope === 'functional-location')
                                                    <td>{{ $row['code'] }}</td>
                                                    <td>{{ $row['serial_no'] }}</td>
                                                    <td>{{ $row['registration'] }}</td>
                                                    <td>{{ $row['type'] }}</td>
                                                @else
                                                    <td>{{ $row['equipment_no'] ?? $row['id'] }}</td>
                                                    <td>{{ $row['serial_number'] }}</td>
                                                    <td>{{ $row['item_no'] }}</td>
                                                    <td>{{ $row['item_description'] ?? $row['item_name'] }}</td>
                                                    <td>{{ $row['variant'] }}</td>
                                                    <td>{{ $row['category_part'] }}</td>
                                                @endif
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="{{ $scope === 'functional-location' ? 4 : 6 }}" class="py-8 text-center text-sm text-gray-500">
                                                    No matching records found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </x-slot>
                                </x-enterprise.table-shell>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 border-t border-gray-200 px-5 py-4">
                            <button type="button" class="btn-primary" wire:click="chooseLookupRow" @disabled($pendingSelectionId === null)>Choose</button>
                            <button type="button" class="btn-secondary" wire:click="closeLookupModal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
