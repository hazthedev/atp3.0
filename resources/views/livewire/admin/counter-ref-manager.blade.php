<div>
    @if ($open)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 p-4"
            x-data
            @keydown.escape.window="$wire.closeModal()"
            wire:key="counter-refs-modal"
        >
            <div class="w-full max-w-[98vw] rounded-xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-gray-200 px-5 py-3">
                    <h3 class="text-sm font-semibold text-gray-900">MRO Counter Ref</h3>
                    <button type="button" class="btn-ghost px-2" wire:click="closeModal" aria-label="Close">
                        <x-icon name="x-circle" class="h-5 w-5" />
                    </button>
                </div>

                <div class="px-5 pt-4">
                    <x-status-message :message="$statusMessage" :tone="$statusTone" />
                </div>

                <div class="max-h-[70vh] overflow-auto px-5 py-4">
                    <table class="w-full border-collapse text-xs">
                        <thead>
                            <tr class="bg-gray-50 text-left text-[11px] font-semibold uppercase tracking-wide text-gray-600">
                                <th class="border border-gray-200 px-2 py-1.5 w-10">#</th>
                                <th class="border border-gray-200 px-2 py-1.5 min-w-[96px]">Code</th>
                                <th class="border border-gray-200 px-2 py-1.5 min-w-[110px]">Name</th>
                                <th class="border border-gray-200 px-2 py-1.5 min-w-[96px]">Status</th>
                                <th class="border border-gray-200 px-2 py-1.5 min-w-[150px]">Code MUT Measure Unit</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-20">Incr/Decr</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-28">Allow Incr/Decr</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-24">Min Value</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-24">Max Value</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-24">Initial Value</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-28">Propagation flag</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-36">Used 4 Residual Calculation</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-36">Allow auto-incrementation</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-28">Orange light Limit</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-20">Sort order</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-24">Log instance</th>
                                <th class="border border-gray-200 px-2 py-1.5 min-w-[150px]">Linked counter(potential calc)</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-32">Propagation on linked counter</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-24 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $index => $row)
                                @php
                                    $isEditing = $editingIndex === $index;
                                    $inputClass = 'w-full border-0 bg-transparent px-2 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500 read-only:cursor-not-allowed read-only:text-gray-500 disabled:cursor-not-allowed disabled:text-gray-500 disabled:opacity-100';
                                @endphp
                                <tr wire:key="counter-ref-row-{{ $index }}" @class(['bg-amber-50' => $isEditing])>
                                    <td class="border border-gray-200 px-2 py-1 text-gray-500">{{ $index + 1 }}</td>
                                    <td class="border border-gray-200 p-0">
                                        <input type="text" wire:model="rows.{{ $index }}.code" @readonly(! $isEditing) class="{{ $inputClass }}" />
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <input type="text" wire:model="rows.{{ $index }}.name" @readonly(! $isEditing) class="{{ $inputClass }}" />
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <select wire:model="rows.{{ $index }}.status" @disabled(! $isEditing) class="{{ $inputClass }}">
                                            @foreach ($statusOptions as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <select wire:model="rows.{{ $index }}.measure_unit" @disabled(! $isEditing) class="{{ $inputClass }}">
                                            <option value=""></option>
                                            @foreach ($measureUnitOptions as $designation)
                                                <option value="{{ $designation }}">{{ $designation }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <input type="number" wire:model="rows.{{ $index }}.incr_decr" @readonly(! $isEditing) class="{{ $inputClass }}" />
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <input type="number" wire:model="rows.{{ $index }}.allow_incr_decr" @readonly(! $isEditing) class="{{ $inputClass }}" />
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <input type="text" wire:model="rows.{{ $index }}.min_value" @readonly(! $isEditing) class="{{ $inputClass }}" />
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <input type="text" wire:model="rows.{{ $index }}.max_value" @readonly(! $isEditing) class="{{ $inputClass }}" />
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <input type="text" wire:model="rows.{{ $index }}.initial_value" @readonly(! $isEditing) class="{{ $inputClass }}" />
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <input type="number" wire:model="rows.{{ $index }}.propagation_flag" @readonly(! $isEditing) class="{{ $inputClass }}" />
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <input type="number" wire:model="rows.{{ $index }}.used_for_residual_calc" @readonly(! $isEditing) class="{{ $inputClass }}" />
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <input type="number" wire:model="rows.{{ $index }}.allow_auto_incrementation" @readonly(! $isEditing) class="{{ $inputClass }}" />
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <input type="number" wire:model="rows.{{ $index }}.orange_light_limit" @readonly(! $isEditing) class="{{ $inputClass }}" />
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <input type="number" wire:model="rows.{{ $index }}.sort_order" @readonly(! $isEditing) class="{{ $inputClass }}" />
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <input type="number" wire:model="rows.{{ $index }}.log_instance" @readonly(! $isEditing) class="{{ $inputClass }}" />
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <select wire:model="rows.{{ $index }}.linked_counter" @disabled(! $isEditing) class="{{ $inputClass }}">
                                            <option value=""></option>
                                            @foreach ($linkedCounterOptions as $option)
                                                @continue($option['code'] === ($row['code'] ?? ''))
                                                <option value="{{ $option['code'] }}">{{ $option['code'] }} - {{ $option['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <input type="number" wire:model="rows.{{ $index }}.propagation_on_linked_counter" @readonly(! $isEditing) class="{{ $inputClass }}" />
                                    </td>
                                    <td class="border border-gray-200 px-1 py-1 align-middle">
                                        <div class="flex items-center justify-center gap-1">
                                            <button type="button"
                                                    class="rounded-md p-1 transition hover:bg-amber-50 {{ $isEditing ? 'text-amber-600' : 'text-amber-500' }}"
                                                    wire:click="editRow({{ $index }})"
                                                    title="{{ $isEditing ? 'Stop editing' : 'Edit row' }}"
                                                    aria-label="{{ $isEditing ? 'Stop editing' : 'Edit row' }}">
                                                <x-icon name="pencil-square" class="h-4 w-4" />
                                            </button>
                                            <button type="button"
                                                    class="rounded-md p-1 text-gray-400 transition hover:bg-red-50 hover:text-red-500"
                                                    wire:click="removeRow({{ $index }})"
                                                    title="Remove row"
                                                    aria-label="Remove row">
                                                <x-icon name="x-circle" class="h-4 w-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="19" class="px-2 py-2 text-right">
                                    <button type="button" class="btn-ghost px-3 text-xs" wire:click="addRow">
                                        <x-icon name="plus" class="h-4 w-4" />
                                        Add row
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

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
