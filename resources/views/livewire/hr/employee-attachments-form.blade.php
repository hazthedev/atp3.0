<div class="space-y-4">
    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_180px]">
        <x-data-table>
            <x-slot name="thead">
                <tr>
                    <th class="table-th w-12">#</th>
                    <th class="table-th">Target Path</th>
                    <th class="table-th">File Name</th>
                    <th class="table-th">Attachment Date</th>
                    <th class="table-th w-24"></th>
                </tr>
            </x-slot>
            <x-slot name="tbody">
                @forelse ($attachments as $idx => $att)
                    <tr class="table-row" wire:key="attachment-{{ $att->id }}">
                        <td class="table-td">{{ $idx + 1 }}</td>
                        <td class="table-td truncate">{{ $att->target_path }}</td>
                        <td class="table-td">{{ $att->file_name }}</td>
                        <td class="table-td">{{ optional($att->attachment_date)->format('Y-m-d') ?? '—' }}</td>
                        <td class="table-td text-right">
                            <button type="button"
                                    class="text-xs text-red-600 hover:text-red-800"
                                    wire:click="deleteAttachment({{ $att->id }})"
                                    wire:confirm="Remove this attachment?">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-sm text-gray-500">No attachments.</td>
                    </tr>
                @endforelse
            </x-slot>
        </x-data-table>

        <div class="flex flex-col gap-2">
            <button type="button" class="btn-secondary w-full justify-center" wire:click="openBrowse">Browse</button>
            <button type="button" class="btn-secondary w-full justify-center" disabled>Display</button>
        </div>
    </div>

    @if ($showBrowseForm)
        <div class="rounded-xl border border-gray-200 bg-gray-50/80 p-4 space-y-3">
            <p class="text-sm font-semibold text-gray-900">New attachment</p>
            <p class="text-xs text-gray-500">Real file upload pending cross-app pattern. Capture metadata for now.</p>
            <div class="grid gap-3 md:grid-cols-2">
                <div class="space-y-1.5">
                    <label class="block text-xs font-medium text-gray-600">Target Path</label>
                    <x-enterprise.input wire:model="newTargetPath" placeholder="/uploads/hr/..." />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-medium text-gray-600">File Name</label>
                    <x-enterprise.input wire:model="newFileName" placeholder="document.pdf" />
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-medium text-gray-600">Attachment Date</label>
                    <x-enterprise.input type="date" wire:model="newAttachmentDate" />
                </div>
            </div>
            <div class="flex gap-2">
                <button type="button" class="btn-primary" wire:click="addAttachment">Add</button>
                <button type="button" class="btn-secondary" wire:click="cancelBrowse">Cancel</button>
            </div>
        </div>
    @endif
</div>
