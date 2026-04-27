<div>
    @if ($open)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 p-4"
            x-data
            @keydown.escape.window="$wire.closeModal()"
            wire:key="item-counters-modal"
        >
            <div class="w-full max-w-5xl rounded-xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-gray-200 px-5 py-3">
                    <h3 class="text-sm font-semibold text-gray-900">List of Counters</h3>
                    <button type="button" class="btn-ghost px-2" wire:click="closeModal" aria-label="Close">
                        <x-icon name="x-circle" class="h-5 w-5" />
                    </button>
                </div>

                <div class="px-5 pt-4 pb-2">
                    <div class="grid grid-cols-[140px_minmax(0,1fr)] gap-2 text-sm">
                        <div class="text-gray-500">Item Number</div>
                        <div class="font-medium text-gray-900">{{ $itemNumber }}</div>
                        <div class="text-gray-500">Description</div>
                        <div class="font-medium text-gray-900">{{ $itemDescription }}</div>
                    </div>
                </div>

                <div class="px-5 pt-3">
                    <x-status-message :message="$statusMessage" :tone="$statusTone" />
                </div>

                <div class="border-b border-gray-200 px-5">
                    <div class="flex gap-4">
                        <button type="button"
                                class="border-b-2 pb-2 pt-1 text-sm font-medium transition {{ $tab === 'counters' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700' }}"
                                wire:click="$set('tab', 'counters')">
                            Counters
                        </button>
                        <button type="button"
                                class="border-b-2 pb-2 pt-1 text-sm font-medium transition {{ $tab === 'penalties' ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700' }}"
                                wire:click="$set('tab', 'penalties')">
                            Penalties
                        </button>
                    </div>
                </div>

                @if ($tab === 'counters')
                    <div class="max-h-[55vh] overflow-auto px-5 py-4">
                        <table class="w-full border-collapse text-xs">
                            <thead>
                                <tr class="bg-gray-50 text-left text-[11px] font-semibold uppercase tracking-wide text-gray-600">
                                    <th class="border border-gray-200 px-2 py-1.5 w-10">#</th>
                                    <th class="border border-gray-200 px-2 py-1.5 min-w-[140px]">Counter</th>
                                    <th class="border border-gray-200 px-2 py-1.5 w-32">Max Value (dec.)</th>
                                    <th class="border border-gray-200 px-2 py-1.5 w-28">Max Value (hh:mm)</th>
                                    <th class="border border-gray-200 px-2 py-1.5 w-32">Tolerance Value (dec.)</th>
                                    <th class="border border-gray-200 px-2 py-1.5 w-32">Tolerance Value (hh:mm)</th>
                                    <th class="border border-gray-200 px-2 py-1.5 w-24">Orange light</th>
                                    <th class="border border-gray-200 px-2 py-1.5 w-32">Status</th>
                                    <th class="border border-gray-200 px-2 py-1.5 w-28">Modif Ref.</th>
                                    <th class="border border-gray-200 px-2 py-1.5 w-24 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $index => $row)
                                    @php
                                        $isEditing = $editingIndex === $index;
                                    @endphp
                                    <tr wire:key="item-counter-row-{{ $index }}" @class(['bg-amber-50' => $isEditing])>
                                        <td class="border border-gray-200 px-2 py-1 text-gray-500">{{ $index + 1 }}</td>
                                        <td class="border border-gray-200 p-0">
                                            <x-enterprise.select wire:model="rows.{{ $index }}.counter_ref_id" variant="cell" :disabled="! $isEditing">
                                                <option value=""></option>
                                                @foreach ($counterRefOptions as $opt)
                                                    <option value="{{ $opt['id'] }}">{{ $opt['name'] }}</option>
                                                @endforeach
                                            </x-enterprise.select>
                                        </td>
                                        <td class="border border-gray-200 p-0"><x-enterprise.input wire:model="rows.{{ $index }}.max_value_dec" variant="cell" :readonly="! $isEditing" /></td>
                                        <td class="border border-gray-200 p-0"><x-enterprise.input wire:model="rows.{{ $index }}.max_value_hhmm" variant="cell" :readonly="! $isEditing" /></td>
                                        <td class="border border-gray-200 p-0"><x-enterprise.input wire:model="rows.{{ $index }}.tolerance_dec" variant="cell" :readonly="! $isEditing" /></td>
                                        <td class="border border-gray-200 p-0"><x-enterprise.input wire:model="rows.{{ $index }}.tolerance_hhmm" variant="cell" :readonly="! $isEditing" /></td>
                                        <td class="border border-gray-200 p-0"><x-enterprise.input type="number" wire:model="rows.{{ $index }}.orange_light_percent" variant="cell" :readonly="! $isEditing" /></td>
                                        <td class="border border-gray-200 p-0">
                                            <x-enterprise.select wire:model="rows.{{ $index }}.status" variant="cell" :disabled="! $isEditing">
                                                @foreach ($statusOptions as $option)
                                                    <option value="{{ $option['name'] }}">{{ $option['code'] }} - {{ $option['name'] }}</option>
                                                @endforeach
                                            </x-enterprise.select>
                                        </td>
                                        <td class="border border-gray-200 p-0"><x-enterprise.input wire:model="rows.{{ $index }}.modif_ref" variant="cell" :readonly="! $isEditing" /></td>
                                        <td class="border border-gray-200 px-1 py-1 align-middle">
                                            <div class="flex items-center justify-center gap-1">
                                                <button type="button"
                                                        class="rounded-md p-1 transition hover:bg-amber-50 {{ $isEditing ? 'text-amber-600' : 'text-amber-500' }}"
                                                        wire:click="editRow({{ $index }})"
                                                        title="{{ $isEditing ? 'Stop editing' : 'Edit row' }}">
                                                    <x-icon name="pencil-square" class="h-4 w-4" />
                                                </button>
                                                <button type="button"
                                                        class="rounded-md p-1 text-gray-400 transition hover:bg-red-50 hover:text-red-500"
                                                        wire:click="removeRow({{ $index }})"
                                                        title="Remove row">
                                                    <x-icon name="x-circle" class="h-4 w-4" />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="10" class="px-2 py-2 text-right">
                                        <button type="button" class="btn-ghost px-3 text-xs" wire:click="addRow">
                                            <x-icon name="plus" class="h-4 w-4" />
                                            Add counter
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- Calendar Counter --}}
                        <div class="mt-5">
                            <div class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Calendar Counter</div>
                            <table class="w-full border-collapse text-xs">
                                <thead>
                                    <tr class="bg-gray-50 text-left text-[11px] font-semibold uppercase tracking-wide text-gray-600">
                                        <th class="border border-gray-200 px-2 py-1.5 w-40">Counter</th>
                                        <th class="border border-gray-200 px-2 py-1.5 w-32">Limit (days)</th>
                                        <th class="border border-gray-200 px-2 py-1.5">Orange light (days from the limit)</th>
                                        <th class="border border-gray-200 px-2 py-1.5 w-40">Status</th>
                                        <th class="border border-gray-200 px-2 py-1.5 w-24 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr @class(['bg-amber-50' => $editingCalendar])>
                                        <td class="border border-gray-200 p-0"><x-enterprise.input wire:model="calendar.label" variant="cell" :readonly="! $editingCalendar" /></td>
                                        <td class="border border-gray-200 p-0"><x-enterprise.input type="number" wire:model="calendar.limit_days" variant="cell" :readonly="! $editingCalendar" /></td>
                                        <td class="border border-gray-200 p-0"><x-enterprise.input type="number" wire:model="calendar.orange_light_days" variant="cell" :readonly="! $editingCalendar" /></td>
                                        <td class="border border-gray-200 p-0">
                                            <x-enterprise.select wire:model="calendar.status" variant="cell" :disabled="! $editingCalendar">
                                                @foreach ($statusOptions as $option)
                                                    <option value="{{ $option['name'] }}">{{ $option['code'] }} - {{ $option['name'] }}</option>
                                                @endforeach
                                            </x-enterprise.select>
                                        </td>
                                        <td class="border border-gray-200 px-1 py-1 text-center align-middle">
                                            <button type="button"
                                                    class="rounded-md p-1 transition hover:bg-amber-50 {{ $editingCalendar ? 'text-amber-600' : 'text-amber-500' }}"
                                                    wire:click="editCalendar"
                                                    title="{{ $editingCalendar ? 'Stop editing' : 'Edit' }}">
                                                <x-icon name="pencil-square" class="h-4 w-4" />
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="max-h-[55vh] overflow-auto px-5 py-10 text-center text-sm text-gray-400">
                        Penalties configuration is not yet implemented.
                    </div>
                @endif

                <div class="flex items-center justify-start gap-2 border-t border-gray-200 px-5 py-3">
                    <button type="button" class="btn-primary" wire:click="save">
                        {{ $this->isDirty() ? 'Update' : 'OK' }}
                    </button>
                    <button type="button" class="btn-secondary" wire:click="closeModal">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
