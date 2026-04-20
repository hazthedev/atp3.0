<div>
    @if ($open)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 p-4"
            x-data
            @keydown.escape.window="$wire.closeModal()"
            wire:key="equipment-counters-modal"
        >
            <div class="w-full max-w-6xl rounded-xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-gray-200 px-5 py-3">
                    <h3 class="text-sm font-semibold text-gray-900">Equipment Counters</h3>
                    <button type="button" class="btn-ghost px-2" wire:click="closeModal" aria-label="Close">
                        <x-icon name="x-circle" class="h-5 w-5" />
                    </button>
                </div>

                <div class="grid grid-cols-2 gap-x-6 gap-y-1 px-5 pt-4 pb-2 text-xs">
                    <div class="grid grid-cols-[130px_minmax(0,1fr)] gap-2">
                        <div class="text-gray-500">Item No.</div><div class="font-medium text-gray-900">{{ $itemNo }}</div>
                        <div class="text-gray-500">Item description</div><div class="font-medium text-gray-900">{{ $itemDescription }}</div>
                        <div class="text-gray-500">Serial number</div><div class="font-medium text-gray-900">{{ $serialNumber }}</div>
                    </div>
                    <div class="grid grid-cols-[130px_minmax(0,1fr)] gap-2">
                        <div class="text-gray-500">Variant</div><div class="font-medium text-gray-900">{{ $variant }}</div>
                        <div class="text-gray-500">Category part</div><div class="font-medium text-gray-900">{{ $categoryPart }}</div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 px-5 pb-2">
                    <button type="button" class="btn-secondary text-xs">Counter Hierarchy</button>
                    <button type="button" class="btn-secondary text-xs">Increment Counters by UoM</button>
                </div>

                <div class="px-5">
                    <x-status-message :message="$statusMessage" :tone="$statusTone" />
                </div>

                <div class="border-b border-gray-200 px-5">
                    <div class="flex gap-4">
                        @foreach (['general' => 'General', 'penalties' => 'Penalties', 'specific' => 'Specific'] as $key => $label)
                            <button type="button"
                                    class="border-b-2 pb-2 pt-1 text-sm font-medium transition {{ $tab === $key ? 'border-blue-600 text-blue-700' : 'border-transparent text-gray-500 hover:text-gray-700' }}"
                                    wire:click="$set('tab', '{{ $key }}')">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                </div>

                @if ($tab === 'general')
                    <div class="max-h-[55vh] overflow-auto px-5 py-4">
                        <table class="w-full border-collapse text-xs">
                            <thead>
                                <tr class="bg-gray-50 text-left text-[11px] font-semibold uppercase tracking-wide text-gray-600">
                                    <th class="border border-gray-200 px-2 py-1.5 min-w-[110px]">Counter Desc</th>
                                    <th class="border border-gray-200 px-2 py-1.5 w-20 text-center">Propagate</th>
                                    <th class="border border-gray-200 px-2 py-1.5 w-28">Reading Date</th>
                                    <th class="border border-gray-200 px-2 py-1.5 w-20">Hour</th>
                                    <th class="border border-gray-200 px-2 py-1.5 w-32">Value (dec.)</th>
                                    <th class="border border-gray-200 px-2 py-1.5 w-24">Value (hh:mm)</th>
                                    <th class="border border-gray-200 px-2 py-1.5 w-10 text-center">!</th>
                                    <th class="border border-gray-200 px-2 py-1.5 w-32">Max (dec.)</th>
                                    <th class="border border-gray-200 px-2 py-1.5 w-24">Max (hh:mm)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $index => $row)
                                    @php
                                        $inputClass = 'w-full border-0 bg-transparent px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500';
                                        $isUsed = $row['is_used'] ?? false;
                                    @endphp
                                    <tr wire:key="equip-counter-row-{{ $index }}" @class(['text-gray-400' => ! $isUsed])>
                                        <td class="border border-gray-200 px-2 py-1 font-medium">{{ $row['counter_name'] }}</td>
                                        <td class="border border-gray-200 px-1 py-1 text-center align-middle">
                                            <input type="checkbox" wire:model="rows.{{ $index }}.propagate" class="h-3.5 w-3.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                        </td>
                                        <td class="border border-gray-200 p-0"><input type="date" wire:model="rows.{{ $index }}.reading_date" class="{{ $inputClass }}" /></td>
                                        <td class="border border-gray-200 p-0"><input type="text" wire:model="rows.{{ $index }}.reading_hour" class="{{ $inputClass }}" /></td>
                                        <td class="border border-gray-200 p-0 text-right"><input type="text" wire:model="rows.{{ $index }}.value_dec" class="{{ $inputClass }} text-right" /></td>
                                        <td class="border border-gray-200 p-0"><input type="text" wire:model="rows.{{ $index }}.value_hhmm" class="{{ $inputClass }}" /></td>
                                        <td class="border border-gray-200 px-1 py-1 text-center align-middle">
                                            @if ($isUsed)
                                                <span class="inline-block h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                            @else
                                                <span class="inline-block h-2.5 w-2.5 rounded-full bg-gray-300"></span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-200 p-0 text-right"><input type="text" wire:model="rows.{{ $index }}.max_dec" class="{{ $inputClass }} text-right" /></td>
                                        <td class="border border-gray-200 p-0"><input type="text" wire:model="rows.{{ $index }}.max_hhmm" class="{{ $inputClass }}" /></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Calendar counter --}}
                        <div class="mt-5">
                            <table class="w-full border-collapse text-xs">
                                <thead>
                                    <tr class="bg-gray-50 text-left text-[11px] font-semibold uppercase tracking-wide text-gray-600">
                                        <th class="border border-gray-200 px-2 py-1.5 w-32">Counter Desc</th>
                                        <th class="border border-gray-200 px-2 py-1.5 w-28">Value</th>
                                        <th class="border border-gray-200 px-2 py-1.5 w-10 text-center">!</th>
                                        <th class="border border-gray-200 px-2 py-1.5 w-28">Limit</th>
                                        <th class="border border-gray-200 px-2 py-1.5 w-28">Remaining</th>
                                        <th class="border border-gray-200 px-2 py-1.5 w-28">Residual</th>
                                        <th class="border border-gray-200 px-2 py-1.5 min-w-[140px]">Info. Source</th>
                                        <th class="border border-gray-200 px-2 py-1.5 w-28 text-center">Reset to Null</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $inputClass = 'w-full border-0 bg-transparent px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500'; @endphp
                                    <tr>
                                        <td class="border border-gray-200 px-2 py-1 font-medium">{{ $calendar['label'] }}</td>
                                        <td class="border border-gray-200 p-0"><input type="date" wire:model="calendar.value_date" class="{{ $inputClass }}" /></td>
                                        <td class="border border-gray-200 px-1 py-1 text-center align-middle">
                                            @if (! ($calendar['is_used'] ?? false))
                                                <span class="font-bold text-red-500">X</span>
                                            @else
                                                <span class="inline-block h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-200 p-0"><input type="text" wire:model="calendar.limit" class="{{ $inputClass }}" /></td>
                                        <td class="border border-gray-200 p-0"><input type="text" wire:model="calendar.remaining" class="{{ $inputClass }}" /></td>
                                        <td class="border border-gray-200 p-0"><input type="text" wire:model="calendar.residual" class="{{ $inputClass }}" /></td>
                                        <td class="border border-gray-200 p-0"><input type="text" wire:model="calendar.info_source" class="{{ $inputClass }}" /></td>
                                        <td class="border border-gray-200 px-1 py-1 text-center align-middle">
                                            <input type="checkbox" wire:model="calendar.reset_to_null" class="h-3.5 w-3.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3 flex items-center justify-between text-xs">
                            <div class="text-gray-500">
                                <span class="font-bold text-red-500">X</span>
                                &nbsp;Counters marked with this cross are available but not used, enter a value to use them
                            </div>
                            <label class="flex items-center gap-2 text-gray-700">
                                <input type="checkbox" wire:model="deactivatePropagation" class="h-3.5 w-3.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500" />
                                <span>Deactivate propagation</span>
                            </label>
                        </div>
                    </div>
                @elseif ($tab === 'penalties')
                    <div class="px-5 py-10 text-center text-sm text-gray-400">Penalties is not yet implemented.</div>
                @else
                    <div class="px-5 py-10 text-center text-sm text-gray-400">Specific tab is not yet implemented.</div>
                @endif

                <div class="flex items-center justify-start gap-2 border-t border-gray-200 px-5 py-3">
                    <button type="button" class="btn-primary" wire:click="save">OK</button>
                    <button type="button" class="btn-secondary" wire:click="closeModal">Cancel</button>
                </div>
            </div>
        </div>
    @endif
</div>
