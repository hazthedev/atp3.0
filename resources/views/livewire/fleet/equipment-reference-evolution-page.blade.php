@php
    $statusClasses = match ($statusTone) {
        'green' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
        'amber' => 'border-amber-200 bg-amber-50 text-amber-700',
        'red' => 'border-red-200 bg-red-50 text-red-700',
        default => 'border-blue-200 bg-blue-50 text-blue-700',
    };

    $equipmentFields = [
        ['label' => 'Equipment No.', 'key' => 'equipment_no'],
        ['label' => 'Serial Number', 'key' => 'serial_number'],
        ['label' => 'Item Number', 'key' => 'item_no'],
        ['label' => 'Item Description', 'key' => 'item_description'],
        ['label' => 'Category Part', 'key' => 'category_part'],
        ['label' => 'Variant', 'key' => 'variant'],
    ];

    $ataFields = [
        ['label' => 'Chapter', 'key' => 'chapter'],
        ['label' => 'Section', 'key' => 'section'],
        ['label' => 'Subject', 'key' => 'subject'],
        ['label' => 'Sheet', 'key' => 'sheet'],
        ['label' => 'Mark', 'key' => 'mark'],
    ];
@endphp

<div class="relative space-y-6">
    <x-page-header
        title="Equipment Reference Evolution"
        description="Choose the equipment first, then enter the new reference information."
    />

    @if ($statusMessage)
        <div class="flex items-center rounded-lg border p-4 text-sm {{ $statusClasses }}" role="alert">
            <x-icon name="information-circle" class="mr-2.5 h-5 w-5 shrink-0" />
            <span>{{ $statusMessage }}</span>
        </div>
    @endif

    <section class="max-w-[1280px] space-y-5">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
        <div class="space-y-6">
            @if ($step === 1)
                <div class="space-y-6">
                    <p class="text-sm font-semibold text-gray-900">Step 1 : Choose the equipment</p>

                    <div class="grid gap-6 xl:grid-cols-[380px_auto] xl:items-start">
                        <div class="space-y-3">
                            <p class="text-sm font-medium text-gray-600">Equipment information</p>

                            <div class="grid gap-4 md:grid-cols-2">
                                @foreach ($equipmentFields as $field)
                                    <x-form.input
                                        :label="$field['label']"
                                        :name="'step1_' . $field['key']"
                                        :value="$equipment[$field['key']] ?? ''"
                                        readonly
                                        :class="filled($equipment[$field['key']] ?? '') ? 'input-field-filled' : ''"
                                    />
                                @endforeach
                            </div>
                        </div>

                        <div class="self-start xl:pt-[1.375rem]">
                            <button type="button" class="btn-secondary" wire:click="openSearchModal">Search Equipment</button>
                        </div>
                    </div>
                </div>
            @else
                <div class="space-y-6">
                    <p class="text-sm font-semibold text-gray-900">Step 2 : Enter new references information</p>

                    <div class="grid gap-6 xl:grid-cols-[380px_minmax(0,1fr)] xl:items-start">
                        <div class="space-y-5">
                            <div class="space-y-3">
                                <p class="text-sm font-medium text-gray-600">Equipment information</p>

                                <div class="grid gap-4 md:grid-cols-2">
                                    @foreach ($equipmentFields as $field)
                                        <x-form.input
                                            :label="$field['label']"
                                            :name="'step2_' . $field['key']"
                                            :value="$equipment[$field['key']] ?? ''"
                                            readonly
                                            class="input-field-filled"
                                        />
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <x-form.input
                                        label="Date"
                                        name="equipment_reference_evolution_date"
                                        wire:model.live="date"
                                        class="input-field-filled"
                                    />
                                </div>

                                <div class="grid grid-cols-[132px_minmax(0,1fr)] items-start gap-3">
                                    <label for="equipment_reference_evolution_comment" class="pt-2 text-sm font-medium text-gray-600">Comment</label>
                                    <textarea
                                        id="equipment_reference_evolution_comment"
                                        wire:model.live="comment"
                                        rows="5"
                                        class="input-field resize-none"
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div class="space-y-4 rounded-xl border border-gray-200 bg-gray-50/80 p-5">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div class="space-y-3">
                                        <label class="flex items-center gap-3 text-sm font-medium text-gray-700">
                                            <input type="checkbox" wire:model.live="newItemNumber" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <span>New Item Number</span>
                                        </label>

                                        <x-form.input
                                            label="Enter New Item Number"
                                            name="equipment_reference_new_item_number"
                                            wire:model.live="enteredItemNumber"
                                            :disabled="! $newItemNumber"
                                            class="disabled:bg-gray-100 disabled:text-gray-400"
                                        />
                                    </div>

                                    <div class="space-y-3">
                                        <label class="flex items-center gap-3 text-sm font-medium text-gray-700">
                                            <input type="checkbox" wire:model.live="newSerialNumber" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <span>New Serial Number</span>
                                        </label>

                                        <x-form.input
                                            label="Enter Serial Number"
                                            name="equipment_reference_new_serial_number"
                                            wire:model.live="enteredSerialNumber"
                                            :disabled="! $newSerialNumber"
                                            class="disabled:bg-gray-100 disabled:text-gray-400"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4 rounded-xl border border-gray-200 bg-gray-50/80 p-5">
                                <div class="space-y-3">
                                    <p class="text-sm font-semibold text-gray-900">Current ATA Code</p>
                                    <div class="grid gap-4 md:grid-cols-2">
                                        @foreach ($ataFields as $field)
                                            <x-form.input
                                                :label="$field['label']"
                                                :name="'current_' . $field['key']"
                                                :value="$currentAta[$field['key']] ?? ''"
                                                readonly
                                                class="input-field-filled"
                                            />
                                        @endforeach
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <p class="text-sm font-semibold text-gray-900">New ATA Code</p>
                                    <div class="grid gap-4 md:grid-cols-2">
                                        @foreach ($ataFields as $field)
                                            <x-form.input
                                                :label="$field['label']"
                                                :name="'new_' . $field['key']"
                                                wire:model.live="newAta.{{ $field['key'] }}"
                                            />
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-5 flex flex-wrap items-center justify-end gap-3 border-t border-gray-200 pt-5">
                <button type="button" class="btn-secondary">Cancel</button>
                <button type="button" class="btn-secondary" wire:click="previousStep" @disabled($step === 1)>&lt; Back</button>
                <button type="button" class="btn-primary" wire:click="nextStep" @disabled($step === 2 || $equipmentId === null)>Next &gt;</button>
                <button type="button" class="btn-secondary" wire:click="finishPreview" @disabled($step !== 2 || $equipmentId === null)>Finish</button>
            </div>
        </div>
    </section>

    @if ($searchModalOpen)
        <div class="fixed inset-0 z-40 overflow-y-auto p-4">
            <div class="flex min-h-full items-center justify-center">
                <div class="relative w-full max-w-4xl max-h-[65vh]">
                    <div class="relative flex max-h-[65vh] flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl">
                        <div class="flex items-start justify-between gap-4 border-b border-gray-200 px-5 py-4">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Search Equipment</h3>
                                <p class="mt-1 text-sm text-gray-500">Choose the equipment record that will feed this reference-evolution workflow.</p>
                            </div>

                            <button type="button" class="btn-ghost px-3" wire:click="closeSearchModal" aria-label="Close modal">
                                <x-icon name="x-circle" />
                            </button>
                        </div>

                        <div class="flex-1 overflow-y-auto px-5 py-4">
                            <div class="space-y-5">
                                <div class="w-full max-w-sm">
                                    <x-form.input
                                        label="Search Equipment"
                                        name="equipment_reference_search"
                                        wire:model.live.debounce.250ms="search"
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
                                        @foreach ($searchResults as $row)
                                            <tr
                                                class="cursor-pointer transition-colors {{ $pendingSelectionId === $row['id'] ? 'bg-blue-50/70' : '' }}"
                                                wire:key="equipment-reference-evolution-search-{{ $row['id'] }}"
                                                wire:click="selectSearchResult('{{ $row['id'] }}')"
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
    </section>
</div>
