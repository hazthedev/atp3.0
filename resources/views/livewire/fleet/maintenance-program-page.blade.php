@php
    $generalLeftFields = [
        ['label' => 'External Ref.', 'key' => 'external_ref'],
        ['label' => 'Version', 'key' => 'version'],
        ['label' => 'Effective date', 'key' => 'effective_date'],
    ];

    $generalRightFields = [
        ['label' => 'Create Date', 'key' => 'create_date'],
        ['label' => 'Created By', 'key' => 'created_by'],
        ['label' => 'Update Date', 'key' => 'update_date'],
        ['label' => 'Updated By', 'key' => 'updated_by'],
    ];
@endphp

<div class="space-y-6" x-data="{ activeTab: 'general' }">
    <x-page-header
        title="Maintenance Program"
        description="Maintenance-program workspace using the legacy tab structure in the current ATP design system."
    />

    <x-status-message :message="$statusMessage" :tone="$statusTone" />
    <section class="max-w-[1280px] space-y-5">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="space-y-5">
                {{-- Top: Code / Name / Status --}}
                <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_280px]">
                    <div class="space-y-2">
                        <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                            <span class="attach-field-label">Code</span>
                            <input type="text" value="{{ $program['code'] ?? '' }}" readonly class="input-field attach-input {{ filled($program['code'] ?? '') ? 'input-field-filled' : '' }}" />
                        </div>
                        <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                            <span class="attach-field-label">Name</span>
                            <input type="text" value="{{ $program['name'] ?? '' }}" readonly class="input-field attach-input {{ filled($program['name'] ?? '') ? 'input-field-filled' : '' }}" />
                        </div>
                    </div>

                    <div>
                        <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                            <span class="attach-field-label">Status</span>
                            <select class="input-field attach-input {{ filled($program['status'] ?? '') ? 'input-field-filled' : '' }}">
                                <option value=""></option>
                                <option value="Draft" @selected(($program['status'] ?? '') === 'Draft')>Draft</option>
                                <option value="Released" @selected(($program['status'] ?? '') === 'Released')>Released</option>
                                <option value="Approved" @selected(($program['status'] ?? '') === 'Approved')>Approved</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Tabs --}}
                <div class="subtab-shell">
                    <div class="subtab-list">
                        @foreach ([
                            ['id' => 'general', 'label' => 'General'],
                            ['id' => 'visits', 'label' => 'Visits'],
                            ['id' => 'task-lists', 'label' => 'Task Lists'],
                            ['id' => 'applied-to', 'label' => 'Applied To'],
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

                {{-- General tab --}}
                <div class="modification-tab-panel" x-show="activeTab === 'general'" x-cloak>
                    <div class="grid gap-6 xl:grid-cols-[minmax(0,320px)_280px]">
                        <div class="space-y-2">
                            @foreach ($generalLeftFields as $field)
                                <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                                    <span class="attach-field-label">{{ $field['label'] }}</span>
                                    <input type="text" value="{{ $program[$field['key']] ?? '' }}" readonly class="input-field attach-input {{ filled($program[$field['key']] ?? '') ? 'input-field-filled' : '' }}" />
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-2">
                            @foreach ($generalRightFields as $field)
                                <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                                    <span class="attach-field-label">{{ $field['label'] }}</span>
                                    <input type="text" value="{{ $program[$field['key']] ?? '' }}" readonly class="input-field attach-input {{ filled($program[$field['key']] ?? '') ? 'input-field-filled' : '' }}" />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-5 rounded-xl border border-gray-200 p-5">
                        <div class="mb-4 text-sm font-semibold text-gray-900">Apply To</div>
                        <div class="space-y-2">
                            @foreach (['Equipment', 'Functional Location'] as $target)
                                <div class="text-sm {{ in_array($target, $program['apply_to'] ?? [], true) ? 'text-gray-800' : 'text-gray-400' }}">
                                    {{ $target }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Visits tab --}}
                <div class="modification-tab-panel" x-show="activeTab === 'visits'" x-cloak>
                    <div class="min-h-[320px]">
                        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm h-full">
                            <div class="max-h-[320px] min-h-[260px] overflow-auto">
                                <table class="pending-base-table">
                                    <thead>
                                        <tr>
                                            <th>Visit</th>
                                            <th>Interval</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse (($program['visits'] ?? []) as $row)
                                            <tr>
                                                <td>{{ $row['visit'] }}</td>
                                                <td>{{ $row['interval'] }}</td>
                                                <td>{{ $row['status'] }}</td>
                                            </tr>
                                        @empty
                                            @foreach (range(1, 9) as $placeholder)
                                                <tr>
                                                    <td><span class="invisible">.</span></td>
                                                    <td><span class="invisible">.</span></td>
                                                    <td><span class="invisible">.</span></td>
                                                </tr>
                                            @endforeach
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-end gap-3 pt-4">
                        <button type="button" class="btn-secondary" @disabled(! $programId)>Add Visit</button>
                        <button type="button" class="btn-secondary" @disabled(! $programId)>Update Visit</button>
                    </div>
                </div>

                {{-- Task Lists tab --}}
                <div class="modification-tab-panel" x-show="activeTab === 'task-lists'" x-cloak>
                    <div class="space-y-5">
                        <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_280px]">
                            <div class="space-y-2">
                                <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                                    <span class="attach-field-label">Active</span>
                                    <select class="input-field attach-input">
                                        <option value=""></option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                                    <span class="attach-field-label">Task List Ref.</span>
                                    <input type="text" class="input-field attach-input" />
                                </div>
                                <div class="grid items-center gap-3 sm:grid-cols-[112px_minmax(0,1fr)]">
                                    <span class="attach-field-label">Key Word</span>
                                    <input type="text" class="input-field attach-input" />
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="grid grid-cols-[88px_1fr_24px_1fr] items-center gap-3">
                                    <span class="attach-field-label">Chapter</span>
                                    <input type="text" class="input-field attach-input" />
                                    <span class="text-center text-sm text-gray-500">-</span>
                                    <input type="text" class="input-field attach-input" />
                                </div>

                                <div class="flex flex-wrap items-center justify-end gap-3">
                                    <button type="button" class="btn-secondary">Advanced search</button>
                                    <button type="button" class="btn-secondary">Refresh</button>
                                </div>
                            </div>
                        </div>

                        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                            <div class="max-h-[260px] min-h-[210px] overflow-auto">
                                <table class="pending-base-table">
                                    <thead>
                                        <tr>
                                            <th>Active</th>
                                            <th>Task List Ref.</th>
                                            <th>Key Word</th>
                                            <th>Chapter</th>
                                            <th>Section</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse (($program['task_lists'] ?? []) as $row)
                                            <tr>
                                                <td>{{ $row['active'] }}</td>
                                                <td>{{ $row['task_list_ref'] }}</td>
                                                <td>{{ $row['keyword'] }}</td>
                                                <td>{{ $row['chapter'] }}</td>
                                                <td>{{ $row['section'] }}</td>
                                            </tr>
                                        @empty
                                            @foreach (range(1, 7) as $placeholder)
                                                <tr>
                                                    <td><span class="invisible">.</span></td>
                                                    <td><span class="invisible">.</span></td>
                                                    <td><span class="invisible">.</span></td>
                                                    <td><span class="invisible">.</span></td>
                                                    <td><span class="invisible">.</span></td>
                                                </tr>
                                            @endforeach
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div class="grid grid-cols-[160px_120px] items-center gap-3">
                                <span class="text-sm text-gray-600">Number of records found</span>
                                <input type="text" readonly value="{{ count($program['task_lists'] ?? []) }}" class="input-field attach-input {{ $programId ? 'input-field-filled' : '' }}" />
                            </div>

                            <div class="flex flex-wrap items-center gap-3">
                                <button type="button" class="btn-secondary" @disabled(! $programId)>Add Task List</button>
                                <button type="button" class="btn-secondary" @disabled(! $programId)>Update Task List</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Applied To tab --}}
                <div class="modification-tab-panel" x-show="activeTab === 'applied-to'" x-cloak>
                    <div class="min-h-[320px]">
                        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm h-full">
                            <div class="max-h-[320px] min-h-[260px] overflow-auto">
                                <table class="pending-base-table">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Reference</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse (($program['applied_to_rows'] ?? []) as $row)
                                            <tr>
                                                <td>{{ $row['type'] }}</td>
                                                <td>{{ $row['reference'] }}</td>
                                            </tr>
                                        @empty
                                            @foreach (range(1, 9) as $placeholder)
                                                <tr>
                                                    <td><span class="invisible">.</span></td>
                                                    <td><span class="invisible">.</span></td>
                                                </tr>
                                            @endforeach
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                <div class="relative w-full max-w-3xl">
                    <div class="relative flex max-h-[68vh] flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
                        <div class="flex items-start justify-between gap-4 border-b border-gray-200 px-5 py-4">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Choose From List</h3>
                                <p class="mt-1 text-sm text-gray-500">Search and choose a maintenance program to load into this workspace.</p>
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
                                        name="maintenance_program_lookup_search"
                                        wire:model.live.debounce.250ms="search"
                                        placeholder="Search by code, name, status, or version..."
                                    />
                                </div>

                                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                                    <div class="overflow-x-auto">
                                        <table class="pending-base-table">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($lookupRows as $row)
                                                    <tr
                                                        class="cursor-pointer transition-colors {{ $pendingProgramId === $row['id'] ? 'bg-blue-50/70' : '' }}"
                                                        wire:key="maintenance-program-lookup-{{ $row['id'] }}"
                                                        wire:click="selectLookupRow('{{ $row['id'] }}')"
                                                    >
                                                        <td>{{ $row['code'] }}</td>
                                                        <td>{{ $row['name'] }}</td>
                                                        <td>{{ $row['status'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 border-t border-gray-200 px-5 py-4">
                            <button type="button" class="btn-primary" wire:click="chooseLookupRow" @disabled($pendingProgramId === null)>Choose</button>
                            <button type="button" class="btn-secondary" wire:click="closeLookupModal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
