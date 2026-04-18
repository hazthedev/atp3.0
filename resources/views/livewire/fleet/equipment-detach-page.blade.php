@php
    $equipmentFields = [
        ['label' => 'Equipment No.', 'key' => 'equipment_no'],
        ['label' => 'Serial Number', 'key' => 'serial_number'],
        ['label' => 'Item Number', 'key' => 'item_no'],
        ['label' => 'Item Description', 'key' => 'item_description'],
        ['label' => 'Category Part', 'key' => 'category_part'],
        ['label' => 'Variant', 'key' => 'variant'],
    ];
@endphp

<div class="relative space-y-6">
    <x-page-header
        title="Detach Equipment"
        description="Equipment detach workspace using the same searchable modal pattern as the attach flow."
    />

    <x-status-message :message="$statusMessage" :tone="$statusTone" />
    <x-card title="Detach Equipment" description="Choose the equipment to detach and review its father equipment context." padding="p-6">
        <div class="space-y-8">
            <div class="space-y-6">
                <p class="text-sm font-semibold text-gray-900">Step 1 : Choose the equipment to detach</p>

                <div class="grid gap-6 xl:grid-cols-[minmax(0,720px)_auto] xl:items-start">
                    <div class="space-y-3">
                        <p class="text-sm font-medium text-gray-600">Equipment to detach information</p>

                        <div class="grid gap-4 md:grid-cols-2">
                            @foreach ($equipmentFields as $field)
                                <x-form.input
                                    :label="$field['label']"
                                    :name="'detach_' . $field['key']"
                                    :value="$equipmentToDetach[$field['key']] ?? ''"
                                    readonly
                                    :class="filled($equipmentToDetach[$field['key']] ?? '') ? 'input-field-filled' : ''"
                                />
                            @endforeach
                        </div>
                    </div>

                    <div class="self-start xl:pt-[1.375rem]">
                        <button type="button" class="btn-secondary" wire:click="openSearchModal">Search Equipment</button>
                    </div>
                </div>

                <div class="space-y-3 xl:max-w-[720px]">
                    <p class="text-sm font-medium text-gray-600">Father Equipment information</p>

                    <div class="grid gap-4 md:grid-cols-2">
                        @foreach ($equipmentFields as $field)
                            <x-form.input
                                :label="$field['label']"
                                :name="'father_' . $field['key']"
                                :value="$fatherEquipment[$field['key']] ?? ''"
                                readonly
                                :class="filled($fatherEquipment[$field['key']] ?? '') ? 'input-field-filled' : ''"
                            />
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-5 flex flex-wrap items-center justify-end gap-3">
                <a href="{{ route('fleet.equipment.customer-equipment-card') }}" class="btn-secondary">Cancel</a>
                <button type="button" class="btn-secondary" disabled>&lt; Back</button>
                <button type="button" class="btn-primary" disabled>Next &gt;</button>
                <button type="button" class="btn-secondary" wire:click="detachPreview" @disabled($equipmentId === null)>Detach</button>
            </div>
        </div>
    </x-card>

    @if ($searchModalOpen)
        <div class="fixed inset-0 z-40 overflow-y-auto p-4">
            <div class="flex min-h-full items-center justify-center">
                <div class="relative w-full max-w-4xl">
                    <div class="relative flex max-h-[65vh] flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
                        <div class="flex items-start justify-between gap-4 border-b border-gray-200 px-5 py-4">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Search Equipment</h3>
                                <p class="mt-1 text-sm text-gray-500">Search Equipments modal with choose/cancel actions for the detach workflow.</p>
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
                                    label="Search Equipments"
                                    name="equipment_detach_search"
                                    wire:model.live.debounce.250ms="search"
                                    placeholder="Search by ID, item number, serial number, category, or status..."
                                />
                            </div>

                            <p class="pb-2 text-sm text-gray-500">
                                Showing {{ $searchResults->count() }} result{{ $searchResults->count() === 1 ? '' : 's' }}.
                            </p>
                        </div>

                        <x-data-table
                            :empty="$searchResults->count() === 0"
                            empty-label="No equipment records found"
                            empty-description="Try a different equipment ID, item number, serial number, or status."
                            search-meta=""
                        >
                            <x-slot name="thead">
                                <tr>
                                    <th class="table-th">ID</th>
                                    <th class="table-th">Item No.</th>
                                    <th class="table-th">Item Name</th>
                                    <th class="table-th">Serial Number</th>
                                    <th class="table-th">Category Part</th>
                                    <th class="table-th">Variant</th>
                                    <th class="table-th">Status</th>
                                </tr>
                            </x-slot>

                            <x-slot name="tbody">
                                @foreach ($searchResults as $row)
                                    <tr
                                        class="table-row cursor-pointer transition-colors {{ $pendingSelectionId === $row['id'] ? 'bg-blue-50/70' : '' }}"
                                        wire:key="detach-equipment-search-{{ $row['id'] }}"
                                        wire:click="selectSearchResult('{{ $row['id'] }}')"
                                    >
                                        <td class="table-td">
                                            <span class="inline-flex items-center gap-3 font-semibold text-gray-900">
                                                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-50 text-blue-600 ring-1 ring-inset ring-blue-100">
                                                    <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                                                </span>
                                                <span>{{ $row['id'] }}</span>
                                            </span>
                                        </td>
                                        <td class="table-td">{{ $row['item_no'] }}</td>
                                        <td class="table-td">{{ $row['item_name'] }}</td>
                                        <td class="table-td">{{ $row['serial_number'] }}</td>
                                        <td class="table-td">{{ $row['category_part'] }}</td>
                                        <td class="table-td">{{ $row['variant'] }}</td>
                                        <td class="table-td">
                                            <x-badge :color="$row['status'] === 'On Aircraft' ? 'success' : 'default'">
                                                {{ $row['status'] }}
                                            </x-badge>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-slot>
                        </x-data-table>

                        @if ($selectedSearchRecord)
                            <div class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-700">
                                Selected equipment {{ $selectedSearchRecord['id'] }} / {{ $selectedSearchRecord['item_no'] }} / {{ $selectedSearchRecord['serial_number'] !== '' ? $selectedSearchRecord['serial_number'] : 'No Serial' }}.
                            </div>
                        @endif
                    </div>
                </div>

                        <div class="flex flex-wrap items-center justify-end gap-3 border-t border-gray-200 px-5 py-4">
                            <button type="button" class="btn-secondary" wire:click="closeSearchModal">Cancel</button>
                            <button type="button" class="btn-primary" wire:click="chooseSearchResult" @disabled($pendingSelectionId === null)>Choose</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
