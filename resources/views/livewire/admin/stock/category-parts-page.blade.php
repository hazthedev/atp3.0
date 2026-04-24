<div class="space-y-6">
    <x-page-header title="Category Parts" description="Component categorisation (H/T LLP, Engine L/R, APU, pilot/co-pilot displays) — SAP @MRO_OCAT.">
        <x-slot name="actions">
            <span class="inline-flex items-center gap-2 rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-700">
                {{ count($rows) }} records
            </span>
        </x-slot>
    </x-page-header>

    <x-status-message :message="$statusMessage" :tone="$statusTone" />

    <x-card padding="p-0">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <th class="border border-gray-200 px-3 py-2 w-12">#</th>
                        <th class="border border-gray-200 px-3 py-2 w-40">Code</th>
                        <th class="border border-gray-200 px-3 py-2 w-40">New Code</th>
                        <th class="border border-gray-200 px-3 py-2">Name</th>
                        <th class="border border-gray-200 px-3 py-2 w-24 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $index => $row)
                        @php $isEditing = $editingIndex === $index; @endphp
                        <tr wire:key="category-part-row-{{ $index }}" @class(['bg-amber-50' => $isEditing])>
                            <td class="border border-gray-200 px-3 py-1.5 text-gray-500">{{ $index + 1 }}</td>
                            <td class="border border-gray-200 px-0 py-0">
                                <input
                                    type="text"
                                    wire:model="rows.{{ $index }}.code"
                                    @readonly(! $isEditing)
                                    class="w-full border-0 bg-transparent px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 read-only:cursor-not-allowed read-only:text-gray-500"
                                />
                            </td>
                            <td class="border border-gray-200 px-0 py-0">
                                <input
                                    type="text"
                                    wire:model="rows.{{ $index }}.new_code"
                                    @readonly(! $isEditing)
                                    class="w-full border-0 bg-transparent px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 read-only:cursor-not-allowed read-only:text-gray-500"
                                />
                            </td>
                            <td class="border border-gray-200 px-0 py-0">
                                <input
                                    type="text"
                                    wire:model="rows.{{ $index }}.name"
                                    @readonly(! $isEditing)
                                    class="w-full border-0 bg-transparent px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 read-only:cursor-not-allowed read-only:text-gray-500"
                                />
                            </td>
                            <td class="border border-gray-200 px-2 py-1 align-middle">
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
                        <td colspan="5" class="px-3 py-2 text-right">
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
            <button type="button" class="btn-secondary" wire:click="cancel">
                Cancel
            </button>
        </div>
    </x-card>
</div>
