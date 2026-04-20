<div>
    @if ($open)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 p-4"
            x-data
            @keydown.escape.window="$wire.closeModal()"
            wire:key="mro-status-modal"
        >
            <div class="w-full max-w-3xl rounded-xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-gray-200 px-5 py-3">
                    <h3 class="text-sm font-semibold text-gray-900">MRO Status Object</h3>
                    <button type="button" class="btn-ghost px-2" wire:click="closeModal" aria-label="Close">
                        <x-icon name="x-circle" class="h-5 w-5" />
                    </button>
                </div>

                <div class="px-5 pt-4">
                    <x-status-message :message="$statusMessage" :tone="$statusTone" />
                </div>

                <div class="max-h-[60vh] overflow-auto px-5 py-4">
                    <table class="w-full border-collapse text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                <th class="border border-gray-200 px-2 py-1.5 w-10">#</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-32">Code</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-40">Name</th>
                                <th class="border border-gray-200 px-2 py-1.5">Description</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-20 text-center">Locked</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-24 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $index => $row)
                                @php
                                    $isEditing = $editingIndex === $index;
                                    $inputClass = 'w-full border-0 bg-transparent px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 read-only:cursor-not-allowed read-only:text-gray-500 disabled:cursor-not-allowed disabled:text-gray-500 disabled:opacity-100';
                                @endphp
                                <tr wire:key="mro-status-row-{{ $index }}" @class(['bg-amber-50' => $isEditing])>
                                    <td class="border border-gray-200 px-2 py-1 text-gray-500">{{ $index + 1 }}</td>
                                    <td class="border border-gray-200 p-0">
                                        <input type="text" wire:model="rows.{{ $index }}.code" @readonly(! $isEditing) class="{{ $inputClass }}" />
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <input type="text" wire:model="rows.{{ $index }}.name" @readonly(! $isEditing) class="{{ $inputClass }}" />
                                    </td>
                                    <td class="border border-gray-200 p-0">
                                        <input type="text" wire:model="rows.{{ $index }}.description" @readonly(! $isEditing) class="{{ $inputClass }}" />
                                    </td>
                                    <td class="border border-gray-200 px-1 py-1 text-center align-middle">
                                        <input type="checkbox" wire:model="rows.{{ $index }}.locked" @disabled(! $isEditing) class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 disabled:opacity-60" />
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
                                <td colspan="6" class="px-2 py-2 text-right">
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
