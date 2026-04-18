@php
    $objectType = $selectedRecord['object_type'] ?? '';
    $objectFields = $selectedRecord['object_fields'] ?? [
        ['label' => 'Code', 'value' => ''],
        ['label' => 'Serial Number', 'value' => ''],
        ['label' => 'Registration', 'value' => ''],
        ['label' => 'Type', 'value' => ''],
    ];

    $blankRows = range(1, 9);
@endphp

<div class="space-y-6" x-data="{ activeTab: 'object-information' }">
    <x-page-header
        title="WorkPackage"
        description="Work-package shell following the legacy operational structure with ATP-styled tabs, grids, and search workflow."
    />

    <x-status-message :message="$statusMessage" :tone="$statusTone" />
    <section class="max-w-[1280px] space-y-5">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="space-y-5">
                {{-- Code / Status --}}
                <div class="grid gap-6 xl:grid-cols-[320px_260px] xl:justify-between">
                    <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                        <span class="attach-field-label">Code</span>
                        <input
                            type="text"
                            readonly
                            value="{{ $selectedRecord['code'] ?? '' }}"
                            class="input-field attach-input {{ filled($selectedRecord['code'] ?? '') ? 'input-field-filled' : '' }}"
                        />
                    </div>

                    <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                        <span class="attach-field-label">Status</span>
                        <input
                            type="text"
                            readonly
                            value="{{ $selectedRecord['status'] ?? '' }}"
                            class="input-field attach-input {{ filled($selectedRecord['status'] ?? '') ? 'input-field-filled' : '' }}"
                        />
                    </div>
                </div>

                {{-- Object Type --}}
                <div class="rounded-xl border border-gray-200 bg-white p-4">
                    <div class="mb-3 text-sm font-semibold text-gray-900">Object Type</div>
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="rounded-full border px-4 py-2 text-sm {{ $objectType === 'Equipment' ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-gray-200 bg-gray-50 text-gray-500' }}">Equipment</div>
                        <div class="rounded-full border px-4 py-2 text-sm {{ $objectType === 'Functional Location' ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-gray-200 bg-gray-50 text-gray-500' }}">Functional Location</div>
                    </div>
                </div>

                {{-- Tabs --}}
                <div class="subtab-shell">
                    <div class="subtab-list">
                        @foreach ([
                            ['id' => 'object-information', 'label' => 'Object information'],
                            ['id' => 'visit', 'label' => 'Visit'],
                            ['id' => 'task-list', 'label' => 'Task List'],
                            ['id' => 'postponed-operations', 'label' => 'Postponed Operations'],
                            ['id' => 'deferred-defects', 'label' => 'Deferred Defects'],
                        ] as $tab)
                            <div class="subtab-item">
                                <button
                                    type="button"
                                    @click="activeTab = '{{ $tab['id'] }}'"
                                    class="subtab-link"
                                    :class="activeTab === '{{ $tab['id'] }}' ? 'subtab-link-active' : 'subtab-link-inactive'"
                                >
                                    {{ $tab['label'] }}
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Object Information tab --}}
                <div class="space-y-4 rounded-xl border border-gray-200 bg-white p-4" x-show="activeTab === 'object-information'" x-cloak>
                    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_280px]">
                        <div class="space-y-2">
                            @foreach ($objectFields as $field)
                                <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                                    <span class="attach-field-label">{{ $field['label'] }}</span>
                                    <input
                                        type="text"
                                        readonly
                                        value="{{ $field['value'] }}"
                                        class="input-field attach-input {{ filled($field['value']) ? 'input-field-filled' : '' }}"
                                    />
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-2">
                            @foreach ([
                                ['label' => 'Create Date', 'value' => $selectedRecord['create_date'] ?? ''],
                                ['label' => 'Created By', 'value' => $selectedRecord['created_by'] ?? ''],
                                ['label' => 'Update Date', 'value' => $selectedRecord['update_date'] ?? ''],
                                ['label' => 'Updated By', 'value' => $selectedRecord['updated_by'] ?? ''],
                            ] as $field)
                                <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                                    <span class="attach-field-label">{{ $field['label'] }}</span>
                                    <input
                                        type="text"
                                        readonly
                                        value="{{ $field['value'] }}"
                                        class="input-field attach-input {{ filled($field['value']) ? 'input-field-filled' : '' }}"
                                    />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid items-start gap-3 xl:grid-cols-[112px_minmax(0,1fr)]">
                        <span class="attach-field-label pt-2">Comment</span>
                        <textarea readonly class="input-field min-h-[82px] resize-none">{{ $selectedRecord['comment'] ?? '' }}</textarea>
                    </div>

                    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_340px]">
                        <div class="space-y-3 rounded-xl border border-gray-200 bg-white p-4">
                            <div class="mb-3 text-sm font-semibold text-gray-900">Linked Equipment in simulation</div>

                            <div class="min-h-[250px] overflow-hidden rounded-xl border border-gray-200 bg-white">
                                <table class="pending-base-table">
                                    <tbody>
                                        @if (count($linkedEquipment) > 0)
                                            @foreach ($linkedEquipment as $row)
                                                <tr>
                                                    <td class="border-b border-r border-gray-200 px-4 py-5 align-middle">{{ $row['reference'] }}</td>
                                                    <td class="border-b border-r border-gray-200 px-4 py-5 align-middle">{{ $row['description'] }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @foreach ($blankRows as $row)
                                                <tr>
                                                    <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                                    <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="space-y-4 rounded-xl border border-gray-200 bg-white p-4">
                            <div class="mb-3 text-sm font-semibold text-gray-900">Increment counters</div>

                            <div class="space-y-3">
                                <div class="grid items-center gap-3 xl:grid-cols-[72px_minmax(0,1fr)_60px_minmax(0,1fr)]">
                                    <span class="attach-field-label">Days</span>
                                    <input type="text" wire:model.live="days" class="input-field attach-input" />
                                    <span class="text-sm text-gray-600">Or Date</span>
                                    <input type="text" wire:model.live="orDate" class="input-field attach-input" />
                                </div>

                                <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                                    <span class="attach-field-label">Hours Increment</span>
                                    <input type="text" wire:model.live="hoursIncrement" class="input-field attach-input" />
                                </div>

                                <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                                    <span class="attach-field-label">Cycles Increment</span>
                                    <input type="text" wire:model.live="cyclesIncrement" class="input-field attach-input" />
                                </div>

                                <label class="mel-radio-option">
                                    <input type="checkbox" wire:model.live="calculateFromUtilizationModel" />
                                    <span>Calculate from utilization model</span>
                                </label>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <button type="button" class="btn-secondary" wire:click="searchAddVisitTaskList">Search/Add Visit/Task List</button>
                                <button type="button" class="btn-secondary" wire:click="clearSimulationList" @disabled(count($linkedEquipment) === 0)>Clear List</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Visit tab --}}
                <div class="space-y-4 rounded-xl border border-gray-200 bg-white p-4" x-show="activeTab === 'visit'" x-cloak>
                    <div class="min-h-[250px] overflow-hidden rounded-xl border border-gray-200 bg-white">
                        <table class="pending-base-table">
                            <tbody>
                                @foreach ($blankRows as $row)
                                    <tr>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex flex-wrap items-center justify-end gap-3">
                        <button type="button" class="btn-secondary" wire:click="selectAllVisit">Select All</button>
                        <button type="button" class="btn-secondary" wire:click="unselectAllVisit">Unselect All</button>
                        <button type="button" class="btn-secondary" wire:click="selectRemainingVisit">Select Remaining</button>
                        <button type="button" class="btn-secondary" wire:click="clearVisitList">Clear All</button>
                    </div>
                </div>

                {{-- Task List tab --}}
                <div class="space-y-4 rounded-xl border border-gray-200 bg-white p-4" x-show="activeTab === 'task-list'" x-cloak>
                    <div class="min-h-[250px] overflow-hidden rounded-xl border border-gray-200 bg-white">
                        <table class="pending-base-table">
                            <tbody>
                                @foreach ($blankRows as $row)
                                    <tr>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex flex-wrap items-center justify-end gap-3">
                        <button type="button" class="btn-secondary" wire:click="selectAllTaskList">Select All</button>
                        <button type="button" class="btn-secondary" wire:click="unselectAllTaskList">Unselect All</button>
                        <button type="button" class="btn-secondary" wire:click="selectRemainingTaskList">Select Remaining</button>
                        <button type="button" class="btn-secondary" wire:click="clearTaskList">Clear All</button>
                    </div>
                </div>

                {{-- Postponed Operations tab --}}
                <div class="space-y-4 rounded-xl border border-gray-200 bg-white p-4" x-show="activeTab === 'postponed-operations'" x-cloak>
                    <div class="min-h-[250px] overflow-hidden rounded-xl border border-gray-200 bg-white">
                        <table class="pending-base-table">
                            <tbody>
                                @foreach ($blankRows as $row)
                                    <tr>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex flex-wrap items-center justify-end gap-3">
                        <button type="button" class="btn-secondary" wire:click="selectAllPostponedOperations">Select All</button>
                        <button type="button" class="btn-secondary" wire:click="unselectAllPostponedOperations">Unselect All</button>
                        <button type="button" class="btn-secondary" wire:click="clearPostponedOperations">Clear All</button>
                    </div>
                </div>

                {{-- Deferred Defects tab --}}
                <div class="space-y-4 rounded-xl border border-gray-200 bg-white p-4" x-show="activeTab === 'deferred-defects'" x-cloak>
                    <div class="min-h-[250px] overflow-hidden rounded-xl border border-gray-200 bg-white">
                        <table class="pending-base-table">
                            <tbody>
                                @foreach ($blankRows as $row)
                                    <tr>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex flex-wrap items-center justify-end gap-3">
                        <button type="button" class="btn-secondary" wire:click="selectAllDeferredDefects">Select All</button>
                        <button type="button" class="btn-secondary" wire:click="unselectAllDeferredDefects">Unselect All</button>
                        <button type="button" class="btn-secondary" wire:click="clearDeferredDefects">Clear All</button>
                    </div>
                </div>
            </div>

            <div class="mt-5 flex flex-wrap items-center gap-3 border-t border-gray-200 pt-5">
                <button type="button" class="btn-primary" wire:click="openLookupModal">Find</button>
                <button type="button" class="btn-secondary" wire:click="cancelPreview">Cancel</button>
            </div>
        </div>
    </section>

    @if ($lookupModalOpen)
        <div class="fixed inset-0 z-40 overflow-y-auto p-4">
            <div class="flex min-h-full items-center justify-center">
                <div class="relative w-full max-w-4xl">
                    <div class="relative flex max-h-[68vh] flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
                        <div class="flex items-start justify-between gap-4 border-b border-gray-200 px-5 py-4">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Choose WorkPackage</h3>
                                <p class="mt-1 text-sm text-gray-500">Search for an existing work package and load it into the workspace.</p>
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
                                        name="work_package_lookup_search"
                                        wire:model.live.debounce.250ms="search"
                                        placeholder="Search by code, status, object type, or object reference..."
                                    />
                                </div>

                                <x-enterprise.table-shell table-class="pending-base-table">
                                    <x-slot name="thead">
                                        <tr>
                                            <th>Code</th>
                                            <th>Status</th>
                                            <th>Object Type</th>
                                            <th>Object Reference</th>
                                        </tr>
                                    </x-slot>

                                    <x-slot name="tbody">
                                        @foreach ($lookupRows as $row)
                                            <tr
                                                class="cursor-pointer transition-colors {{ $pendingSelectionId === (string) $row['id'] ? 'bg-blue-50/70' : '' }}"
                                                wire:key="work-package-lookup-{{ $row['id'] }}"
                                                wire:click="selectLookupRow('{{ $row['id'] }}')"
                                            >
                                                <td>{{ $row['code'] }}</td>
                                                <td>{{ $row['status'] }}</td>
                                                <td>{{ $row['object_type'] }}</td>
                                                <td>{{ $row['object_reference'] }}</td>
                                            </tr>
                                        @endforeach
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
