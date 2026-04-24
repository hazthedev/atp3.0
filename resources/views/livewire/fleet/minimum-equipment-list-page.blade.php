<div class="space-y-6">
    <x-page-header
        title="Minimum Equipment List"
        description="Minimum equipment list workspace with equipment or functional-location search, revision controls, and MEL item preview."
    />

    <x-status-message :message="$statusMessage" :tone="$statusTone" />
    <section class="max-w-[1280px] space-y-5">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="space-y-5">
                {{-- Header row: scope radios + status select --}}
                <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                    <div class="flex flex-wrap items-center gap-6 pt-1">
                        <label class="mel-radio-option">
                            <input type="radio" value="equipment" wire:model.live="scope" />
                            <span>Equipment</span>
                        </label>

                        <label class="mel-radio-option">
                            <input type="radio" value="functional-location" wire:model.live="scope" />
                            <span>Functional location</span>
                        </label>
                    </div>

                    <div class="w-full max-w-[320px]">
                        <label for="mel_status" class="attach-field-label">Status</label>
                        <x-enterprise.select
                            id="mel_status"
                            name="mel_status"
                            wire:model.live="status"
                            class="attach-input attach-input-highlight mt-1.5"
                        >
                            @foreach ($statusOptions as $optionValue => $optionLabel)
                                <option value="{{ $optionValue }}">{{ $optionLabel }}</option>
                            @endforeach
                        </x-enterprise.select>
                    </div>
                </div>

                {{-- Top grid: left fields + right meta fields --}}
                <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
                    <div class="space-y-2">
                        @foreach ($leftFields as $field)
                            <x-enterprise.field-row :label="$field['label']" label-class="attach-field-label">
                                @if (! empty($field['lookup']))
                                    <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                                        <x-enterprise.input
                                            wire:model.live="form.{{ $field['key'] }}"
                                            class="attach-input {{ ! empty($field['highlight']) ? 'attach-input-highlight' : '' }}"
                                        />
                                        <button type="button" class="attach-mini-button" wire:click="openLookupModal">...</button>
                                    </div>
                                @else
                                    <x-enterprise.input
                                        wire:model.live="form.{{ $field['key'] }}"
                                        class="attach-input"
                                    />
                                @endif
                            </x-enterprise.field-row>
                        @endforeach

                        <x-enterprise.field-row label="MMEL" label-class="attach-field-label">
                            <div class="grid grid-cols-[minmax(0,1fr)_40px] gap-2">
                                <x-enterprise.input wire:model.live="form.mmel" class="attach-input" />
                                <button type="button" class="attach-mini-button attach-mini-button-ghost">...</button>
                            </div>
                        </x-enterprise.field-row>

                        <x-enterprise.field-row label="Title" label-class="attach-field-label">
                            <x-enterprise.input wire:model.live="form.title" class="attach-input attach-input-highlight" />
                        </x-enterprise.field-row>
                    </div>

                    <div class="space-y-2">
                        @foreach ($metaFields as $field)
                            <x-enterprise.field-row :label="$field['label']" label-class="attach-field-label">
                                <x-enterprise.input
                                    wire:model.live="form.{{ $field['key'] }}"
                                    class="attach-input {{ ! empty($field['highlight']) ? 'attach-input-highlight' : '' }}"
                                />
                            </x-enterprise.field-row>
                        @endforeach
                    </div>
                </div>

                {{-- MEL items list --}}
                <div class="space-y-4">
                    <div class="text-sm font-semibold text-gray-900">List of MEL Items</div>

                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                        <div class="max-h-[320px] min-h-[240px] overflow-y-auto">
                            @if (count($items) > 0)
                                <div class="divide-y divide-gray-200">
                                    @foreach ($items as $row)
                                        <div class="flex items-start justify-between gap-4 px-4 py-3" wire:key="mel-item-{{ $row['reference'] }}">
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold text-gray-900">{{ $row['reference'] }}</p>
                                                <p class="mt-1 text-sm text-gray-600">{{ $row['title'] }}</p>
                                            </div>

                                            <x-badge color="default">{{ $row['category'] }}</x-badge>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="divide-y divide-gray-200">
                                    @foreach (range(1, 8) as $row)
                                        <div class="h-10 bg-white"></div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
                        <button type="button" class="btn-secondary" wire:click="checkOperationalStatus" @disabled(! $loaded)>Check Operational Status</button>
                        <div class="flex flex-wrap items-center gap-3">
                            <button type="button" class="btn-secondary" wire:click="addItemPreview" @disabled(! $loaded)>Add Item</button>
                            <button type="button" class="btn-secondary" wire:click="displayItemPreview" @disabled(! $loaded)>Display Item</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5 flex flex-wrap items-center gap-3 border-t border-gray-200 pt-5">
                <button type="button" wire:click="openLookupModal" class="btn-primary">Find</button>
                <button type="button" wire:click="cancelPreview" class="btn-secondary">Cancel</button>
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
                                <p class="mt-1 text-sm text-gray-500">Master Minimum Equipment List lookup for the current equipment or functional-location scope.</p>
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
                                        name="mel_lookup_search"
                                        wire:model.live.debounce.250ms="lookupSearch"
                                        placeholder="Search by code, equipment code, or FL code..."
                                    />
                                </div>

                                <x-enterprise.table-shell table-class="pending-base-table">
                                    <x-slot name="thead">
                                        <tr>
                                            <th>Code</th>
                                            <th>Equipment Code</th>
                                            <th>FL Code</th>
                                        </tr>
                                    </x-slot>

                                    <x-slot name="tbody">
                                        @forelse ($lookupRows as $row)
                                            <tr
                                                class="cursor-pointer transition-colors {{ $pendingLookupId === $row['id'] ? 'bg-blue-50/70' : '' }}"
                                                wire:key="mel-lookup-{{ $row['id'] }}"
                                                wire:click="selectLookupRow('{{ $row['id'] }}')"
                                            >
                                                <td>{{ $row['code'] }}</td>
                                                <td>{{ $row['equipment_code'] }}</td>
                                                <td>{{ $row['fl_code'] }}</td>
                                            </tr>
                                        @empty
                                            @foreach (range(1, 8) as $row)
                                                <tr>
                                                    <td><span class="invisible">.</span></td>
                                                    <td><span class="invisible">.</span></td>
                                                    <td><span class="invisible">.</span></td>
                                                </tr>
                                            @endforeach
                                        @endforelse
                                    </x-slot>
                                </x-enterprise.table-shell>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 border-t border-gray-200 px-5 py-4">
                            <button type="button" class="btn-primary" wire:click="chooseLookupRow" @disabled($pendingLookupId === null)>Choose</button>
                            <button type="button" class="btn-secondary" wire:click="closeLookupModal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
