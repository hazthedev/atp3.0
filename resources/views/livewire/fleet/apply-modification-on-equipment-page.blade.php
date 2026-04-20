@php
    $equipmentFields = [
        ['label' => 'Equipment No.', 'key' => 'equipment_no'],
        ['label' => 'Serial Number', 'key' => 'serial_number'],
        ['label' => 'Item Number', 'key' => 'item_no'],
        ['label' => 'Category Part', 'key' => 'category_part'],
        ['label' => 'Variant', 'key' => 'variant'],
    ];
@endphp

<div class="relative space-y-6">
    <x-page-header
        title="Apply Modifications to an Equipment"
        description="Select an equipment record, stage one or more modifications, then initialize the action workflow."
    />

    <x-status-message :message="$statusMessage" :tone="$statusTone" />
    <section class="max-w-[1280px] space-y-5">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="space-y-6">
                <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_320px]">
                    {{-- Equipment information --}}
                    <div class="space-y-4 rounded-xl border border-gray-200 p-4 shadow-sm">
                        <p class="text-sm font-medium text-gray-700">Equipment information</p>

                        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_auto] xl:items-start">
                            <div class="space-y-2">
                                @foreach ($equipmentFields as $field)
                                    <div class="grid items-center gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                                        <span class="attach-field-label">{{ $field['label'] }}</span>
                                        <input
                                            type="text"
                                            value="{{ $equipment[$field['key']] ?? '' }}"
                                            readonly
                                            class="input-field attach-input {{ filled($equipment[$field['key']] ?? '') ? 'input-field-filled' : '' }}"
                                        />
                                    </div>
                                @endforeach
                            </div>

                            <div class="self-start xl:pt-[1.375rem]">
                                <button type="button" class="btn-secondary" wire:click="openEquipmentModal">Search Equipment</button>
                            </div>
                        </div>
                    </div>

                    {{-- Action panel --}}
                    <div class="space-y-3 rounded-xl border border-gray-200 p-4 shadow-sm">
                        <p class="text-sm font-medium text-gray-700">Action</p>

                        <div class="grid items-center gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                            <span class="attach-field-label">Status</span>
                            <select wire:model.live="status" class="input-field attach-input">
                                <option value="Applicable">Applicable</option>
                                <option value="Draft">Draft</option>
                                <option value="Released">Released</option>
                                <option value="Approved">Approved</option>
                            </select>
                        </div>

                        <div class="grid items-center gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                            <span class="attach-field-label">Action</span>
                            <select wire:model.live="action" class="input-field attach-input">
                                <option value="Apply">Apply</option>
                                <option value="Release">Release</option>
                                <option value="Close">Close</option>
                            </select>
                        </div>

                        <div class="grid items-center gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                            <span class="attach-field-label">Date for action</span>
                            <input type="text" wire:model.live="dateForAction" class="input-field attach-input attach-input-highlight" />
                        </div>

                        <div class="grid items-center gap-3" style="grid-template-columns: 112px minmax(0,1fr)">
                            <span class="attach-field-label">Comment</span>
                            <input type="text" wire:model.live="comment" class="input-field attach-input" />
                        </div>

                        <div class="flex justify-end pt-1">
                            <button type="button" class="btn-primary" wire:click="initializePreview">Initialize</button>
                        </div>
                    </div>
                </div>

                {{-- Modification Information --}}
                <div class="space-y-4 rounded-xl border border-gray-200 p-4 shadow-sm">
                    <p class="text-sm font-medium text-gray-700">Modification Information</p>

                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                        <div class="max-h-[340px] overflow-auto">
                            <table class="pending-base-table">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Unique Ref.</th>
                                        <th>Reference</th>
                                        <th>Revision</th>
                                        <th>Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($selectedModifications as $row)
                                        <tr wire:key="apply-modification-row-{{ $row['id'] }}">
                                            <td>{{ $row['type'] }}</td>
                                            <td>{{ $row['unique_ref'] }}</td>
                                            <td>{{ $row['reference'] }}</td>
                                            <td>{{ $row['revision'] !== '' ? $row['revision'] : '-' }}</td>
                                            <td>{{ $row['title'] }}</td>
                                        </tr>
                                    @empty
                                        @foreach (range(1, 8) as $placeholder)
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
                        <button type="button" class="btn-secondary" wire:click="openModificationModal">Search Modifications</button>
                        <button type="button" class="btn-secondary" wire:click="clearModifications" @disabled(count($selectedModifications) === 0)>Clear</button>
                    </div>
                </div>
            </div>

            <div class="mt-5 flex flex-wrap items-center gap-3 border-t border-gray-200 pt-5">
                <button type="button" class="btn-primary" wire:click="submitPreview">OK</button>
                <button type="button" class="btn-secondary" wire:click="cancelPreview">Cancel</button>
            </div>
        </div>
    </section>

    @if ($equipmentModalOpen)
        <div class="fixed inset-0 z-40 overflow-y-auto p-4">
            <div class="flex min-h-full items-center justify-center">
                <div class="relative w-full max-w-4xl">
                    <div class="relative flex max-h-[65vh] flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
                        <div class="flex items-start justify-between gap-4 border-b border-gray-200 px-5 py-4">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Search Equipment</h3>
                                <p class="mt-1 text-sm text-gray-500">Choose the equipment record that will receive the staged modification package.</p>
                            </div>

                            <button type="button" class="btn-ghost px-3" wire:click="closeEquipmentModal" aria-label="Close modal">
                                <x-icon name="x-circle" />
                            </button>
                        </div>

                        <div class="flex-1 overflow-y-auto px-5 py-4">
                            <div class="space-y-5">
                                <div class="w-full max-w-sm">
                                    <x-form.input
                                        label="Search Equipment"
                                        name="apply_modification_equipment_search"
                                        wire:model.live.debounce.250ms="equipmentSearch"
                                        placeholder="Search by ID, item number, serial number, category, or status..."
                                    />
                                </div>

                                <x-enterprise.table-shell table-class="pending-base-table">
                                    <x-slot name="thead">
                                        <tr>
                                            <th>ID</th>
                                            <th>Item No.</th>
                                            <th>Item Name</th>
                                            <th>Serial Number</th>
                                            <th>Category Part</th>
                                            <th>Variant</th>
                                            <th>Status</th>
                                        </tr>
                                    </x-slot>

                                    <x-slot name="tbody">
                                        @foreach ($equipmentSearchResults as $row)
                                            <tr
                                                class="cursor-pointer transition-colors {{ $pendingEquipmentId === $row['id'] ? 'bg-blue-50/70' : '' }}"
                                                wire:key="apply-equipment-search-{{ $row['id'] }}"
                                                wire:click="selectEquipmentResult('{{ $row['id'] }}')"
                                            >
                                                <td>{{ $row['id'] }}</td>
                                                <td>{{ $row['item_no'] }}</td>
                                                <td>{{ $row['item_name'] }}</td>
                                                <td>{{ $row['serial_number'] }}</td>
                                                <td>{{ $row['category_part'] }}</td>
                                                <td>{{ $row['variant'] }}</td>
                                                <td>{{ $row['status'] }}</td>
                                            </tr>
                                        @endforeach
                                    </x-slot>
                                </x-enterprise.table-shell>

                                @if ($selectedEquipmentSearchRecord)
                                    <div class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-700">
                                        Selected equipment {{ $selectedEquipmentSearchRecord['id'] }} / {{ $selectedEquipmentSearchRecord['item_no'] }} / {{ $selectedEquipmentSearchRecord['serial_number'] !== '' ? $selectedEquipmentSearchRecord['serial_number'] : 'No Serial' }}.
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-end gap-3 border-t border-gray-200 px-5 py-4">
                            <button type="button" class="btn-secondary" wire:click="closeEquipmentModal">Cancel</button>
                            <button type="button" class="btn-primary" wire:click="chooseEquipmentResult" @disabled($pendingEquipmentId === null)>Choose</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($modificationModalOpen)
        <div class="fixed inset-0 z-40 overflow-y-auto p-4">
            <div class="flex min-h-full items-center justify-center">
                <div class="relative w-full max-w-5xl">
                    <div class="relative flex max-h-[68vh] flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
                        <div class="flex items-start justify-between gap-4 border-b border-gray-200 px-5 py-4">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Search Modifications</h3>
                                <p class="mt-1 text-sm text-gray-500">Choose the modification package to add into the staged equipment action list.</p>
                            </div>

                            <button type="button" class="btn-ghost px-3" wire:click="closeModificationModal" aria-label="Close modal">
                                <x-icon name="x-circle" />
                            </button>
                        </div>

                        <div class="flex-1 overflow-y-auto px-5 py-4">
                            <div class="space-y-5">
                                <div class="w-full max-w-sm">
                                    <x-form.input
                                        label="Search Modifications"
                                        name="apply_modification_search"
                                        wire:model.live.debounce.250ms="modificationSearch"
                                        placeholder="Search by type, unique reference, reference, revision, or title..."
                                    />
                                </div>

                                <x-enterprise.table-shell table-class="pending-base-table">
                                    <x-slot name="thead">
                                        <tr>
                                            <th>Type</th>
                                            <th>Unique Ref.</th>
                                            <th>Reference</th>
                                            <th>Revision</th>
                                            <th>Title</th>
                                        </tr>
                                    </x-slot>

                                    <x-slot name="tbody">
                                        @foreach ($modificationSearchResults as $row)
                                            <tr
                                                class="cursor-pointer transition-colors {{ $pendingModificationId === $row['id'] ? 'bg-blue-50/70' : '' }}"
                                                wire:key="apply-modification-search-{{ $row['id'] }}"
                                                wire:click="selectModificationResult('{{ $row['id'] }}')"
                                            >
                                                <td>{{ $row['type'] }}</td>
                                                <td>{{ $row['unique_ref'] }}</td>
                                                <td>{{ $row['reference'] }}</td>
                                                <td>{{ $row['revision'] !== '' ? $row['revision'] : '-' }}</td>
                                                <td>{{ $row['title'] }}</td>
                                            </tr>
                                        @endforeach
                                    </x-slot>
                                </x-enterprise.table-shell>

                                @if ($selectedModificationSearchRecord)
                                    <div class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-700">
                                        Selected modification {{ $selectedModificationSearchRecord['unique_ref'] }}.
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-end gap-3 border-t border-gray-200 px-5 py-4">
                            <button type="button" class="btn-secondary" wire:click="closeModificationModal">Cancel</button>
                            <button type="button" class="btn-primary" wire:click="chooseModificationResult" @disabled($pendingModificationId === null)>Choose</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
