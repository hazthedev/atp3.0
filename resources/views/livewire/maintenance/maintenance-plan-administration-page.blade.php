@php
    $statusClasses = match ($statusTone) {
        'green' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
        'amber' => 'border-amber-200 bg-amber-50 text-amber-700',
        'red' => 'border-red-200 bg-red-50 text-red-700',
        default => 'border-blue-200 bg-blue-50 text-blue-700',
    };

    $lookupHeading = $scope === 'functional-location' ? 'Search Functional Locations' : 'Search Equipments';
    $lookupDescription = $scope === 'functional-location'
        ? 'Choose the functional location that should drive the maintenance-plan administration context.'
        : 'Choose the equipment that should drive the maintenance-plan administration context.';

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

    $visitRows = range(1, 10);
    $taskRows = range(1, 10);
@endphp

<div class="space-y-6" x-data="{ activeTab: 'visit' }">
    <x-page-header
        title="Maintenance Plan Administration"
        description="Administer visits and task lists with the legacy maintenance-plan workflow adapted into the current ATP design system."
    />

    @if ($statusMessage)
        <div class="flex items-center rounded-lg border p-4 text-sm {{ $statusClasses }}" role="alert">
            <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
            <span>{{ $statusMessage }}</span>
        </div>
    @endif

    <section class="max-w-[1280px] space-y-5">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="space-y-5">
                {{-- Scope radio --}}
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

                {{-- Top: Object panel + Action panel --}}
                <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
                    <div class="rounded-xl border border-gray-200 bg-white p-4">
                        <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_auto] xl:items-start">
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

                            <div class="flex items-start">
                                <button type="button" class="btn-secondary" wire:click="openLookupModal">
                                    {{ $scope === 'functional-location' ? 'Search FL' : 'Search Equipment' }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 rounded-xl border border-gray-200 bg-white p-4">
                        <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                            <span class="attach-field-label">Maintenance Program</span>
                            <input
                                type="text"
                                readonly
                                value="{{ $maintenanceProgram }}"
                                class="input-field attach-input {{ filled($maintenanceProgram) ? 'input-field-filled' : '' }}"
                            />
                        </div>

                        <div class="text-sm text-gray-700">Operational</div>

                        <div>
                            <button type="button" class="btn-secondary" wire:click="checkOperationalStatus">Check Operational Status</button>
                        </div>
                    </div>
                </div>

                {{-- Tabs --}}
                <div class="subtab-shell">
                    <div class="subtab-list">
                        @foreach ([
                            ['id' => 'visit', 'label' => 'Visit'],
                            ['id' => 'task-list', 'label' => 'Task List'],
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

                {{-- Visit tab --}}
                <div class="space-y-4 rounded-xl border border-gray-200 bg-white p-4 pt-4" x-show="activeTab === 'visit'" x-cloak>
                    <div class="rounded-xl border border-gray-200 p-4">
                        <div class="mb-4 text-sm font-semibold text-gray-900">Search Visit</div>

                        <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_minmax(0,1fr)_auto] xl:items-end">
                            <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                                <span class="attach-field-label">Active</span>
                                <select wire:model.live="visitActive" class="input-field attach-input">
                                    <option value=""></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>

                            <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                                <span class="attach-field-label">Status</span>
                                <select wire:model.live="visitStatus" class="input-field attach-input">
                                    <option value=""></option>
                                    <option value="Draft">Draft</option>
                                    <option value="Released">Released</option>
                                    <option value="Approved">Approved</option>
                                </select>
                            </div>

                            <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                                <span class="attach-field-label">Initialized</span>
                                <select wire:model.live="visitInitialized" class="input-field attach-input">
                                    <option value=""></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>

                            <div class="flex justify-end">
                                <button type="button" class="btn-secondary" wire:click="refreshVisits">Refresh</button>
                            </div>
                        </div>
                    </div>

                    <div class="min-h-[250px] overflow-hidden rounded-xl border border-gray-200 bg-white">
                        <table class="pending-base-table">
                            <tbody>
                                @foreach ($visitRows as $row)
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

                    <div class="flex justify-end">
                        <button type="button" class="btn-secondary" wire:click="updateVisitPreview">Update Visit</button>
                    </div>
                </div>

                {{-- Task List tab --}}
                <div class="space-y-4 rounded-xl border border-gray-200 bg-white p-4 pt-4" x-show="activeTab === 'task-list'" x-cloak>
                    <div class="rounded-xl border border-gray-200 p-4">
                        <div class="mb-4 text-sm font-semibold text-gray-900">Search Task List</div>

                        <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_minmax(0,1fr)_auto] xl:items-end">
                            <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                                <span class="attach-field-label">Active</span>
                                <select wire:model.live="taskActive" class="input-field attach-input">
                                    <option value=""></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>

                            <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                                <span class="attach-field-label">Status</span>
                                <select wire:model.live="taskStatus" class="input-field attach-input">
                                    <option value=""></option>
                                    <option value="Draft">Draft</option>
                                    <option value="Released">Released</option>
                                    <option value="Approved">Approved</option>
                                </select>
                            </div>

                            <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                                <span class="attach-field-label">Initialized</span>
                                <select wire:model.live="taskInitialized" class="input-field attach-input">
                                    <option value=""></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>

                            <div class="flex flex-wrap items-center justify-end gap-3">
                                <button type="button" class="btn-secondary">Advanced search</button>
                                <button type="button" class="btn-secondary" wire:click="refreshTaskLists">Refresh</button>
                            </div>

                            <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)] xl:col-span-2">
                                <span class="attach-field-label">Task List Ref</span>
                                <input type="text" wire:model.live="taskListRef" class="input-field attach-input" />
                            </div>

                            <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)] xl:col-span-2">
                                <span class="attach-field-label">Key Word</span>
                                <input type="text" wire:model.live="taskKeyword" class="input-field attach-input" />
                            </div>

                            <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                                <span class="attach-field-label">Sub Equipment</span>
                                <select wire:model.live="taskSubEquipment" class="input-field attach-input">
                                    <option value=""></option>
                                    <option value="Equipment">Equipment</option>
                                    <option value="Functional Location">Functional Location</option>
                                </select>
                            </div>

                            <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                                <span class="attach-field-label">Effectivity</span>
                                <select wire:model.live="taskEffectivity" class="input-field attach-input">
                                    <option value=""></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>

                            <div class="grid items-center gap-3 xl:col-span-2 xl:grid-cols-[112px_minmax(0,1fr)] xl:items-center">
                                <span class="attach-field-label">Chapter - Section</span>
                                <div class="grid grid-cols-[minmax(0,1fr)_20px_minmax(0,1fr)] items-center gap-3">
                                    <input type="text" wire:model.live="taskChapter" class="input-field attach-input" />
                                    <span class="text-center text-sm text-gray-500">-</span>
                                    <input type="text" wire:model.live="taskSection" class="input-field attach-input" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="min-h-[250px] overflow-hidden rounded-xl border border-gray-200 bg-white">
                        <table class="pending-base-table">
                            <tbody>
                                @foreach ($taskRows as $row)
                                    <tr>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                        <td class="border-b border-r border-gray-200 px-4 py-5 align-middle"><span class="invisible">placeholder</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" class="btn-secondary" wire:click="updateTaskListPreview">Update Task List</button>
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
                                        name="maintenance_plan_admin_lookup_search"
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
                                        @foreach ($lookupRows as $row)
                                            <tr
                                                class="cursor-pointer transition-colors {{ $pendingSelectionId === (string) $row['id'] ? 'bg-blue-50/70' : '' }}"
                                                wire:key="maintenance-plan-admin-lookup-{{ $scope }}-{{ $row['id'] }}"
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
