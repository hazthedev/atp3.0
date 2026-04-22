<div>
    @if ($open)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 p-4"
            x-data
            @keydown.escape.window="$wire.closeModal()"
            wire:key="fl-counters-modal"
        >
            <div class="w-full max-w-6xl rounded-xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-gray-200 px-5 py-3">
                    <h3 class="text-sm font-semibold text-gray-900">Functional Location Counters</h3>
                    <button type="button" class="btn-ghost px-2" wire:click="closeModal" aria-label="Close">
                        <x-icon name="x-circle" class="h-5 w-5" />
                    </button>
                </div>

                <div class="grid grid-cols-3 gap-4 px-5 pt-4 pb-2 text-xs">
                    <div class="grid grid-cols-[100px_minmax(0,1fr)] gap-2">
                        <div class="text-gray-500">Code</div><div class="font-medium text-gray-900">{{ $code }}</div>
                    </div>
                    <div class="grid grid-cols-[100px_minmax(0,1fr)] gap-2">
                        <div class="text-gray-500">Registration</div><div class="font-medium text-gray-900">{{ $registration }}</div>
                    </div>
                    <div class="grid grid-cols-[100px_minmax(0,1fr)] gap-2">
                        <div class="text-gray-500">Type</div><div class="font-medium text-gray-900">{{ $type }}</div>
                    </div>
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
                                    <tr wire:key="fl-counter-row-{{ $index }}" @class(['text-gray-400' => ! $isUsed])>
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
                    <div class="space-y-3 px-5 py-4">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                Penalty rules that fire when a monitoring counter on this functional location changes.
                            </div>
                            <button type="button" class="btn-secondary" wire:click="addPenaltyRow">+ Add Rule</button>
                        </div>

                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase text-gray-500">
                                    <tr>
                                        <th class="px-3 py-2">Penalty</th>
                                        <th class="px-3 py-2">Target Item</th>
                                        <th class="px-3 py-2">Monitor</th>
                                        <th class="px-3 py-2">Rate</th>
                                        <th class="px-3 py-2">Rate Counter</th>
                                        <th class="px-3 py-2">Static</th>
                                        <th class="px-3 py-2">Static Counter</th>
                                        <th class="px-3 py-2">Active</th>
                                        <th class="px-3 py-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($penaltyRows as $index => $row)
                                        @php $isEditing = $editingPenaltyIndex === $index; @endphp
                                        <tr class="border-t border-gray-100 {{ $isEditing ? 'bg-amber-50' : '' }}">
                                            <td class="px-3 py-2">
                                                @if ($isEditing)
                                                    <select wire:model="penaltyRows.{{ $index }}.penalty_id" class="input-field">
                                                        <option value="">—</option>
                                                        @foreach ($penaltyOptions as $opt)
                                                            <option value="{{ $opt['id'] }}">{{ $opt['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    {{ collect($penaltyOptions)->firstWhere('id', $row['penalty_id'])['name'] ?? '—' }}
                                                @endif
                                            </td>
                                            <td class="px-3 py-2">
                                                @if ($isEditing)
                                                    <select wire:model="penaltyRows.{{ $index }}.target_item_id" class="input-field">
                                                        <option value="">(self)</option>
                                                        @foreach ($targetItemOptions as $opt)
                                                            <option value="{{ $opt['id'] }}">{{ $opt['code'] }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    {{ collect($targetItemOptions)->firstWhere('id', $row['target_item_id'])['code'] ?? '(self)' }}
                                                @endif
                                            </td>
                                            <td class="px-3 py-2">
                                                @if ($isEditing)
                                                    <select wire:model="penaltyRows.{{ $index }}.monitoring_counter_ref_id" class="input-field">
                                                        <option value="">—</option>
                                                        @foreach ($counterRefOptions as $opt)
                                                            <option value="{{ $opt['id'] }}">{{ $opt['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    {{ collect($counterRefOptions)->firstWhere('id', $row['monitoring_counter_ref_id'])['name'] ?? '—' }}
                                                @endif
                                            </td>
                                            <td class="px-3 py-2">
                                                @if ($isEditing)
                                                    <input type="text" wire:model="penaltyRows.{{ $index }}.rate_value" class="input-field w-20" />
                                                @else
                                                    {{ $row['rate_value'] }}
                                                @endif
                                            </td>
                                            <td class="px-3 py-2">
                                                @if ($isEditing)
                                                    <select wire:model="penaltyRows.{{ $index }}.rate_counter_ref_id" class="input-field">
                                                        <option value="">—</option>
                                                        @foreach ($counterRefOptions as $opt)
                                                            <option value="{{ $opt['id'] }}">{{ $opt['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    {{ collect($counterRefOptions)->firstWhere('id', $row['rate_counter_ref_id'])['name'] ?? '—' }}
                                                @endif
                                            </td>
                                            <td class="px-3 py-2">
                                                @if ($isEditing)
                                                    <input type="text" wire:model="penaltyRows.{{ $index }}.static_value" class="input-field w-20" />
                                                @else
                                                    {{ $row['static_value'] }}
                                                @endif
                                            </td>
                                            <td class="px-3 py-2">
                                                @if ($isEditing)
                                                    <select wire:model="penaltyRows.{{ $index }}.static_counter_ref_id" class="input-field">
                                                        <option value="">—</option>
                                                        @foreach ($counterRefOptions as $opt)
                                                            <option value="{{ $opt['id'] }}">{{ $opt['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    {{ collect($counterRefOptions)->firstWhere('id', $row['static_counter_ref_id'])['name'] ?? '—' }}
                                                @endif
                                            </td>
                                            <td class="px-3 py-2">
                                                <input type="checkbox" wire:model="penaltyRows.{{ $index }}.is_active" @disabled(! $isEditing) />
                                            </td>
                                            <td class="px-3 py-2">
                                                <button type="button" class="text-amber-600 hover:text-amber-800" wire:click="editPenaltyRow({{ $index }})" title="Edit">&#9998;</button>
                                                <button type="button" class="ml-2 text-red-600 hover:text-red-800" wire:click="removePenaltyRow({{ $index }})" title="Remove">&times;</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="px-3 py-6 text-center text-sm text-gray-400">No penalty rules defined for this functional location.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
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
