<div>
    @if ($open)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 p-4"
            x-data
            @keydown.escape.window="$wire.closeModal()"
            wire:key="counter-refs-modal"
        >
            <div class="w-full max-w-5xl rounded-xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-gray-200 px-5 py-3">
                    <h3 class="text-sm font-semibold text-gray-900">MRO Counter Ref</h3>
                    <button type="button" class="btn-ghost px-2" wire:click="closeModal" aria-label="Close">
                        <x-icon name="x-circle" class="h-5 w-5" />
                    </button>
                </div>

                <div class="px-5 pt-4">
                    <x-status-message :message="$statusMessage" :tone="$statusTone" />
                </div>

                <div class="max-h-[60vh] overflow-auto px-5 py-4">
                    <table class="w-full border-collapse text-sm">
                        <thead class="sticky top-0 bg-gray-50">
                            <tr class="text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                <th class="border border-gray-200 px-2 py-1.5 w-10">#</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-32">Code</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-40">Name</th>
                                <th class="border border-gray-200 px-2 py-1.5 w-32">Status</th>
                                <th class="border border-gray-200 px-2 py-1.5">Measure Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $index => $row)
                                <tr wire:key="counter-ref-row-{{ $index }}">
                                    <td class="border border-gray-200 px-2 py-1 text-gray-500">{{ $index + 1 }}</td>
                                    <td class="border border-gray-200 px-0 py-0">
                                        <input type="text" wire:model="rows.{{ $index }}.code"
                                               class="w-full border-0 bg-transparent px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    </td>
                                    <td class="border border-gray-200 px-0 py-0">
                                        <input type="text" wire:model="rows.{{ $index }}.name"
                                               class="w-full border-0 bg-transparent px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    </td>
                                    <td class="border border-gray-200 px-0 py-0">
                                        <input type="text" wire:model="rows.{{ $index }}.status"
                                               class="w-full border-0 bg-transparent px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    </td>
                                    <td class="border border-gray-200 px-0 py-0">
                                        <input type="text" wire:model="rows.{{ $index }}.measure_unit"
                                               class="w-full border-0 bg-transparent px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="5" class="px-2 py-2 text-right">
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
